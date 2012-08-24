<?php

namespace Cbase\Cbag3\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class ArtefactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('attr'=>array('class'=>'span8')))
            ->add('description', 'textarea', array("attr" => array("class"=>"span8", "rows" => 7)))
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array('data_class' => 'Cbase\Cbag3\BaseBundle\Document\Artefact');
    }

    public function getName()
    {
        return 'artefact';
    }
}
