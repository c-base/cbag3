<?php

namespace Cbase\Cbag3\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/asset")
 *
 */
class AssetController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {

    }
}
