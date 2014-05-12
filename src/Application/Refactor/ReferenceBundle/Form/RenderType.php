<?php

namespace Application\Refactor\ReferenceBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Application\Refactor\ReferenceBundle\Form\MediaType;


class RenderType extends MediaType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    parent::buildForm($builder, $options);
    $builder
    	->remove('providerName')
        ->getForm()

;
  }

  public function getName()
  {
    return 'application_refactor_referencebundle_render';
  }
}