<?php

namespace Cbase\Cbag3\ArtefactBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

use Cbase\Cbag3\AssetBundle\Document\Asset;


/**
 * @MongoDB\Document
 * @MongoDB\Document(repositoryClass="Cbase\Cbag3\ArtefactBundle\Repository\ArtefactRepository")
 */
class Artefact
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $name;

    /**
     * @MongoDB\String
     */
    protected $description;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Asset")
     */
    protected $assets = array();

    /**
     * @MongoDB\String
     */
    protected $slug;

    /**
     * @MongoDB\Date
     */
    protected $createdAt;


    /**
     * @MongoDB\String
     */
    protected $createdBy;

    /**
     * @MongoDB\EmbedOne(targetDocument="ArtefactState")
     */
    protected $state;


    public function __construct()
    {
        $this->assets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @MongoDB\PrePersist()
     */
    protected function prePersist()
    {
        $this->createdAt = new \Date();
        $this->createdBy = "alien";
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Artefact
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Artefact
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Add assets
     *
     * @param Cbase\Cbag3\AssetBundle\Document\Asset $assets
     */
    public function addAssets(\Cbase\Cbag3\AssetBundle\Document\Asset $assets)
    {
        $this->assets[] = $assets;
    }

    /**
     * Get assets
     *
     * @return Doctrine\Common\Collections\Collection $assets
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Artefact
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * Get slug
     *
     * @return string $slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set createdAt
     *
     * @param date $createdAt
     * @return Artefact
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return date $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     * @return Artefact
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * Get createdBy
     *
     * @return string $createdBy
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set state
     *
     * @param Cbase\Cbag3\ArtefactBundle\Document\ArtefactState $state
     * @return Artefact
     */
    public function setState(\Cbase\Cbag3\ArtefactBundle\Document\ArtefactState $state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * Get state
     *
     * @return Cbase\Cbag3\ArtefactBundle\Document\ArtefactState $state
     */
    public function getState()
    {
        return $this->state;
    }
}
