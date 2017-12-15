@extends('layouts.main')


@section('content')
	<div class="container">
		<div class="row">
		@foreach($items as $item)
		<div class="col s4" style="width: 33.33%; height: 33.33%;">
				<div class="card"">
		            <div class="card-image">
		              <img height="128" width="128" src="/images/{{ $item->image }}">
		              <span class="card-title">{{ $item->title }}</span>
		            </div>
		            <div class="card-content">
		              <p>{!! $item->desc !!}</p>
		            </div>
		            <div class="card-action">
		              <a href="{{ route(App\Category::where('id', $item->category_id)->value('title').'.'.$item->title) }}">Read More</a>
		            </div>
		         </div>
        </div>
        @endforeach
	</div>
	</div>
@endsection

