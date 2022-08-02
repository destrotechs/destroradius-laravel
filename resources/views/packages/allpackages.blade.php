@extends('layouts.master')
@section('buttons')
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
    <div class="card-header">
      Available Packages
      <div class="col-lg-6 col-5 text-right float-right">
        <a href="{{ route('packages.new') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i>&nbsp; New package</a>
      </div>
    </div>
    <div class="card-body">
       <div class="card-body table-responsive p-0">
				<table class="dTable table table-head-fixed text-nowrap table-sm">
					<?php $num=0;?>
					<thead style="color: black">
                <tr>
                    <th>#</th>
                    <th>Package Name</th>
                    <th>Zone</th>
                    <th>Download Speed</th>
                    <th>Upload Speed</th>
                    <th>Max Quota</th>
                    <th>Max Devices</th>
                    <th>Pool Name</th>
                    <th>Profile</th>
                    <th>Designated For</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($packages as $p)
                <?php $num++;?>
                    <tr>
                        <td><?php echo $num;?></td>
                        <td>{{ $p->packagename }}</td>
                        <td>{{ $p->packagezone }}</td>
                        <td>{{ ($p->downloadspeed)/(1024*1024) }} mbps Burst:{{ round($p->burstup/(1024*1024),2)??'Not Set' }}</td>
                        <td>{{ ($p->uploadspeed)/(1024*1024) }} mbps Burst: {{ round($p->burstdown/(1024*1024),2)??'Not set' }}</td>
                        @if ($p->quota !=0)
                        <td>{{ round(($p->quota)/(1024*1024),2) }}MBs</td>
                        @else
                        <td>No limit</td>
                        @endif
                        <td>{{ $p->numberofdevices}}</td>
                        <td>{{ $p->poolname}}</td>
                        <td>{{ $p->profile}}</td>
                        <td>{{ $p->users }} users</td>
                        <td><a href="{{ route('packages.edit',['id'=>$p->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a><a href="#" class="btn btn-danger btn-sm trash" id="{{ $p->id }}"><i class="fas fa-trash"></i></a></td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
  $(document).ready(function(){
    // route('deleteplan',['id'=>$c->id])
    $(".trash").click(function(){
      var id = $(this).attr("id");
      if(confirm("Are you sure you want to delete this package?")){
        $.ajax({
          method:'GET',
          url:'delete/'+id,
          success:function(res){
            window.location.reload()
          }
        })
      }
    })
  })
</script>
@endsection