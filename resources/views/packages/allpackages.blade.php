@extends('layouts.master')
@section('buttons')
<div class="col-lg-6 col-5 text-right">
  <a href="{{ route('packages.new') }}" class="btn btn-sm btn-neutral"><i class="fas fa-plus"></i>&nbsp; New package</a>
</div>
@endsection
@section('content_header')
 Available Packages
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
    <div class="card-header"><h5>Available Packages</h5></div>
    <div class="card-body">
        <table class="table table-sm">
            <thead>
                <?php $num=0;?>
                <tr>
                    <th>#</th>
                    <th>Package Name</th>
                    <th>Zone</th>
                    <th>Download Speed</th>
                    <th>Upload Speed</th>
                    <th>Max Quota</th>
                    <th>Max Devices</th>
                    <th>Designated For</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($packages as $p)
                <?php $num++;?>
                    <tr>
                        <td><?php echo $num;?></td>
                        <td>{{ $p->packagename }}</td>
                        <td>{{ $p->packagezone }}</td>
                        <td>{{ ($p->downloadspeed)/(1024*1024) }} mbps</td>
                        <td>{{ ($p->uploadspeed)/(1024*1024) }} mbps</td>
                        @if ($p->quota !=0)
                        <td>{{ round(($p->quota)/(1024*1024),2) }}MBs</td>
                        @else
                        <td>No limit</td>
                        @endif
                        <td>{{ $p->numberofdevices}}</td>
                        <td>{{ $p->users }} users</td>
                        <td><a href="{{ route('packages.edit',['id'=>$p->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a><a href="{{ route('packages.delete',['id'=>$p->id]) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="bg-danger p-2">you have no Packages available</td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>
@endsection
