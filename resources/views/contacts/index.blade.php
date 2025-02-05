@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-6">
                <h1>Contact List</h1>
            </div>
            <div class="col-6 text-end">
                <a href="{{ route('contacts.create') }}" class="btn btn-primary">Add New Contact</a>
            </div>
        </div>
        <table id="contacts_table" class="display">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $contact)
                    <tr>
                        <td>{{ $contact->first_name }}</td>
                        <td>{{ $contact->last_name }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('contacts.edit', $contact->id) }}">Edit</a>
                                <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#contacts_table').DataTable({
                "pageLength": 10,
                "responsive": true
            });
        });
    </script>
@endsection
