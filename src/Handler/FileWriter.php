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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FileWriter extends AbstractHandler
{
    public function handlesRequest(Request $request)
    {
        return $request->isMethod('POST');
    }

    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        $filesystem = $this->getFilesystem();
        $path = $request->getRequestUri();

        if ($filesystem->has($path)) {
            return new Response('', Response::HTTP_NOT_ACCEPTABLE);
        }

        $filesystem->write($path, $request->getContent());

        return $this->handleDefault($request, $type, $catch);
    }

    protected function createDefaultHttpKernel()
    {
        return new CallableHttpKernel(function () {
            return new Response('', Response::HTTP_CREATED);
        });
    }
}