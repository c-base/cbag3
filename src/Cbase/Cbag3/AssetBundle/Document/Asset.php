<?php

namespace Cbase\Cbag3\AssetBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 * @MongoDB\Document(repositoryClass="Cbase\Cbag3\AssetBundle\Repository\AssetRepository")
 */
class Asset
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $path;

    /**
     * @MongoDB\String
     */
    protected $description;

    /**
     * @MongoDB\String
     */
    protected $licence;

    /**
     * @MongoDB\String
     */
    protected $author;

    /**
     * @Assert\File(
     *      maxSize = "2M",
     *      maxSizeMessage = "grafic hat die gro:sse {{ size }}. die maC_inen ko:nnen nur {{ limit }} verarbeiten",
     *      uploadIniSizeErrorMessage = "2d scan ist zu gross. die maC_inen ko:nnen nur {{ limit }} verarbeiten.",
     *      mimeTypes = {"image/jpeg", "image/gif"},
     *      mimeTypesMessage = "grafic hat nicht das richtige format. lade eine ordentliche grafic hoch, junge (tip: jpeg, jpg, gif)"
     * )
     */
    public $file;

    public function __toString()
    {
        return $this->getWebPath();
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
     * Set path
     *
     * @param string $path
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Get path
     *
     * @return string $path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Image
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


    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/assets';
    }

    /**
     * @MongoDB\PrePersist()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->path = uniqid().'.'.$this->file->guessExtension();
        }
    }

    /**
     * @MongoDB\PostPersist()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->file->move($this->getUploadRootDir(), $this->path);

        unset($this->file);
    }

    /**
     * @MongoDB\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

    /**
     * Set licence
     *
     * @param string $licence
     * @return Asset
     */
    public function setLicence($licence)
    {
        $this->licence = $licence;
        return $this;
    }

    /**
     * Get licence
     *
     * @return string $licence
     */
    public function getLicence()
    {
        return $this->licence;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Asset
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Get author
     *
     * @return string $author
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
