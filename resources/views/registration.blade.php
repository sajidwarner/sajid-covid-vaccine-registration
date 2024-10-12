@extends('master')

@section('content')
<div class="mt-4">
    <h2>Register for Vaccination</h2>

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

    <form id="registrationForm" action="{{ route('registration.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Name *</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email *</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="nid" class="form-label">National ID (NID) *</label>
            <input type="text" class="form-control" id="nid" name="nid" value="{{ old('nid') }}" required onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
        </div>


        <div class="mb-3">
            <label for="vaccine_center" class="form-label">Select Vaccine Center *</label>
            <select class="form-select" id="vaccine_center" name="vaccine_center_id" required>
                <option value="">Select Vaccine Center</option>
                @foreach ($vaccineCenters as $center)
                    <option value="{{ $center->id }}" {{ old('vaccine_center_id') == $center->id ? 'selected' : '' }}>{{ $center->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>

</div>
@endsection

@push('js')

<script>
    $(document).ready(function () {
        $('#registrationForm').on('submit', function(e) {

            const errorMessages = document.querySelectorAll('.error-message');
            errorMessages.forEach(function(msg) {
                msg.remove();
            });
            let name = $('#name').val().trim();
            const email = $('#email').val().trim();
            const nid = $('#nid').val().trim();
            const vaccineCenter = $('#vaccine_center').val();

            let valid = true;
            const originalName = name;
            name = name.replace(/[^a-zA-Z\s.'-]/g, '');

            if (name === '') {
                showError('name', 'Name field is required.');
                valid = false;
            } else if (name !== originalName) {

                showError('name', 'Name must not contain special characters.');
                valid = false;
            }
            const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            if (email === '' || !emailPattern.test(email)) {
                showError('email', 'Please enter a valid email address.');
                valid = false;
            }

            if (nid === '') {
                showError('nid', 'National ID (NID) field is required.');
                valid = false;
            }

            if (vaccineCenter === '') {
                showError('vaccine_center', 'Please select a vaccine center.');
                valid = false;
            }

            if (valid) {
                var submitButton = $('button[type="submit"]');
                submitButton.prop('disabled', true);
                submitButton.html('Loading...');
                $('#name').val(name);
            } else {
                e.preventDefault();
            }
        });

        function showError(fieldId, message) {
            const field = document.getElementById(fieldId);
            const errorMessage = document.createElement('div');
            errorMessage.className = 'error-message text-danger';
            errorMessage.innerText = message;
            field.parentElement.appendChild(errorMessage);
        }
    });

    </script>


@endpush
