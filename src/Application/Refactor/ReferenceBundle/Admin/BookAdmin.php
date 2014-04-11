<?php

namespace Application\Refactor\ReferenceBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

class BookAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('clientName')
            ->add('projectName')
            ->add('date')
            ->add('published')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title')
            ->add('clientName')
            ->add('projectName')
            ->add('date')
            ->add('published')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', null, array('label' => 'Title'))
            ->add('date', 'genemu_jquerydate', array('label' => 'Date', 'widget' => 'single_text'))
            ->add('clientName', null, array('label' => 'Client Name'))
            ->add('projectName', null, array('label' => 'Project Name', 'required' => false))

            ->add('fiches', 'sonata_type_collection',
                array(
                    'label' => 'Fiches',
                    'required' => false,
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                )
            )
            ->add('published', null, array('label' => 'Published', 'required' => false))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        // conditional validation, see the related section for more information
        $errorElement
            ->with('title')
            ->assertNotBlank()
            ->assertNotNull()
            ->assertLength(array('max' => 255))
            ->end()
        ;

        $errorElement
            ->with('date')
            ->assertNotBlank()
            ->assertNotNull()
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
            ->add('clientName')
            ->add('projectName')
            ->add('date')
            ->add('fiches')
            ->add('created_at')
            ->add('updated_at')
            ->add('published')
        ;
    }
}
