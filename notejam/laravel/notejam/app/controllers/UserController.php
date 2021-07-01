<?php

class UserController extends BaseController {

    public function signup()
    {
        return View::make('user/signup');
    }

    public function store()
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
            return Redirect::route('signup')->withErrors($validation);
        }
        $user = User::create(
            array(
                'email'  => Input::get('email'),
                'password' => Hash::make(Input::get('password'))
            )
        );
        return Redirect::route('signin')
            ->with('success', 'Account is created. Now you can sign in.');
    }

    public function signin()
    {
        return View::make('user/signin');
    }

    public function processSignin()
    {
        $validation = Validator::make(
            Input::all(),
            array(
                'email' => 'required|email',
                'password' => 'required|min:6',
            )
        );
        if ($validation->fails())
        {
            return Redirect::route('signin')->withErrors($validation);
        }
        $authParams = array(
            'email' => Input::get('email'),
            'password' => Input::get('password')
        );
        if (Auth::attempt($authParams))
        {
            return Redirect::route('all_notes')
                ->with('success', 'Signed in now!');
        }
        return Redirect::route('signin')
            ->with('error', 'Invalid email or password');
    }

    public function settings()
    {
        return View::make('user/settings');
    }

    public function updateSettings()
    {
        $user = Auth::user();
        $validation = Validator::make(
            Input::all(),
            array(
                'old_password' => 'required',
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            )
        );
        if ($validation->fails())
        {
            return Redirect::route('settings')->withErrors($validation);
        }
        $authParams = array(
            'email' => $user->email,
            'password' => Input::get('old_password')
        );
        if (Auth::validate($authParams))
        {
            $user->password = Hash::make(Input::get('password'));
            return Redirect::route('settings')
                ->with('success', 'Password is successfully changed');
        } else {
            return Redirect::route('settings')
                ->with('error', 'Current password is incorrect');
        }
    }

    public function forgotPassword()
    {
        if (Request::isMethod('post'))
        {
            $validation = Validator::make(
                Input::all(),
                array(
                    'email' => 'required|email|exists:users',
                )
            );
            if ($validation->fails())
            {
                return Redirect::route('forgot_password')
                    ->withErrors($validation);
            }
            $user = User::where(
                'email', '=', Input::get('email')
            )->firstOrFail();

            $password = $this->generatePassword();
            $user->password = Hash::make($password);
            $user->save();

            $this->sendNewPassword($user, $password);

            return Redirect::route('signin')
                ->with('success', 'New password sent to you mail.');
        }
        return View::make('user/forgot-password');
    }

    private function generatePassword()
    {
        return substr(md5(time()), 0, 8);
    }

    private function sendNewPassword($user, $password)
    {
        $data = array(
            'email' => $user->email,
            'password' => $password
        );
        Mail::send(array('text' => 'emails.password') , $data,
            function($message) use ($user)
            {
                $message->to($user->email)->subject('New password');
            }
        );
    }
}

