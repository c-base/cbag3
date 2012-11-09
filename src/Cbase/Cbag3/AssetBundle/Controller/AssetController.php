<?php

namespace Cbase\Cbag3\AssetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;


use Cbase\Cbag3\AssetBundle\Document\Asset;
use Cbase\Cbag3\AssetBundle\Form\Type\AssetType;

class AssetController extends Controller
{
    /**
     * @Route("/", name="asset_index")
     * @Template()
     */
    public function indexAction()
    {
        $assets = $this->get('doctrine.odm.mongodb.document_manager')
            ->getRepository('CbaseCbag3AssetBundle:Asset')->findAll();
        return array('assets'=>$assets);
    }

    /**
     * @Route("/create", name="asset_create")
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

                return $this->redirect($this->generateUrl('asset_index'));
            }
        }

        return array('form'=>$form->createView());
    }

    /**
     * @Route("/edit/{id}", name="asset_edit")
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

       return array('form'=>$form->createView(), 'id'=> $id, 'asset' => $asset);
   }

    /**
     * @Route("/{id}/update", name="asset_update")
     * @Template()
     * @Method("POST")
     * @Secure(roles="ROLE_CREW")
     *
     */
    public function updateAction($id)
    {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $asset = $dm->getRepository('CbaseCbag3AssetBundle:Asset')->find($id);

        if (!$asset) {
            throw $this->createNotFoundException('No artefact found for '.$id);
        }

        $form = $this->createForm(new AssetType(), $asset);

        if (($id = $this->processAssetForm($form)) !== false) {
            return $this->redirect($this->generateUrl('asset_edit', array('id'=> $id)));
        }
        return $this->redirect($this->generateUrl('asset_edit', array('id'=> $id)));
    }

    /**
     * @Route("/delete/{id}", name="asset_delete")
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

        return $this->redirect($this->generateUrl('asset_index'));
    }

    protected function processAssetForm($form)
    {
        $form->bind($this->getRequest());

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $asset = $form->getData();

            $dm = $this->get('doctrine.odm.mongodb.document_manager');
            $dm->persist($asset);
            $dm->flush();

            return $asset->getId();
        }
        return false;
    }
}
