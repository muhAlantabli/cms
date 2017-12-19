@extends('layouts.main')


@section('content')
	<div class="container">
		<div class="row" style="padding-top: 20px;">
			<div class="col s12">
			        <a href="{{ url('/') }}" class="breadcrumb purple-text">Home </a>
			        @foreach($urls as $url)
				        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>
				        <a href="{{ route(ucfirst($url)) }}" class="breadcrumb purple-text">{{ ucfirst($url) }}</a>
			        @endforeach
			</div>
		</div>
		<div class="col s4 offset-s2">
			<h2>{{ $page->title }}</h2>
			@if($page->image)
				<img style="display: block; max-width: 100%;" src="/images/{{ $page->image }}" >
			@endif

			<div>
				{!! $page->desc !!}
			</div>

			<div>
				{!! $page->info !!}
			</div>

			@foreach($custom_fields as $custom_field)
			<div>
				<label>{{ $custom_field->field_key }}</label>
				<p>{{ $custom_field->value }}</p>
			</div>
			@endforeach

			@if(count($tags))
				<strong>Tags:</strong>
				@foreach($tags as $tag)
					<a class="waves-effect waves-light btn" href="/search/{{$tag->name}}">{{ $tag->name }}</a>
				@endforeach
			@endif
			
		</div>
	</div>

@endsection