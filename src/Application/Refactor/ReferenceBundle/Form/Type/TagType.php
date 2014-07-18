<?php

namespace Application\Refactor\ReferenceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TagType extends AbstractType
{

        /**
         * @param FormBuilderInterface $builder
         * @param array                $options
         */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                //'attr' => array('class' => 'tagInput'),
            ))
            ->add('slug', 'text', array(
                'required' => false
            ))
            ->add('save', 'submit')
            ->add('saveAndAddAnother', 'submit')
        ;


    }//end buildForm()

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => 'Application\Refactor\ReferenceBundle\Entity\Tag')
        );

    }//end setDefaultOptions()

    /**
     * @return string
     */
    public function getName()
    {
        return 'application_refactor_referencebundle_tag';

    }//end getName()
}//end class
