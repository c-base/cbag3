<?php

namespace Cbase\Cbag3\ArtefactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ArtefactAssetType extends AbstractType
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('assets', 'document', array(
                'class'    => 'Cbase\Cbag3\AssetBundle\Document\Asset',
                'multiple' => true,
                'expanded' => true,
            ))
        ;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'artefact_assets';
    }
}
