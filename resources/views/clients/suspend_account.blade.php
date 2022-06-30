@extends('layouts.clientslayout')
@section('buttons')
<div class="col-lg-6 col-5 text-right">
<a href="#" class="btn btn-white btn-sm" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i>&nbsp;New User Account</a>
</div>
@endsection
@section('content_header')
User accounts
@endsection
@section('content')
<div class="card">
	{{-- <div class="card-header"><h5>Logs</h5></div> --}}
	<div class="card-body">
		
						@if(count($accounts)>0 && count($accounts)>0)
						<table class="table table-xs table-bordered">
							<tr>
								<td>Access code/Account Name</td>
								<td>Status</td>
								<td>Action</td>
							</tr>
							@foreach($accounts as $k=>$c)
							<tr>
								<td>{{ $c->account_no }}</td>
								<td>{{ $c->status }}</td>
								<td>
									@if($c->status=='active')
									<a href="#" id="{{ $c->id }}" class="btn btn-sm btn-danger diactivate">Diactivate</a>
									@else
									<a href="#" id="{{ $c->id }}" class="btn btn-primary btn-sm activate" data-toggle="modal" data-target="#exampleModal2">Activate</a>
									@endif
								</td>
							</tr>
							@endforeach
							
						</table>							


						@else
					
						<div class="text-danger text-sm">User has no associated accounts</div>
								
						@endif
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Activate Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<form method="POST" action="{{ route('customer.changepackage.post') }}">
        <input type="hidden" name="username" id="username">
        <input type="hidden" name="account_no" id="account_no">
        <input type="hidden" name="package" id="package">
        <h3>Are you sure you want to Activate this account?</h3>    	

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">NOPE</button>
        <button type="submit" class="btn btn-success">YES!</button>
      </div>
      @csrf
      </form>
    </div>
  </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
	$(document).ready(function(){
		$(".gen").click(function(){
			var account = generateNumber();
			$(".num").val(account);
		})

		$(".activate").click(function(){
			var account_id = $(this).attr('id');
			$.ajax({
				method:'GET',
				url:'/user/accounts/'+account_id,
				success:function(data){
					$("#username").val(data[0]['owner']);
					$("#account_no").val(data[0]['account_no']);
					$("#package").val(data[0]['package_name']);
					console.log(data[0]['package_name'])
				}
			})
		})

		function generateNumber(){
			return Math.floor((Math.random() * 10000) + 1);
		}
	})
</script>
@endsection