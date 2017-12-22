@extends('layouts.main_admin')

@section('title', 'Languages')

@section('content')
	<div class="row" style="padding-top: 50px;">
		<div class="col s8">
			
		<table class="bordered highlight">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				
					@foreach($languages as $language)
					<tr>
						<td>{{ $language->id }}</td>
						<td><a href="{{ route('languages.show', $language->id) }}">{{ $language->name }}</a></td>
						
						<td class="right"> 
						@if($language->slug != 'en')
						<form action="{{ route('languages.destroy', $language->id) }}" method="POST">
							<input type="hidden" name="_method" value="DELETE">
    						<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<button class="waves-effect waves-light btn red tiny" type="submit">Delete</button>	
						</form>
						@endif
						</td>
					</tr>
					@endforeach
				
			</tbody>
		</table>	
		</div>
		<div class="col s4">
			<div class="card">
				<h5 class="center" style="padding-top: 20px;">Create New Tag</h5>
				<form action="{{ route('languages.store') }}" method="POST">
					{{ csrf_field() }}
					<div class="card-content">

						<div class="input-field">
							<input type="text" id="name" name="name" class="validate">
							<label for="name">Name</label>					
						</div>
						
						<div class="input-field">
							<input type="text" id="dir" name="dir" class="validate">
							<label for="dir">Direction: (ltr, rtl)</label>					
						</div>

						<div class="input-field">
							<input type="text" id="slug" name="slug" class="validate">
							<label for="slug">Slug</label>					
						</div>
					</div>
					<div class="card-action">
						<button class="waves-effect waves-light btn" type="submit" href="#">
						Create
					</button>							
					</div>
				</form>

			</div>
		</div>
			
	</div>
	
@endsection

