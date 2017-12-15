@extends('layouts.main')


@section('content')
	<div class="container">
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