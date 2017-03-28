<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DealType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => 'Nombre'))
            ->add('startDate', null, array('label' => 'Fecha inicial', 'widget' => 'single_text',
                'format' => 'dd/MM/yyyy', 'required' => false))
            ->add('endDate', null, array('label' => 'Fecha final', 'widget' => 'single_text',
                'format' => 'dd/MM/yyyy', 'required' => false))
            // ->add('connections', null, array('label' => 'Conexiones'))
            ->add('nodes', 'collection', array('type' => new DealNodeType(), 'label' => ' ', 'label_attr' => array('class' => 'no-display'),
                'allow_add' => true, 'allow_delete' => true, 'by_reference' => false, 'error_bubbling' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Deal'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'corebundle_deal';
    }
}
