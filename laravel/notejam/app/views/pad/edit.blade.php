@extends('user')

@section('page_title')
Edit pad {{ $pad->name }}
@stop

@section('content')
    {{ Form::open() }}

    {{ Form::label('name', 'Name') . Form::text('name', $pad->name) }}
    @include('partials.error', array('error' => $errors->first('name')))

    {{ Form::submit('Create') }}

    {{ Form::close() }}

@stop
