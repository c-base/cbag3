<?php

namespace Cbase\Cbag3\AssetBundle\Controller;

use Cbase\Cbag3\BaseBundle\Controller\BaseController as Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;


use Cbase\Cbag3\AssetBundle\Document\Asset;
use Cbase\Cbag3\AssetBundle\Form\Type\AssetType;
use Cbase\Cbag3\ArtefactBundle\Document\Artefact;

class AssetController extends Controller
{
    /**
     * @Route("/", name="asset_index")
     * @Template()
     *
     * @return Response
     */
    public function indexAction()
    {
        $assets = $this->getAssetRepository()->findBy(array(),array('_id'=>'asc'));
        return array('assets' => $assets);
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

                $this->get('session')->setFlash('success','neue grafic wurde in den speicher aufgenommen.');

                return $this->redirect($this->generateUrl('asset_index'));
            }
        }

        return array('form'=>$form->createView());
    }

    /**
     * @Route("/edit/{id}", name="asset_edit")
     * @Template()
     * @Secure("ROLE_CREW")
     *
     * @param int $id asset_id
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return Response
     */
    public function editAction($id)
   {
       $asset = $this->getAssetRepository()->find($id);

       if (!$asset) {
           throw $this->createNotFoundException('No asset found for '.$id);
       }
       $form = $this->createForm(new AssetType(), $asset);
       $form->remove("file");

       $artefacts = $this->getArtefactRepository()->getByAssetId($id);

       return array(
           'form'=>$form->createView(),
           'id'=> $id,
           'asset' => $asset,
           'artefacts' => $artefacts);
   }

    /**
     * @Route("/{id}/update", name="asset_update")
     * @Template()
     * @Method("POST")
     * @Secure(roles="ROLE_CREW")
     *
     * @param int $id asset_id
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return RedirectResponse
     */
    public function updateAction($id)
    {
        $asset = $this->getAssetRepository()->find($id);

        if (!$asset) {
            throw $this->createNotFoundException('No artefact found for '.$id);
        }

        $form = $this->createForm(new AssetType(), $asset);
        $form->remove("file");

        $form->bind($this->getRequest());

        if ($form->isValid()) {

            $asset = $form->getData();

            $dm = $this->getDocumentManager();
            $dm->persist($asset);
            $dm->flush();

            $this->get('session')->setFlash('success','änderungen an der grafic wurden erfogreich angenommen');
        }
        return $this->redirect($this->generateUrl('asset_edit', array('id'=> $id)));
    }

    /**
     * @Route("/delete/{id}", name="asset_delete")
     * @Template()
     * @Method("GET")
     * @Secure(roles="ROLE_CREW")
     *
     * @param int $id asset_id
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return RedirectResponse
     */
    public function deleteAction($id)
    {
        /** @var Asset $asset */
        $asset = $this->getAssetRepository()->find($id);

        if (!$asset) {
            throw $this->createNotFoundException('No artefact found for '.$id);
        }
        $this->getArtefactRepository()->removeAsset($asset);

        $dm = $this->getDocumentManager();
        $dm->remove($asset);
        $dm->flush();

        $this->get('session')->setFlash('success','grafic wurde erfolreich für immer entfernt');

        return $this->redirect($this->generateUrl('asset_index'));
    }

    /**
     * @Route("/delete-from-artefact/{id}/{slug}", name="asset_delete_from_artefact")
     * @Template()
     * @Method("GET")
     * @Secure(roles="ROLE_CREW")
     *
     * @param int $id asset_id
     * @param string $slug artefact slug
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return RedirectResponse
     */
    public function deleteFromArtefactAction($id, $slug)
    {
        /** @var Asset $asset */
        $asset = $this->getAssetRepository()->find($id);

        if (!$asset) {
            throw $this->createNotFoundException('No asset found for '.$id);
        }

        $artefact = $this->getArtefactRepository()->findOneBySlug($slug);

        if (!$artefact) {
            throw $this->createNotFoundException('No artefact found for '.$slug);
        }

        $this->getArtefactRepository()->removeAssetFromArtefact($asset, $artefact);

        $this->get('session')->setFlash('success','grafic wurde aus der zuordnung des artefacts "'.$artefact->getName().'" entfernt');

        return $this->redirect($this->generateUrl('asset_edit', array('id'=> $id)));
    }
}
