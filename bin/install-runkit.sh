#!/usr/bin/env sh
#
# Automate the installation of Runkit7 in development and testing environments.
#
# USAGE:
#
#   install-runkit.sh {version}
#
# If an explicit version is not provided, the latest version compatible with your PHP
# version will be installed.

# Helpers for printing messages with color.
error() {
    printf "\\033[0;31m%s\\033[0;0m\\n" "$1"
}

notice() {
    printf "\\033[0;33m%s\\033[0;0m\\n" "$1"
}

# Download a Runkit7 tarball using either cURL or Wget (depending on environment).
download() {
    echo "Downloading Runkit7 from ${1}"
    if [ "$(command -v curl)" ]; then
        curl -sSL "$1" > "$2";
    elif [ "$(command -v wget)" ]; then
        wget -nv -O "$2" "$1"
    else
        error 'No suitable download utility was found, unable to proceed!'
        exit 1
    fi
}

# Verify that PECL is installed.
if [ ! "$(command -v pecl)" ]; then
    error 'PECL (and, by extension, PEAR) is required in order to install Runkit7.
Please see http://pear.php.net/manual/en/installation.getting.php for more information.'
    exit 1
fi

PHP_MAJOR_VERSION="$(php -r "echo PHP_MAJOR_VERSION;")"
PHP_VERSION=$(php -r "echo PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION;")
EXTENSION="runkit7"

# Enable users to set an explicit version.
if [ -n "$1" ]; then
    RUNKIT_VERSION="runkit7-${1}"
elif [ "$PHP_MAJOR_VERSION" -lt 7 ]; then
    RUNKIT_VERSION="runkit"
    EXTENSION="runkit"
else
    case "$PHP_VERSION" in
        "7.0")
            RUNKIT_VERSION="runkit7-1.0.11"
            TARBALL="https://github.com/runkit7/runkit7/releases/download/1.0.11/runkit-1.0.11.tgz"
            EXTENSION="runkit"
            ;;
        "7.1")
            RUNKIT_VERSION="runkit7-3.1.0a1"
            ;;
        *)
            RUNKIT_VERSION="runkit7-alpha"
            ;;
    esac
fi

# Install runkit(7) via PECL.
notice "Installing ${RUNKIT_VERSION}..."

# If we're using a tarball, download it and prepare PECL to install from the downloaded version.
if [ -n "$TARBALL" ]; then
    download "$TARBALL" "${RUNKIT_VERSION}.tgz"
    echo "> $ pecl install ${RUNKIT_VERSION}.tgz"
    pecl install "$RUNKIT_VERSION.tgz" || exit 1
    rm "${RUNKIT_VERSION}.tgz"
else
    echo "> $ pecl install ${RUNKIT_VERSION}"
    pecl install "$RUNKIT_VERSION" || exit 1
fi

# Create .ini files for each version of PHP.
MODS=$(find /etc/php/ -name "mods-available" -type d 2> /dev/null || echo '')
for DIR in $MODS; do
    if [ ! -f "${DIR}/${EXTENSION}.ini" ]; then
        echo "extension=${EXTENSION}.so" | sudo tee "${DIR}/${EXTENSION}.ini" > /dev/null \
            && echo "Created ${DIR}/${EXTENSION}.ini"
    fi
done

# Attempt to enable the Runkit PHP module.
if [ "$(command -v phpenmod)" ]; then
    sudo phpenmod "$EXTENSION" && echo "\\033[0;32m${EXTENSION} has been installed and activated!\\033[0;0m"
else
    notice "${RUNKIT_VERSION} has been installed, but may require manual activation."
fi
