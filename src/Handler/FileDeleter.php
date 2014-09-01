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

/**
 * Handling DELETE requests by removing the given file.
 */
class FileDeleter extends AbstractHandler
{
    public function handlesRequest(Request $request)
    {
        return $request->isMethod('DELETE');
    }

    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        $filesystem = $this->getFilesystem();
        $requestUri = $request->getRequestUri();

        // Delete file if it exists.
        if ($filesystem ->has($requestUri)) {
            $filesystem ->delete($requestUri);
        }

        return $this->handleDefault($request, $type, $catch);
    }

    protected function createDefaultHttpKernel()
    {
        return new CallableHttpKernel(function () {
            return new Response('', Response::HTTP_NO_CONTENT);
        });
    }
}
