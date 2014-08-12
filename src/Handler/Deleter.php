<?php

namespace h4cc\StackFlysystem\Handler;

use h4cc\StackFlysystem\HandlerInterface;
use League\Flysystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Deleter implements HandlerInterface
{
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function handlesRequest(Request $request)
    {
        return ('DELETE' == $request->getMethod());
    }

    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        if ($this->filesystem->has($request->getRequestUri())) {
            $this->filesystem->delete($request->getRequestUri());
        }

        return new Response('', 204);
    }
}