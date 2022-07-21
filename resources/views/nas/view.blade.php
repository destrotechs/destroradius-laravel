@extends('layouts.master')
@section('content_header')
All nas
@endsection
@section('buttons')
@if(Auth::user()->role_id==1)
<div class="col-lg-6 text-right">
  <a href="{{ route('nas.new') }}" class="btn btn-sm btn-white"><i class="fas fa-plus-circle"></i> New Nas</a>
</div>
@endif
@endsection
@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="card">
    <div class="card-header"><h5>Available Nas</h5></div>
<div class="card-body">
    <table class="table table-sm table-responsivetable-bordered table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Ip Address</th>                
                <th>Make</th>
                <th>Zone</th>
                <th>Description</th>
                @if(Auth::user()->role_id==1)
                <th></th>
                @endif
            </tr>
        </thead>
        <tbody>
            <?php $num=0;?>
            @forelse ($nas as $n)
            <?php $num++;?>
                <tr>
                    <td><?php echo $num;?></td>
                    <td>{{ $n->nasname }}</td>
                    <td>{{ $n->type }}</td>
                    <td>{{ $n->zonename }}</td>
                    <td>{{ $n->description }}</td>
                    @if(Auth::user()->role_id==1)
                    <td><a href="{{ route('nas.edit',['id'=>$n->id]) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i><a><a href="{{ route('nas.remove',['id'=>$n->id]) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i><a></td>
                        @endif
                </tr> 
            @empty
                <tr>
                    <td colspan="6">No nas added yet</td>
                </tr>
            @endforelse
        </tbody>
    </table>
  </div>
</div>
@stop