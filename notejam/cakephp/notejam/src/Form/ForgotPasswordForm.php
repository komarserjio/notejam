<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class ForgotPasswordForm extends Form
{

    /**
     * Build form schema
     *
     * @param \Cake\Form\Schema $schema Schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('email', ['type' => 'string']);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    protected function _buildValidator(Validator $validator)
    {
        return $validator
            ->requirePresence('email', 'create')
            ->add('email', 'valid', ['rule' => 'email']);
    }
}

