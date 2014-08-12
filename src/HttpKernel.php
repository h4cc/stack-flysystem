<?php

namespace h4cc\StackFlysystem;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class HttpKernel implements HttpKernelInterface
{
    /** @var  HandlerInterface[] */
    private $handler = array();

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

        return new Response('Bad Request', 400);
    }
}
