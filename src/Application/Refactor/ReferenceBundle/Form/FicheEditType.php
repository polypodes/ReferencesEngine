<?php

namespace Application\Refactor\ReferenceBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class FicheEditType extends FicheType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
        ->remove('date')
        ->getForm();

    }//end buildForm()

    public function getName()
    {
        return 'application_refactor_referencebundle_edit_fiche';

    }//end getName()
}//end class
