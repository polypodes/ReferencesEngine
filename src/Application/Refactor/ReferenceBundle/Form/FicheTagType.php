<?php

namespace Application\Refactor\ReferenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Application\Refactor\ReferenceBundle\Form\Tagtype;

class FicheTagType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('order')
            // ->add('tag', 'collection', array('class' => 'Application\Refactor\ReferenceBundle\Entity\Tag'))
            ->add('tag', 'collection',  array(
           'type' => new TagType(),
     //     'options' => array(
     //         'data_class' => 'Application\Refactor\ReferenceBundle\Entity\FicheTag'),
          'allow_add' => true,
         'allow_delete' =>true,
          'by_reference' => false,
        ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\Refactor\ReferenceBundle\Entity\FicheTag'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'application_refactor_referencebundle_fichetag';
    }
}
