@extends('user')

@section('page_title')
{{ $pad->name; }} ({{ $notes->count() }})
@stop

@section('content')
    @if ($notes->count())
        <table class="notes">
            <tr>
                <th class="note">Note <a href="{{ URL::route('view_pad', array('id' => $pad->id)) }}?order=-name" class="sort_arrow" >&uarr;</a><a href="{{ URL::route('view_pad', array('id' => $pad->id)) }}?order=name" class="sort_arrow" >&darr;</a></th>
                <th>Pad</th>
                <th class="date">Last modified <a href="{{ URL::route('view_pad', array('id' => $pad->id)) }}?order=-updated_at" class="sort_arrow" >&uarr;</a><a href="{{ URL::route('view_pad', array('id' => $pad->id)) }}?order=updated_at" class="sort_arrow" >&darr;</a></th>
            </tr>
            @foreach ($notes as $note)
                <tr>
                    <td><a href="{{ URL::route('view_note', array('id' => $note->id)) }}">{{ $note->name }}</a></td>
                    <td class="pad">
                        @if ($note->pad)
                            <a href="#">{{ $note->pad->name }}</a>
                        @else
                            No pad
                        @endif
                    </td>
                    <td class="hidden-text date">{{ $note->smartDate(); }}</td>
                </tr>
            @endforeach
        </table>
    @else
        <p class="empty">You don't have notes in this pad yet.</p>
    @endif
    <a href="{{ URL::route('create_note') }}?pad={{ $pad->id; }}" class="button">New note</a>&nbsp;
    <a href="{{ URL::route('edit_pad', array('id' => $pad->id)) }}">Pad settings</a>
@stop
