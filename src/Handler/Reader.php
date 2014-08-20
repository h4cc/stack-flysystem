<?php

namespace h4cc\StackFlysystem\Handler;

use DateTime;
use h4cc\StackFlysystem\HandlerInterface;
use League\Flysystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Reader implements HandlerInterface
{
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function handlesRequest(Request $request)
    {
        return ('GET' == $request->getMethod());
    }

    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        /** @var \League\Flysystem\File $file */
        $file = $this->filesystem->get($request->getRequestUri());

        $response = new StreamedResponse(function () use ($file) {
            $stream = $file->readStream();
            fpassthru($stream);
        }, 200);

        $response->headers->set('Content-Type', $file->getMimetype());
        $timestamp = $file->getTimestamp();

        if ($timestamp) {
            $response->setLastModified(new DateTime('@' . $timestamp));
        }

        return $response;
    }
}
