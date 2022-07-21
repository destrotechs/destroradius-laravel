@extends('layouts.master')
@section('content_header')
Edit nas
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<a href="{{route('nas.view')}}" class="float-right">
					<span class="fas fa-arrow-left "></span>&nbsp;
					<span class="sidenav-normal">go back</span>
				</a>
			</div>
		</div>
        
	</div>
</div>
<div class="row">
    <div class="col-md-7 card">
        <form class="form-group p-3" method="POST" action="{{ route('nas.edit.post') }}">
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
            
            @foreach($nas as $n)
            <label>Nas Ip Address</label>
            <input type="text" name="nasname" class="form-control" value="{{ $n->nasname }}">
            <label>Nas Secret</label>
            <input type="text" name="nassecret" class="form-control"  value="{{ $n->secret }}">
            <label>Nas Zone</label>     
                <select class="form-control" name="nasshortname">
                    @forelse($zones as $m)
                    <option {{ $n->shortname == $m->id ? 'selected':''}} value="{{  $m->id }}">{{ $m->zonename }}</option>
                    @empty
                    <option value="">No zones without managers</option>
                    @endforelse
                </select>
            <label>Nas type</label>
            <input type="text" name="nastype" class="form-control"  value="{{ $n->type }}">
            <label>Nas Description</label>
            <textarea rows="2" name="nasdescription" class="form-control">{{ $n->description }}</textarea>
            <br>
            <input type="hidden" name="id" value="{{ $n->id }}">
            <select class="form-control" name="restartserver">
                <option value="">Restart Server After change?</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
            <hr>
            <button class="btn btn-success btn-md" type="submit"><i class="fas fa-save"></i>&nbsp;Save Changes</button>

            {{ csrf_field() }}
            @endforeach
        </form>
    </div>
</div>
@stop