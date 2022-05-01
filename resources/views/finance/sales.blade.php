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
    <div class="card card-body">
        <table class="table table-responsivetable-bordered table-sm">
            <thead>
                <tr>All sales</tr>
                <?php $num=0;?>
                <tr>
                    <th>#</th>
                    <th>Manager</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th class="text-right">Commission</th>
                    {{-- <th></th> --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($sales as $key=>$m)
                <?php $num++;?>
                    <tr>
                        <td><?php echo $num;?></td>
                        <td>{{ $m->name }}</td>
                        <td>{{ $m->description }} </td>
                        <td>
                        	@if($m->status=='paid')
                        	<span class="badge badge-success">{{ $m->status }}</span>
                        	@else
                        	<span class="badge badge-danger">{{ $m->status }}</span>
                        	@endif
                        </td>
                        <td class="text-right">KES. {{ $m->commission }}</td>

                        {{-- <td><a href="{{ route('manager.edit',['id'=>$m->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a><a href="{{ route('manager.delete',['id'=>$m->id]) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a></td> --}}
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="bg-secondary p-2">you have no sales</td>
                    </tr>
                @endforelse
                <tr>
                	<td colspan="4"></td>
                	<td class="text-right">Total Commission Due <b>KES. {{ $totalCommDue }}</b> </td>
                </tr>
            </tbody>
            <tfoot>
            	<tr>
            		<td colspan="6">{!! $sales->links() !!}</td>
            	</tr>
            </tfoot>
        </table>
    </div>
@endsection
