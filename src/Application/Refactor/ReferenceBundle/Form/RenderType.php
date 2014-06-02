<?php

namespace Application\Refactor\ReferenceBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class RenderType extends MediaEditType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->remove('providerName')
            ->remove('media_selector')
            ->remove('name')
            ->remove('description')
            ->add(
                'binaryContent', 'file', array(
                                          'label'    => false,
                                          'required' => false,
                                          'attr'     => array('class' => 'providerInput')
                                         )
            )
            ->add(
            'render_selector', 'entity', array(
                                          'attr'        => array('class' => 'renderSelector'),
                                          'required'    => false,
                                          'empty_value' => 'Add render',
                                          'empty_data'  => null,
                                          'mapped'      => false,
                                          'class'       => 'Application\Sonata\MediaBundle\Entity\Media',
                                         )
        );

    }//end buildForm()

    public function getName()
    {
        return 'application_refactor_referencebundle_render';

    }//end getName()
}//end class
