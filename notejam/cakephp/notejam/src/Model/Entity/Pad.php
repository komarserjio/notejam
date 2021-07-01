<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pad Entity.
 */
class Pad extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'user_id' => true,
        'user' => true,
        'notes' => true,
    ];
}
