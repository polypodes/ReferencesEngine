<?php

namespace Application\Refactor\ReferenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Application\Refactor\ReferenceBundle\Form\Mediatype;
use Application\Refactor\ReferenceBundle\Form\Rendertype;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Security\Core\SecurityContext;
use Application\Refactor\ReferenceBundle\Form\DataTransformer\TagToTitleTransformer;

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
            ->add('image', 'entity', array(
                'class' => 'Application\Sonata\MediaBundle\Entity\Media',

                ))
            // ->add('image' , 'sonata_media_type', array(

            //     'data_class' => 'Application\Sonata\MediaBundle\Entity\Media',
            // 'provider' => 'sonata.media.provider.image',
            // 'context'  => 'default'
            // ))
            ->add('image_input', 'file', array(
                'mapped' => false,
                'label' => false,
                'required' => false
                ))

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

            ))
            ->add('renders' , 'collection', array(
            'type' => new RenderType(),
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' =>true,

            ))
            // ->add('image', 'choice', array(
            //     'choices' => array(
            //         'Upload' => array(
            //             'type' => "image"
            //             ),
            //         'Select' => array(
            //             'type' => 'entity',
            //             'options' => array(
            //                 'class' => 'Application\Sonata\MediaBundle\Entity\Media'
            //                 )
            //             )
            //         )
                // ))
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
        // $entityManager = $options['em'];
        // $transformer = new TagToTitleTransformer($entityManager);
        // $builder->add(
        //     $builder->create('tags', 'text')
        //     ->addModelTransformer($transformer));



        // $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
        //     $form = $event->getForm();
        //     $data = $event->getData();
        //     if($data->getImage()->getName() == "Ajouter une image"){
        //         $form->remove('image');
        //     }
            // $form->add('image', 'text');
            
        // });


    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\Refactor\ReferenceBundle\Entity\Fiche'
        ));
        // $resolver->setRequired(array(
        //     'em',
        // ));

        // $resolver->setAllowedTypes(array(
        //     'em' => 'Doctrine\Common\Persistence\ObjectManager',
        // ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'application_refactor_referencebundle_fiche';
    }
}
