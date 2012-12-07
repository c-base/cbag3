<?php

namespace Cbase\Cbag3\AssetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class AssetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'text', array('label' => 'was sieht man?'))
            ->add('file', 'file', array('label' => 'datei auswa:hlen'))
            ->add('author', 'text', array('label' => 'wer hat den 2d scan vorgenommen?'))
            ->add('licence', 'choice', array(
                'choices' => array(
                    '' => 'none',
                    'CC-BY' => 'CC-BY',
                    'CC-BY-ND' => 'CC-BY-ND',
                    'CC-BY-SA' => 'CC-BY-SA',
                    'CC-BY-NC-ND' => 'CC-BY-NC-ND',
                    'CC-BY-NC' => 'CC-BY-NC',
                    'CC-BY-NC-SA' => 'CC-BY-NC-SA',
                ),
                'label' => 'licenc',
            ))
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Cbase\Cbag3\AssetBundle\Document\Asset',
            'show_legend' => false,
        );
    }

    public function getName()
    {
        return 'artefact_asset';
    }
}