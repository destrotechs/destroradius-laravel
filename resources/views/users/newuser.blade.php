@extends('layouts.master')
@section('content')
@if (session('success'))
   <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>{{ session('success') }}</strong>
</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="">
        <form  method="post" action="{{ route('save.user') }}">
            @csrf
            <div class="row">
                <div class="card card-body col-md-6 br-1">
                    <label>Username</label>
                    <input name="username" class="form-control" placeholder="username">
                    <label>Password</label>
                    <input name="password" class="form-control" placeholder="password">
                    <label>Zone</label>
                <select class="form-control zone" name="zoneid">
                    <option value="">select zone ...</option>
                    @forelse($zones as $m)
                    <option value="{{  $m->id }}">{{ $m->zonename }}</option>
                    @empty
                    <option value="">No zones without managers</option>
                    @endforelse
                </select>
                <label>Default Nas for this user</label>
                    <select class="form-control" name="nasid" id="nases"></select>
                    <label>Phone</label>
                    <input name="phone" class="form-control" placeholder="users phone number">
                    <label>Is Reseller</label>
                        <select name="isreseller" class="form-control">
                            <option value="">Is Reseller? </option>
                            <option value="reseller">Yes</option>
                            <option value="not reseller">No</option>
                        </select>
                    {{-- <label>User Package</label>
                    <select name="package" class="form-control">
                        <option value="">Choose user package ...</option>

                        @forelse ($packages as $p)
                        <option value="{{ $p->packagename }}">{{ $p->packagename }}</option>
                        @empty
                        <option value="">no package is available, please add a package</option>
                        @endforelse
                        <option value="none">None</option>
                    </se lect>--}}

                </div>
                <div class="card card-body col-md-6">
                    {{-- <div class="form-check">
                        <input class="form-check-input allcustomers" name="allcustomers" type="checkbox" value="allcustomers" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                            Advanced
                        </label>
                      </div> --}}
                      {{-- <hr> --}}
                      <div class="advanced" style="display: block;">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="full name">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="email address ..">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <option value="">Choose user type ...</option>
                            <option value="prepaid">Prepaid</option>
                            <option value="postpaid">Postpaid</option>
                            <option value="hotspot">Hotspot User</option>
                            <option value="pppoe">PPPOE User</option>
                        </select>
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" placeholder="e.g 123 street">
                        <label>Gender</label>
                        <select name="gender" class="form-control">
                            <option value="">Choose customer gender ...</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="prefer not to say">Prefer Not To Say</option>
                        </select>
                        
                      </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-success btn-md"><i class="fas fa-plus"></i> Add customer</button>
        </form>
    </div>
@endsection
@section('js')
<script type="text/javascript">
	$(document).ready(function(){
		$(".allcustomers").click(function(){
			if($(this).prop('checked')==true){
				$(".advanced").show();
			}else{
				$(".advanced").hide();
            }

		})
        //listen to zone change and fetch nas according to zone selected
        $(".zone").change(function(){
            var id=$(this).val();
            var _token=$("input[name='_token']").val();
            var req=$.ajax({
                method:'POST',
                url:"{{ route('getnas') }}",
                data:{_token:_token,id:id},
            })
            req.done(function(result){

                $("#nases").html(result);
            })
        })
	})
</script>
@endsection
