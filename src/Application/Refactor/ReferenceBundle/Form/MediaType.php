<?php

namespace Application\Refactor\ReferenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\MediaBundle\Form\Type\MediaType as Media;

class MediaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('binaryContent', 'file' , array(
                'label' => false,
                // 'attr' => array(
                //     "name" => "file")
                ));
            // ->add('binaryContent', 'sonata_media_type', array(
            //     'provider' => 'sonata.media.provider.image',
            //     'context'  => 'default'
            //     ))
            // ;
    }
        /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\Sonata\MediaBundle\Entity\Media'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'application_refactor_referencebundle_media';
    }
}