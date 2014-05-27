<?php
namespace Application\Refactor\ReferenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Application\Refactor\ReferenceBundle\Form\Fichetype;


class FicheChooseType extends FicheType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
        ->remove('title')
        ->remove('title2')
        ->remove('date')
        ->remove('content')
        ->remove('published')
        ->remove('image')
        ->remove('image_input')
        ->remove('tags')
        ->remove('medias')
        ->remove('renders')
        ->add('fiche_selector', 'entity', array(
            'attr' => array(
                'class' => 'ficheSelector'
                ),
            'label' =>false,
            "required" =>false,
            "empty_value" =>'Choose a project',
            "empty_data" => null,
            'mapped' => false,
            'class' => 'Application\Refactor\ReferenceBundle\Entity\Fiche',
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'application_refactor_referencebundle_ficheChoose';
    }
}