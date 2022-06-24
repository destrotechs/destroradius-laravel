@extends('layouts.master')
@section('content_header')
system settings
@endsection
@section('buttons')

@endsection
@section('content')
@if (session('success'))
   <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>{{ session('success') }}</strong>
</div>
@endif
<div class="card">
	<div class="card-header">System settings</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<div class="card">
			<div class="card-header"><h6>Logging</h6></div>
			<div class="card-body">
				@if($logging==1)
				<span class="badge badge-success"><i class="fas fa-check"></i> {{ 'enabled' }}</span>
				@else
				<span class="badge badge-danger"><i class="fas fa-close"></i> {{ 'Disabled' }}</span>
				@endif
				<div class="dropdown-divider"></div>
				<form>
					@if($logging==1)
					<a href="{{ route('logging',['en'=>0]) }}" class="btn btn-danger btn-sm">Disable</a>
					@else
					<a href="{{ route('logging',['en'=>1]) }}" class="btn btn-success btn-sm">Enable</a>
					@endif
				</form>
			</div>
		</div>
		<div class="card">
			<div class="card-header">Set Manager commission rates</div>
			<div class="card-body">
				<form class="form-row" method="post" action="{{ route('add.manager.commission') }}">
					@csrf
					<div class="col">
						<select class="form-control text-dark" name="managerid">
							<option value="">Select manager...</option>
							@forelse($managers as $m)
							<option value="{{ $m->id }}">{{ $m->name }}</option>
							@empty
							<option value="">No managers available</option>
							@endforelse
						</select>
					</div>
					<div class="col">
						<input type="text" name="rate" class="form-control" placeholder="rate %">
					</div>
					<div class="col">
						<button class="btn btn-success form-control"><i class="fas fa-save"></i> Add</button>
					</div>
				</form>
				<div class="dropdown-divider"></div>

			</div>
		</div>
		<div class="card">
			<div class="card-header">Add Risk Fees</div>
			<div class="card-body">
				<form class="form-row" method="POST" action="{{ route('post-risk-fee') }}">
					<div class="col">
						<select class="form-control" name="packageid" required>
							<option value="">Select package...</option>
							@forelse($packages as $p)
							<option value="{{ $p->id }}">{{ $p->packagename }}</option>
							@empty
							<option value="">No Packages available</option>
							@endforelse
						</select>
						<label>Daily Fee Amount</label>
						<input type="digit" name="amount" required class="form-control" placeholder="e.g 10">
					</div>
					<div class="col">
						<button class="btn btn-success form-control"><i class="fas fa-save"></i> Save</button>
					</div>
					@csrf
				</form>
				<div class="dropdown-divider"></div>

			</div>
		</div>
			</div>
			<div class="col-md-6">
				<table class="table table-sm table-responsivetable-bordered">
					<thead>
						<tr><th colspan="4">Manager commission rates</th></tr>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Email</th>
							<th>Rate</th>
						</tr>
					</thead>
					<tbody>
						<?php $num=0;?>
					@forelse($managerrates as $mr)
					<?php $num++;?>
					<tr>
						<td><?php echo $num;?></td>
						<td>{{ $mr->name }}</td>
						<td>{{ $mr->email }}</td>
						<td>{{ $mr->rate }}%</td>
					</tr>	
					@empty
					<tr>
						<td colspan="4">No managers assigned commission rates</td>
					</tr>
					@endforelse
					</tbody>
				</table>
				<hr>
				<table class="table table-sm table-responsivetable-bordered">
					<thead>
						<tr><th colspan="4">Package Risk Fees</th></tr>
						<tr>
							<th>#</th>
							<th>Package</th>
							<th>Fee</th>
						</tr>
					</thead>
					<tbody>
					@forelse($package_risk_fees as $key=>$f)
					<tr>
						<td>{{ $key+1 }}</td>
						<td>{{ $f->packagename }}</td>
						<td>{{ $f->amount }}</td>
					</tr>	
					@empty
					<tr>
						<td colspan="4">No risk fees defined yet</td>
					</tr>
					@endforelse
					</tbody>
				</table>
			</div>
		</div>
		
	</div>
</div>
@endsection