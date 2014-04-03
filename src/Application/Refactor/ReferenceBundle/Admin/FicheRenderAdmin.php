<?php

namespace Application\Refactor\ReferenceBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

class FicheRenderAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
        //->add('fiche')
        ->add('media', 'sonata_type_model_list',
            array(
                'required' => false
            ),
            array(
                'link_parameters' => array(
                    'provider' => 'sonata.media.provider.image',
                    'context' => 'default'
                )
            )
        );
    }
}
