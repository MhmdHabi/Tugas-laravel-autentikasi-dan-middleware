<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <header class="bg-info">
        <nav class="d-flex justify-content-between pt-2">
            <p class="fw-bold fs-4 ms-3">Amandemy Market</p>
            <div class="me-5 mt-2">
                <a href="{{ route('login') }}" class="text-decoration-none  fw-bold fs-6 text-black">Login</a>
                <a href="{{ route('register') }}" class="text-decoration-none fw-bold fs-6 text-black ms-2">Register</a>
            </div>
        </nav>
    </header>
    <main class="bg-info mx-5 rounded-1 mt-3">
        <h1 class="mb-0 fs-2 fw-bold text-center">Login</h1>
        <div class="mt-3 bg-dark mx-auto rounded" style="height: 3px;width: 75px"></div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-4 border p-4 rounded bg-white mb-3">

                <!-- error message -->
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <!-- success message -->
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('login_user') }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="Masukan Email Kamu" required>
                        @error('email')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Masukan Password Kamu" required>
                        @error('password')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="w-100 btn btn-primary">Login</button>
                    {{-- <a href="{{ route('login_google') }}" class="w-100 btn btn-lg btn-danger mt-2">Login with Google</a> --}}
                </form>
            </div>
        </div>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

</html>
