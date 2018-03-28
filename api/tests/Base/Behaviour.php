<?php
namespace App\Tests\Base;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class Behaviour
{
    /** @var KernelTestCase */
    protected $testCase;

    /** @var KernelInterface */
    protected $kernel;

    /**
     * @param KernelInterface $kernel
     * @param KernelTestCase $testCase
     */
    public function __construct(KernelInterface $kernel, KernelTestCase $testCase = null)
    {
        $this->kernel = $kernel;
        $this->testCase = $testCase;
    }
}
