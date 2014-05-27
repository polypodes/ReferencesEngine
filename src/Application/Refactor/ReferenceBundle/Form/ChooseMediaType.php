<?php

namespace Application\Refactor\ReferenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\MediaBundle\Form\Type\MediaType as Media;

class chooseMediaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('media_selector', 'entity', array(
                'attr' => array(
                    'class' => 'mediaSelector'
                    ),
                "required" =>false,
                "empty_value" =>"Add media",
                "empty_data" => null,
                'mapped' => false,
                'class' => 'Application\Sonata\MediaBundle\Entity\Media',
                ))
    }
        /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\Sonata\MediaBundle\Entity\Media'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'application_refactor_referencebundle_addmedia';
    }
}