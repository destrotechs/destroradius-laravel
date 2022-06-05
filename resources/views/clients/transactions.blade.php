@extends('layouts.clientslayout')
@section('page_info')
<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('client.bundles')}}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Transactions</li>
  </ol>
</nav>
@endsection
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
					<td>{{ date('d/m/Y', strtotime($t->transactiondate))}}</td>
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
