<?php

namespace Cbase\Cbag3\AssetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;


use Cbase\Cbag3\AssetBundle\Document\Asset;
use Cbase\Cbag3\AssetBundle\Form\Type\AssetType;

class AssetController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $assets = $this->get('doctrine.odm.mongodb.document_manager')
            ->getRepository('CbaseCbag3AssetBundle:Asset')->findAll();
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

                return $this->redirect($this->generateUrl('cbase_cbag3_asset_asset_index'));
            }
        }

        return array('form'=>$form->createView());
    }

    /**
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction($id)
   {
       $dm = $this->get('doctrine.odm.mongodb.document_manager');

       $asset = $dm->getRepository('CbaseCbag3AssetBundle:Asset')->find($id);

       if (!$asset) {
           throw $this->createNotFoundException('No asset found for '.$id);
       }
       $form = $this->createForm(new AssetType(), $asset);
       $form->remove("file");

       return array('form'=>$form->createView(), 'id' => $id);
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

        $asset = $dm->getRepository('CbaseCbag3AssetBundle:Asset')->find($id);

        $dm->remove($asset);
        $dm->flush();

        return $this->redirect($this->generateUrl('cbase_cbag3_asset_asset_index'));
    }
}
