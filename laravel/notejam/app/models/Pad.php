<?php

use Illuminate\Auth\UserInterface;

class Pad extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pads';

    protected $fillable = array('name');

    public function user()
    {
        $this->belongsTo('User');
    }
}

