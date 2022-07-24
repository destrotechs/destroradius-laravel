@extends('layouts.master')
@section('content_header')
Sales
@endsection
@section('content')
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
  <div class="card">
    <div class="card-body table-responsive p-0">
      <table class="dTable table table-head-fixed text-nowrap table-sm">
          <thead style="color: black">
              <tr><th colspan="8">All Sales</th></tr>
              <?php $num=0;?>
              <tr>
                  <th>#</th>
                  <th>Username</th>
                  <th>Phonenumber</th>
                  <th>Packagebought</th>
                  <th>transactionid</th>
                  <th>Amount</th>
                  {{-- <th>Payment Method</th> --}}
                  <th>Transactiondate</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>
              {{-- @forelse ($payments as $key=>$m)
              <?php $num++;?>
                  <tr>
                      <td><?php echo $num;?></td>
                      <td>{{ $m->username }}</td>
                      <td>{{ $m->phonenumber }} </td>
                      <td>{{ $m->packagebought }} </td>
                      <td>{{ $m->transactionid }} </td>
                      <td>{{ $m->amount }} </td>
                      <td>{{ 'MPESA' }} </td>
                      <td>{{ $m->transactiondate }} </td>
                      
                  </tr>
              @empty
                  <tr>
                      <td colspan="8" class="bg-secondary p-2">No payments made yet</td>
                  </tr>
              @endforelse --}}
          </tbody>
          <tfoot>
            <tr>
              {{-- <td colspan="8">{!! $payments->links() !!}</td> --}}
            </tr>
          </tfoot>
      </table>
    </div>
  </div>
    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payment Details</h5>
       {{--  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
        {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> --}}

<script type="text/javascript">
  $(function () {
    var table = $('.dTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('payment.all') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'username', name: 'username'},
            {data: 'phonenumber', name: 'phonenumber'},
            {data: 'packagebought', name: 'packagebought'},
            {data: 'transactionid', name: 'transactionid'},
            {data: 'amount', name: 'amount'},
            {data: 'transactiondate', name: 'transactiondate'},
            {data: 'action', name: 'action', orderable: true, searchable: true},
        ]
    });
  });
  function show(id){
    console.log("clicked..."+id);
    $('#exampleModal').modal('show')
  }
  $(".closebtn").click(function(){
    $('#exampleModal').modal('hide')

  })
</script>
@endsection
