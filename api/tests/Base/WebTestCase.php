<?php
namespace App\Tests\Base;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

class WebTestCase extends BaseWebTestCase
{
    /** @var Given */
    protected $given;

    /** @var When */
    protected $when;

    /** @var Then */
    protected $then;

    public function setUp()
    {
        parent::setUp();

        static::bootKernel();

        $this->given = new Given(static::$kernel, $this);
        $this->when = new When(static::$kernel, $this);
        $this->then = new Then(static::$kernel, $this);
    }

    /**
     * Make PhpUnit faster and unset $app
     */
    public function tearDown()
    {
        $refl = new \ReflectionObject($this);
        foreach ($refl->getProperties() as $prop) {
            if (!$prop->isStatic() && 0 !== strpos($prop->getDeclaringClass()->getName(), 'PHPUnit_')) {
                $prop->setAccessible(true);
                $prop->setValue($this, null);
            }
        }

        parent::tearDown();
    }

    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }
}
