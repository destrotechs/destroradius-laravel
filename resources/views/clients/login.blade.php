@extends('layouts.clientslayout')

@section('content')
<div class="row d-flex justify-content-center">
    <div class="card" style="width: 40em;">
        <div class="card-header d-flex justify-content-center"><h3>Login To Your Account</h3></div>
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form method="POST" action="{{ route('post.customer.login') }}">

                <div class="form-group">
                  <label for="exampleInputEmail1">username</label>
                  <input type="text" class="form-control" name="username" id="exampleInputEmail1" aria-describedby="emailHelp">

                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                </div>
                @csrf
                <div class="form-row">
                    <div class="col-md-6 col-sm-12">                        
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                    @if(isset($usertype) && $usertype=='hotspot')
                    <div class="col-md-6 col-sm-12">
                        <a href="{{ route('get.customer.register') }}" class="nav-link">New User? Register an account.</a>
                    </div>
                    @endif
                </div>
              </form>
        </div>
    </div>
</div>


  @stop
