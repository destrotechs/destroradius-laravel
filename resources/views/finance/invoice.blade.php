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
<div class="row">
	<div class="col-md-12">
		
		<div class="card">
			<div class="card-header"><h4>Invoice Details</h4></div>
			<div class="card-body">
				<table class="table table-sm table-responsive">
					<thead>
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
						<tr>
							<td colspan="9">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal3">
							  Launch demo modal
							</button>

							</td>
						</tr>
					</tbody>
				</table>
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
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3">
		  <div class="col-md-6">
		    <label for="inputPassword4" class="form-label">Invoice Number</label>
		    <input type="text" name="invoice_number" class="form-control" id="inputPassword4">
		  </div>
		  <div class="col-md-6">
		    <label for="inputEmail4" class="form-label">Customer</label>
		    <select class="form-control" name="customer_id">
		    	<option value="">Select Customer ...</option>
		    	@forelse($customers as $c)
		    	<option value="{{ $c->id }}">{{ $c->name }}</option>
		    	@empty
		    	<option value="">No customers available</option>
		    	@endforelse
		    </select>
		  </div>
		  <div class="col-12">
		    <label for="inputAddress" class="form-label">Rate</label>
		    <input type="text" class="form-control" name="rate" id="inputAddress" placeholder="rate">
		  </div>
		  <div class="col-6">
		    <label for="inputAddress2" class="form-label">From</label>
		    <input type="date" name="from" class="form-control" id="inputAddress2">
		  </div>
		  <div class="col-md-6">
		    <label for="inputCity" class="form-label">To</label>
		    <input type="date" name="to" class="form-control" id="inputCity">
		  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
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
		// alert();
	})
</script>
@endsection
