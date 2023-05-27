@extends('layouts.master')
@section('buttons')
@if(Auth::user()->role_id==1)
<div class="col-lg-6 text-right">
  <a href="{{route('user.new')}}" class="btn btn-sm btn-white"><i class="fas fa-plus-circle"></i> New User</a>
</div>
@endif
@endsection
@section('content_header')
    All Users
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
    <div class="card-body">
         <table class="table table-bordered table-active data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
</div>
</div>

@endsection
@section('js')
<script>
    // $(document).ready(function() {
    //     $('#users-table').dataTable({

    //         processing: true,
    //         // serverSide: true,
    //         dom: 'Bfrtip',
    //         buttons: [
    //         {extend:'csv',className:'btn btn-red'},{extend:'copy',className:'btn btn-primary'},{extend:'excel',className:'btn btn-primary'},{extend:'print',className:'btn btn-primary'}
    //     ],
    //         ajax: "{{ route('user.get.all') }}",
    //         columns: [
    //             { data: 'id', name: 'id' },
    //             { data: 'name', name: 'name' },
    //             { data: 'email', name: 'email' },
    //         ],
            
    //     });
    // });
    $(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        dom: 'Bfrtip',
        buttons: [
            {extend:'csv',className:'btn btn-red'},{extend:'copy',className:'btn btn-primary'},{extend:'excel',className:'btn btn-primary'},{extend:'print',className:'btn btn-primary'}
        ],
        ajax: "{{ route('user.get.all') }}",

        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email',orderable:true,searchable:true},

        ]
    });
  });
</script>
@endsection