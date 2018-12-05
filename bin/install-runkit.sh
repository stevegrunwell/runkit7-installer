#!/usr/bin/env sh
#
# Automate the installation of Runkit7 in development and testing environments.

# Enable users to set an explicit version.
[ "$1" ] && RUNKIT_VERSION=$1 || RUNKIT_VERSION="1.0.9"

DOWNLOAD_FILENAME="runkit-${RUNKIT_VERSION}.tgz"

# Download a Runkit7 tarball using either cURL or Wget (depending on environment).
download() {
    echo "Downloading Runkit7 from ${1}"
    if [ "$(command -v curl)" ]; then
        curl -sL "$1" > "$2";
    elif [ "$(command -v wget)" ]; then
        wget -nv -O "$2" "$1"
    else
        echo "\\033[0;31mNo suitable download utility was found, unable to proceed!\\033[0;m"
        exit 1
    fi
}

# Verify that PECL is installed.
if [ ! "$(command -v pecl)" ]; then
    echo "\\033[0;31mPECL (and, by extension, PEAR) is required in order to install Runkit7."
    echo "Please see http://pear.php.net/manual/en/installation.getting.php for more information.\\033[0;m"
    exit 1
fi

# Download and install Runkit7.
echo "\\033[0;33mInstalling Runkit7...\\033[0;m"
download "https://github.com/runkit7/runkit7/releases/download/${RUNKIT_VERSION}/runkit-${RUNKIT_VERSION}.tgz" "$DOWNLOAD_FILENAME" \
    && pecl install "$DOWNLOAD_FILENAME" \
    && rm "$DOWNLOAD_FILENAME"

# Create runkit.ini files for each version of PHP.
MODS=$(find /etc/php/ -name "mods-available" -type d)
for DIR in $MODS; do
    if [ ! -f "$DIR/runkit.ini" ]; then
        echo "extension=runkit.so" | sudo tee "$DIR/runkit.ini" > /dev/null \
            && echo "Created ${DIR}/runkit.ini"
    fi
done

# Attempt to enable the Runkit PHP module.
if [ "$(command -v phpenmod)" ]; then
    sudo phpenmod runkit && echo "\\033[0;32mRunkit7 has been installed and activated!\\033[0;0m"
fi
