@extends('layout')
@section('content')
    {{ Form::open(array('class' => 'offset-by-six')) }}

    {{ Form::label('email', 'E-mail') . Form::text('email', Input::old('email')) }}
    @include('partials.error', array('error' => $errors->first('email')))
    {{ Form::label('password', 'Password') . Form::password('password') }}
    @include('partials.error', array('error' => $errors->first('password')))
    {{ Form::label('password_confirmation', 'Confirm password') . Form::password('password_confirmation') }}
    @include('partials.error', array('error' => $errors->first('password_confirmation')))

    {{ Form::submit('Sign Up') }}
    <p><a href="#">Already have an account?</a></p>

    {{ Form::close() }}
@stop
