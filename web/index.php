<?php

/**
 * This is a example usage of the FlysystemHttpKernel with its handlers.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use h4cc\StackFlysystem\HttpKernel as FlysystemHttpKernel;
use h4cc\StackFlysystem\Handler\Deleter;
use h4cc\StackFlysystem\Handler\Lister;
use h4cc\StackFlysystem\Handler\Reader;
use h4cc\StackFlysystem\Handler\Updater;
use h4cc\StackFlysystem\Handler\Writer;

$filesystem = new Filesystem(new Local(__DIR__ . '/../files/'));

$app = new FlysystemHttpKernel($filesystem);
// just use the handlers you need.
$app->addHandler(new Lister($filesystem));
$app->addHandler(new Reader($filesystem));
$app->addHandler(new Writer($filesystem));
$app->addHandler(new Updater($filesystem));
$app->addHandler(new Deleter($filesystem));

// Stacking some middlewares.
$stack = (new Stack\Builder())
    ->push('Silpion\Stack\Logger', array('logger' => new \Monolog\Logger('flysystem')));
$app = $stack->resolve($app);

// Run!
Stack\run($app);
