<?php

namespace Application\Refactor\ReferenceBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

class FicheAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $ckeditor_toolbar_icons = array(
            1 => array('Bold', 'Italic', 'Underline',
                '-', 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord',
                '-', 'Undo', 'Redo',
                '-', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent',
                '-', 'Blockquote',
                '-', 'Image', 'Link', 'Unlink', 'Table'),
            2 => array('Maximize', 'Source')
            );

        $formMapper
        ->add('title', null, array('label' => 'Title'))
        ->add('title2', null, array('label' => 'Subtitle', 'required' => false))
        ->add('date', 'genemu_jquerydate', array('label' => 'Date', 'widget' => 'single_text'))
        ->add('content','sonata_formatter_type', array(
            'label' => 'Description',
            'event_dispatcher'     => $formMapper->getFormBuilder()->getEventDispatcher(),
            'format_field'   => 'contentFormatter',
            'source_field'   => 'rawContent',
            'source_field_options'      => array(
                'attr' => array('class' => 'span10', 'rows' => 20)
                ),
            'listener'       => true,
            'target_field'   => 'content',
            'ckeditor_context'     => 'default',
            'ckeditor_toolbar_icons' => $ckeditor_toolbar_icons,
            ))
        ->add('image_url', null, array('label' => 'Image URL'))
        ->add('image_alt', null, array('label' => 'Image alt', 'required' => false))
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

        $errorElement
        ->with('image_url')
        ->assertNotBlank()
        ->assertNotNull()
        ->end()
        ;

    }


    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('title')
        ->add('date')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('title')
        ->add('date')
        ;
    }
}
