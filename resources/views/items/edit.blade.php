@extends('layouts.main_admin')

@section('title', 'Items')

@section('content')

	<div class="container">
		<h5>{{ $title }}</h5>

		<form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
			{{ csrf_field() }}
			{{ method_field('PUT') }}
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
					<input type="text" id="title_{{ $language->slug }}" name="title_{{ $language->slug }}" class="validate" value="{{ $item->languages->find($language->id)->pivot->title or old('title') }}">
					<label for="title">Title</label>
															
				</div>

				<div class="input-field" style="padding-top: 20px;">
				    <select name="tags[]" multiple="multiple">
				      <option value="" disabled selected>Choose your option</option>
				      @foreach($tags as $tag)
						<option value="{{ $tag->id }}">{{ $tag->name }}</option>
				      @endforeach
				      
				    </select>
				    <label for="tags">Tags</label>
				</div>

				<div class="input-field" style="padding-top: 20px;">
				    <select class="icons" name="category_id">
				      <option value="" disabled selected>Choose your option</option>
				      @foreach($categories as $c)
						<option selected="{{ $category == $c->id ? "selected" : "" }}" value="{{ $c->id }}" data-icon="/images/{{ $c->image }}" class="left circle">{{ $c->languages->find($language->id)->pivot->title }}</option>
				      @endforeach
				      
				    </select>
				    <label for="category_id">Category</label>
				</div>

				<div class="file-field input-field"  style="padding-top: 20px;">
			      <div class="btn">
			        <span>Image</span>
			        <input type="file" type="text" name="image" >
			      </div>
			      <div class="file-path-wrapper">
			        <input class="file-path validate" value="{{ $item->image or old('image') }}">
			        <img class="left" height="128" width="128" src="/images/{{ $item->image }}">
			      </div>
    			</div>

    			<div style="padding-top: 20px;">
					<label for="desc">Description</label>
					<textarea name="desc_{{ $language->slug }}" id="desc_{{ $language->slug }}">{{ $item->languages->find($language->id)->pivot->desc or old('desc') }}</textarea>
    			</div>
				
				<div style="padding-top: 20px;">
					<label for="info">Information</label>
					<textarea name="info_{{ $language->slug }}" id="info_{{ $language->slug }}">{{ $item->languages->find($language->id)->pivot->info or old('info') }}</textarea>
    			</div>

    			<input type="hidden" name="length" value="{{ count($custom_fields) }}">

    			@for($i =0; $i < count($custom_fields); $i++)
					@if($custom_fields[$i]->type == 'integer')
						<div class="input-field" style="padding-top: 20px;">
							<input type="hidden" name="field_id" value="{{ $custom_fields[$i]->id }}" >
							<input type="text" id="custom_field_value" name="custom_field_value" class="validate" value="{{ $custom_fields[$i]->value }}">
							<label for="custom_field_value">{{ $custom_fields[$i]->field_key }}</label>
						</div>
					@elseif($custom_fields[$i]->type == 'string')
						<div class="input-field" style="padding-top: 20px;">
							<input type="hidden" name="field_id" value="{{ $custom_fields[$i]->id }}" >
							<input type="text" id="custom_field_value" name="custom_field_value" class="validate" value="{{ $custom_fields[$i]->value }}">
							<label for="custom_field_value">{{ $custom_fields[$i]->field_key }}</label>
						</div>

					@elseif($custom_fields[$i]->type == 'text')
						<div style="padding-top: 20px;">
							<input type="hidden" name="field_id" value="{{ $custom_fields[$i]->id }}" >
							<label for="custom_field_value">{{ $custom_fields[$i]->field_key }}</label>
							<textarea name="custom_field_value_t" id="custom_field_value">{{ $custom_fields[$i]->value }}</textarea>
		    			</div>

		    		@elseif($custom_fields[$i]->type == 'file')
		    			<div class="file-field input-field"  style="padding-top: 20px;">
		    			<input type="hidden" name="field_id" value="{{ $custom_fields[$i]->id }}" >
					      <div class="btn">
					        <span>{{ $custom_fields[$i]->field_key }}</span>
					        <input type="file" type="text" name="custom_field_value_file" >
					      </div>
					      <div class="file-path-wrapper">
					        <input class="file-path validate">
					      </div>
		    			</div>
					@endif
    			@endfor
				
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
	        CKEDITOR.replace('desc_{{$language->slug}}');
    	    CKEDITOR.replace('info_{{$language->slug}}');
        @endforeach
        CKEDITOR.replace('custom_field_value_t');
    </script>

@endsection