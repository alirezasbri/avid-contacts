<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>User Login</title>

@include('layouts.bootstrap')

    {{--    <!-- Custom styles for this template -->--}}
    {{--    <link href = {{ asset("bootstrap/css/sticky-footer-navbar.css") }} rel="stylesheet" />--}}

    {{--    <!-- Optional theme -->--}}
    {{--    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap-theme.min.css') }}">--}}
</head>
<body>
<h1>Login Form</h1>
<form action="{{ route('user.login') }}" method="post">
    {!! csrf_field() !!}
    <div class="form-group">
        <label for="usernameInput">UserName</label>
        <input type="text" name="username" class="form-control" id="usernameInput" placeholder="Username">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
    <a href="{{route('user.register')}}">
        <button type="button" class="btn btn-dark">Register</button>
    </a>

</form>
</body>

