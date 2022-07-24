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
					<select name="usertype" class="form-control usertype select2">
						<option value="">Choose ...</option>
						<option value="radius">Radius Server</option>
						<option value="nas">Nas</option>
					</select>
				</div>
				<div class="col nas" style="display:none;">
					<select name="nasid" class="form-control nasid select2">
						<option value="">Choose nas...</option>
						<option value="All">All Nas</option>
						@forelse($nas as $n)
						<option value="{{ $n->id }}">{{ $n->nasname }} >>>> {{ $n->shortname }}</option>
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
				<div class="card">
					<div class="card-body table-responsive p-0">
						<table class="dTable table table-head-fixed text-nowrap table-sm">
							<thead style="color: black">
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
	</div>
</div>
@endsection
@section('js')
	<script type="text/javascript">
		$(document).ready(function(){
			var id = 0;
			var _token='';
			var usertype = null;
			$(".usertype").change(function(){
				usertype=$(this).val();
				_token=$("input[name='_token']").val();
				
				if(usertype!=""){
					if (usertype=='nas'){
						$(".nas").show();
						$(".nasid").change(function(){
							id = $(this).val();
							if(id!=0 && id!=''){
								fetchUsers();
							}
						})
					}else{
						fetchUsers();
					}
					
				}
			})
			function fetchUsers(){
				$(".tbody").empty().html("<tr><td colspan='7'>Loading...</td></tr>").removeClass('alert-danger');
				var req=$.ajax({
						method:"POST",
						url:"{{ route('getonlineusers') }}",
						data:{usertype:usertype,_token:_token,nasid:id},
					})

					req.done(function(result){
						if(result=='none'){
							$(".tbody").empty().html("<tr><td colspan='7'>No Customers online</td></tr>").addClass("alert alert-danger");
						}
						else{
							$(".tbody").empty().html(result).removeClass("alert alert-danger");
						}
					})
			}
		})
	</script>
@endsection