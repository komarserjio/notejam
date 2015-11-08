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

    /**
     * Get pretty date like "Yesterday", "2 days ago", "etc"
     *
     * @return string
     */
    public function getPrettyDate()
    {
        $day = 86400;
        $date = strtotime($this->_properties['updated_at']);
        $diff = floor((time() - $date) / $day);
        if ($diff < 1) {
            return "Today at " . date("H:i", $date);
        } elseif ($diff == 1) {
            return "Yesterday at " . date("H:i", $date);
        } elseif ($diff > 1 && $diff < 8) {
            return "{$diff} days ago";
        } else {
            return date("d.m.Y", $date);
        }
    }
}
