@extends('layouts.master')
@section('content_header')
Edit Package
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
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<a href="{{route('packages.all')}}" class="float-right">
					<span class="fas fa-arrow-left "></span>&nbsp;
					<span class="sidenav-normal">go back</span>
				</a>
			</div>
		</div>
        
	</div>
</div>
<div class="row">
    <div class="col-md-7">
        <div class="card card-body">
            <form action="{{ route('packages.edit.save') }}" method="post" class="form-group">
                {{ csrf_field() }}
                <label for="uploadspeed">Package Name</label>
                <input type="text" name="packagename" class="form-control" value="{{ $package->packagename }}" placeholder="package name ..." readonly="readonly">
                <label for="bandwidth">Users</label>
                <select name="users" class="form-control select2">
                    {{-- <option value="{{ $package->users }}">{{ $package->users }}</option> --}}
                    <option value="hotspot">HotSpot</option>
                    <option value="pppoe">PPPOE</option>
                    <option value="resellers">Resellers</option>
                </select>
                @if($package->users=='pppoe')
                <label>Pool Name</label>
                <input type="text" name="poolname" value="{{ $package->poolname }}" class="form-control">
                @endif
                <label>Package Zone</label>     
                <select class="form-control select2" name="packagezone">
                    {{-- <option value="{{ $package->packagezone }}">{{ $package->packagezone }}</option> --}}
                    <option value="all zones">All zones</option>
                    @forelse($zones as $m)
                    <option value="{{  $m->zonename }}">{{ $m->zonename }}</option>
                    @empty
                    <option value="">No zones without managers</option>
                    @endforelse
                </select>
                <label for="bandwidth">Bandwidth/Speed unit</label>
                <select name="bandwidth" class="form-control unit select2">
                    <option value="M">Mbps</option>
                    <option value="K">Kbps</option>
                </select>
                
                <p class="p-1 text-danger mes"></p>
                <label for="uploadspeed">Upload Speed</label>
                <input type="digit" name="uploadspeed" class="form-control up" placeholder="1 or 2 ..." value="{{ $package->uploadspeed/(1024*1024)}}">
                <label for="uploadspeed">Download Speed</label>
                <input type="hidden" value="{{ $package->uploadspeed}}" name="upbandwidth" id="upbnd">
                <input type="hidden" value="{{ $package->downloadspeed}}" name="downbandwidth" id="downbnd">
                <input type="hidden" name="id" value="{{ $package->id }}">
                <input type="digit" value="{{ $package->downloadspeed/(1024*1024)}}" name="downloadspeed" class="form-control down" placeholder="1 or 2 ...">
                <label>Max Number of Devices</label>
                <input type="digit" value="{{ $package->numberofdevices}}" name="numberofdevices" class="form-control">
                <div class="form-row">
                    <div class="col">
                        <label>Duration</label>
                        <select class="form-control select2" name="period">
                            <option value="{{ $package->durationmeasure }}">{{ $package->durationmeasure }}</option>
                            <option value="min">Minutes</option>
                            <option value="hour">Hours</option>
                            <option value="day">Days</option>
                            <option value="week">Weeks</option>
                            <option value="month">Months</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="validdays">Valid Days of Payment</label>
                        <input name="validdays" type="digit" class="form-control" value="{{ $package->validdays }}">
                    </div>
                </div>
                <label>Priority</label>
                <select name="priority" class="form-control select2">
                    <option>Select Priority</option>
                    <option value="10">HIGH</option>
                    <option value="5">MEDIUM</option>
                </select>
                <label>Valid Until (optional)</label>
                <input type="date" name="validuntil" class="form-control">
                <label for="validdays">Maximum Usage Quota (MBS)</label>
                <input name="quota" value="{{ $package->quota/(1024*1024)}}" type="text" class="form-control quota">
                <hr>
                <button class="btn btn-success btn-md"><i class="fas fa-save"></i>&nbsp;Save changes</button>
            </form>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card card-body">
            <div class="card-title"><h5>Speed Calculation in bytes</h5></div><hr>
            <p class="card-text">Upload Speed In Bytes per Second: &nbsp;<span class="text-success upspd"></span></p>
            <hr>
            <p class="card-text">Download Speed In Bytes per Second: &nbsp;<span class="text-success dwnspd"></span></p>
        </div>
        <div class="card card-body">
            <div class="card-title"><h5>Quota calculation</h5></div><hr>
            <p class="card-text">Size in KB: &nbsp;<span class="text-success kb"></span></p>
            <hr>
            <p class="card-text">Size in GB: &nbsp;<span class="text-success gb"></span></p>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function(){
        var totalup=0;
        var totaldown=0;
        var uptemp;
        var downtemp;
        var unit;
        $(".up").on("keyup",function(){
            uptemp=$(this).val();
            unit=$(".unit").val();
            if(unit==""){
                $(".mes").html("Please select unit first");
            }else{ 
                $(".mes").empty();
                totalup=calculateSpeed(unit,uptemp);
                $(".upspd").html(totalup);
                $("#upbnd").val(totalup);
            }
        })
        $(".down").on("keyup",function(){
            downtemp=$(this).val();
            unit=$(".unit").val();
            if(unit==""){
                $(".mes").html("Please select unit first");
            }else{ 
                $(".mes").empty();
                totaldown=calculateSpeed(unit,downtemp);
                $(".dwnspd").html(totaldown);
                $("#downbnd").val(totaldown);
            }
        })
        $(".quota").on('keyup',function(){
            var kbsize=calculateSizeToKB($(this).val());
            var gbsize=calculateSizeToGB($(this).val());
            $(".kb").html(kbsize+" KB");
            $(".gb").html(gbsize+" GB");
        })
        function calculateSpeed(unit,spd){
            if(unit=="M"){
                return spd*1024*1024;
            }else if(unit=="K"){
                return spd*1024;
            }
        }
        function calculateSizeToGB(mb){
            return parseInt(mb)/1024;
        }
        function calculateSizeToKB(mb){
            return parseInt(mb)*1024;
        }
    })
</script>  
@endsection