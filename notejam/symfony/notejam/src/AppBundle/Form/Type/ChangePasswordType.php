<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

/**
 * Class ChangePasswordType
 *
 */
class ChangePasswordType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('current_password', 'password', [
            'constraints' => new UserPassword()
        ]);
        $builder->add('new_password', 'repeated', [
           'first_name'  => 'password',
           'second_name' => 'confirm',
           'type'        => 'password',
           'invalid_message' => 'The password fields do not match.',
        ]);
        $builder->add('save', 'submit', [
            'attr' => ['type' => 'submit']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'change_password';
    }
}


