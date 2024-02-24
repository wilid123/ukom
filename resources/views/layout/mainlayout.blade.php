<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan | @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.0/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.0/datatables.min.js"></script>
    <link href="https://cdn.datatables.net/v/dt/dt-2.0.0/b-3.0.0/b-html5-3.0.0/b-print-3.0.0/datatables.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.0.0/b-3.0.0/b-html5-3.0.0/b-print-3.0.0/datatables.min.js"></script>

</head>

<body>

    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                "scrollY": "300px",
                "scrollCollapse": true,
                "paging": true
            });
        });
    </script>

    <div class="main d-flex flex-column justify-content-between">
        <nav class="navbar navbar-dark navbar-expand-lg bg-primary">
            <div class="container-fluid">
            <a class="navbar-brand" href="#">Perpustakaan Digital </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <div class="body-content h-100 ">
            <div class="row g-0 h-100">
                <div class="sidebar col-lg-2 collapse d-lg-block " id="navbarScroll">
                    @if (Auth::user())
                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
                    @if (Auth::user()->role_id == 1)
                    <a href="/dashboard" @if (request()->route()->uri == 'dashboard') class="active" @endif><i class="bi bi-house"></i>Dashboard</a>
                    <!-- <a href="/officers" @if (request()->route()->uri == 'officers') class="active" @endif><i class="bi bi-people"></i>officers</a> -->
                    @endif
                    <a href="/books" @if (request()->route()->uri == 'books') class="active" @endif><i class="bi bi-journal-bookmark"></i>Books</a>
                    <a href="/categories" @if (request()->route()->uri == 'categories') class="active" @endif><i class="bi bi-list-nested"></i>Categories</a>
                    <a href="/users" @if (request()->route()->uri == 'users') class="active" @endif><i class="bi bi-people"></i>Users</a>
                    <a href="/rent-logs" @if (request()->route()->uri == 'rent-logs') class="active" @endif><i class="bi bi-inboxes"></i>Rent Log</a>
                    <a href="/" @if (request()->route()->uri == '/') class="active" @endif><i class="bi bi-journals"></i>Book List</a>
                    <a href="/logout" @if (request()->route()->uri == 'logout') class="active" @endif><i class="bi bi-box-arrow-left"></i>Logout</a>
                    @else
                    <a href="/profile" @if (request()->route()->uri == 'profile') class="active" @endif><i class="bi bi-person-circle"></i>Profile</a>
                    <a href="/" @if (request()->route()->uri == '/') class="active" @endif><i class="bi bi-journals"></i>Book List</a>
                    <a href="/book-return" @if (request()->route()->uri == 'book-return') class="active" @endif><i class="bi bi-journal-arrow-up"></i>Book Return</a>
                    <a href="/koleksi" @if (request()->route()->uri == 'koleksi') class="active" @endif><i class="bi bi-bag-check"></i>Collection</a>
                    <a href="/logout" @if (request()->route()->uri == 'logout') class="active" @endif><i class="bi bi-box-arrow-left"></i>Logout</a>
                    @endif
                    @else
                    <a href="/login" @if (request()->route()->uri == 'profile') class="active" @endif>Login</a>
                    @endif
                </div>
                <div class="content col-lg-10 p-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</html>