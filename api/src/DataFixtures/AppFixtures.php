<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Artefact;
use App\Entity\Asset;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $asset = new Asset('01.jpg', 'see it all', 'tester', 'CC-BY-NC-SA');

        $manager->persist($asset);
        $manager->flush();


        $artefact = new Artefact(
            'Test Artefact',
            'test-slug',
            'description',
            new \DateTime(),
            'tester'
        );
        $artefact->addAsset($asset);

        $manager->persist($artefact);
        $manager->flush();
    }
}
