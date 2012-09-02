<?php

namespace Cbase\Cbag3\ArtefactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Response;

use Cbase\Cbag3\ArtefactBundle\Document\Artefact;
use Cbase\Cbag3\ArtefactBundle\Form\Type\ArtefactType;


class ArtefactController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     * @Method("GET")
     */
    public function indexAction()
    {
        $artefacts = $this->getArtefactRepository()->findAll();
        return array('artefacts'=>$artefacts);
    }

    /**
     * @Route("/new")
     * @Template()
     * @Method("GET")
     */
    public function newAction()
    {
        $form = $this->createForm(new ArtefactType(), new Artefact());
        return array('form'=>$form->createView());
    }

    /**
     * @Route("/")
     * @Template()
     * @Method("POST")
     *
     * @return Response
     */
    public function createAction()
    {
        $form = $this->createForm(new ArtefactType(), new Artefact());

        if ($slug = $this->processArtefactForm($form) !== false) {
            return $this->redirect($this->generateUrl('cbase_cbag3_artefact_artefact_show', array('slug'=> $slug)));
        }

        return array('form'=>$form->createView());
    }

    /**
     * @Route("/{slug}")
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
     * @Route("/{slug}/edit")
     * @Template()
     * @Method("GET")
     *
     */
    public function editAction($slug)
    {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $artefact = $this->getArtefactRepository()
            ->findOneBySlug($slug);

        if (!$artefact) {
            throw $this->createNotFoundException('No artefact found for '.$slug);
        }

        $form = $this->createForm(new ArtefactType(), $artefact);

        return array('form'=>$form->createView(), 'slug'=>$slug);
    }

    /**
     * @Route("/{slug}")
     * @Template()
     * @Method("PUT")
     *
     */
    public function updateAction($slug)
    {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $artefact = $dm->getRepository('CbaseCbag3ArtefactBundle:Artefact')->findOneBySlug($slug);

        if (!$artefact) {
            throw $this->createNotFoundException('No artefact found for '.$slug);
        }

        $form = $this->createForm(new ArtefactType(), $artefact);

        if ($slug = $this->processArtefactForm($form) !== false) {
            return $this->redirect($this->generateUrl('cbase_cbag3_artefact_artefact_show', array('slug'=> $slug)));
        }
        return $this->redirect($this->generateUrl('cbase_cbag3_artefact_artefact_edit', array('slug'=> $slug)));
    }

    /**
     * @return mixed
     */
    private function getArtefactRepository()
    {
        return $this->get('doctrine.odm.mongodb.document_manager')
            ->getRepository('CbaseCbag3ArtefactBundle:Artefact');
    }

    protected function processArtefactForm($form)
    {
        $form->bind($this->getRequest());

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $artefact = $form->getData();

            $dm = $this->get('doctrine.odm.mongodb.document_manager');
            $dm->persist($artefact);
            $dm->flush();

            return $artefact->getSlug();
        }
        return false;
    }
}