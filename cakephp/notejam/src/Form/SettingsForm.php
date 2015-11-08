<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class SettingsForm extends Form
{

    /**
     * Build form schema
     *
     * @param \Cake\Form\Schema $schema Schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('current_password', ['type' => 'password'])
            ->addField('new_password', ['type' => 'password'])
            ->addField('confirm_new_password', ['type' => 'password']);
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
            ->requirePresence('current_password', 'create')
            ->notEmpty('current_password')
            ->requirePresence('new_password', 'create')
            ->notEmpty('new_password')
            ->add('new_password', [
                'length' => [
                    'rule' => ['minLength', 6]
                ],
                'compare' => [
                    'rule' => ['compareWith', 'confirm_new_password'],
                    'message' => 'Passwords do not match'
                ],
            ]);
    }
}
