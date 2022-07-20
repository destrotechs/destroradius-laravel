<!DOCTYPE html>
<!-- saved from url=(0051)https://getbootstrap.com/docs/5.0/examples/sign-in/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.83.1">
    <title>Signin Template · Bootstrap v5.0</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">



    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/argon.css?v=1.2.0')}}" type="text/css">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>


    <!-- Custom styles for this template -->
    <link href="{{ asset('login.blade_files/signin.css') }}" rel="stylesheet">
  </head>
  <body class="">

<main class="form-signin">

    <div class="card">
      <div class="card-header text-center">
          <img src="{{ asset('images/u2.png') }}"><br>
        <h4>Sign In Here</h4></div>
      <div class="card-body">

        <form method="POST" action="{{ route('post.customer.login') }}">
            <div class="form-group">
                <label for="exampleInputEmail1">username</label>
                <input type="text" class="form-control" name="username" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
              </div>

              {{-- <button type="submit" class="btn btn-primary">Login</button> --}}
      </div>
      <div class="card-footer">
          {{ csrf_field() }}
        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
      </div>
      </form>
    </div>
</main>





</body></html>
