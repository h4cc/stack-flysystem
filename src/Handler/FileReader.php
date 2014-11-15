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

use DateTime;
use h4cc\StackFlysystem\AbstractHandler;
use League\Flysystem\File;
use League\Flysystem\FileNotFoundException;
use Stack\CallableHttpKernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handler for reading a file.
 */
class FileReader extends AbstractHandler
{
    public function handlesRequest(Request $request)
    {
        return $request->isMethod('GET');
    }

    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        try {
            /** @var \League\Flysystem\File $file */
            $file = $this->getFilesystem()->get($request->getRequestUri());
        }catch(FileNotFoundException $exception) {

            return $this->handleDefault($request, $type, $catch, $exception);
        }

        $response = $this->createResponseForFile($file);

        $timestamp = $file->getTimestamp();
        if ($timestamp) {
            $response->setLastModified(new DateTime('@' . $timestamp));
        }

        return $response;
    }

    protected function createResponseForFile(File $file)
    {
        return new Response(
            $file->read(),
            Response::HTTP_OK,
            array('Content-Type' => $file->getMimetype())
        );
    }

    protected function createDefaultHttpKernel()
    {
        return new CallableHttpKernel(function () {
            return new Response('Not found', Response::HTTP_NOT_FOUND);
        });
    }
}
