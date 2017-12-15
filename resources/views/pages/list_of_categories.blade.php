@extends('layouts.main')


@section('content')
	<div class="container">
		<div class="row">
		@foreach($categories as $category)
		<div class="col s4" style="width: 33.33%; height: 33.33%;">
				<div class="card"">
		            <div class="card-image">
		              <img height="128" width="128" src="/images/{{ $category->image }}">
		              <span class="card-title">{{ $category->title }}</span>
		            </div>
		            <div class="card-content">
		              <p>{!! $category->desc !!}</p>
		            </div>
		            <div class="card-action">
		              <a href="{{ route(App\Category::where('id', $category->id)->value('title')) }}">Find out More</a>
		            </div>
		         </div>
        </div>
        @endforeach
	</div>
	</div>
@endsection