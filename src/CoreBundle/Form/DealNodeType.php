<?php

namespace CoreBundle\Form;

use CoreBundle\Entity\Connection;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DealNodeType extends AbstractType
{
    /** @var Connection */
    private $previousConnection;

    public function __construct(Connection $previousConnection = null)
    {
        $this->previousConnection = $previousConnection;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $previousConnection = $this->previousConnection;
        $builder
            ->add('connection', null, array('label' => ' ', 'label_attr' => array('class' => 'no-display'), 'required' => false,
                'query_builder' => function (EntityRepository $er) use ($previousConnection) {
                    $qb = $er->createQueryBuilder('c');
                    if(!empty($previousConnection)){
                        $qb->andWhere('c.initialCompany = :company_id')->setParameter('company_id', $previousConnection->getEndCompany());
                    }

                    return $qb;
                }))
            ->add('level', 'hidden')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\DealNode',
            'label' => null
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'corebundle_deal_node';
    }
}
