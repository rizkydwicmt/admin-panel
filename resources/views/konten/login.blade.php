<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in - Voler Admin Dashboard</title>
<!--===============================================================================================-->
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap.css') }}">
<!--===============================================================================================--> 
    <link rel="shortcut icon" href="{{ asset('/assets/images/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('/assets/css/app.css') }}">
<!--===============================================================================================-->
</head>

<body>
    <div id="auth">
        
<div class="container">
    <div class="row">
        <div class="col-md-5 col-sm-12 mx-auto">
            <div class="card pt-4">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <img src="{{ asset('/assets/images/favicon.svg') }}" height="48" class='mb-4'>
                        <h3>Sign In</h3>
                        <p>Please sign in to continue to Voler.</p>
                    </div>
                    <form method="POST" action="">
                        @csrf
                        <div class="form-group position-relative has-icon-left">
                            <label for="username">Username</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" name="username" placeholder="username">
                                <div class="form-control-icon">
                                    <i data-feather="user"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left">
                            <div class="clearfix">
                                <label for="password">Password</label>
                                <a href="auth-forgot-password.html" class='float-right'>
                                </a>
                            </div>
                            <div class="position-relative">
                                <input type="password" class="form-control" name="password" placeholder="password">
                                <div class="form-control-icon">
                                    <i data-feather="lock"></i>
                                </div>
                            </div>
                        </div>

                        <div class='form-check clearfix my-4'>
                            <div class="checkbox float-left">
                                <input type="checkbox" id="checkbox1" class='form-check-input' >
                                <label for="checkbox1">Remember me</label>
                            </div>
                        </div>
                        @if(\Session::has('alert-danger'))
                            <div class="alert alert-danger">
                                <div>
                                    {{Session::get('alert-danger')}}
                                    {{Session::forget('alert-danger')}}
                                </div>
                            </div>
                        @endif
                        @if(\Session::has('alert-primary'))
                            <div class="alert alert-primary">
                                <div>
                                    {{Session::get('alert-primary')}}
                                    {{Session::forget('alert-primary')}}
                                </div>
                            </div>
                        @endif
                        <div class="clearfix">
                            <button class="btn btn-primary float-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
<!--===============================================================================================-->
    <script src="{{ asset('/assets/js/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('/assets/js/app.js') }}"></script>
<!--===============================================================================================-->
    <script src="{{ asset('/assets/js/main.js') }}"></script>
<!--===============================================================================================-->
</body>

</html>
