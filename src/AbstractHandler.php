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

use League\Flysystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Base class for the Handler implementations.
 */
abstract class AbstractHandler implements HandlerInterface
{
    /** @var \League\Flysystem\Filesystem  */
    private $filesystem;

    /** @var \Symfony\Component\HttpKernel\HttpKernelInterface  */
    private $defaultHttpKernel;

    /**
     * Giving a defaultHttpKernel can change the default behaviour of the handler.
     * If thats not enought, implement your own.
     *
     * @param Filesystem $filesystem
     * @param HttpKernelInterface $defaultHttpKernel
     */
    public function __construct(Filesystem $filesystem, HttpKernelInterface $defaultHttpKernel = null)
    {
        $this->filesystem = $filesystem;
        $this->defaultHttpKernel = ($defaultHttpKernel) ? $defaultHttpKernel : $this->createDefaultHttpKernel();
    }

    /**
     * The default HttpKernel for the handler, used when handling failed or should not be done.
     *
     * @return HttpKernelInterface
     */
    abstract protected function createDefaultHttpKernel();

    /**
     * @return Filesystem
     */
    protected function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * @param Request $request
     * @param int $type
     * @param bool $catch
     * @param \Exception $exception
     * @return Response
     */
    protected function handleDefault(Request $request, $type = self::MASTER_REQUEST, $catch = true, \Exception $exception = null)
    {
        return $this->defaultHttpKernel->handle($request, $type, $catch);
    }
}
