@extends('layouts.main')


@section('content')
	<div class="container">
		<div class="row" style="padding-top: 20px;">
			<nav>
				<div class="nav-wrapper">
					<div class="col s12">
					        <a href="/{{ session('slug') }}" class="breadcrumb {{ session('dir') == 'ltr' ? 'left' : 'right' }}">{{ App\Language::translate('Home') }}</a>
					        @foreach($urls as $url)
					        	@if(DB::table('category_language')->where('language_id', session('lang_id'))->get())
						        <a href="{{ url(session('slug').'/'.App\Category::where('slug', $url)->first()->url) }}" class="breadcrumb {{ session('dir') == 'ltr' ? 'left' : 'right' }}">{{ DB::table('category_language')->where('language_id', session('lang_id'))->where('category_id', App\Category::where('slug', $url)->first()->id)->value('title') }}</a>
						        @else
						        	<a href="{{ url(session('slug').'/'.App\Category::where('slug', $url)->first()->url) }}" class="breadcrumb {{ session('dir') == 'ltr' ? 'left' : 'right' }}">{{ DB::table('category_language')->where('language_id', 1)->where('category_id', App\Category::where('slug', $url)->first()->id)->value('title') }}</a>
						        	@endif
					        @endforeach
					</div>	
				</div>
			</nav>
		</div>
		<div class="row">
			<div class="col s4 {{ session('dir') == 'ltr' ? 'left' : 'right' }}">
					<form action="{{ url(session('slug').'/search') }}" method="GET">
						<div class="input-field">
							<input type="text" id="search" name="search" class="validate">
						</div>
						<button class="btn" type="submit">{{ App\Language::translate('Search')}}</button>
					</form>
			</div>
		</div>
		
		<div class="row">
			@foreach($categories as $category)
			@if($category->languages->find(session('lang_id')))
		<div class="col s12 m4 {{ session('dir') == 'ltr' ? 'left' : 'right' }}">
				<div class="card">
		            <div class="card-image {{ session('dir') == 'ltr' ? 'left' : 'right' }}">
		              <img width="256" height="256" src="/images/{{ $category->image }}">
		              <span class="card-title" style="{{ session('dir') == 'rtl' ? 'right: 0;' : '' }}">{{ $category->languages->find(session('lang_id'))->pivot->title }}</span>
		            </div>
		            <div class="card-content">
		              <p>{!! $category->languages->find(session('lang_id'))->pivot->desc !!}</p>
		            </div>
		            <div class="card-action">
		              <a href="{{ url(session('slug').'/'.App\Category::where('id', $category->id)->value('url')) }}">{{ App\Language::translate('Find out More') }}</a>
		            </div>
		         </div>
        </div>
        @else
        	<div class="col s12 m4 {{ session('dir') == 'ltr' ? 'left' : 'right' }}">
				<div class="card">
		            <div class="card-image {{ session('dir') == 'ltr' ? 'left' : 'right' }}">
		              <img width="256" height="256" src="/images/{{ $category->image }}">
		              <span class="card-title" style="{{ session('dir') == 'rtl' ? 'right: 0;' : '' }}">{{ $category->languages->first()->pivot->title }}</span>
		            </div>
		            <div class="card-content">
		              <p>{!! $category->languages->first()->pivot->desc !!}</p>
		            </div>
		            <div class="card-action">
		              <a href="{{ url(session('slug').'/'.App\Category::where('id', $category->id)->value('url')) }}">{{ App\Language::translate('Find out More') }}</a>
		            </div>
		         </div>
        </div>
        @endif
        @endforeach
	</div>
</div>

@endsection