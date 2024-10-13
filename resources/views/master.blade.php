<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COVID Vaccine - {{@$title ?? ''}}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <header class="mt-5">
            <h1 class="text-center">COVID Vaccine | {{@$title ?? ''}}</h1>
            <nav class="navbar navbar-expand-lg navbar-light bg-light mt-4">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ url('/') }}">Vaccine Reg System</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('registration.index') }}">Registration</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('search.index') }}">Search Schedule</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        @yield('content')

        <footer class="mt-5 text-center">
            <p>&copy; {{ date('Y') }} COVID Vaccine Registration. All rights reserved.</p>
        </footer>
    </div>

     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    @stack('js')

    {{--  <script>

        $(document).ready(function () {
            $('form').submit(function () {
                var submitButton = $('button[type="submit"]');
                submitButton.prop('disabled', true);
                submitButton.html('Loading...');
            });
        });


    </script>  --}}

</body>
</html>
