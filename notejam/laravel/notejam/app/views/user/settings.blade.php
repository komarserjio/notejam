@extends('layout')

@section('page_title')
Account Settings
@stop

@section('content')
    {{ Form::open(array('class' => 'offset-by-six')) }}

    {{ Form::label('old_password', 'Current password') . Form::password('old_password') }}
    @include('partials.error', array('error' => $errors->first('old_password')))
    {{ Form::label('password', 'Password') . Form::password('password') }}
    @include('partials.error', array('error' => $errors->first('password')))
    {{ Form::label('password_confirmation', 'Confirm password') . Form::password('password_confirmation') }}
    @include('partials.error', array('error' => $errors->first('password_confirmation')))

    {{ Form::submit('Save') }}

    {{ Form::close() }}

@stop

