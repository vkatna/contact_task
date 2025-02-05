@extends('layouts.app')

@section('content')
    <h1>Add New Contact</h1>
    <form method="POST" action="{{ route('contacts.store') }}">
        @csrf
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="text" name="phone" placeholder="Phone" required>
        <button type="submit">Add Contact</button>
    </form>
@endsection
