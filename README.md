# Runkit7 Installer

[![Build Status](https://travis-ci.org/stevegrunwell/runkit7-installer.svg?branch=develop)](https://travis-ci.org/stevegrunwell/runkit7-installer)
[![Packagist](https://img.shields.io/packagist/v/stevegrunwell/runkit7-installer.svg)](https://packagist.org/packages/stevegrunwell/runkit7-installer)


This package enables you to automate the installation of [Runkit7](https://github.com/runkit7/runkit7) in development and CI environments, for projects that require the flexibility offered by runkit.

## What is Runkit7?

Runkit7 is the unofficial fork of [PHP's runkit extension](http://php.net/manual/en/book.runkit.php), upgraded to work with PHP 7.0 and above.

With runkit, developers can dynamically redefine code behavior at run-time (often referred to as "monkey-patching"). While it's usually a **very** bad idea to do in production environments, monkey-patching can be useful in scenarios where tests need to do things like redefine constants or remove functions.

## Installation

In order to use the Runkit7 installer, your target environment must support [PECL and PEAR](https://pear.php.net/manual/en/installation.php).

You may install the Runkit7 Installer package via [Composer](https://getcomposer.org):

```sh
$ composer require --dev stevegrunwell/runkit7-installer
```

Then, either in a development environment or as part of your <abbr title="Continuous Integration">CI</abbr> workflow, run the `install-runkit.sh` script:

```sh
$ ./vendor/bin/install-runkit.sh
```

> **Note:** If you receive permission issues, you may need to run the command above prefixed with `sudo`.

If you wish to install a specific version of Runkit7, you may pass the version number to the script as an argument:

```sh
$ ./vendor/bin/install-runkit.sh 1.0.5b1
```

## License

Copyright 2018 Steve Grunwell

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
