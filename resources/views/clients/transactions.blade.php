@extends('layouts.clientslayout')

@section('content')
<div class="card">
	<div class="card-body">
		<table class="table table-sm table-responsivetable-bordered table-sm table striped">
			<thead>
				<tr>
					<th colspan="7">{{ Auth::guard('customer')->user()->name }}&nbsp; Transactions</th>
				</tr>
				<tr>
					<th>Username</th>
					<th>Plan Bought</th>
					<th>Amount Paid</th>
					<th>Receipt No</th>
					<th>Phone Number</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				@forelse($transactions as $t)
				<tr>
					<td>{{ $t->username }}</td>
					<td>{{ $t->packagebought }}</td>
					<td>{{ $t->amount }}</td>
					<td>{{ $t->transactionid }}</td>
					<td>{{ $t->phonenumber }}</td>
					<td>{{ date('Y/m/d', strtotime(substr($t->transactiondate,0,8)))}}</td>
				</tr>
				@empty
				<tr>
					<td colspan="7"><div class="alert alert-danger">You have no transactions yet</div></td>
				</tr>
				@endforelse
			</tbody>
		</table>
	</div>
</div>
@endsection
