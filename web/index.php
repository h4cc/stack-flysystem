<?php

/*
 * This file is part of the h4cc/stack-flysystem package.
 *
 * (c) Julius Beckmann <github@h4cc.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This is a example usage of the FlysystemHttpKernel with its handlers.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use h4cc\StackFlysystem\HttpKernel as FlysystemHttpKernel;
use h4cc\StackFlysystem\Handler\FileDeleter;
use h4cc\StackFlysystem\Handler\DirectoryLister;
use h4cc\StackFlysystem\Handler\FileReader;
use h4cc\StackFlysystem\Handler\FileUpdater;
use h4cc\StackFlysystem\Handler\FileWriter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$filesystem = new Filesystem(new Local(__DIR__ . '/../files/'));

$app = new FlysystemHttpKernel();
// just use the handlers you need.
$app->addHandler(new DirectoryLister($filesystem));
$app->addHandler(new FileReader($filesystem));
$app->addHandler(new FileWriter($filesystem));
$app->addHandler(new FileUpdater($filesystem));
$app->addHandler(new FileDeleter($filesystem));

// Stacking some middlewares.
$stack = (new Stack\Builder())
    // Add a logger so we can "see" the requests.
    ->push('Silpion\Stack\Logger', array(
        'logger' => new Logger('flysystem', array(new StreamHandler(__DIR__.'/../requests.log')))
    )
);
$app = $stack->resolve($app);

// Run!
Stack\run($app);
