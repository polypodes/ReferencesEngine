<?php

namespace Application\Refactor\ReferenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Application\Refactor\ReferenceBundle\Form\Mediatype;

class FicheType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('title2')
            ->add('date')
            ->add('content')
            ->add('rawContent')
            ->add('contentFormatter')
            ->add('created_at')
            ->add('updated_at')
            ->add('published','checkbox', array('required' => false))
            ->add('image', 'entity', array('class' => 'Application\Sonata\MediaBundle\Entity\Media'))
            // ->add('image', 'sonata_media_type', array(
            //     'provider' => 'sonata.media.provider.image',
            //     'context'  => 'default'
            //     ))
            // ->add('medias' , 'collection', array(
            // 'type' => new MediaType(),
            // 'allow_add' => true,
            // 'by_reference' => false,
            // 'allow_delete' =>true,

            // ))
            ;

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\Refactor\ReferenceBundle\Entity\Fiche'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'application_refactor_referencebundle_fiche';
    }
}
