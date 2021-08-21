@extends('layouts.clients')

@section('content')
<div class="card d-flex justify-content-center" style="width: 40em;">
    <div class="card-header"></div>
    <div class="card-body">
        <form method="POST" action="{{ url('post.customer.register') }}">
            <div class="form-group">
              <label for="exampleInputEmail1">username</label>
              <input type="text" class="form-control" name="username" id="exampleInputEmail1" aria-describedby="emailHelp">
              <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" name="password" class="form-control" id="exampleInputPassword1">
            </div>
            @csrf
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
    </div>
</div>

  @stop
