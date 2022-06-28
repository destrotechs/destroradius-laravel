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

		<label>Account Code</label>
		<input type="text" class="form-control" name="username" placeholder="Access Code" id="username">
		<small>Enter the account code here and click check</small>
		<br>
		<button class="btn btn-success btn-md" type="submit">Check</button>
		{{ csrf_field() }}
	</form>
	<br>

</div>
@else
<div class="card-body d-flex justify-content-center">
	{{-- @if($user_info!='')
	<h3>Hi <b>{{ $username }}</b>, Your access is valid until <b>{{ $user_info->value??'' }}</b></h3>
	@else
	<h3>You have no active internet access</h3>
	@endif --}}
	@if(count($accounts)>0)
	<table class="table table-sm table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>Access Code</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($accounts as $k=>$ac)
			<tr>
				<td>{{ $k+1 }}</td>
				<td>{{ $ac->account_no }}</td>
				<td>{{ $ac->status }}</td>
				<td>
					@if(CustomerHelper::isSuspended($ac->account_no) || $ac->status=='inactive')
		            <a class="btn btn-primary btn-sm p-2 activate" href="#" id="{{ $ac->account_no }}" data-toggle="modal" data-target="#exampleModal3"><i class="fas fa-wifi text-danger"></i> Activate Connection</a>
		            @else
		            <a class="btn btn-danger btn-sm p-2" href="#" id="{{ $ac->account_no }}" data-toggle="modal" data-target="#exampleModal6"><i class="fas fa-wifi text-danger"></i> Suspend Connection</a>
		            @endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
		
	@else
	<div class="alert alert-danger">Dear customer, You have not internet subscriptions</div>
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
		$(".activate").click(function(){
          var username = $(this).attr('id');

          $("#username").val(username);
        })
	})
</script>
@endsection
