<?php
namespace App\Tests\Unit;

use App\Utils\Slugger;
use PHPUnit\Framework\TestCase;

class SluggerTest extends TestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testSluggify($value, $expected)
    {
        $slugger = new Slugger;

        $this->assertEquals($expected, $slugger->slugify($value));
    }

    public function urlProvider()
    {
        yield ['a', 'a'];
        yield ['a b', 'a-b'];
        yield ['A b', 'a-b'];
    }
}
