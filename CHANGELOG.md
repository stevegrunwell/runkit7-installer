# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [1.2.0] — 2020-11-22

* Install different versions based on PHP version ([#10]).


## [1.1.1] - 2018-12-05

* Add PHP 7.3 support by [upgrading Runkit 7 to version 1.0.9](https://github.com/runkit7/runkit7/releases/tag/1.0.9) ([#8]).


## [1.1.0] - 2018-06-27

* Attempt to automatically create `runkit.ini` files upon installation ([#1]).
* Add a `name` attribute to the `<testsuite>` node, fixing some Travis build errors ([#2]).
* Document that root access might be necessary to run the installer ([#3]).
* Include [Shellcheck](https://www.shellcheck.net/) as part of the continuous integration process.


## [1.0.0] - 2018-03-29

* Initial public release.


[Unreleased]: https://github.com/stevegrunwell/runkit7-installer/compare/master...develop
[1.2.0]: https://github.com/stevegrunwell/runkit7-installer/releases/tag/v1.2.0
[1.1.1]: https://github.com/stevegrunwell/runkit7-installer/releases/tag/v1.1.1
[1.1.0]: https://github.com/stevegrunwell/runkit7-installer/releases/tag/v1.1.0
[1.0.0]: https://github.com/stevegrunwell/runkit7-installer/releases/tag/v1.0.0
[#1]: https://github.com/stevegrunwell/runkit7-installer/issues/1
[#2]: https://github.com/stevegrunwell/runkit7-installer/issues/2
[#3]: https://github.com/stevegrunwell/runkit7-installer/issues/3
[#8]: https://github.com/stevegrunwell/runkit7-installer/pull/8
[#10]: https://github.com/stevegrunwell/runkit7-installer/pull/10
