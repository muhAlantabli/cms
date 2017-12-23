@extends('layouts.main')


@section('content')
	<div class="container">
		<div class="row" style="padding-top: 20px;">
			<nav>
				<div class="nav-wrapper">
					<div class="col s12">
					        <a href="/{{ session('slug') }}" class="breadcrumb {{ session('dir') == 'ltr' ? 'left' : 'right' }}">{{ App\Language::translate('Home') }}</a>
					        @foreach($urls as $url)
						        <a href="{{ url(session('slug').'/'.App\Category::where('slug', $url)->first()->url) }}" class="breadcrumb {{ session('dir') == 'ltr' ? 'left' : 'right' }}">{{ DB::table('category_language')->where('language_id', session('lang_id'))->where('category_id', App\Category::where('slug', $url)->first()->id)->value('title') }}</a>
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
			@foreach($items as $item)
			@if($item->languages->find(session('lang_id')))
		<div class="col s12 m4 {{ session('dir') == 'ltr' ? 'left' : 'right' }}">
				<div class="card"">
		            <div class="card-image {{ session('dir') == 'ltr' ? 'left' : 'right' }}">
		              <img height="256" width="256" src="/images/{{ $item->image }}">
		              <span class="card-title" style="{{ session('dir') == 'rtl' ? 'right: 0;' : '' }}">{{ $item->languages->find(session('lang_id'))->pivot->title }}</span>
		            </div>
		            <div class="card-content">
		              <p>{!! $item->languages->find(session('lang_id'))->pivot->desc !!}</p>
		            </div>
		            <div class="card-action">
		              <a href="{{ url(session('slug').'/'.App\Category::where('id', $item->category_id)->value('url').'/'.$item->id) }}">{{ App\Language::translate('Read More') }}</a>
		            </div>
		         </div>
		    @else
		    	<div class="col s12 m4 {{ session('dir') == 'ltr' ? 'left' : 'right' }}">
				<div class="card"">
		            <div class="card-image {{ session('dir') == 'ltr' ? 'left' : 'right' }}">
		              <img height="256" width="256" src="/images/{{ $item->image }}">
		              <span class="card-title" style="{{ session('dir') == 'rtl' ? 'right: 0;' : '' }}">{{ $item->languages->first()->pivot->title }}</span>
		            </div>
		            <div class="card-content">
		              <p>{!! $item->languages->first()->pivot->desc !!}</p>
		            </div>
		            <div class="card-action">
		              <a href="{{ url(session('slug').'/'.App\Category::where('id', $item->category_id)->value('url').'/'.$item->id) }}">{{ App\Language::translate('Read More') }}</a>
		            </div>
		         </div>
		     @endif
		    @endforeach
        </div>
        
	</div>
</div>
@endsection

