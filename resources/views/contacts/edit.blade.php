@extends('layouts.app')

@section('content')
    <h1>Edit Contact</h1>
    <form method="POST" action="{{ route('contacts.update', $contact->id) }}">
        @csrf
        @method('PUT')
        <input type="text" name="first_name" value="{{ $contact->first_name }}" required>
        <input type="text" name="last_name" value="{{ $contact->last_name }}" required>
        <input type="text" name="phone" value="{{ $contact->phone }}" required>
        <button type="submit">Update Contact</button>
    </form>
@endsection
