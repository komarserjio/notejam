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
        $this->belongsTo('User');
    }

    public function pad()
    {
        $this->belongsTo('Pad');
    }
}


