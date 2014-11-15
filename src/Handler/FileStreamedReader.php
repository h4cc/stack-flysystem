<?php

/*
 * This file is part of the h4cc/stack-flysystem package.
 *
 * (c) Julius Beckmann <github@h4cc.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace h4cc\StackFlysystem\Handler;

use League\Flysystem\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Handler for reading a file in streamed mode.
 */
class FileStreamedReader extends FileReader
{
    protected function createResponseForFile(File $file)
    {
        return new StreamedResponse(
            function () use ($file) {
                fpassthru($file->readStream());
            },
            Response::HTTP_OK,
            array('Content-Type' => $file->getMimetype())
        );
    }
}
