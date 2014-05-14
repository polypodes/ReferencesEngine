<?php

namespace Application\Refactor\ReferenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Application\Refactor\ReferenceBundle\Form\Mediatype;
use Application\Refactor\ReferenceBundle\Form\Rendertype;
use Symfony\Component\Form\FormEvents;

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
            ->add('date', 'date', array("attr" => array('class'=>'form-control')))
            ->add('content')
            ->add('published','checkbox', array('required' => false))
            ->add('image', 'entity', array('class' => 'Application\Sonata\MediaBundle\Entity\Media'))
            ->add('tags' , 'collection', array(
            'type' => new TagType(),
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' =>true,

            ))
            ->add('medias' , 'collection', array(
            'type' => new MediaType(),
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' =>true,
            'required' => false

            ))
            ->add('renders' , 'collection', array(
            'type' => new RenderType(),
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' =>true,
            'required' => false

            ))
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
