@extends('user')

@section('page_title')
New pad
@stop

@section('content')
    {{ Form::open(array('route' => 'pads.store')) }}

    {{ Form::label('name', 'Name') . Form::text('name', Input::old('name')) }}
    @include('partials.error', array('error' => $errors->first('name')))

    {{ Form::submit('Save') }}

    {{ Form::close() }}

@stop

