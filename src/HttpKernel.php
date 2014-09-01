<?php

/*
 * This file is part of the h4cc/stack-flysystem package.
 *
 * (c) Julius Beckmann <github@h4cc.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace h4cc\StackFlysystem;

use Stack\CallableHttpKernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * A HttpKernel for dispatching to a given Set of Handlers.
 * The first matching handler wins.
 */
class HttpKernel implements HttpKernelInterface
{
    private $defaultKernel;

    /** @var  HandlerInterface[] */
    private $handler = array();

    /**
     * The default kernel will be called, when none of the handlers has matched the request.
     *
     * @param HttpKernelInterface $defaultKernel
     */
    function __construct(HttpKernelInterface $defaultKernel = null)
    {
        if(!$defaultKernel) {
            $defaultKernel = $this->createDefaultHttpKernel();
        }
        $this->defaultKernel = $defaultKernel;
    }

    /**
     * Adding new handler, the first matching wins.
     * This means the order of adding is important.
     *
     * @param HandlerInterface $handler
     */
    public function addHandler(HandlerInterface $handler)
    {
        $this->handler[] = $handler;
    }

    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        foreach ($this->handler as $handler) {
            if ($handler->handlesRequest($request)) {
                return $handler->handle($request, $type, $catch);
            }
        }

        return $this->defaultKernel->handle($request, $type, $catch);
    }

    private function createDefaultHttpKernel()
    {
        return new CallableHttpKernel(function () {
            return new Response('Bad Request', Response::HTTP_BAD_REQUEST);
        });
    }
}
