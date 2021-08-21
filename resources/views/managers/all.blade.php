@extends('layouts.master')
@section('content_header')
    All Managers
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
    <div class="card card-body">
        <table class="table table-sm">
            <thead>
                <tr>All managers</tr>
                <?php $num=0;?>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>City</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($managers as $key=>$m)
                <?php $num++;?>
                    <tr>
                        <td><?php echo $num;?></td>
                        <td>{{ $m->name }}</td>
                        <td>{{ $m->phone }} </td>
                        <td>{{ $m->address }}</td>
                        <td>{{ $m->city }}</td>
                        
                        <td><a href="{{ route('manager.edit',['id'=>$m->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a><a href="{{ route('manager.delete',['id'=>$m->id]) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="bg-secondary p-2">you have no managers available</td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
@endsection