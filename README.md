# h4cc/StackFlysystem

This is the implementation of a idea inspired by [StackPHP](stackphp.com)

Next to middlewares providing extra functionality for the HttpKernelInterface,
there might also be some single purpose applications.

These tiny apps might be used like middlewares to construct larger systems with ease.

## Installing

Clone this repo and run composer:

```
git clone git@github.com:h4cc/stack-flysystem.git
cd stack-flysystem
curl -sS https://getcomposer.org/installer | php
php composer.phar install
```

## Example usage

Start the website with PHP internal webserver.

```
cd web
php -S 0.0.0.0:8080 index.php
```

Using some curl Requests to use all the Handlers.

```
# Downloading a image from Google
curl -O https://www.google.de/images/srpr/logo11w.png

# List empty dir.
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

