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
            ->add('hasImage', 'checkbox', array(
                'label'=> 'grafic_e darstellung ist angefu:gt',
            ))
            ->add('hasAsset', 'checkbox', array(
                'label'=> 'grafic_e darstellung ist angefu:gt oder dokument wurde angefu:gt',
            ))
            ->add('hasText', 'checkbox', array(
                'label'=> 'documentation ist vorhanden',
            ))
            ->add('hasCompleteText', 'checkbox', array(
                'label'=> 'documentation ist komplett',
            ))
            ->add('hasManual', 'checkbox', array(
                'label'=> 'anleitung ist angefu:gt',
            ))
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
