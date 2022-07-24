@extends('layouts.master')
@section('content_header')
Open Tickets
@endsection
@section('content')
@if (session('success'))
   <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>{{ session('success') }}</strong>
</div>
@endif
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header"><h5>Available Tickets</h5></div>
			<div class="card-body">
				<div class="card-body table-responsive p-0">
					<table class="dTable table table-head-fixed text-nowrap table-sm">
						<thead style="color: black">
						<tr>
							<td>#</td>
							<td>subject</td>
							<td>Customer</td>
							<td>Priority</td>
							<td>Status</td>
							<td>Package</td>
							<th>Price</th>
							<td>Assigned To</td>
							<td>Edit</td>
						</tr>
					</thead>
					<tbody>
						<?php $num=0;?>
						@foreach($tickets as $t)
						<?php $num++;?>
							<tr>
								<td><?php echo $num;?></td>
								<td>{{ $t->subject }}</td>
								<td>{{ $t->customer_username }}</td>
								<td>{{ $t->priority }}</td>
								<td>{{ $t->status }}</td>
								<td>{{ $t->package }}</td>
								<td>{{ $t->cost }}</td>
								<td>{{ $t->assignedto }}</td>
								<td><a href="#" class="btn btn-danger btn-sm trash" id="{{ $t->id }}"><i class="fas fa-trash"></i></a>&nbsp;<a href="#" id="{{ $t->id }}" class="btn btn-success btn-sm sell"><i class="fas fa-check text-white"></i>&nbsp;sell</a></td>
							</tr>
						@endforeach
					</tbody>
				</table>
				</div>
			</div>
		</div>

	</div>
	{{-- <div class="col-md-5"></div> --}}
</div>
@endsection
@section('js')
<script type="text/javascript">
  $(document).ready(function(){
    // route('deleteplan',['id'=>$c->id])
    $(".trash").click(function(){
      var id = $(this).attr("id");
      if(confirm("Are you sure you want to delete this ticket?")){
        $.ajax({
          method:'GET',
          url:'delete/'+id,
          success:function(res){
            alert(res);
            window.location.reload();
          }
        })
      }
    })
    $(".sell").click(function(){
      var id = $(this).attr("id");
      if(confirm("Are you sure you want to close this ticket?")){
        $.ajax({
          method:'GET',
          url:'close/'+id,
          success:function(res){
            alert(res);
            window.location.reload();
          }
        })
      }
    })
  })
</script>
@endsection
