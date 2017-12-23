@extends('layouts.main')

@section('content')
	<div class="container">
		<div class="row" style="padding-top: 20px;">
		<h5>{{ App\Language::translate('Search Results') }}:</h5>
		@foreach($allItems as $item)
		@if({{ DB::table('item_language')->where('item_id', $item['id'])->where('language_id', session('lang_id'))->get())
		<div class="col s12 m4 {{ session('dir') == 'ltr' ? 'left' : 'right' }}">
				<div class="card">
		            <div class="card-image {{ session('dir') == 'ltr' ? 'left' : 'right' }}">
		              <img height="256" width="256" src="/images/{{ $item['image'] }}">
		              <span class="card-title" style="{{ session('dir') == 'rtl' ? 'right: 0;' : '' }}">{{ DB::table('item_language')->where('item_id', $item['id'])->where('language_id', session('lang_id'))->value('title') }}</span>
		            </div>
		            <div class="card-content">
		              <p>{!! DB::table('item_language')->where('item_id', $item['id'])->where('language_id', session('lang_id'))->value('desc') !!}</p>
		            </div>
		            <div class="card-action">
		              <a href="{{ url(session('slug').'/'.App\Category::where('id', $item['category_id'])->value('url').'/'.$item['id']) }}">{{ App\Language::translate('Read More') }}</a>
		            </div>
		         </div>
        </div>
        @else
        	<div class="col s12 m4 {{ session('dir') == 'ltr' ? 'left' : 'right' }}">
				<div class="card">
		            <div class="card-image {{ session('dir') == 'ltr' ? 'left' : 'right' }}">
		              <img height="256" width="256" src="/images/{{ $item['image'] }}">
		              <span class="card-title" style="{{ session('dir') == 'rtl' ? 'right: 0;' : '' }}">{{ DB::table('item_language')->where('item_id', $item['id'])->where('language_id', 1)->value('title') }}</span>
		            </div>
		            <div class="card-content">
		              <p>{!! DB::table('item_language')->where('item_id', $item['id'])->where('language_id', 1)->value('desc') !!}</p>
		            </div>
		            <div class="card-action">
		              <a href="{{ url(session('slug').'/'.App\Category::where('id', $item['category_id'])->value('url').'/'.$item['id']) }}">{{ App\Language::translate('Read More') }}</a>
		            </div>
		         </div>
        </div>
        @endif
        @endforeach
	</div>
	</div>
@endsection

