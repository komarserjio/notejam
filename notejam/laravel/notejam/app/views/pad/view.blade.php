@extends('user')

@section('page_title')
{{ $pad->name; }} ({{ $notes->count() }})
@stop

@section('content')
    @if ($notes->count())
        <table class="notes">
            <tr>
                <th class="note">Note <a href="{{ URL::route('pads.show', array('id' => $pad->id)) }}?order=-name" class="sort_arrow" >&uarr;</a><a href="{{ URL::route('pads.show', array('id' => $pad->id)) }}?order=name" class="sort_arrow" >&darr;</a></th>
                <th class="date">Last modified <a href="{{ URL::route('pads.show', array('id' => $pad->id)) }}?order=-updated_at" class="sort_arrow" >&uarr;</a><a href="{{ URL::route('pads.show', array('id' => $pad->id)) }}?order=updated_at" class="sort_arrow" >&darr;</a></th>
            </tr>
            @foreach ($notes as $note)
                <tr>
                    <td><a href="{{ URL::route('notes.show', array('id' => $note->id)) }}">{{ $note->name }}</a></td>
                    <td class="hidden-text date">{{ $note->smartDate(); }}</td>
                </tr>
            @endforeach
        </table>
    @else
        <p class="empty">You don't have notes in this pad yet.</p>
    @endif
    <a href="{{ URL::route('notes.create') }}?pad={{ $pad->id; }}" class="button">New note</a>&nbsp;
    <a href="{{ URL::route('pads.edit', array('id' => $pad->id)) }}">Pad settings</a>
@stop
