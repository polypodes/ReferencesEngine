<?php

namespace Application\Refactor\ReferenceBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class MediaEditType extends MediaType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->remove('binaryContent')
            ->remove('providerName');

    }//end buildForm()

    /**
     * @return string
     */
    public function getName()
    {
        return 'application_refactor_referencebundle_media_edit';

    }//end getName()
}//end class
