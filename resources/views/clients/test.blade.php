@extends('layouts.clientslayout')
@section('content')
<form>
<input type="text" name="username" class="form-control">
<button class="btn btn-success" type="submit">Test</button>
	@csrf
</form>
@endsection