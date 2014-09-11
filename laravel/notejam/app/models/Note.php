<?php

use Illuminate\Auth\UserInterface;

class Note extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notes';

    protected $fillable = array('name', 'text');

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function pad()
    {
        return $this->belongsTo('Pad');
    }

    public function smartDate()
    {
        $day = 86400;
        $date = strtotime($this->updated_at);
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
