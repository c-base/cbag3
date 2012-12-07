<?php
namespace Cbase\Cbag3\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{

    /**
     * @return \Doctrine\ODM\MongoDB\DocumentManager
     */
    protected function getDocumentManager()
    {
        return $this->get('doctrine.odm.mongodb.document_manager');
    }

    /**
     * @return \Cbase\Cbag3\AssetBundle\Repository\AssetRepository
     */
    protected function getAssetRepository() {
        return $this->get('doctrine.odm.mongodb.document_manager')
            ->getRepository('CbaseCbag3AssetBundle:Asset');
    }

    /**
     * @return \Cbase\Cbag3\ArtefactBundle\Repository\ArtefactRepository
     */
    protected function getArtefactRepository()
    {
        return $this->get('doctrine.odm.mongodb.document_manager')
            ->getRepository('CbaseCbag3ArtefactBundle:Artefact');
    }
}
