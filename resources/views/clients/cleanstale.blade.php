@extends('layouts.clientslayout')

@section('content')
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@section('page_info')
<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('client.bundles')}}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Clean my connections</li>
  </ol>
</nav>
@endsection
<div class="card">
<div class="card-body">
	<div class="message"></div>
	<form id="cleanconnections">
		<div id="err"></div>

		<label>Access Code/Username</label>
		<input type="text" class="form-control" name="username" value="@if(isset(Auth::user()->username )){{ Auth::user()->username }}@else {{ '' }}@endif" id="username">
		<small>Enter the Access code here and click clean connection</small>
		<br>
		<button class="btn btn-success btn-md" type="submit">Clean Connections</button>
		{{ csrf_field() }}
	</form>
	<br>

</div>
<div class="dropdown-divider"></div>
	<p class="alert alert-info">This page is usefull if you have trouble in signing in to access internet and you are sure that your plan is still active.</p>
</div>

@endsection
@section('js')
<script type="text/javascript">
	$(document).ready(function(){
		$("#username").on('keydown',function(){
			$("#err").empty().removeClass('alert alert-danger');
		})
		$("#cleanconnections").submit(function(e){
			var username=$("#username").val();
			var _token=$("input[name='_token']").val();
			if(username!=" " && username!="NULL"){
				var req = $.ajax({
					method:'POST',
					url:"{{ route('user.post.cleanstale') }}",
					data:{username:username,_token:_token},
				})

				req.done(function(data){
					if (data=='success') {
						$(".message").html("Successfully Cleaned stale connections for user "+username).removeClass('alert alert-danger').addClass('alert alert-success');
					}else{
						$(".message").html("There are no stale connection for user "+username).removeClass('alert alert-success').addClass('alert alert-danger');
					}
				})
			}else{
				$("#err").html("add a valid username").addClass('alert alert-danger');
			}
			e.preventDefault();
		})
	})
</script>
@endsection
