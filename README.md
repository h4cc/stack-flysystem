
# h4cc/StackFlysystem

This implementation of a HttpKernelInterface is providing a REST Api
and using a flysystem abstraction as storage backend.

[![Build Status](https://travis-ci.org/h4cc/stack-flysystem.svg?branch=master)](https://travis-ci.org/h4cc/stack-flysystem)

A idea inspired by [StackPHP](http://stackphp.com/).
Next to middlewares providing extra functionality for the HttpKernelInterface,
there might also be some single purpose applications like this one.
These tiny apps can be used to construct larger systems with ease, like middlewares do.

## Installation

### Composer

The recommended way to install `h4cc/stack-flysystem` is through [Composer](http://getcomposer.org/):

``` json
{
    "require": {
        "h4cc/stack-flysystem": "@stable"
    }
}
```

**Protip:** you should browse the
[`h4cc/stack-flysystem`](https://packagist.org/packages/h4cc/stack-flysystem)
page to choose a stable version to use, avoid the `@stable` meta constraint.


### Development and Standalone

Clone this repo and run composer:

```
git clone git@github.com:h4cc/stack-flysystem.git
cd stack-flysystem
curl -sS https://getcomposer.org/installer | php
php composer.phar install
```

## Example usage

Start the application with PHP internal webserver.

```
cd web
php -S 0.0.0.0:8080 index.php
```

Using some curl Requests to try all the Handlers.

```
# Downloading a image from Google
curl -O https://www.google.de/images/srpr/logo11w.png

# List empty dir (except .gitkeep file).
curl -X GET http://localhost:8080/

# POST image.
curl -X POST --data-binary @logo11w.png http://localhost:8080/foo/logo.png

# List again.
curl -X GET http://localhost:8080/
curl -X GET http://localhost:8080/foo/

# Fetch image
curl -X GET http://localhost:8080/foo/logo.png

# Replace image
curl -X PUT --data-binary @logo11w.png http://localhost:8080/foo/logo.png

# Delete image
curl -X DELETE http://localhost:8080/foo/logo.png

# List directory
curl -X GET http://localhost:8080/foo/
```

