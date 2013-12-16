<?php

namespace Notejam\NoteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add('text', 'textarea');
        $builder->add('save', 'submit', array(
            'attr' => array('type' => 'submit') 
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Notejam\NoteBundle\Entity\Note'
        ));
    }

    public function getName()
    {
        return 'note';
    }
}



