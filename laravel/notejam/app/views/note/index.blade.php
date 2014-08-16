@extends('user')

@section('page_title')
All notes ({{ $notes->count() }})
@stop

@section('content')
    @if ($notes->count())
        <table class="notes">
            <tr>
                <th class="note">Note <a href="{{ URL::route('all_notes') }}?order=-name" class="sort_arrow" >&uarr;</a><a href="{{ URL::route('all_notes') }}?order=name" class="sort_arrow" >&darr;</a></th>
                <th>Pad</th>
                <th class="date">Last modified <a href="{{ URL::route('all_notes') }}?order=-updated_at" class="sort_arrow" >&uarr;</a><a href="{{ URL::route('all_notes') }}?order=updated_at" class="sort_arrow" >&darr;</a></th>
            </tr>
            @foreach ($notes as $note)
                <tr>
                    <td><a href="{{ URL::route('notes.show', array('id' => $note->id)) }}">{{ $note->name }}</a></td>
                    <td class="pad">
                        @if ($note->pad)
                            <a href="{{ URL::route('view_pad', array('id' => $note->pad->id)); }}">{{ $note->pad->name }}</a>
                        @else
                            No pad
                        @endif
                    </td>
                    <td class="hidden-text date">{{ $note->smartDate(); }}</td>
                </tr>
            @endforeach
        </table>
    @else
        <p class="empty">Create your first note.</p>
    @endif
    <a href="{{ URL::route('notes.create') }}" class="button">New note</a>
@stop
