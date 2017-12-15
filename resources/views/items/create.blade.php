@extends('layouts.main_admin')

@section('title', 'Items')

@section('content')

	<div class="container">
		<h5>{{ $title }}</h5>

		<form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="col s12">
				<div class="input-field" style="padding-top: 20px;">
					<input type="text" id="title" name="title" class="validate">
					<label for="title">Title</label>
															
				</div>

				<input type="hidden" name="category_id" value="{{ $category_id }}" >

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
			        <input class="file-path validate">
			      </div>
    			</div>

    			<div style="padding-top: 20px;">
					<label for="desc">Description</label>
					<textarea name="desc" id="desc"></textarea>
    			</div>
				
				<div style="padding-top: 20px;">
					<label for="info">Information</label>
					<textarea name="info" id="info"></textarea>
    			</div>

    			@foreach($custom_fields as $custom_field)
					@if($custom_field->type == 'integer')
						<div class="input-field" style="padding-top: 20px;">
							<input type="hidden" name="field_id" value="{{ $custom_field->id }}" >
							<input type="text" id="custom_field_value" name="custom_field_value" class="validate">
							<label for="custom_field_value">{{ $custom_field->field_key }}</label>
						</div>
					@elseif($custom_field->type == 'string')
						<div class="input-field" style="padding-top: 20px;">
							<input type="hidden" name="field_id" value="{{ $custom_field->id }}" >
							<input type="text" id="custom_field_value" name="custom_field_value" class="validate">
							<label for="custom_field_value">{{ $custom_field->field_key }}</label>
						</div>

					@elseif($custom_field->type == 'text')
						<div style="padding-top: 20px;">
							<input type="hidden" name="field_id" value="{{ $custom_field->id }}" >
							<label for="custom_field_value">{{ $custom_field->field_key }}</label>
							<textarea name="custom_field_value_t" id="custom_field_value"></textarea>
		    			</div>

		    		@elseif($custom_field->type == 'file')
		    			<div class="file-field input-field"  style="padding-top: 20px;">
		    			<input type="hidden" name="field_id" value="{{ $custom_field->id }}" >
					      <div class="btn">
					        <span>{{ $custom_field->field_key }}</span>
					        <input type="file" type="text" name="custom_field_value_file" >
					      </div>
					      <div class="file-path-wrapper">
					        <input class="file-path validate">
					      </div>
		    			</div>
					@endif
    			@endforeach

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