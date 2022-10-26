<?php

declare(strict_types=1);

namespace Tests\Factory;

use Faker\Factory;
use Faker\Generator;
use Faker\Provider\de_DE\Address;

trait FakerCapability
{
    private static ?Generator $faker = null;

    private static function faker(): Generator
    {
        if (static::$faker === null) {
            static::$faker = Factory::create();
//            static::$faker->addProvider(new Address($faker));
        }

        return static::$faker;
    }
}
