@extends('layouts.template')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<!-- small box -->
		<h3>Haloo, {{\Auth::user()->name}}</h3>
	</div>
	<!-- ./col -->
</div>
@include('test-card')
@endsection