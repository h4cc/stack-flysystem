<?php

namespace h4cc\StackFlysystem;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

interface HandlerInterface extends HttpKernelInterface
{
    public function handlesRequest(Request $request);
} 