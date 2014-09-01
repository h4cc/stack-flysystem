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

use h4cc\StackFlysystem\AbstractHandler;
use Stack\CallableHttpKernel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DirectoryLister extends AbstractHandler
{
    public function handlesRequest(Request $request)
    {
        // Expect to list a directory, if last char of request URI is a slash.
        if ($request->isMethod('GET') && '/' == substr($request->getRequestUri(), -1)) {
            return true;
        }

        return false;
    }

    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        $contents = $this->getFilesystem()->listContents($request->getRequestUri());

        $jsonContent = array_map(
            function ($content) {
                $path = '/' . $content['basename'];
                if ($content['dirname']) {
                    $path = '/' . $content['dirname'] . $path;
                }
                $timestamp = date_format(new \DateTime('@' . $content['timestamp']), 'c');
                if ('file' == $content['type']) {
                    return array(
                        'type' => $content['type'],
                        'timestamp' => $timestamp,
                        'size' => $content['size'],
                        'path' => $path
                    );
                } else {
                    return array(
                        'type' => $content['type'],
                        'timestamp' => $timestamp,
                        'path' => $path . '/'
                    );
                }
            },
            $contents
        );

        return new JsonResponse($jsonContent);
    }

    protected function createDefaultHttpKernel()
    {
        return new CallableHttpKernel(function () {
            return new Response('', Response::HTTP_NOT_FOUND);
        });
    }
}