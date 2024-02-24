@extends('layout.mainlayout')

@section('title', 'Delete User')

@section('content')
<style>
    .register-box {
        width: 1150px;
    }

    form div {
        margin-bottom: 20px;
    }
</style>

<body>

    <h2>Add User</h2>
    <div class="main d-flex flex-column justify-content-center align-items-center">
        @if ($errors->any())
        <div class="alert alert-danger" style="width: 500px;">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('status'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
        <div class="register-box p-5">
            <form action="" method="post">
                @csrf
                <div>
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control">
                </div>
                <div>
                    <label for="password" class="form-label">password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div>
                    <label for="phone" class="form-label">phone</label>
                    <input type="text" name="phone" id="phone" class="form-control">
                </div>
                <div>
                    <label for="address" class="form-label">address</label>
                    <textarea type="text" name="address" id="address" class="form-control" rows="5" required></textarea>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary form-control">Register</button>
                </div>
                <!-- <div class="text-center">
                    Have account? <a href="login">Login</a>
                </div> -->
            </form>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>



@endsection