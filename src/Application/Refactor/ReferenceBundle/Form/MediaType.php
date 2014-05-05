<?php
namespace Application\Refactor\ReferenceBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\MediaBundle\Form\Type\MediaType as MediaBaseType;

class MediaType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
  //   $builder->add('avatar', 'sonata_media_type', array('required' => false,
		// 'cascade_validation' => true,
		// 'context' => 'user',
		// 'provider'=>'sonata.media.provider.image'
// ));
  }

  public function getName()
  {
    return 'application_refactor_referencebundle_media';
  }
}