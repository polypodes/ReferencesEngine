<?php

namespace Application\Refactor\ReferenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
            ->add('published')
            ->add('image', 'entity', array('class' => 'Application\Sonata\MediaBundle\Entity\Media'))
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
