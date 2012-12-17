<?php
namespace Cbase\Cbag3\AssetBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Cbase\Cbag3\AssetBundle\Document\Asset;

class AssetListener {

    protected $uploadDir;

    public function __construct($uploadDir)
    {
        $this->uploadDir = $uploadDir;
    }

    /**
     * postLoad
     */
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $this->setAssetUploadDir($eventArgs);
    }

    /**
     * prePersist
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $this->setAssetUploadDir($eventArgs);
    }

    /**
     * @param \Doctrine\ODM\MongoDB\Event\LifecycleEventArgs $eventArgs
     */
    private function setAssetUploadDir(LifecycleEventArgs $eventArgs)
    {
        if ($eventArgs->getDocument() instanceof Asset) {
            $eventArgs->getDocument()->setUploadDir($this->uploadDir);
        }
    }
}
