<?php

namespace h4cc\StackFlysystem\Handler;


use h4cc\StackFlysystem\HandlerInterface;
use League\Flysystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Lister implements HandlerInterface
{
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function handlesRequest(Request $request)
    {
        if ('GET' == $request->getMethod()) {
            if ('/' == substr($request->getRequestUri(), -1)) {
                return true;
            }
        }

        return false;
    }

    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        $contents = $this->filesystem->listContents($request->getRequestUri());

        $contents = array_map(function ($content) {
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
        }, $contents);

        return new JsonResponse($contents);
    }
}