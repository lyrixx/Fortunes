<?php

namespace Lyrixx\Bundle\FortuneBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FortuneType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quotes', 'textarea', array('attr' => array('placeholder' => '<nickname> quote', 'rows' => '5')))
            ->add('author', 'text', array('required' => false))
            ->add('save', 'submit')
            ->add('preview', 'submit')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lyrixx\Bundle\FortuneBundle\Entity\Fortune',
            'error_mapping' => array(
                'quotesValid' => 'quotes',
            ),
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fortune';
    }
}
