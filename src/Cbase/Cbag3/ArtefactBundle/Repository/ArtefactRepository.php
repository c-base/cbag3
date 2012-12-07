<?php

namespace Cbase\Cbag3\ArtefactBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ORM\QueryBuilder;

use Cbase\Cbag3\AssetBundle\Document\Asset;
use Cbase\Cbag3\ArtefactBundle\Document\Artefact;

/**
 * ArtefactRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArtefactRepository extends DocumentRepository
{
    public function removeAsset(Asset $asset)
    {
        return $this->getDocumentManager()->createQueryBuilder()
            ->update('Cbase\Cbag3\ArtefactBundle\Document\Artefact')
            ->field('assets')->pull(array(
                '$id' => new \MongoId($asset->getId()),
            ))
            ->multiple(true)
            ->getQuery()
            ->execute()
        ;
    }

    public function removeAssetFromArtefact(Asset $asset, Artefact $artefact)
    {
        return $this->removeAssetFromArtefactById($asset->getId(), $artefact->getId());
    }

    public function removeAssetFromArtefactById($assetId, $artefactId)
    {
        return $this->getDocumentManager()->createQueryBuilder()
            ->update('Cbase\Cbag3\ArtefactBundle\Document\Artefact')
            ->field('_id')->equals(new \MongoId($artefactId))
            ->field('assets')->pull(array(
                    '$id' => new \MongoId($assetId),
                ))
            ->multiple(true)
            ->getQuery()
            ->execute()
            ;
    }

    public function getByAsset(Asset $asset)
    {
        return $this->getByAssetId($asset->getId());
    }

    public function getByAssetId($assetId)
    {
        return $this->getDocumentManager()->createQueryBuilder()
            ->find('Cbase\Cbag3\ArtefactBundle\Document\Artefact')
            ->field('assets.$id')->equals(new \MongoId($assetId))
            ->getQuery()
            ->execute()
        ;
    }

    public function getLatest($limit = 5)
    {
        return $this->getDocumentManager()->createQueryBuilder()
            ->find('Cbase\Cbag3\ArtefactBundle\Document\Artefact')
            ->sort('createdAt', 'desc')
            ->limit($limit)
            ->getQuery()
            ->execute();
    }

    public function getStateStats($stateName)
    {
        return $this->getDocumentManager()->createQueryBuilder()
            ->find('Cbase\Cbag3\ArtefactBundle\Document\Artefact')
            ->field('state.'.$stateName)->equals(true)
            ->count()
            ->getQuery()
            ->execute();
    }

    public function getByDoesNotHaveThisState($stateName)
    {
        $qb =  $this->getDocumentManager()->createQueryBuilder();

        return $this->getDocumentManager()->createQueryBuilder()
            ->find('Cbase\Cbag3\ArtefactBundle\Document\Artefact')
            ->addOr($qb->expr()->field('state.'.$stateName)->equals(false))
            ->addOr($qb->expr()->field('state.'.$stateName)->exists(false))
            ->getQuery()
            ->execute();
    }
}