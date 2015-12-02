<?php

namespace Lyrixx\Bundle\FortuneBundle\Form;

use Lyrixx\Bundle\FortuneBundle\Entity\Fortune;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FortuneType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quotes', TextareaType::class, array('attr' => array('placeholder' => '<nickname> quote', 'rows' => '5')))
            ->add('author', TextType::class, array('required' => false))
            ->add('save', SubmitType::class)
            ->add('preview', SubmitType::class)
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Fortune::class,
            'error_mapping' => array(
                'quotesValid' => 'quotes',
            ),
        ));
    }
}
