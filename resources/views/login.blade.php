<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Buku | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<style>
    .main {
        height: 100vh;
        box-sizing: border-box;
    }

    .login-box {
        width: 500px;
        padding: 30px;
    }

    form div {
        margin-bottom: 20px;
    }
</style>

<body>
    
    <div class="main d-flex flex-column justify-content-center align-items-center">
        @if (session('status'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif
        <div class="login-box shadow">
            <form action="" method="post">
                @csrf
                <h3 class="text-center">Perpustakaan Digital</h3>
                <div class="mt-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div>
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary form-control">Login</button>
                </div>
                <!-- <div class="text-center">
                    Don't have account? <a href="register">Sign Up</a>
                </div> -->
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>