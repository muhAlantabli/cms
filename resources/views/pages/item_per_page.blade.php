@extends('layouts.main')


@section('content')
	<div class="container">
		<div class="row" style="padding-top: 20px;">
			<div class="col s8">
			        <a href="{{ url('/') }}" class="breadcrumb purple-text">Home </a>
			        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>
			        <a href="#" class="breadcrumb purple-text">{{ ucfirst($url) }}</a>
			</div>
		<div class="col s4 offset-s2">
			<h2>{{ $item->languages->find(session('lang_id'))->pivot->title }}</h2>
			@if($item->image)
				<img style="display: block; max-width: 100%;" src="/images/{{ $item->image }}" >
			@endif

			<div>
				{!! $item->languages->find(session('lang_id'))->pivot->desc !!}
			</div>

			<div>
				{!! $item->languages->find(session('lang_id'))->pivot->info !!}
			</div>
		</div>
	</div>
@endsection