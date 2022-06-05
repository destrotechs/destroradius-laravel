@extends('layouts.clientslayout')
@section('page_info')
<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('client.bundles')}}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Check Balance</li>
  </ol>
</nav>
@endsection
@section('content')
<div class="card">
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
