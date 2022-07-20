@extends('layouts.clientslayout')
@section('page_info')
<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('client.bundles')}}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Change Phone Number</li>
  </ol>
</nav>
@endsection
@section('content')
<div class="card">
	<div class="card-body">
		<form action="{{ route('user.post.changephone') }}" method="post">
			<div id="err"></div>

			<label>Phone</label>
			<input type="text" class="form-control" name="phone" value="@if(isset(Auth::guard('customer')->user()->phone )){{ Auth::guard('customer')->user()->phone }}@else {{ 'username' }}@endif" id="username">
			<small>Edit the number and click change</small>
			<br>
			<button class="btn btn-success btn-md" type="submit">Change</button>
			{{ csrf_field() }}
		</form>
	</div>
</div>
@endsection
