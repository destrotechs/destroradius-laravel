@extends('layouts.master')
@section('content_header')
ip accounting
@stop
@section('content')
<div class="card">
	<div class="card-header"></div>
	<div class="card-body">
		<form id="ipaccounting">
			<div class="form-row">
				<div class="col">
					<input type="text" name="ip" class="form-control ip" placeholder="enter ip address">
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
		$(".ip").on('keyup',function(){
			var ip=$(this).val();
			var _token=$("input[name='_token']").val();

			if(ip!=""){
				fetchAccounts(ip,_token);
			}else{
				$(".output").empty();
			}
		})

		$("#ipaccounting").on('submit',function(){
			var username=$(".ip").val();
			var _token=$("input[name='_token']").val();

			if(username!=""){
				fetchAccounts(ip,_token);
			}else{
				$(".output").empty();
			}
		})

		function fetchAccounts(ip,_token){
			var req = $.ajax({
				method:"POST",
				url:"{{ route('ipaccounting') }}",
				data:{ip:ip,_token:_token},
			})

			req.done(function(result){
				$(".output").html(result);
			})
		}
	})
	
</script>
@stop