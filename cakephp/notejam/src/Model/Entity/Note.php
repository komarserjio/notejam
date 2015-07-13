<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Note Entity.
 */
class Note extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'pad_id' => true,
        'user_id' => true,
        'name' => true,
        'text' => true,
        'created_at' => true,
        'updated_at' => true,
        'pad' => true,
        'user' => true,
    ];
}
