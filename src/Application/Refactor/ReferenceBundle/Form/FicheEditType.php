<?php

namespace Application\Refactor\ReferenceBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Application\Refactor\ReferenceBundle\Form\FicheType;


class FicheEditType extends FicheType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    parent::buildForm($builder, $options);
    $builder
    	// ->remove('created_at')
    	// ->remove('updated_at')
    	// ->remove('rawContent')
    	// ->remove('contentFormatter')

      // ->add('medias' , 'sonata_type_collection', array(
      //       'required' => false,
      //       'type' => 'sonata_media_type',
      //       'cascade_validation' => true,
      //       'by_reference' => false,
      //       'type_options' => array(
      //           'provider' => 'sonata.media.provider.image',
      //           'context'  => 'default',
      //           'auto_initialize' => false
      //           )
      //       ),
      //       array(
      //       'edit' => 'inline',
      //       'inline' => 'table',
      //       'allow_delete' => true,
      //       'allow_add' => true,
      //       'sortable' => 'position'
      //   ))
      // ->add('medias' , 'sonata_type_collection', array(
      //       'required' => false,
      //       'by_reference' => false,
      //       'cascade_validation' => true,
      //       'type' => 'sonata_media_type',
      //       'type_options' => array(
      //           'provider' => 'sonata.media.provider.image',
      //           'context'  => 'default',
      //           'auto_initialize' => false
      //           )
      //       ),
      //       array(
      //       'edit' => 'inline',
      //       'inline' => 'table',
      //       'allow_delete' => true,
      //       'allow_add' => true,
      //       'sortable' => 'position'
      //   ))
        ->getForm()

;
  }

  public function getName()
  {
    return 'application_refactor_referencebundle_edit_fiche';
  }
}