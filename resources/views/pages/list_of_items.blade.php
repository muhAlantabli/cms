@extends('layouts.main')


@section('content')
	<div class="container">
		<div class="row" style="padding-top: 20px;">
			<div class="col s12">
			        <a href="{{ url('/') }}" class="breadcrumb purple-text">Home </a>
			        @foreach($urls as $url)
				        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>
				        <a href="#" class="breadcrumb purple-text">{{ ucfirst($url) }}</a>
			        @endforeach
			</div>
		@foreach($items as $item)
		<div class="col s4" style="width: 33.33%; height: 33.33%;">
				<div class="card"">
		            <div class="card-image">
		              <img height="128" width="128" src="/images/{{ $item->image }}">
		              <span class="card-title">{{ $item->languages->find(session('lang_id'))->pivot->title }}</span>
		            </div>
		            <div class="card-content">
		              <p>{!! $item->languages->find(session('lang_id'))->pivot->desc !!}</p>
		            </div>
		            <div class="card-action">
		              <a href="{{ url(session('slug').'/'.App\Category::where('id', $item->category_id)->value('url').'/'.$item->id) }}">Read More</a>
		            </div>
		         </div>
        </div>
        @endforeach
	</div>
	</div>
@endsection

