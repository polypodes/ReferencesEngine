<?php

namespace Application\Refactor\ReferenceBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Application\Refactor\ReferenceBundle\Form\FicheTagType;
use Application\Refactor\ReferenceBundle\Form\Mediatype;
use Application\Refactor\ReferenceBundle\Form\TagType;

class FicheEditType extends FicheType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    parent::buildForm($builder, $options);
    $builder
    	->remove('created_at')
    	->remove('updated_at')
    	->remove('rawContent')
    	->remove('contentFormatter')
    	->add('tags' , 'collection', array(
    		'type' => new FicheTagType(),
    		'allow_add' => true,
    		'by_reference' => false,
    		// 'options' => array(
      //    		'data_class' => null),
    	// 	'allow_delete' =>true,

    		))
    	// ->add('tags', 'collection', array(
    	// 	'type' => new FicheTagType(),
     //    	'options' => array(
     //    		'data_class' => 'Application\Refactor\ReferenceBundle\Entity\FicheTag'),
    	// 	'allow_add' => true,
    	// 	'allow_delete' =>true,
    		// 'by_reference' => false,
    		// 'multiple' =>true,
    		// 'expanded' =>true

    	// )
    	// ->add('medias', 'collection', array(
    	// 	)
    	// ->add('tags', 'entity', array(
     //    'class'    => 'ApplicationRefactorReferenceBundle:tag',
     //    'property' => 'title',
     //    'multiple' => true,
     //    'expanded' => false)
    	// )
;
  }

  public function getName()
  {
    return 'application_refactor_referencebundle_edit_fiche';
  }
}