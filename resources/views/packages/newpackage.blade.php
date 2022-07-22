@extends('layouts.master')
@section('content_header')
New Package
@endsection

@section('content')
@if($errors->count()>0)
    <div class="alert alert-danger">
    @foreach ($errors->all() as $message)
    <p><i class="fas fa-circle"></i>&nbsp;{{ $message }}</p>
    @endforeach
    </div>
    @endif
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
        <div class="card card-body" style="background: rgb(247, 189, 83)">
            <form action="{{ route('package.save') }}" method="post" class="form-group">
                {{ csrf_field() }}

                <style>
                    label{
                        color: black;
                    }
                </style>

                <div class="form-row">
                    <div class="col">
                        <label for="uploadspeed">Package Name</label>
                         <input type="text" required name="packagename" class="form-control" placeholder="package name ...">
                    </div>
                    <div class="col">
                        <label for="bandwidth">Users</label>
                        <select name="users" required class="form-control users">
                            <option value="">Select who will use the package</option>
                            <option value="hotspot">HotSpot</option>
                            <option value="pppoe">PPPOE</option>
                            <option value="resellers">Resellers</option>
                        </select>
                    </div>                    
                </div>     
                

                
                
                <div class="form-row pool" style="display: none;">
                    <div class="col">
                        <label>Pool name (Mikrotik PPPoE pool name)</label>
                        <input type="text" name="poolname" class="form-control">
                    </div>
                    <div class="col">
                        <label>Profile name (Mikrotik PPPoE profile name)</label>
                        <input type="text" name="profile" class="form-control">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <label>Package Zone</label>
                        <select class="form-control" name="packagezone">
                            <option value="">select zone ...</option>
                            <option value="all zones">All zones</option>
                            @forelse($zones as $m)
                            <option value="{{  $m->zonename }}">{{ $m->zonename }}</option>
                            @empty
                            <option value="">No zones without managers</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col">
                        <label for="bandwidth">Bandwidth/Speed unit</label>
                        <select name="bandwidth" required class="form-control unit">
                            <option value="">Select Bandwidth unit</option>
                            <option value="M">Mbps</option>
                            <option value="K">Kbps</option>
                        </select>
                    </div>                    
                </div>    

                
                

                <p class="p-1 text-danger mes"></p>
                <div class="form-row">
                    <div class="col">
                        <label for="uploadspeed">Upload Speed</label>
                        <input type="digit" required name="uploadspeed" class="form-control up" placeholder="1 or 2 ...">
                    </div>
                    <div class="col">
                        <label for="uploadspeed">Download Speed</label>
                        <input type="hidden" name="upbandwidth" id="upbnd">
                        <input type="hidden" name="downbandwidth" id="downbnd">
                        <input type="digit" required name="downloadspeed" class="form-control down" placeholder="1 or 2 ...">
                    </div>
                </div>
                <div class="form-row pool" style="display: none;">
                    <div class="col">
                        <label>Burst Upload</label>
                        <input type="digit" name="burstup" class="form-control" placeholder="burst up">
                    </div>
                    <div class="col">
                        <label>Burst Download</label>
                        <input type="digit" name="burstdown" class="form-control" placeholder="burst down">
                    </div>                    
                </div>
                <label>Max Number of Devices</label>
                <input required type="digit" name="numberofdevices" class="form-control">
                <div class="form-row">
                    <div class="col">
                        <label>Measure</label>
                        <select class="form-control" name="period" required>
                            <option value="">select duration measure ...</option>
                            <option value="min">Minutes</option>
                            <option value="hour">Hours</option>
                            <option value="day">Days</option>
                            <option value="week">Weeks</option>
                            <option value="month">Months</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="validdays">Duration</label>
                        <input name="validdays" type="digit" class="form-control" required>
                    </div>
                </div>

                <label for="validdays">Maximum Usage Quota (MBS)</label>
                <input required placeholder="use 0 for no limit" name="quota" type="text" class="form-control quota">


                <div class="form-row">
                    <div class="col">
                        <label for="validdays">Priority</label>
                        <select name="priority" class="form-control">
                            <option>Select Priority</option>
                            <option value="10">HIGH</option>
                            <option value="5">MEDIUM</option>
                        </select>
                    </div>
                    <div class="col">
                        <label>Valid Until (optional)</label>
                        <input type="date" name="validuntil" class="form-control">
                    </div>                    
                </div>     

                
                
                <label>Description</label>
                <textarea class="form-control" name="description"></textarea>

                <div class="form-row">
                    <div class="col">
                        <label>Currency</label>
                        <select name="currency" class="form-control">
                            <option value="USD($)">USD ($)</option>
                            <option value="KSH">KSH</option>
                        </select>
                    </div>
                    <div class="col">
                        <label>Amount</label>
                        <input type="text" name="amount" class="form-control" placeholder="amount">
                    </div>                    
                </div>                
                
                <hr>
                <button class="btn btn-success btn-md"><i class="fas fa-save"></i>&nbsp;Save</button>
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

        $(".users").change(function(){
            if($(this).val()=='pppoe'){
                $(".pool").show();
            }else{
                $(".pool").hide();
            }
        })
    })
</script>
@endsection
