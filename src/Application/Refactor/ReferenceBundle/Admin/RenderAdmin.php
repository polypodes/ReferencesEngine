<?php

namespace Application\Refactor\ReferenceBundle\Admin;

use Sonata\MediaBundle\Admin\BaseMediaAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class RenderAdmin extends Admin
{

        /**
         * @param  \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
         * @return void
         */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('providerReference')
            ->add('enabled')
            ->add('context');

        $providers = array();

        $providerNames = (array) $this->pool->getProviderNamesByContext($this->getPersistentParameter('context', $this->pool->getDefaultContext()));
        foreach ($providerNames as $name) {
            $providers[$name] = $name;
        }

        $datagridMapper->add(
            'providerName', 'doctrine_orm_choice', array(
                                                    'field_options' => array(
                                                                        'choices'  => $providers,
                                                                        'required' => false,
                                                                        'multiple' => false,
                                                                        'expanded' => false,
                                                                       ),
                                                    'field_type'    => 'choice',
                                                   )
        );

    }//end configureDatagridFilters()
}//end class
