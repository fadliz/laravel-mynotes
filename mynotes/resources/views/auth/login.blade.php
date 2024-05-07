<!DOCTYPE html>
<html lang="en">

<head>
    <title>SB Admin 2 - Login</title>
    @include('template.head')

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form id="loginForm" class="user">
                                        @csrf

                                        <!-- Email Address -->
                                        <div class="form-group">
                                            <x-input-label for="email" :value="__('Email')" />
                                            <x-text-input id="email" class="form-control form-control-user" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>

                                        <!-- Password -->
                                        <div class="form-group">
                                            <x-input-label for="password" :value="__('Password')" />

                                            <x-text-input id="password" class="form-control form-control-user"
                                                            type="password"
                                                            name="password"
                                                            required autocomplete="current-password" />

                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>

                                        <!-- Remember Me -->
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck" name="remember">
                                                <label class="custom-control-label" for="customCheck">{{ __('Remember Me') }}</label>
                                            </div>
                                        </div>

                                        <button id="loginButton" type="button" class="btn btn-primary btn-user btn-block">
                                            {{ __('Log in') }}
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        @if (Route::has('password.request'))
                                            <a class="small" href="forgot-password">Forgot Password?</a>
                                        @endif    
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    @include('template.script')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const loginForm = document.getElementById('loginForm');
            const loginButton = document.getElementById('loginButton');

            loginButton.addEventListener('click', function(event) {
                event.preventDefault();

                const formData = new FormData(loginForm);
                const xhr = new XMLHttpRequest();

                xhr.open('POST', "{{ route('login') }}", true);
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader('Accept', 'application/json');

                xhr.onreadystatechange = function() {
                    console.log(xhr.readyState);
                    console.log('first test');
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        console.log('second test');
                        console.log(xhr.status);
                        if (xhr.status === 200) {
                            const response = JSON.parse(xhr.responseText);
                            console.log(response.redirect);
                            if (response.redirect) {
                                window.location.href = response.redirect;
                            } else {
                                console.error('Login response does not contain redirect URL:', response);
                            }
                        } else if (xhr.status === 204) {
                            // Successful login without redirect URL
                            window.location.href = "{{ route('dashboard', [], false) }}";
                        } else {
                            // Handle error response
                            console.error('Login failed:', xhr.responseText);
                            const errorResponse = JSON.parse(xhr.responseText);
                            if (errorResponse && errorResponse.errors) {
                                // Display error messages to the user
                                // You can customize this part to fit your UI/UX
                                alert(Object.values(errorResponse.errors).join('\n'));
                            } else {
                                console.error('Unexpected error response format:', errorResponse);
                            }
                        }
                    }
                };

                xhr.send(formData);
            });
        });
    </script>

</body>

</html>
