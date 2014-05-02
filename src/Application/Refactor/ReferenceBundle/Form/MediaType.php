<?php
namespace Application\Refactor\ReferenceBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\MediaBundle\Form\Type\MediaType as MediaBaseType;

class MediaType extends MediaBaseType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    parent::buildForm($builder, $options);
  }

  public function getName()
  {
    return 'application_refactor_referencebundle_media';
  }
}