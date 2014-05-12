<?php

namespace Application\Refactor\ReferenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Application\Refactor\ReferenceBundle\Entity\Fiche;
use Application\Refactor\ReferenceBundle\Form\Fichetype;

class BookType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('clientName')
            ->add('projectName')
            ->add('date')
            ->add('published', 'checkbox', array(
                'required' => false
                ))
            ->add('fiches', 'collection', array(
                'type' => new FicheType,
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' =>true,
                'required' => false
                ))
        ;
      //   $factory = $builder->getFormFactory();
      //   $builder->addEventListener(
      // FormEvents::PRE_SET_DATA,
      // function(FormEvent $event) use ($factory) {
      //   $book = $event->getData();
      //   $book->get('title')->setData('test');
      // }
    // );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\Refactor\ReferenceBundle\Entity\Book',
            // 'cascade_validation' =>true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'application_refactor_referencebundle_book';
    }
}
