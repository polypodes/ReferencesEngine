<?php

namespace Application\Refactor\ReferenceBundle\Form;

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
            // ->add('tag', 'entity', array('class' => 'Application\Refactor\ReferenceBundle\Entity\Tag'))
            ->add(
                'title', 'text', array(
                                  'attr' => array('class' => 'tagInput'),
                                 )
            );

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
