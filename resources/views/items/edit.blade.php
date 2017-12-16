@extends('layouts.main_admin')

@section('title', 'Items')

@section('content')

	<div class="container">
		<h5>{{ $title }}</h5>

		<form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
			{{ csrf_field() }}
			{{ method_field('PUT') }}
			<div class="col s12">
				<div class="input-field" style="padding-top: 20px;">
					<input type="text" id="title" name="title" class="validate" value="{{ $item->title or old('title') }}">
					<label for="title">Title</label>
															
				</div>

				<div class="input-field" style="padding-top: 20px;">
				    <select class="icons" name="category_id">
				      <option value="" disabled selected>Choose your option</option>
				      @foreach($categories as $c)
						<option selected="{{ $category == $c->id ? "selected" : "" }}" value="{{ $c->id }}" data-icon="/images/{{ $c->image }}" class="left circle">{{ $c->title }}</option>
				      @endforeach
				      
				    </select>
				    <label for="category_id">Category</label>
				</div>

				<div class="input-field" style="padding-top: 20px;">
				    <select name="language_id">
				      <option value="" disabled selected>Choose your option</option>
				      @foreach($languages as $language)
						<option value="{{ $language->id }}">{{ $language->name }}</option>
				      @endforeach
				      
				    </select>
				    <label for="language_id">Language</label>
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
					<textarea name="desc" id="desc">{{ $item->desc or old('desc') }}</textarea>
    			</div>
				
				<div style="padding-top: 20px;">
					<label for="info">Information</label>
					<textarea name="info" id="info">{{ $item->info or old('info') }}</textarea>
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

				<div style="padding-top: 20px;">
					<button type="submit" class="btn waves-effect waves-light large">Submit</button>	
				</div>
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
        CKEDITOR.replace('desc');
        CKEDITOR.replace('info');
        CKEDITOR.replace('custom_field_value_t');
    </script>

@endsection