@extends('layouts.main_admin')

@section('title', 'Roles')

@section('content')

	<div class="container">
		<h5>{{ $title }}</h5>

		<form action="{{ route('roles.store') }}" method="POST">
			{{ csrf_field() }}
			
		     
			<div class="col s12">
				<div class="input-field" style="padding-top: 20px;">
					<input type="text" id="name" name="name" class="validate">
					<label for="name">Name</label>									
				</div>

				<div class="input-field" style="padding-top: 20px;">
					<input type="text" id="slug" name="slug" class="validate">
					<label for="slug">Slug</label>									
				</div>
				
			</div>
			
			<div style="padding-top: 20px;">
					<button type="submit" class="btn waves-effect waves-light large">Submit</button>	
			</div>
		</form>
	</div>

@endsection
