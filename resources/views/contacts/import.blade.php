@extends('layouts.app')

@section('content')
    <h1>Import Contacts</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('contacts.import') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="xml_file" accept=".xml" required>
        <button type="submit">Import Contacts</button>
    </form>
@endsection
