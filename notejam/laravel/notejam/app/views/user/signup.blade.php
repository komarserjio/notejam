@extends('layout')

@section('page_title')
Sign Up
@stop

@section('content')
    {{ Form::open(array('class' => 'offset-by-six')) }}

    {{ Form::label('email', 'E-mail') . Form::text('email', Input::old('email')) }}
    @include('partials.error', array('error' => $errors->first('email')))
    {{ Form::label('password', 'Password') . Form::password('password') }}
    @include('partials.error', array('error' => $errors->first('password')))
    {{ Form::label('password_confirmation', 'Confirm password') . Form::password('password_confirmation') }}
    @include('partials.error', array('error' => $errors->first('password_confirmation')))

    {{ Form::submit('Sign Up') }} or <a href="{{ URL::route('signin'); }}">Sign in</a>

    {{ Form::close() }}

@stop
