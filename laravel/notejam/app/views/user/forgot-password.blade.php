@extends('layout')

@section('page_title')
Forgot Password?
@stop

@section('content')
    {{ Form::open(array('class' => 'offset-by-six')) }}

    {{ Form::label('email', 'E-mail') . Form::text('email', Input::old('email')) }}
    @include('partials.error', array('error' => $errors->first('email')))

    {{ Form::submit('Send') }}

    {{ Form::close() }}
@stop


