<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Pad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PadType
 *
 */
class PadType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pad::class
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pad';
    }
}
