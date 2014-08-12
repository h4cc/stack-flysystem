<?php

namespace h4cc\StackFlysystem\Handler;

use h4cc\StackFlysystem\HandlerInterface;
use League\Flysystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Updater implements HandlerInterface
{
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function handlesRequest(Request $request)
    {
        return ('PUT' == $request->getMethod());
    }

    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        $path = $request->getRequestUri();

        if (!$this->filesystem->has($path)) {
            return new Response('', 404);
        }
        $this->filesystem->delete($path);
        $this->filesystem->write($path, $request->getContent());

        return new Response('', 201);
    }
}