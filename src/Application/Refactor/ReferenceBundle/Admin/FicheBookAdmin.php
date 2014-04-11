<?php

namespace Application\Refactor\ReferenceBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

class FicheBookAdmin extends Admin
{

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            //->add('book')
            ->add('fiche', 'sonata_type_model_list',
                array(
                    'required' => false
                )
            )
        ;
    }

}
