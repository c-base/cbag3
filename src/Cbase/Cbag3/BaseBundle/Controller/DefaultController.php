<?php

namespace Cbase\Cbag3\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        /** @var $repo \Cbase\Cbag3\ArtefactBundle\Repository\ArtefactRepository */
        $repo = $this->get('doctrine.odm.mongodb.document_manager')
            ->getRepository('CbaseCbag3ArtefactBundle:Artefact');

        $latestArtefacts = $repo->getLatest();

        return array('latest' => $latestArtefacts);
    }
}
