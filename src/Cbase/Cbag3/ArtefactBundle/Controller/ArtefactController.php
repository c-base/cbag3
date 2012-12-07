<?php

namespace Cbase\Cbag3\ArtefactBundle\Controller;

use Cbase\Cbag3\BaseBundle\Controller\BaseController as Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Symfony\Component\HttpFoundation\Response;

use Cbase\Cbag3\ArtefactBundle\Document\Artefact;
use Cbase\Cbag3\ArtefactBundle\Form\Type\ArtefactType;
use Cbase\Cbag3\ArtefactBundle\Document\ArtefactState;


class ArtefactController extends Controller
{
    /**
     * @Route("/", name="artefact_index")
     * @Template()
     * @Method("GET")
     */
    public function indexAction()
    {
        $artefacts = $this->getArtefactRepository()->findBy(array(),array('name'=>'asc'));
        return array('artefacts'=>$artefacts);
    }

    /**
     * @Route("/new", name="artefact_new")
     * @Template()
     * @Method("GET")
     * @Secure(roles="ROLE_CREW")
     */
    public function newAction()
    {
        $form = $this->createForm(new ArtefactType(), new Artefact());
        return array('form'=>$form->createView());
    }

    /**
     * @Route("/", name="artefact_create")
     * @Template("CbaseCbag3ArtefactBundle:Artefact:new.html.twig")
     * @Method("POST")
     * @Secure(roles="ROLE_CREW")
     *
     * @return Response
     */
    public function createAction()
    {
        $form = $this->createForm(new ArtefactType(), new Artefact());
        $form->bind($this->getRequest());

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $artefact = $form->getData();
            $artefact->setCreatedBy($this->getUser()->getUserName());

            $dm = $this->get('doctrine.odm.mongodb.document_manager');
            $dm->persist($artefact);
            $dm->flush();

            return $this->redirect($this->generateUrl('artefact_show', array('slug'=> $artefact->getSlug())));
        }

        return array('form'=>$form->createView());
    }

    /**
     * @Route("/{slug}", name="artefact_show")
     * @Template()
     * @Method("GET")
     */
    public function showAction($slug)
    {
        $artefact = $this->getArtefactRepository()
            ->findOneBySlug($slug);

        if (!$artefact) {
            throw $this->createNotFoundException('No artefact found for '.$slug);
        }

        return array('artefact'=>$artefact);
    }

    /**
     * @Route("/{slug}/edit", name="artefact_edit")
     * @Template()
     * @Method("GET")
     * @Secure(roles="ROLE_CREW")
     *
     */
    public function editAction($slug)
    {
        $artefact = $this->getArtefactRepository()
            ->findOneBySlug($slug);

        if (!$artefact) {
            throw $this->createNotFoundException('No artefact found for '.$slug);
        }

        $form = $this->createForm(new ArtefactType(), $artefact);

        return array('form'=>$form->createView(), 'artefact' => $artefact);
    }

    /**
     * @Route("/{slug}/update", name="artefact_update")
     * @Template("CbaseCbag3ArtefactBundle:Artefact:edit.html.twig")
     * @Method("POST")
     * @Secure(roles="ROLE_CREW")
     *
     */
    public function updateAction($slug)
    {
        $artefact = $this->getArtefactRepository()->findOneBySlug($slug);

        if (!$artefact) {
            throw $this->createNotFoundException('No artefact found for '.$slug);
        }

        $form = $this->createForm(new ArtefactType(), $artefact);

        $form->bind($this->getRequest());

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $artefact = $form->getData();
            $artefact->setCreatedBy($this->getUser()->getUserName());

            $dm = $this->get('doctrine.odm.mongodb.document_manager');
            $dm->persist($artefact);
            $dm->flush();

            return $this->redirect($this->generateUrl('artefact_show', array('slug'=> $artefact->getSlug())));
        }
        $artefact->setSlug($slug);

        return array('form'=>$form->createView(), 'artefact' => $artefact);
    }

    /**
     * @Route("/{slug}/assets", name="artefact_manage_asset")
     * @Template()
     * @Method("GET")
     * @Secure(roles="ROLE_CREW")
     *
     */
    public function manageAssetsAction($slug)
    {
        $assets = $this->getAssetRepository()->findAll();

        /** @var $artefact Artefact */
        $artefact = $this->getArtefactRepository()->findOneBySlug($slug);

        $selectedAssets = $artefact->getAssets()->map(function($item) {
            return $item->getId();
        })->getValues();

        return array(
            'artefact' => $artefact,
            'assets' => $assets,
            'selectedAssets' => $selectedAssets,
        );
    }

    /**
     * @Route("/{slug}/assets/save", name="artefact_save_asset")
     * @Template()
     * @Method("POST")
     * @Secure(roles="ROLE_CREW")
     *
     */
    public function saveAssetsAction($slug)
    {
        /* @var $artefact Artefact */
        $artefact = $this->getArtefactRepository()->findOneBySlug($slug);

        $artefact->removeImages();

        $assetIds = $this->getRequest()->get('asset');
        if (is_array($assetIds)) {
            foreach($assetIds as $oneAssetId) {
                /**@var \Cbase\Cbag3\AssetBundle\Document\Asset $asset*/
                $asset = $this->getAssetRepository()->find($oneAssetId);
                $artefact->addAsset($asset);
            }

            $artefact->getState()->setHasAsset(true);
            $artefact->getState()->setHasImage(true);
        }

        $dm = $this->getArtefactRepository()->getDocumentManager();
        $dm->persist($artefact);
        $dm->flush();

        $this->get('session')->setFlash('success',"Artefact Assets saved!");

        return $this->redirect($this->generateUrl('artefact_manage_asset', array('slug'=> $slug)));
    }

    /**
     * @Route("/{slug}/delete", name="artefact_delete")
     * @Template()
     * @Method("GET")
     * @Secure(roles="ROLE_CREW")
     *
     * @param string $slug artefact slug
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return RedirectResponse
     */
    public function deleteAction($slug)
    {
        /* @var $artefact Artefact */
        $artefact = $this->getArtefactRepository()->findOneBySlug($slug);

        if (!$artefact) {
            throw $this->createNotFoundException('No artefact found for '.$slug);
        }

        $dm = $this->getDocumentManager();
        $dm->remove($artefact);
        $dm->flush();

        $this->get('session')->setFlash('success','artefact wurde erfolreich für immer entfernt');

        return $this->redirect($this->generateUrl('artefact_index'));
    }
}