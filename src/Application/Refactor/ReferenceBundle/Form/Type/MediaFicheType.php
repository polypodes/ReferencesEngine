<?php

namespace Application\Refactor\ReferenceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\MediaBundle\Form\Type\MediaType as Media;

class MediaFicheType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'binaryContent', 'file', array(
                                          'label'    => false,
                                          'required' => false,
                                          'attr'     => array('class' => 'providerInput')
                                         )
            )
            ->add(
                'providerName', 'choice', array(
                                           'label'       => false,
                                           'empty_value' => false,
                                           'required'    => false,
                                           'attr'        => array('class' => 'providerSelector'),
                                           'choices'     => array(
                                                             'sonata.media.provider.image'       => 'Image',
                                                             'sonata.media.provider.youtube'     => 'Youtube',
                                                             'sonata.media.provider.dailymotion' => 'Dailymotion',
                                                             'sonata.media.provider.vimeo'       => 'Vimeo',
                                                             'sonata.media.provider.file'        => 'File',
                                                            )
                                          )
            )
            ->add(
                'media_selector', 'entity', array(
                                             'attr'        => array('class' => 'mediaSelector'),
                                             'required'    => false,
                                             'empty_value' => 'Add media',
                                             'empty_data'  => null,
                                             'mapped'      => false,
                                             'class'       => 'Application\Sonata\MediaBundle\Entity\Media',
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
        return 'application_refactor_referencebundle_mediafiche';

    }//end getName()
}//end class
