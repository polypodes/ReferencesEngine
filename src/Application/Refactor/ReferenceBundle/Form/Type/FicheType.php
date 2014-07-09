<?php

namespace Application\Refactor\ReferenceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Application\Refactor\ReferenceBundle\Form\DataTransformer\TagToTitleTransformer;

class FicheType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $ckeditor_toolbar_icons = array(
            1 => array('Bold', 'Italic', 'Underline',
                '-', 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord',
                '-', 'Undo', 'Redo',
                '-', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent',
                '-', 'Blockquote',
                '-', 'Image', 'Link', 'Unlink', 'Table'),
            2 => array('Maximize', 'Source')
        );
        $builder
            ->add('title')
            ->add('title2')
            ->add('date', 'date', array("attr" => array('class'=>'form-control')))
            ->add('projectUrl', 'url', array(
                'required' => false
            ))
            ->add('content', 'sonata_formatter_type', array(
                'event_dispatcher' => $builder->getEventDispatcher(),
                'format_field' => 'contentFormatter',
                'source_field' => 'rawContent',
                'source_field_options'      => array(
                    'attr' => array('class' => 'span10', 'rows' => 20, 'style' => 'width:100%;max-width:100%')
                ),
                'listener' => true,
                'target_field' => 'content',
                'ckeditor_context' => 'default',
                'ckeditor_toolbar_icons' => $ckeditor_toolbar_icons,
            ))
            ->add('published', 'checkbox', array('required' => false))
            ->add(
                'image', 'entity', array(
                'class' => 'Application\Sonata\MediaBundle\Entity\Media',

                )
            )
            // ->add('image' , 'sonata_media_type', array(

            //     'data_class' => 'Application\Sonata\MediaBundle\Entity\Media',
            // 'provider' => 'sonata.media.provider.image',
            // 'context'  => 'default'
            // ))
            ->add(
                'image_input', 'file', array(
                    'attr' => array('class' => 'drop_zone'),
                    'mapped' => false,
                    'label' => false,
                    'required' => false
                )
            )

            ->add(
                'tags', 'collection', array(
                    'type' => new TagType(),
                    'allow_add' => true,
                    'by_reference' => false,
                    'allow_delete' =>true,
                )
            )
            ->add(
                'medias', 'collection', array(
                    'type' => new MediaFicheType(),
                    'allow_add' => true,
                    'by_reference' => false,
                    'allow_delete' =>true,
                )
            )
            ->add(
                'renders', 'collection', array(
                    'type' => new RenderType(),
                    'allow_add' => true,
                    'by_reference' => false,
                    'allow_delete' =>true,
                )
            )
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

        // $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
        //     $form = $event->getForm();
        //     $data = $event->getData();
        //     if ($data->getImage()->getName() == "Ajouter une image") {
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
        $resolver->setDefaults(
            array(
                'data_class' => 'Application\Refactor\ReferenceBundle\Entity\Fiche'
            )
        );
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
