@extends('user')

@section('page_title')
{{ $pad->name }}
@stop

@section('content')
    {{ Form::open(array('route' => array('pads.update', $pad->id))) }}

    {{ Form::label('name', 'Name') . Form::text('name', $pad->name) }}
    @include('partials.error', array('error' => $errors->first('name')))

    {{ Form::submit('Save') }}
    {{ Form::close() }}
    <a class="red" href="{{ URL::route('pads.delete', array('id' => $pad->id)) }}">Delete pad</a>

@stop
