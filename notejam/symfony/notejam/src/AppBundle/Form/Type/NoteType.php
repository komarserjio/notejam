<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Note;
use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NoteType
 *
 */
class NoteType extends AbstractType
{
    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
      $this->user = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add('text', 'textarea');
        $builder->add('pad', 'entity', [
            'class' => 'AppBundle:Pad',
            'choices' => $this->user->getPads(),
            'empty_value' => '----------',
            'required' => false
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Note::class
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'note';
    }
}
