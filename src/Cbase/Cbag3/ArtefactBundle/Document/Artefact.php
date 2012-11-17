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
     * @Assert\MinLength(
     *     limit=3,
     *     message="Your name must have at least {{ limit }} characters."
     * )
     */
    protected $name;

    /**
     * @MongoDB\String
     * @Assert\NotBlank()
     */
    protected $description;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Cbase\Cbag3\AssetBundle\Document\Asset")
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
     * @MongoDB\EmbedOne(targetDocument="Cbase\Cbag3\ArtefactBundle\Document\ArtefactState")
     */
    protected $state;


    public function __construct()
    {
        $this->assets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @MongoDB\PrePersist()
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
        $this->createdBy = "alien";
    }

    /**
     * @MongoDB\PrePersist()
     * @MongoDB\PreUpdate()
     */
    public function prePersistAndPreUpdate()
    {
        $slug = $this->getName();
        $slug = $this->slugify($slug);
        $this->setSlug($slug);
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
     * @param \Cbase\Cbag3\AssetBundle\Document\Asset $assets
     */
    public function addAsset(\Cbase\Cbag3\AssetBundle\Document\Asset $assets)
    {
        $this->assets[] = $assets;
    }

    /**
     * @todo rename function
     * Remove images
     */
    public function removeImages()
    {
        $this->getAssets()->clear();

        if (null === $this->getState()) {
            $this->setState(new ArtefactState());
        }
        $this->getState()->setHasImage(false);
    }

    /**
     * Get assets
     *
     * @return \Doctrine\Common\Collections\Collection $assets
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
     * @param \Cbase\Cbag3\ArtefactBundle\Document\ArtefactState $state
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
     * @return \Cbase\Cbag3\ArtefactBundle\Document\ArtefactState $state
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Slugify string for url representation
     *
     * @param string $text
     * @param string $separator
     * @return string
     */
    private function slugify($text, $separator = "-")
    {
        if (function_exists('mb_strtolower')) {
            $text = mb_strtolower($text);
        } else {
            $text = strtolower($text);
        }

        // Remove all none word characters
        $text = preg_replace('/\W/', ' ', $text);

        // More stripping. Replace spaces with dashes
        $text = strtolower(preg_replace('/[^A-Z^a-z^0-9^\/]+/', $separator,
            preg_replace('/([a-z\d])([A-Z])/', '\1_\2',
                preg_replace('/([A-Z]+)([A-Z][a-z])/', '\1_\2',
                    preg_replace('/::/', '/', $text)))));

        return trim($text, $separator);
    }
}
