@extends('layouts.master')
@section('buttons')
<div class="col-lg-6 col-5 text-right">
<a href="#" class="btn btn-white btn-sm" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i>&nbsp;New User Account</a>
</div>
@endsection
@section('content_header')
Edit user account
@endsection

@section('content')
<div class="card">
	<div class="card-header"><h4>Edit {{ $account->account_no }}</h4></div>
	<div class="card-body">
		<form method="POST" action="{{ route('edit.customer.account.post') }}">
			<div class="form-row">
				<div class="col-md-6 col-sm-12">
					<label>Account Name</label>
					<input type="text" name="account_name" class="form-control" placeholder="Account Name" value="{{ $account->account_name??'' }}">
				</div>
				<input type="hidden" name="account_no" value="{{ $account->account_no }}">
				<div class="col-md-6 col-sm-12">
					<label>Town</label>
					<input type="text" name="town" class="form-control" placeholder="Physical Address" value="{{ $account->town??'' }}">
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6 col-sm-12">
					<label>Physical Address</label>
					<input type="text" name="address" class="form-control" placeholder="Account Name" value="{{ $account->address??'' }}">
				</div>
				<div class="col-md-6 col-sm-12">
					<label>Building</label>
					<input type="text" name="building" class="form-control" placeholder="Building" value="{{ $account->building??'' }}">
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-12 col-sm-12">
					<label>Coordinates</label>
					<input type="text" name="coordinates" class="form-control" placeholder="Coordinates" value="{{ $account->coordinates??'' }}">
				</div>
			</div>
			<div class="form-row">
				{{-- <input type="hidden" name="package_name" id="packname" value="{{ $account->package_name }}"> --}}
				<label>Package Subscribed</label>
				<select class="form-control pack select2" name="package_name">
					<option value="">Choose package ...</option>
					@forelse($packages as $p)
					<option value="{{ $p->packagename }}" <?php echo $p->packagename==$account->package_name? 'selected':''?>>{{ $p->packagename }}</option>
					@empty
					<option value="">No packages available</option>
					@endforelse
				</select>
			</div>
			@csrf
			<br>
			<div class="form-row">
				<div class="col-md-12 col-sm-12">
					<button class="btn btn-success btn-md" type="submit">Save changes</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
	$(document).ready(function(){
		$(".pack").change(function(){
			var package = $(this).val();
			$("#packname").val(package);
		})
	})
</script>
@endsection