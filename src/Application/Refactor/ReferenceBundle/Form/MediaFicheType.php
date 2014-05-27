<?php

namespace Application\Refactor\ReferenceBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Application\Refactor\ReferenceBundle\Form\MediaType;

class MediaFicheType extends MediaType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->remove('description')
            ->remove('name')
            ->remove('binaryContent')
            ->remove('providerName')
            ->add('binaryContent', 'file' , array(
                'label' => false,
                'required' =>false,
                'attr' => array(
                    'class' => 'providerInput'
                    )
                ))
            ->add('providerName', 'choice', array(
                'label' => false,
                'empty_value' => false,
                'required' =>false,
                'attr' => array(
                    'class' => 'providerSelector'
                    ),
                'choices' => array(
                    'sonata.media.provider.image' => 'Image',
                    'sonata.media.provider.youtube' => 'Youtube',
                    'sonata.media.provider.dailymotion' => 'Dailymotion',
                    'sonata.media.provider.vimeo' => 'Vimeo',
                    'sonata.media.provider.file' => 'File',
                    )
                ))
            ->add('media_selector', 'entity', array(
                'attr' => array(
                    'class' => 'mediaSelector'
                    ),
                "required" =>false,
                "empty_value" =>"Add media",
                "empty_data" => null,
                'mapped' => false,
                'class' => 'Application\Sonata\MediaBundle\Entity\Media',
                ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'application_refactor_referencebundle_mediafiche';
    }
}