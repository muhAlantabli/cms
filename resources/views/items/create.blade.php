@extends('layouts.main_admin')

@section('title', 'Items')

@section('content')

	<div class="container">
		<h5>{{ $title }}</h5>

		<form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="col s12">
				<div class="input-field" style="padding-top: 20px;">
					<input type="text" id="title" name="title" class="validate" value="{{ $item->title or old('title') }}">
					<label for="title">Title</label>
															
				</div>

				<div class="input-field" style="padding-top: 20px;">
				    <select class="icons" name="category_id">
				      <option value="" disabled selected>Choose your option</option>
				      @foreach($categories as $c)
						<option value="{{ $c->id }}" data-icon="/images/{{ $c->image }}" class="left circle">{{ $c->title }}</option>
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

				<div style="padding-top: 20px;">
					<button type="submit" class="btn waves-effect waves-light large">Submit<i class="material-icons right">send</i></button>	
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
    </script>

@endsection