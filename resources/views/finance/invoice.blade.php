@extends('layouts.master')
@section('buttons')
<div class="col-lg-6 col-5 text-right">
<button class="btn btn-white btn-md" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus-circle"></i> New Invoice</button>
</div>
@endsection
@section('content_header')
Send Invoice
@endsection
@section('content')
<div class="card">
	<div class="card-body table-responsive p-0">
		<table class="dTable table table-head-fixed text-nowrap table-sm">
			<thead style="color: black">
				<tr>
					<th>#</th>
					<th>Invoice Number</th>
					<th>Customer</th>
					<th>Rate</th>
					<th>Invoice Date</th>
					<th>Invoice Amount</th>
					<th>From</th>
					<th>To</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				@foreach ( $invoices as $key=>$inv )
					<tr>
						<td>{{ $key+1 }}</td>
						<td>{{ $inv->invoice_no }}</td>
						<td>{{ $inv->customer_id }}</td>
						<td>{{ $inv->rate }}</td>
						<td>{{ $inv->invoice_date }}</td>
						<td>{{ $inv->amount }}</td>
						<td>{{ $inv->start_date }}</td>
						<td>{{ $inv->end_date }}</td>
						<td>{{ $inv->status }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
{{-- <div class="row">
	<div class="col-md-12">
		
		<div class="card">
			<div class="card-header"><h4>Invoice Details</h4></div>
			<div class="card-body table-responsive p-0">
				<table class="dTable table table-head-fixed text-nowrap table-sm">
					<thead style="color: black">
						<tr>
							<th>#</th>
							<th>Invoice Number</th>
							<th>Customer</th>
							<th>Rate</th>
							<th>Invoice Date</th>
							<th>Invoice Amount</th>
							<th>From</th>
							<th>To</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						@forelse($invoices as $key=>$inv)
						<tr>
							<td>{{ $key+1 }}</td>
							<td>{{ $inv->invoice_no }}</td>
							<td>{{ $inv->customer_id }}</td>
							<td>{{ $inv->rate }}</td>
							<td>{{ $inv->invoice_date }}</td>
							<td>{{ $inv->amount }}</td>
							<td>{{ $inv->start_date }}</td>
							<td>{{ $inv->end_date }}</td>
							<td>{{ $inv->status }}</td>
						</tr>
						@empty
						<tr><td colspan="9">There are no invoices to show</td></tr>
						@endforelse
					</tbody>
				</table>
			</div>
			</div>
		</div>
	</div>
	{{-- <div class="col-md-8">
		<iframe
		    src="{{ route('invoice.doc') }}"
		    frameBorder="0"
		    scrolling="auto"
		    height="100%"
		    width="100%"
		></iframe>
	</div> --}}
{{-- </div> --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3" method="POST" action="{{ route('invoice.post') }}">
        	@csrf
		  <div class="col-md-6">
		    <label for="inputPassword4" class="form-label">Invoice Number</label>
		    <input type="text" name="invoice_no" class="form-control" id="inputPassword4">
		  </div>
		  <div class="col-md-6">
		    <label for="inputEmail4" class="form-label">Customer</label>
		    <select class="form-control select2" name="customer">
		    	<option value="">Select Customer ...</option>
		    	@forelse($customers as $c)
		    	<option value="{{ $c->id }}">{{ $c->name }}</option>
		    	@empty
		    	<option value="">No customers available</option>
		    	@endforelse
		    </select>
		  </div>		 
		  <div class="col-12">
		    <label for="inputAddress" class="form-label">Invoice Date</label>
		    <input type="date" class="form-control" name="invoice_date" required id="inputAddress" placeholder="rate">
		  </div>
		  <div class="col-12">
		    <label for="inputAddress" class="form-label">Due Date</label>
		    <input type="date" class="form-control" name="due_date" required id="inputAddress" placeholder="rate">
		  </div>
		  <div class="col-6">
		    <label for="inputAddress2" class="form-label">From</label>
		    <input type="date" name="start_date" class="form-control" id="from">
		  </div>
		  <div class="col-md-6">
		    <label for="inputCity" class="form-label">To</label>
		    <input type="date" name="end_date" class="form-control" id="to">
		  </div>
		  <div class="col-6">
		    <label for="inputAddress" class="form-label">Rate</label>
		    <input type="text" class="form-control" name="rate" id="rate" placeholder="rate">
		  </div>
		  <div class="col-6">
		    <label for="inputAddress" class="form-label">Measure/Per</label>
		    <select id="measure" class="form-control select2" name="measure">
		    	<option value="">Choose Measure ...</option>
		    	<option value="DAY">PER DAY</option>
		    	<option value="MONTH">PER MONTH</option>
		    	<option value="MB">PER MB</option>
		    </select>
		  </div>
		  <div class="col-12">
		    <label for="inputAddress" class="form-label">Amount</label>
		    <input type="number" class="form-control" name="amount" id="amount" placeholder="rate">
		  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save Invoice</button>
      </div>
  </form>
    </div>
  </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="times" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        body
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
 <!-- Modal2 -->
  <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">Delete User Records</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			<iframe
		    src="{{ route('invoice.doc') }}"
		    frameBorder="0"
		    scrolling="auto"
		    height="100%"
		    width="100%"
		></iframe>
        </div>
        <div class="modal-footer">
        	 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      
        </div>
	  </div>
	</div>
  </div>
@endsection
@section('js')
<script type="text/javascript">
	$(document).ready(function(){
		$("#measure").change(function(){
			var measure = $(this).val();
			calculateAmount(measure);
		})

		function calculateAmount(measure=null){
			var start = new Date ($("#from").val());
			var end = new Date ($("#to").val());
			var difference = end.getTime() - start.getTime();
			var days = Math.ceil(difference / (1000 * 3600 * 24));
			var rate = $("#rate").val();
			var amount = 0;
			if (!days){
				alert("select from and to dates");
			}else{
				if (measure=='DAY' && rate!=0){
					amount = days*rate;
				}else if(measure=='MONTH'){
					amount = (days/30) * rate;
				}
			}
			$("#amount").val(amount);
		}
	})
</script>
@endsection
