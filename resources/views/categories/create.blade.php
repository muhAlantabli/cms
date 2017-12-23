@extends('layouts.main_admin')

@section('title', 'Categories')

@section('content')

	<div class="container">
		<h5>{{ $title }}</h5>

		<form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="col s12">
		      <ul class="tabs">
		      	@foreach($languages as $language)
		        	<li class="tab col s3">
		        		<a href="#{{ $language->slug }}">{{ $language->name }}</a>
		        	</li>
		        @endforeach
		      </ul>
		  	</div>
		     @foreach($languages as $language)
			<div class="col s12" id="{{ $language->slug }}">
				<div class="input-field" style="padding-top: 20px;">
					<input type="text" id="title_{{ $language->slug }}" name="title_{{ $language->slug }}" class="validate" value="{{ $category->title or old('title') }}">
					<label for="title">Title</label>
															
				</div>

				@if($language->slug == "en")
					<div class="input-field" style="padding-top: 20px;">
						<input type="text" id="slug" name="slug" class="validate">
						<label for="slug">Slug</label>
																
					</div>
				

				<div class="input-field" style="padding-top: 20px;">
				    <select class="icons" name="parent_id">
				      <option value="" disabled selected>Choose your option</option>
				      @foreach($categories as $c)
						<option value="{{ $c->id }}" data-icon="/images/{{ $c->image }}" class="left circle">{{ $c->paddedTitle($c->id) }}</option>
				      @endforeach
				      
				    </select>
				    <label for="parent_id">Parent</label>
				</div>


				<div class="file-field input-field"  style="padding-top: 20px;">
			      <div class="btn">
			        <span>Image</span>
			        <input type="file" type="text" name="image" >
			      </div>
			      <div class="file-path-wrapper">
			        <input class="file-path validate" value="{{ $category->image or old('image') }}">
			      </div>
    			</div>
				@endif
    			<div style="padding-top: 20px;">
					<label for="desc">Description</label>
					<textarea name="desc_{{ $language->slug }}" id="desc_{{ $language->slug }}">{{ $category->desc or old('desc') }}</textarea>
    			</div>

				
			</div>
			@endforeach
			<div style="padding-top: 20px;">
					<button type="submit" class="btn waves-effect waves-light large">Submit</button>	
			</div>
		</form>
	</div>

@endsection

@section('script')
	<script type="text/javascript">
		$(document).ready(function() {
			$('select').material_select();
		});	
	</script>

	<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
    	@foreach($languages as $language)
        	CKEDITOR.replace('desc_{{ $language->slug }}');
        @endforeach
    </script>

@endsection