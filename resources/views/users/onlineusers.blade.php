@extends('layouts.master')
@section('content_header')
Online users
@endsection
@section('content')
<div class="card">
	<div class="card-header">Select users to show</div>
	<div class="card-body">
		<form>
			@csrf
			<div class="form-row">
				<div class="col">
					<select name="usertype" class="form-control usertype">
						<option value="">Choose ...</option>
						<option value="radius">Radius Server</option>
						<option value="nas">Nas</option>
					</select>
				</div>
				<div class="col" style="display:none;">
					<select name="nasid" class="form-control nasid">
						<option value="">Choose ...</option>
						@forelse($nas as $n)
						<option value="{{ $n->id }}">{{ $n->nasname }}</option>
						@empty
						<option value="">No nas added</option>
						@endforelse
					</select>
				</div>
			</div>
		</form>
		<hr>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-sm table-responsivetable-bordered table-md">
					<thead>
						<tr>
							<th colspan="7">Online users </th>
						</tr>
						<tr>
							<th>#</th>
							<th>Username</th>
							<th>Session Start Time</th>
							<th>Ip Address</th>
							<th>Nas Ip Address</th>
							<th>Total download</th>
							<th>Total Upload</th>
						</tr>
					</thead>
					<tbody class="tbody">
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
@section('js')
	<script type="text/javascript">
		$(document).ready(function(){
			$(".usertype").change(function(){
				var usertype=$(this).val();
				var _token=$("input[name='_token']").val();
				var id = 0;
				if(usertype!=""){
					if (usertype=='nas'){
						$(".nasid").change(function(){
							id = $(this).val();
							if(id!=0 && id!=''){

							}
						})
					}

					var req=$.ajax({
						method:"POST",
						url:"{{ route('getonlineusers') }}",
						data:{usertype:usertype,_token:_token,nasid:id},
					})

					req.done(function(result){
						if(result=='none'){
							$(".tbody").empty().html("<tr><td colspan='7'>No Customers online</td></tr>").addClass("alert alert-danger");
						}else if(result=="not supported!"){
							$(".tbody").empty().html("<tr><td colspan='7'>Not supported usertype</td></tr>").addClass("alert alert-danger");
						}
						else{
							$(".tbody").empty().html(result).removeClass("alert alert-danger");
						}
					})
				}
			})
		})
	</script>
@endsection