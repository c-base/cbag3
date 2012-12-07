<?php

namespace Cbase\Cbag3\ArtefactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class ArtefactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'attr'=>array('class'=>'span8'),
                'label'  => 'benennung'
            ))
            ->add('description', 'textarea', array(
                "attr" => array("class"=>"span8", "rows" => 7),
                'label'  => 'documentation',
            ))
            ->add('state', new ArtefactStateType(), array(
                'label'  => 'weitere angaben',
            ))
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Cbase\Cbag3\ArtefactBundle\Document\Artefact',
            'show_legend' => false,
        );
    }

    public function getName()
    {
        return 'artefact';
    }
}
