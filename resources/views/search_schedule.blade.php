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

    <form id="search-form">
        <div class="mb-3">
            <label for="nid" class="form-label">National ID (NID) *</label>
            <input type="text" class="form-control" id="nid" name="nid" value="{{ old('nid') }}" required onkeyup="this.value = this.value.replace(/^\.|[^\d\.]/g, '')">
        </div>
        <button type="submit" class="btn btn-primary w-100">Search</button>
    </form>

    <div class="mt-4" id="result" style="display: none;">
        <h3>Status: <span id="status"></span></h3>
        <p id="message"></p>
        <a href="#" id="registration-link" style="display: none;">Register here</a>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('#search-form').on('submit', function (event) {
            event.preventDefault();
            $('#result').show();
            var submitButton = $('button[type="submit"]');
            submitButton.prop('disabled', true);
            submitButton.html('Loading...');

            $.ajax({
                url: "{{ route('search.schedule') }}",
                method: 'GET',
                data: $(this).serialize(),
                success: function (response) {
                    $('#status').text(response.status);
                    if (response.status === 'Not registered') {
                        $('#message').text(response.message);
                        $('#registration-link').attr('href', response.registration_link).show();
                    } else if (response.status === 'Scheduled') {
                        $('#message').text(`Your vaccination is scheduled on ${response.scheduled_date}.`);
                        $('#registration-link').hide();
                    } else {
                        $('#message').text(response.message);
                        $('#registration-link').hide();
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $('#status').text('Error');
                        $('#message').text(errors.nid[0]);
                        $('#registration-link').hide();
                    } else {
                        $('#status').text('Error');
                        $('#message').text('An unexpected error occurred. Please try again later.');
                        $('#registration-link').hide();
                    }
                },
                complete: function () {
                    submitButton.prop('disabled', false);
                    submitButton.html('Search');
                }
            });
        });
    });
    </script>

@endpush
