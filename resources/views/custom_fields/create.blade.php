@extends('layouts.main_admin')

@section('title', 'Categories')

@section('content')
	<div class="container">
		<h4>Create Custom Field</h4>
		<form action="{{ route('categories.store_custom_field') }}" method="POST" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="col s4">
				<div class="input-field" style="padding-top: 20px;">
					<input type="text" id="field_key" name="field_key" class="validate">
					<label for="field_key">Field Title</label>
				</div>
				
				<div class="input-field" style="padding-top: 20px;">
				    <select name="type">
				      	<option value="" disabled selected>Choose your option</option>
						<option value="integer">Integer</option>
						<option value="string">String</option>
						<option value="file">File</option>
						
				    </select>
				    <label for="type">Field Type</label>
				</div>
				<input type="hidden" name="category_id" value="{{ $id }}">

				<button type="submit" class="btn btn-info">Submit</button>
				<a href="{{ route('categories.show', $id) }}" class="waves-effect waves-light btn ">Or Back to Category</a>
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
@endsection