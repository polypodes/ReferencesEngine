<?php

namespace Application\Refactor\ReferenceBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

class FicheAdmin extends Admin
{
    /**
     * Default Datagrid values
     *
     * @var array
     */
    protected $datagridValues = array(
        '_page' => 1,            // display the first page (default = 1)
        '_sort_order' => 'DESC', // reverse order (default = 'ASC')
        '_sort_by' => 'created_at'  // name of the ordered field
                                 // (default = the model's id field, if any)

        // the '_sort_by' key can be of the form 'mySubModel.mySubSubModel.myField'.
    );

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $ckeditor_toolbar_icons = array(
            1 => array('Bold', 'Italic', 'Underline',
                '-', 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord',
                '-', 'Undo', 'Redo',
                '-', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent',
                '-', 'Blockquote',
                '-', 'Image', 'Link', 'Unlink', 'Table'
            ),
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
        ->add('image', 'sonata_type_model_list', array(), array(
            'link_parameters' => array(
                'context' => 'default',
                'provider' => 'sonata.media.provider.image',
            )
        ))
        ->add('image_alt', null, array('label' => 'Image alt', 'required' => false))

        ->add('renders', 'sonata_type_collection',
            array(
                'label' => 'Renders',
                'required' => false,
                'cascade_validation' => true,
                'by_reference' => true,
                //'expanded' => true,
                //'multiple' => true,
            ),
            array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
                'link_parameters' => array(
                    'context' => 'default',
                    'provider' => 'sonata.media.provider.image',
                )
            )
        )
        ->add('medias', 'sonata_type_collection',
            array(
                'label' => 'Associated medias',
                'required' => false,
                //'expanded' => true,
                //'multiple' => true,
            ),
            array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
                'link_parameters' => array(
                    'context' => 'default',
                    //'provider' => 'sonata.media.provider.image',
                )
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

        $errorElement
        ->with('image')
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
        ->add('date', 'doctrine_orm_datetime', array(), 'genemu_jquerydate', array('widget' => 'single_text', 'required' => false, 'attr' => array('class' => 'datepicker')))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->add('image', null, array('format' => 'small'))
        ->addIdentifier('title')
        ->add('date', 'date', array('format' => 'F Y'))
        ->add('published', 'boolean', array('editable' => true))
        ->add('_action', 'actions', array(
            'actions' => array(
                'show' => array(),
                'edit' => array(),
                'delete' => array(),
            )
        ))
        ;
    }

    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return array();
        }

        return array(
            'provider' => $this->getRequest()->get('provider'),
            'context'  => $this->getRequest()->get('context'),
        );
    }

    public function prePersist($fiche)
    {
        $fiche->setRenders($fiche->getRenders());
        $fiche->setMedias($fiche->getMedias());
    }

    public function preUpdate($fiche)
    {
        $fiche->setRenders($fiche->getRenders());
        $fiche->setMedias($fiche->getMedias());
    }
}
