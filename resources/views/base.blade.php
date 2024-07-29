<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <!-- Additional styles or scripts -->
    @yield('base_styles')
    @yield('base_scripts')
        <script type="text/javascript">
            let csrf = "{{@csrf_token()}}"
        </script>

        @if (session('message'))
            <script>
                $(document).ready(function () {
                    var type = "{{ session('alert-type', 'info') }}";
                    toastr.options.timeOut = 10000;
                    var message = "{{ session('message') }}";

                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toast-bottom-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "10000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };

                    // Custom icon for toastr
                    var iconClass = {
                        'info': 'toast-info',
                        'success': 'toast-success',
                        'warning': 'toast-warning',
                        'error': 'toast-error'
                    }[type];

                    toastr.options.iconClass = iconClass;

                    switch (type) {
                    case 'info':
                        toastr.info(message);
                        break;
                    case 'success':
                        toastr.success(message);
                        break;
                    case 'warning':
                        toastr.warning(message);
                        break;
                    case 'error':
                        toastr.error(message);
                        break;
                }
                });
            </script>
        @endif
</head>
<body>
<nav class="navbar navbar-expand-lg mb-4">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{asset('imgs/logo.png')}}" width="40" alt="Logo" />
            <p class="mb-0 ml-2 h4">Chatio</p>
        </a>
        @if( auth()->user() )
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <i class="bi bi-person-fill h5"></i>
                    {{ auth()->user()->name }}
                </li>
            </ul>
        @endif
    </div>
</nav>

<div class="container">
    @yield('base_content')
</div>
</body>
</html>
