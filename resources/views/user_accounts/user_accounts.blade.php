@extends('layouts.master')
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
		<table class="table table-xs table-striped table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Account(s)</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@forelse($customers as $key=>$ac)
				<tr>
					<td>{{ $key+1 }}</td>
					<td>{{ $ac->name }}</td>
					{{-- <td>{{ count($customer_accounts[$key])?? 'None' }}</td> --}}
					<td>
						@if(count($customer_accounts)>0 && count($customer_accounts[$key])>0)
						<table class="table table-xs table-bordered">
							<tr>
								<td>Accesscode</td>
								<td>Status</td>
							</tr>
							<?php
							for($i=0;$i<count($customer_accounts);$i++){
								echo '<tr><td>'.$customer_accounts[$key][$i]->account_no.'</td><td>'.$customer_accounts[$key][$i]->status.'</td></tr>';
							}
						?>
						</table>
								


						@else
						<table class="table table-xs">
							<tr>
								<td colspan="2">
									
									<div class="text-danger text-sm">User has no associated accounts</div>
								</td>
							</tr>
						</table>
						@endif
					</td>
				</tr>
				@empty
				<tr>
					<td colspan="3">No user accounts available</td>
				</tr>
				@endforelse
			</tbody>
		</table>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Customer User Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
        	<label>User </label>
        	<select class="form-control" name="owner">
        		<option value="">Choose ...</option>
        		@forelse($customers as $c)
        		<option value="{{ $c->username }}">{{ $c->name }}</option>
        		@empty
        		<option value="">No users available</option>
        		@endforelse
        	</select>
        	<label>Account Type</label>
        	<select name="account_name" class="form-control">
        		<option value="">select ...</option>
        		<option value="pppoe"> PPPoE</option>
        		<option value="hotspot">HOTSPOT</option>
        	</select>
        	<label>Account No</label>
        	<input type="text" required name="account_no" class="form-control num" placeholder="Account No ...">
        	<hr><button class="btn btn-primary btn-sm gen" type="button">Generate</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add New Account</button>
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

		function generateNumber(){
			return Math.floor((Math.random() * 10000) + 1);
		}
	})
</script>
@endsection