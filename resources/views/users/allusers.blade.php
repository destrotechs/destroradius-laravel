@extends('layouts.master')
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
        <table class="table table-sm table-responsive">
            <thead>
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
                @forelse ($customers as $key=>$p)
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
                @empty
                    <tr>
                        <td colspan="7" class="bg-secondary p-2">you have no users available</td>
                    </tr>
                @endforelse

            </tbody>
            <tfoot class="table-footer">
                {!! $customers->links() !!}
            </tfoot>
        </table>
    </div>
    </div>
@endsection
