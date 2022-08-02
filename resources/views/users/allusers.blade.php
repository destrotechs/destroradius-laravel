@extends('layouts.master')
@section('buttons')
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
        <div class="card-header">
            @if(Auth::user()->role_id==1)
                <div class="col-lg-6 text-right float-right">
                    <a href="{{route('user.new')}}" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> New User</a>
                </div>
            @endif
        </div>
        <div class="card-body table-responsive p-0">
            <table class="dTable table table-head-fixed text-nowrap table-sm">
                <thead style="color: black">
                    <?php $num=0;?>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Username</th>
                        <th>Package</th>
                        <th>User Type</th>
                        <th>Zone</th>
                        <th>Remaining Time</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $key=>$p)
                    <?php $num++;?>
                        <tr>
                            <td><?php echo $num;?></td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->phone }} </td>
                            <td>{{ $p->username }}</td>
                            <td>{{ $p->packagename }}</td>
                            <td>{{ $p->type}}</td>
                            <td>{{ $p->zonename }}</td>
                            <td>
                                {{ $remainingdays[$key] }}
    
                            </td>
    
                            <td><a href="{{ route('getchangecustomer',['username'=>$p->username]) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a></td>
                    
                    @endforeach
    
                </tbody>
                <tfoot class="table table-sm table-responsive-footer">
                    {!! $customers->links() !!}
                </tfoot>
            </table>
        </div>
    </div>
@endsection
