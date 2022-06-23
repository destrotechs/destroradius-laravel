@extends('layouts.clientslayout')
@section('content')

<h4>{{ ($user_type=='hotspot' || $username=='')? 'Bundle Balance':'Internet Access Information' }}</h4><br>
<div class="card">
@if($user_type=='' or $user_type=='hotspot')
<div class="card-body">
	<table class="table table-sm table-responsivetable-bordered table-striped table-responsive" style="display: none;">
		<thead>
			<tr>
				<th id="user" colspan="3"></th>
			</tr>
			<tr>
				<th>Bundle Bought</th>
				<th>Bundle used</th>
				<th>Balance</th>
			</tr>
		</thead>
		<tbody class="res"></tbody>
	</table><br>
	<form id="checkbalance">
		<div id="err"></div>

		<label>Username</label>
		<input type="text" class="form-control" name="username" placeholder="username" id="username">
		<small>Enter the username here and click check</small>
		<br>
		<button class="btn btn-success btn-md" type="submit">Check</button>
		{{ csrf_field() }}
	</form>
	<br>

</div>
@else
<div class="card-body d-flex justify-content-center">
	@if($user_info!='')
	<h3>Hi <b>{{ $username }}</b>, Your access is valid until <b>{{ $user_info->value??'' }}</b></h3>
	@else
	<h3>You have no active internet access</h3>
	@endif
</div>
@endif
</div>

@endsection
@section('js')
<script type="text/javascript">
	$(document).ready(function(){
		$("#username").on('keydown',function(){
			$("#err").empty().removeClass('alert alert-danger');
		})
		$("#checkbalance").submit(function(e){
			var username=$("#username").val();
			var _token=$("input[name='_token']").val();
			if(username!=""){
				var req = $.ajax({
					method:'POST',
					url:"{{ route('user.check.balance') }}",
					data:{username:username,_token:_token},
				})

				req.done(function(data){
					if (data=='error') {
						$("#err").html("<b>"+username+"</b> has no bundle plan history").addClass('alert alert-danger');
						$("table").hide();
					}else{
						$("#user").html(username+" Bundles statistics");
						$('table').show();
						$(".res").html(data);
					}
				})
			}else{
				$("#err").html("add a valid username to view balance").addClass('alert alert-danger');
			}
			e.preventDefault();
		})
	})
</script>
@endsection
