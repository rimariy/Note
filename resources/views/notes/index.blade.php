<!-- resources/views/notes/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>My Notes</h1>
        <a href="{{ route('notes.create') }}" class="btn btn-primary mb-3">Add Note</a>
        @foreach($userNotes as $note)
            <div class="card mb-3">
                <div class="card-header">{{ $note->title }}</div>
                <div class="card-body">
                    <p class="card-text">{{ $note->content }}</p>
                    <a href="{{ route('notes.show', $note->id) }}" class="btn btn-info">View</a>
                    <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('notes.destroy', $note->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
