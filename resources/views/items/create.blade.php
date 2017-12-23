@extends('layouts.main_admin')

@section('title', 'Items')

@section('content')

	<div class="container">
		<h5>{{ $title }}</h5>

		<form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
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
					<input type="text" id="title_{{ $language->slug }}" name="title_{{ $language->slug }}" class="validate">
					<label for="title">Title</label>								
				</div>

				@if($language->slug == 'en')
				<input type="hidden" name="category_id" value="{{ $category_id }}" >

				<div class="input-field" style="padding-top: 20px;">
				    <select name="tags_{{ $language->slug }}[]" multiple="multiple">
				      <option value="" disabled selected>Choose your option</option>
				      @foreach($tags as $tag)
						<option value="{{ $tag->id }}">{{ $tag->name }}</option>
				      @endforeach
				      
				    </select>
				    <label for="tags">Tags</label>
				</div>

				

				<div class="file-field input-field"  style="padding-top: 20px;">
			      <div class="btn">
			        <span>Image</span>
			        <input type="file" type="text" name="image" >
			      </div>
			      <div class="file-path-wrapper">
			        <input class="file-path validate">
			      </div>
    			</div>
    			@endif

    			<div style="padding-top: 20px;">
					<label for="desc">Description</label>
					<textarea name="desc_{{ $language->slug }}" id="desc_{{ $language->slug }}"></textarea>
    			</div>
				
				<div style="padding-top: 20px;">
					<label for="info">Information</label>
					<textarea name="info_{{ $language->slug }}" id="info_{{ $language->slug }}"></textarea>
    			</div>

				<input type="hidden" name="length" value="{{ count($custom_fields) }}">
				
				@if($language->slug == "en")
    			@for($i =0; $i < count($custom_fields); $i++)
					@if($custom_fields[$i]->type == 'integer')
						<div class="input-field" style="padding-top: 20px;">
							<input type="hidden" name="field_id{{ $i }}" value="{{ $custom_fields[$i]->id }}" >
							<input type="text" id="custom_field_value{{ $i }}" name="custom_field_value{{ $i }}" class="validate">
							<label for="custom_field_value{{ $i }}">{{ $custom_fields[$i]->field_key }}</label>
						</div>
					@elseif($custom_fields[$i]->type == 'string')
						<div class="input-field" style="padding-top: 20px;">
							<input type="hidden" name="field_id{{ $i }}" value="{{ $custom_fields[$i]->id }}" >
							<input type="text" id="custom_field_value{{ $i }}" name="custom_field_value{{ $i }}" class="validate">
							<label for="custom_field_value{{ $i }}">{{ $custom_fields[$i]->field_key }}</label>
						</div>

		    		@elseif($custom_fields[$i]->type == 'file')
		    			<div class="file-field input-field"  style="padding-top: 20px;">
		    			<input type="hidden" name="field_id{{ $i }}" value="{{ $custom_fields[$i]->id }}" >
					      <div class="btn">
					        <span>{{ $custom_fields[$i]->field_key }}</span>
					        <input type="file" type="text" name="custom_field_value_file{{ $i }}" >
					      </div>
					      <div class="file-path-wrapper">
					        <input class="file-path validate">
					      </div>
		    			</div>
					@endif
    			@endfor
				@endif
				<div style="padding-top: 20px;">
					<button type="submit" class="btn waves-effect waves-light large">Submit</button>	
				</div>
			</div>
			@endforeach
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
    	
    		@foreach($languages as $l)
	        	CKEDITOR.replace('desc_{{ $l->slug }}');
	        	CKEDITOR.replace('info_{{ $l->slug }}');
        	@endforeach
    </script>

@endsection