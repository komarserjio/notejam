<?php

class UserController extends BaseController {

	public function signup()
	{
        if (Request::isMethod('post'))
        {
            $validation = Validator::make(
                Input::all(),
                array(
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:6|confirmed',
                    'password_confirmation' => 'required|min:6',
                )
            );
            if ($validation->fails())
            {
                return Redirect::to('signup')->withErrors($validation);
            }
            $user = new User();
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->save();
            Redirect::to('signup')->withInput()->with('success', 'User is created.');
        }
		return View::make('user/signup');
	}

	public function signin()
	{
		return View::make('user/signup');
	}

	public function signout()
	{
		return View::make('user/signup');
	}

    public function forgotPassword()
    {
        // code...
    }

}

