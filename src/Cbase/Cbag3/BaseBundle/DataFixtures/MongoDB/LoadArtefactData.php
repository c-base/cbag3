<?php

namespace Cbase\Cbag3\BaseBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Cbase\Cbag3\BaseBundle\Document\Artefact;

class LoadArtefactData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param Doctrine\Common\Persistence\ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.
    }
}
