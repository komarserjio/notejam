<?php

class NoteController extends BaseController {

	public function index()
	{
		return View::make('note/index');
	}

}
