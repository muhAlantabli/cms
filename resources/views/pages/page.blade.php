@extends('layouts.main')

@section('content')

	<div class="container">
		<div class="row" style="padding-top: 20px;">
			<nav>
				<div class="nav-wrapper">
					<div class="colcol s12">
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
			<div class="col s4">
					<form action="{{ url(session('slug').'/search') }}" method="GET">
						<div class="input-field">
							<input type="text" id="search" name="search" class="validate">
						</div>
						<button class="btn" type="submit">{{ App\Language::translate('Search')}}</button>
					</form>
			</div>
		</div>
		@if($page->languages->find(session('lang_id')))
		<div class="col s4 offset-s2">
			<h2>{{ $page->languages->find(session('lang_id'))->pivot->title }}</h2>
			<label>{{ App\Language::translate('Published at') }}: {{ $page->created_at }}</label>
			<hr>
			@if($page->image)
				<img style="display: block; max-width: 50%;" src="/images/{{ $page->image }}" >
			@endif

			<div>
				{!! $page->languages->find(session('lang_id'))->pivot->desc !!}
			</div>

			<div>
				{!! $page->languages->find(session('lang_id'))->pivot->info !!}
			</div>

			@foreach($custom_fields as $custom_field)
			<div>
				<label>{{ App\Language::translate($custom_field->field_key) }}</label>
				<p>{{ App\Language::translate($custom_field->value) }}</p>
			</div>
			@endforeach

			@if(count($tags))
				<strong>{{ App\Language::translate('Tags') }}:</strong>
				@foreach($tags as $tag)
					<a class="waves-effect waves-light btn" href="{{ url(session('slug').'/search/'.$tag->name)}}">{{ $tag->name }}</a>
				@endforeach
			@endif
			
		</div>
		@else
			<div class="col s4 offset-s2">
			<h2>{{ $page->languages->first()->pivot->title }}</h2>
			<label>{{ App\Language::translate('Published at') }}: {{ $page->created_at }}</label>
			<hr>
			@if($page->image)
				<img style="display: block; max-width: 50%;" src="/images/{{ $page->image }}" >
			@endif

			<div>
				{!! $page->languages->first()->pivot->desc !!}
			</div>

			<div>
				{!! $page->languages->first()->pivot->info !!}
			</div>

			@foreach($custom_fields as $custom_field)
			<div>
				<label>{{ App\Language::translate($custom_field->field_key) }}</label>
				<p>{{ App\Language::translate($custom_field->value) }}</p>
			</div>
			@endforeach

			@if(count($tags))
				<strong>{{ App\Language::translate('Tags') }}:</strong>
				@foreach($tags as $tag)
					<a class="waves-effect waves-light btn" href="{{ url(session('slug').'/search/'.$tag->name)}}">{{ $tag->name }}</a>
				@endforeach
			@endif
			
		</div>
		@endif

		<div class="row" style="padding-top: 50px;">
			<hr>
			<div class="col s7 {{ session('dir') == 'rtl' ? 'offset-s5' : '' }}">
			<h4>{{ App\Language::translate('Add Comment') }}</h4>
			<form action="{{ url(session('slug').'/comments_save/') }}" method='GET'>
				<div class="input-field" style="padding-top: 20px;">
					<input type="text" id="name" name="name" class="validate">
					<label for="name">{{ App\Language::translate('Name') }}</label>
															
				</div>

				<div class="input-field" style="padding-top: 20px;">
					<input type="text" id="email" name="email" class="validate">
					<label for="email">{{ App\Language::translate('Email') }}</label>
															
				</div>

				<input type="hidden" name="item_id" value="{{ $page->id }}">

				<div style="padding-top: 20px;">
					<label for="content">{{ App\Language::translate('Description') }}</label>
					<textarea name="content" id="content"></textarea>
    			</div>
    			<div style="padding-top: 20px; padding-bottom: 20px;">
					<button type="submit" class="btn">{{ App\Language::translate('Add Comment')}}</button>
				</div>
			</form>
			
			</div>

			@if(count($comments))
				<div class="col s7 {{ session('dir') == 'rtl' ? 'offset-s5' : '' }}">
				<hr>
				<h4>{{ App\Language::translate('Comments')}}:</h4>
				<div>
					@foreach($comments as $comment)
						<p>{{ $comment->name }}</p>
						<label>{{ $comment->email }}</label>
						<article>{!! $comment->content !!}</article>
						<hr>
					@endforeach	
				</div>
				</div>
			@endif
		</div>
	</div>

@endsection

@section('script')
	<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
    	
        	CKEDITOR.replace('content');
       
    </script>

@endsection