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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

interface HandlerInterface extends HttpKernelInterface
{
    /**
     * Predicate if this handler will handle the given request or not.
     * Returning true means, that this handler can handle the request.
     *
     * @param Request $request
     * @return bool
     */
    public function handlesRequest(Request $request);
}
