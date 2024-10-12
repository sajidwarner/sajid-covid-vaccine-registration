@extends('master')

@section('content')
<div class="mt-4">
    <h2>Search Vaccination Schedule</h2>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('registration.store') }}" method="POST">
        @csrf


        <div class="mb-3">
            <label for="nid" class="form-label">National ID (NID) *</label>
            <input type="text" class="form-control" id="nid" name="nid" value="{{ old('nid') }}" required>
        </div>


        <button type="submit" class="btn btn-primary w-100">Search</button>
    </form>
</div>

@endsection

