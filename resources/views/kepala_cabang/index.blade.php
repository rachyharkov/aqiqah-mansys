@extends('layouts.template')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h3>Haloo, {{\Auth::user()->name}}</h3>
		<p>{{ Auth::user()->userCabang }}</p>
	</div>
</div>
@include('test-card')
<!-- live test card in template -->
@endsection