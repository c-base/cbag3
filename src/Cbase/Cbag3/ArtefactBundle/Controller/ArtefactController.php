<?php

namespace Cbase\Cbag3\ArtefactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

use Cbase\Cbag3\BaseBundle\Document\Artefact;
use Cbase\Cbag3\BaseBundle\Form\Type\ArtefactType;


class ArtefactController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $artefacts = $this->getArtefactRepository()->findAll();
        return array('artefacts'=>$artefacts);
    }

    /**
     * @Route("/create")
     * @Template()
     *
     * @return Response
     */
    public function createAction()
    {
        $form = $this->createForm(new ArtefactType(), new Artefact());

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                // perform some action, such as saving the task to the database
                $artefact = $form->getData();

                $dm = $this->get('doctrine.odm.mongodb.document_manager');
                $dm->persist($artefact);
                $dm->flush();

                $id = $artefact->getId();

                return $this->redirect($this->generateUrl('cbase_cbag3_base_artefact_show', array('id'=> $id)));
            }
        }

        return array('form'=>$form->createView());
    }

    /**
     * @Route("/show/{id}")
     * @Template()
     *
     * @param $id
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction($id)
    {
        $artefact = $this->getArtefactRepository()
            ->find($id);

        if (!$artefact) {
            throw $this->createNotFoundException('No artefact found for id '.$id);
        }

        return array('artefact'=>$artefact);
    }

    /**
     * @Route("/update/{id}")
     * @Template()
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateAction($id)
    {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $artefact = $dm->getRepository('CbaseCbag3BaseBundle:Artefact')->find($id);

        if (!$artefact) {
            throw $this->createNotFoundException('No artefact found for id '.$id);
        }

        $form = $this->createForm(new ArtefactType(), $artefact);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                // perform some action, such as saving the task to the database
                $artefact = $form->getData();

                $dm = $this->get('doctrine.odm.mongodb.document_manager');
                $dm->persist($artefact);
                $dm->flush();

                return $this->redirect($this->generateUrl('cbase_cbag3_base_artefact_show', array('id'=> $id)));
            }
        }

        return array('form'=>$form->createView(), 'id'=>$id);
    }

    /**
     * @return mixed
     */
    private function getArtefactRepository()
    {
        return $this->get('doctrine.odm.mongodb.document_manager')
            ->getRepository('CbaseCbag3BaseBundle:Artefact');
    }
}