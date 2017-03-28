<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConnectionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isProvider', null, array('label' => 'Es proveedor', 'required' => false))
            ->add('initialCompany', null, array('label' => 'Empresa origen', 'required' => true))
            ->add('endCompany', null, array('label' => 'Empresa destino', 'required' => true))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Connection'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'corebundle_connection';
    }
}
