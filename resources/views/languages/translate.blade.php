@extends('layouts.main_admin')


@section('content')
	<div class="row">
		<h4>Translate Text</h4>
		<form action="{{ route('languages.store_text') }}" method="POST">
			{{ csrf_field() }}
			<div class="col s4">
				<div class="input-field" style="padding-top: 20px;">
					<input type="text" id="text" name="text" class="validate">
					<label for="text">Text</label>
				</div>

				<div class="input-field" style="padding-top: 20px;">
					<input type="text" id="translated_text" name="translated_text" class="validate">
					<label for="translated_text">Translated Text</label>
				</div>
				
				<input type="hidden" name="language_id" value="{{ $id }}">
				<button type="submit" class="btn btn-info">Submit</button>
				
			</div>
		</form>
	</div>

@endsection