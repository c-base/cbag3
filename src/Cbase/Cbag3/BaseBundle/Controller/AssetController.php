<?php

namespace Cbase\Cbag3\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;


use Cbase\Cbag3\BaseBundle\Document\Asset;
use Cbase\Cbag3\BaseBundle\Form\Type\AssetType;

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
        $assets = $this->get('doctrine.odm.mongodb.document_manager')
            ->getRepository('CbaseCbag3BaseBundle:Asset')->findAll();
        return array('assets'=>$assets);
    }

    /**
     * @Route("/create")
     * @Template()
     *
     * @return Response
     */
    public function createAction()
    {
        $form = $this->createForm(new AssetType(), new Asset());

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                // perform some action, such as saving the task to the database
                $asset = $form->getData();

                $dm = $this->get('doctrine.odm.mongodb.document_manager');
                $dm->persist($asset);
                $dm->flush();

                $id = $asset->getId();

                return $this->redirect($this->generateUrl('cbase_cbag3_base_asset_index'));
            }
        }

        return array('form'=>$form->createView());
    }

    /**
     * @Route("/delete/{id}")
     * @Template()
     *
     * @return Response
     */
    public function deleteAction($id)
    {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $asset = $dm->getRepository('CbaseCbag3BaseBundle:Asset')->find($id);

        $dm->remove($asset);
        $dm->flush();

        return $this->redirect($this->generateUrl('cbase_cbag3_base_asset_index'));
    }
}
