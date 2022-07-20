@extends('layouts.master')
@section('content_header')
user accounting
@stop
@section('content')
<div class="card">
	<div class="card-header"></div>
	<div class="card-body">
		<form id="useraccounting">
			<div class="form-row">
				<div class="col">
					<input type="text" name="username" class="form-control username" placeholder="enter a username">
				</div>
				<div class="col">
					<button class="btn btn-md btn-primary" type="submit">Search</button>
				</div>
			</div>
			@csrf
		</form>
		<div class="dropdown-divider"></div>
		<div class="output"></div>
	</div>
</div>
@stop
@section('js')
<script type="text/javascript">
	$(document).ready(function(){
		$(".username").on('keyup',function(){
			var username=$(this).val();
			var _token=$("input[name='_token']").val();

			if(username!=""){
				fetchAccounts(username,_token);
			}else{
				$(".output").empty();
			}
		})

		$("#useraccounting").on('submit',function(){
			var username=$(".username").val();
			var _token=$("input[name='_token']").val();

			if(username!=""){
				fetchAccounts(username,_token);
			}else{
				$(".output").empty();
			}
		})

		function fetchAccounts(username,_token){
			var req = $.ajax({
				method:"POST",
				url:"{{ route('getuseraccountingdetails') }}",
				data:{username:username,_token:_token},
			})

			req.done(function(result){
				$(".output").html(result);
			})
		}
	})
	
</script>
@stop