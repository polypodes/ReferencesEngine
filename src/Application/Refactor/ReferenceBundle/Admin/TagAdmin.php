<?php

namespace Application\Refactor\ReferenceBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

class TagAdmin extends Admin
{

    /**
     * Default Datagrid values
     *
     * @var array
     */
    protected $datagridValues = array(
                                 '_page'       => 1,
    // display the first page (default = 1)
                                 '_sort_order' => 'ASC',
    // reverse order (default = 'ASC')
                                 '_sort_by'    => 'title',
    // name of the ordered field
                                 // (default = the model's id field, if any)

        // the '_sort_by' key can be of the form 'mySubModel.mySubSubModel.myField'.
                                );


    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('title', null, array('label' => 'Title'))
        ->add('slug', null, array('label' => 'Slug', 'required' => false));

    }//end configureFormFields()


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
        ->end();

    }//end validate()


    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('title');

    }//end configureDatagridFilters()


    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('title')
        ->add(
            '_action', 'actions', array(
                                   'actions' => array(
                                                 'edit'   => array(),
                                                 'delete' => array(),
                                                )
                                  )
        );

    }//end configureListFields()


    /*
        public function getPersistentParameters()
        {
        if (!$this->getRequest()) {
            return array();
        }

        return array(
            'provider' => $this->getRequest()->get('provider'),
            'context'  => $this->getRequest()->get('context'),
        );
    }*/

    /*
        public function prePersist($fiche)
        {
        $fiche->setRenders($fiche->getRenders());
        $fiche->setMedias($fiche->getMedias());
        }

        public function preUpdate($fiche)
        {
        $fiche->setRenders($fiche->getRenders());
        $fiche->setMedias($fiche->getMedias());
        }*/
}//end class
