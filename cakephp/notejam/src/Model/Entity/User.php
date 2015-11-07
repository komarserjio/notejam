<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;


/**
 * User Entity.
 */
class User extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'email' => true,
        'password' => true,
        'notes' => true,
        'pads' => true,
    ];


    /**
     * Password setter
     *
     * @param string $value password
     * @return string
     */
    protected function _setPassword($value)
    {
        $hasher = new DefaultPasswordHasher();
        return $hasher->hash($value);
    }

    /**
     * Check if passwords matches
     *
     * @param string $password Password
     * @return boolean
     */
    public function checkPassword($password)
    {
        $hasher = new DefaultPasswordHasher();
        return $hasher->check($password, $this->password);
    }
}
