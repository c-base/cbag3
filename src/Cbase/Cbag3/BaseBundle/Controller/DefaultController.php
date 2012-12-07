<?php

namespace Cbase\Cbag3\BaseBundle\Controller;

use Cbase\Cbag3\BaseBundle\Controller\BaseController as Controller;

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
        $latestArtefacts = $this->getArtefactRepository()->getLatest();

        return array('latest' => $latestArtefacts);
    }
}
