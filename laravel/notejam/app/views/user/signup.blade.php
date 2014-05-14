@extends('layout')
@section('content')
    {{ Form::open() }}

    {{ Form::label('email', 'E-mail') . Form::text('email', Input::old('email')) }}
    {{ $errors->first('email'); }}
    {{ Form::label('password', 'Password') . Form::password('password') }}
    {{ $errors->first('password'); }}
    {{ Form::label('password_confirmation', 'Confirm password') . Form::password('password_confirmation') }}
    {{ $errors->first('confirm_password'); }}

    {{ Form::submit('Sign Up') }}
    <p><a href="#">Don't have an account?</a></p>

    {{ Form::close() }}
@stop
