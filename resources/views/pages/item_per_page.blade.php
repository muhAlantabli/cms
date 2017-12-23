@extends('layouts.main')


@section('content')
	<div class="container">
		<div class="row" style="padding-top: 20px;">
			<nav>
				<div class="nav-wrapper">
					<div class="col s12">
							@if(DB::table('category_language')->where('language_id', session('lang_id'))->get())
					        <a href="/{{ session('slug') }}" class="breadcrumb {{ session('dir') == 'ltr' ? 'left' : 'right' }}">{{ App\Language::translate('Home') }}</a>
						        <a href="{{ url(session('slug').'/'.App\Category::where('slug', $url)->first()->url) }}" class="breadcrumb {{ session('dir') == 'ltr' ? 'left' : 'right' }}">{{ DB::table('category_language')->where('language_id', session('lang_id'))->where('category_id', App\Category::where('slug', $url)->first()->id)->value('title') }}</a>
						        @else
						        	<a href="/{{ session('slug') }}" class="breadcrumb {{ session('dir') == 'ltr' ? 'left' : 'right' }}">{{ App\Language::translate('Home') }}</a>
						        <a href="{{ url(session('slug').'/'.App\Category::where('slug', $url)->first()->url) }}" class="breadcrumb {{ session('dir') == 'ltr' ? 'left' : 'right' }}">{{ DB::table('category_language')->where('language_id', 1)->where('category_id', App\Category::where('slug', $url)->first()->id)->value('title') }}</a>
						        @endif
					</div>	
				</div>
			</nav>
		</div>
		<div class="row">
			<div class="col s4">
					<form action="{{ url(session('slug').'/search') }}" method="GET">
						<div class="input-field">
							<input type="text" id="search" name="search" class="validate">
						</div>
						<button class="btn" type="submit">{{ App\Language::translate('Search')}}</button>
					</form>
			</div>
		</div>
		@if($item->languages->find(session('lang_id')))
		<div class="col s4 offset-s2">
			<h2>{{ $item->languages->find(session('lang_id'))->pivot->title }}</h2>
			@if($item->image)
				<img style="display: block; max-width: 50%;" src="/images/{{ $item->image }}" >
			@endif

			<div>
				{!! $item->languages->find(session('lang_id'))->pivot->desc !!}
			</div>

			<div>
				{!! $item->languages->find(session('lang_id'))->pivot->info !!}
			</div>
		</div>
		@else
			<div class="col s4 offset-s2">
			<h2>{{ $item->languages->first()->pivot->title }}</h2>
			@if($item->image)
				<img style="display: block; max-width: 50%;" src="/images/{{ $item->image }}" >
			@endif

			<div>
				{!! $item->languages->first()->pivot->desc !!}
			</div>

			<div>
				{!! $item->languages->first()->pivot->info !!}
			</div>
		</div>
		@endif
@endsection