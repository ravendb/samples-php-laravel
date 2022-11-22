<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Todo Manager' }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <style type="text/css">
        .task-details:hover {
            /*background-color: #fafafa;*/
        }
        .task-details .task-actions {
            display: none !important;
        }
        .task-details:hover .task-actions {
            display: flex !important;
        }
        .task-actions .btn-remove:hover, .task-actions a:hover {
            background-color: #eaeaea;
            border-radius: 5px;
        }

        .priority-color-1 {
            color: red;
        }
        .priority-color-2 {
            color: darksalmon;
        }
        .priority-color-3 {
            color: deepskyblue;
        }
        .priority-color-4 {
            color: lightgreen;
        }
    </style>

</head>
<body>

<nav class="navbar navbar-light bg-light navbar-expand-md fixed-top">
    <div class="container">
        <div class="container-fluid ms-0">
            <a class="navbar-brand p-0 m-0" href="{{ url('/')  }}">
            <div class="d-flex col gap-3">
                <div class="mb-1">
                <img src="{{url('/ravendb-logo.png')}}" alt="RavenDB" width="140">
                </div>
                <span class="mt-auto">
                    Todo Manager
                </span>
            </div>
            </a>
        </div>
    </div>
</nav>

<main class="container mt-5 py-4">
    @yield('content', '<h1>Hello, world!</h1>')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script type="application/javascript">
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>
</body>
</html>
