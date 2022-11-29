# Use FrankenPHP as webserver
FrankenPHP can be used as a single container interpreting PHP and serving HTTP.
FrankenPHP natively supports the [103 Early Hints status code](https://developer.chrome.com/blog/early-hints/).

* https://frankenphp.dev/
* https://github.com/dunglas/frankenphp

## Decision
With php-fpm there is always a second container required which creates configuration and maintenance costs.
FrankenPHP solves this by using caddy as webserver and by building on PHP container to put both in one container.

## Rationale
We want only one container to serve the application.

## Status
Experimental

## Consequences
* FrankenPHP is a brand new technology, there are not many users that have experience.
* The documentation expects users to have knowledge of Caddy and do not explain a lot.
* There are no examples that can be used for development or production.
* FrankenPHP build on top of the newest PHP 8.2 which consecutivly leads to problems when libraries are not supporting the latest PHP version.
  * PHP-CS-Fixer: PHP needs to be a minimum version of PHP 7.4.0 and maximum version of PHP 8.1.*