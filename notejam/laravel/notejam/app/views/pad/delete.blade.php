@extends('user')

@section('page_title')
Delete pad {{ $pad->name }}
@stop

@section('content')
    {{ Form::open(array('route' => array('pads.destroy', $pad->id))) }}
    <p>Are you sure you want to delete {{ $pad->name }}?</p>
    {{ Form::submit('Yes, I want to delete this pad', array('class' => 'button red')) }}
    <a href="{{ URL::route('pads.edit', array('id' => $pad->id))}}">Cancel</a>

    {{ Form::close() }}
@stop

