<?php

namespace Cbase\Cbag3\ArtefactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class ArtefactStateType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hasImage')
            ->add('hasAsset')
            ->add('hasText')
            ->add('hasCompleteText')
            ->add('hasManual')
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array('data_class' => 'Cbase\Cbag3\ArtefactBundle\Document\ArtefactState');
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'artefactState';
    }
}
