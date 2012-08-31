<?php

namespace Cbase\Cbag3\ArtefactBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\EmbeddedDocument
 */
class ArtefactState
{
    /**
     * @MongoDB\Boolean
     */
    protected $hasAsset;

    /**
     * @MongoDB\Boolean
     */
    protected $hasImage;

    /**
     * @MongoDB\Boolean
     */
    protected $hasText;

    /**
     * @MongoDB\Boolean
     */
    protected $hasCompleteText;

    /**
     * @MongoDB\Boolean
     */
    protected $hasManual;

    /**
     * Set hasAsset
     *
     * @param boolean $hasAsset
     * @return ArtefactState
     */
    public function setHasAsset($hasAsset)
    {
        $this->hasAsset = $hasAsset;
        return $this;
    }

    /**
     * Get hasAsset
     *
     * @return boolean $hasAsset
     */
    public function getHasAsset()
    {
        return $this->hasAsset;
    }

    /**
     * Set hasImage
     *
     * @param boolean $hasImage
     * @return ArtefactState
     */
    public function setHasImage($hasImage)
    {
        $this->hasImage = $hasImage;
        return $this;
    }

    /**
     * Get hasImage
     *
     * @return boolean $hasImage
     */
    public function getHasImage()
    {
        return $this->hasImage;
    }

    /**
     * Set hasText
     *
     * @param boolean $hasText
     * @return ArtefactState
     */
    public function setHasText($hasText)
    {
        $this->hasText = $hasText;
        return $this;
    }

    /**
     * Get hasText
     *
     * @return boolean $hasText
     */
    public function getHasText()
    {
        return $this->hasText;
    }

    /**
     * Set hasCompleteText
     *
     * @param boolean $hasCompleteText
     * @return ArtefactState
     */
    public function setHasCompleteText($hasCompleteText)
    {
        $this->hasCompleteText = $hasCompleteText;
        return $this;
    }

    /**
     * Get hasCompleteText
     *
     * @return boolean $hasCompleteText
     */
    public function getHasCompleteText()
    {
        return $this->hasCompleteText;
    }

    /**
     * Set hasManual
     *
     * @param boolean $hasManual
     * @return ArtefactState
     */
    public function setHasManual($hasManual)
    {
        $this->hasManual = $hasManual;
        return $this;
    }

    /**
     * Get hasManual
     *
     * @return boolean $hasManual
     */
    public function getHasManual()
    {
        return $this->hasManual;
    }
}
