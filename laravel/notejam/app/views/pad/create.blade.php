@extends('user')

@section('page_title')
Create a Pad
@stop

@section('content')
    {{ Form::open() }}

    {{ Form::label('name', 'Name') . Form::text('name', Input::old('name')) }}
    @include('partials.error', array('error' => $errors->first('name')))

    {{ Form::submit('Create') }}

    {{ Form::close() }}

@stop

