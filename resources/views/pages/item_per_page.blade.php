@extends('layouts.main')


@section('content')
	<div class="container">
		<div class="row" style="padding-top: 20px;">
			<div class="col s8">
			        <a href="{{ url('/') }}" class="breadcrumb purple-text">Home </a>
			        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>
			        <a href="{{ route(ucfirst($url)) }}" class="breadcrumb purple-text">{{ ucfirst($url) }}</a>
			</div>
		<div class="col s4 offset-s2">
			<h2>{{ $item->title }}</h2>
			@if($item->image)
				<img style="display: block; max-width: 100%;" src="/images/{{ $item->image }}" >
			@endif

			<div>
				{!! $item->desc !!}
			</div>

			<div>
				{!! $item->info !!}
			</div>
		</div>
	</div>
@endsection