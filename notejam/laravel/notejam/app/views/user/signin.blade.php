@extends('layout')

@section('page_title')
Sign In
@stop

@section('content')
    {{ Form::open(array('class' => 'offset-by-six')) }}

    {{ Form::label('email', 'E-mail') . Form::text('email', Input::old('email')) }}
    @include('partials.error', array('error' => $errors->first('email')))
    {{ Form::label('password', 'Password') . Form::password('password') }}
    @include('partials.error', array('error' => $errors->first('password')))

    {{ Form::submit('Sign in') }} or <a href="{{ URL::route('signup'); }}">Sign up</a>
    <hr />
    <p><a class="small-red" href="{{ URL::route('forgot_password'); }}">Forgot Password?</a></p>

    {{ Form::close() }}
@stop

