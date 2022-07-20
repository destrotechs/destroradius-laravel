@extends('layouts.master')
@section('content_header')
New nas
@endsection
@section('content')
@if (session('success'))
   <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>{{ session('success') }}</strong>
</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="">
    <div class="row">
        <div class="col-md-7 card">
            <form class="form-group p-3" method="POST" action="{{ route('nas.new.add') }}">
                <label>Nas Ip Address</label>
                <input type="text" name="nasname" class="form-control" placeholder="nas ip address">
                <label>Nas Secret</label>
                <input type="text" name="nassecret" class="form-control" placeholder="nas secret">
                <label>Nas Zone</label>     
                <select class="form-control" name="nasshortname">
                    <option value="">select zone ...</option>
                    @forelse($zones as $m)
                    <option value="{{  $m->id }}">{{ $m->zonename }}</option>
                    @empty
                    <option value="">No zones without managers</option>
                    @endforelse
                </select>
                <label>Nas Type</label>
                <input type="text" name="nastype" class="form-control" placeholder="nas type">
                <label>Nas Description</label>
                <textarea rows="2" name="nasdescription" class="form-control"></textarea>
                <br>
                <select class="form-control" name="restartserver">
                    <option value="">Restart Server After Add?</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <hr>
                <button class="btn btn-success btn-md" type="submit"><i class="fas fa-plus"></i>&nbsp;Add</button>

                {{ csrf_field() }}
            </form>
        </div>
        <div class="col-md-5">
            <div class="card card-body p-3">
                <b>Guide</b>
                When a new nas is added to the server, all requests from the nas clients are not included
                to the server in the current session. Therefore, a server restart is required to include 
                this newly added nas on the server queue.
            </div>
        </div>
    </div>
</div>
@stop
