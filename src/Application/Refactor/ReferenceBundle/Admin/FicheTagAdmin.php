<?php

namespace Application\Refactor\ReferenceBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;

class FicheTagAdmin extends Admin
{

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        //->add('fiche')
        ->add(
            'tag', 'sonata_type_model_list',
            array('required' => false)
        );

    }//end configureFormFields()
}//end class
