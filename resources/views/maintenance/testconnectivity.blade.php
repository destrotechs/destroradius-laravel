@extends('layouts.master')
@section('content_header')
    Test User Connectivity
@endsection
@section('content')
<div class="row">
	<div class="col-md-7">
<div class="card">
	<div class="card-header">Fill the details and click test</div>
	<div class="card-body">
		<form>
			<label>Username</label>
			<input type="text" name="username" id="username" class="form-control" value="{{ $user }}">
			<label>Password</label>
			<input type="text" name="password" id="password" class="form-control" value="{{ $cleart }}">
			<label>Radius port</label>
			<input type="text" name="radiusport" id="radiusport" readonly class="form-control" value="1812">
			<label>Radius server Address</label>
			<input type="text" name="server" id="server" class="form-control" value="127.0.0.1">
			<label>Nas Port</label>
			<input type="text" name="nasport" id="nasport" class="form-control" value="0">
			<label>Nas Secret</label>
			<input type="text" name="secret" id="nassecret" class="form-control" value="testing123">
			<hr>
			<button type="button" class="btn btn-success btn-md test">Test</button>
			{{ csrf_field() }}
		</form>
	</div>
</div>
</div>
<div class="col-md-5 card card-body p-4">
	<div class="bg-info p-3 text-white res" style="display: none;"></div>
	<center><p class="card-text mt-5" style="opacity: 0.1;">Test result appear here</p></center>
</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
	$(document).ready(function(){
		$(".test").click(function(){
			var username=$("#username").val();
			var _token=$('input[name="_token"]').val();
			var password=$("#password").val();
			var server=$("#server").val();
			var nasport=$("#nasport").val();
			var nassecret=$("#nassecret").val();
			if(username!="" && password!=""){
				$.ajax({
					method:"post",
					url:"{{ route('testconn') }}",
					data:{_token:_token,username:username,password:password,server:server,nasport:nasport,nassecret:nassecret},
					success:function(result){
						$(".res").html(result).show();
					}
				});
			}else{
				alert("Enter a valid username and password");
			}
		})
	})
</script>
@endsection