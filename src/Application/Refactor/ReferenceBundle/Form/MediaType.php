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
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('description', 'textarea')
            ->add('binaryContent', 'file')
            ->add(
                'providerName', 'choice', array(

                                           'choices' => array(
                                                         'sonata.media.provider.image'       => 'Image',
                                                         'sonata.media.provider.youtube'     => 'Youtube',
                                                         'sonata.media.provider.dailymotion' => 'Dailymotion',
                                                         'sonata.media.provider.vimeo'       => 'Vimeo',
                                                         'sonata.media.provider.file'        => 'File',
                                                        )
                                          )
            );

    }//end buildForm()

        /**
         * @param OptionsResolverInterface $resolver
         */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => 'Application\Sonata\MediaBundle\Entity\Media')
        );

    }//end setDefaultOptions()

    /**
     * @return string
     */
    public function getName()
    {
        return 'application_refactor_referencebundle_media';

    }//end getName()
}//end class
