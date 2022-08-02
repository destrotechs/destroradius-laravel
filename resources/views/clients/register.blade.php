@extends('layouts.clientslayout')


@section('content')
<div class="row d-flex justify-content-center">
<div class="card d-flex justify-content-center" style="width: 60em;">
    <div class="card-header">Create Account</div>
    <div class="card-body">
        <form method="POST" action="{{ route('post.customer.register') }}">
            <div class="form-row">
                <div class="col-md-6 col-sm-12">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="col-md-6 col-sm-12">
                        <label for="exampleInputPassword1">Phone</label>
                        <input type="digit" name="phone" class="form-control" id="exampleInputPassword1">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 col-sm-12">
                    <label for="exampleInputEmail1">username</label>
                    <input type="text" class="form-control" name="username" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="col-md-6 col-sm-12">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <input type="hidden" name="type" value="hotspot">
            </div>
            <div class="form-row">
                <div class="col-md-6 col-sm-12">
                    <label for="exampleInputPassword1">Zone</label>
<<<<<<< HEAD
                    <select name="zone" class="form-control">
=======
                    <select name="zone" class="form-control select2">
>>>>>>> feede6987acc94ec406849e2b8af3a4543003eae
                        <option value="">Select zone</option>
                        @forelse($zones as $key => $zone)
                            <option value="{{ $zone->id }}">{{ $zone->zonename }}</option>
                        @empty
                            <option value="">No zone available</option>
                        @endforelse
                    </select>
                </div>
                <div class="col-md-6 col-sm-12">
                    <label for="exampleInputPassword1">Gender</label>
<<<<<<< HEAD
                    <select name="gender" class="form-control">
=======
                    <select name="gender" class="form-control select2">
>>>>>>> feede6987acc94ec406849e2b8af3a4543003eae
                        <option value="">Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Prefer not to say">Prefer not to say</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 col-sm-12">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1">

                </div>
                <div class="col-md-6 col-sm-12">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" name="password_confirm" class="form-control" id="exampleInputPassword1">

                </div>
            </div>
            <br>
            @csrf
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
    </div>
</div>
</div>

@stop
