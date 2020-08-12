<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>User Register</title>

    <!-- Bootstrap core CSS -->
    <link href={{ asset("bootstrap/css/bootstrap.css") }} rel="stylesheet"/>

</head>
<body style="margin: 20px">
<h1>Register Form</h1>

@include('layouts.errors')

<form action="{{ route('user.register') }}" method="post">
    {!! csrf_field() !!}
    <div class="form-group">
        <label for="usernameInput">UserName</label>
        <input type="text" name="username" class="form-control" id="usernameInput" placeholder="Username">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" id="name" placeholder="Name">
    </div>
    <div class="form-group">
        <label for="family">Family</label>
        <input type="text" name="family" class="form-control" id="family" placeholder="Family">
    </div>
    <button type="submit" class="btn btn-primary">Register</button>

</form>
</body>

