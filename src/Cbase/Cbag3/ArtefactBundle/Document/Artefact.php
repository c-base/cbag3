<?php

namespace Cbase\Cbag3\ArtefactBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique;

use Cbase\Cbag3\AssetBundle\Document\Asset;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @MongoDB\Document
 * @MongoDB\Document(repositoryClass="Cbase\Cbag3\ArtefactBundle\Repository\ArtefactRepository")
 *
 * @Unique("slug")
 * @Unique("name")
 *
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
     *     message="Der Name muss mindestens {{ limit }} Buchstaben enthalten."
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
        $this->assets = new ArrayCollection();
    }

    /**
     * @MongoDB\PrePersist()
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @MongoDB\PrePersist()
     * @MongoDB\PreUpdate()
     */
    public function prePersistAndPreUpdate()
    {
//        $slug = $this->getName();
//        $slug = $this->slugify($slug);
//        $this->setSlug($slug);
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
        $this->setSlug($this->slugify($name));
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
     * @param \Cbase\Cbag3\AssetBundle\Document\Asset $asset
     */
    public function addAsset(Asset $asset)
    {
        $this->assets[] = $asset;
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
    public function setState(ArtefactState $state)
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
        $replacements = array(
            'ü' => 'ue',
            'ö' => 'oe',
            'ä' => 'ae',
            'ß' => 'ss',
        );

        $text = str_replace(array_keys($replacements), array_values($replacements), $text);
        return $this->toAscii($text, array(), $separator);
    }

    private function toAscii($str, $replace=array(), $delimiter='-') {
        setlocale(LC_ALL, 'en_US.UTF8');
        if( !empty($replace) ) {
            $str = str_replace((array)$replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }
}
