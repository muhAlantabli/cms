@extends('layouts.main_admin')

@section('title', 'Tags')

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
				
					@foreach($tags as $tag)
					<tr>
						<td>{{ $tag->id }}</td>
						<td><a href="{{ route('tags.show', $tag->id) }}">{{ $tag->name }}</a></td>
						
						<td class="right"> 
						<form action="{{ route('tags.destroy', $tag->id) }}" method="POST">
							<input type="hidden" name="_method" value="DELETE">
    						<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<button class="waves-effect waves-light btn red tiny" type="submit">Delete</button>	
						</form>
						</td>
					</tr>
					@endforeach
				
			</tbody>
		</table>	
		</div>
		<div class="col s4">
			<div class="card">
				<h5 class="center" style="padding-top: 20px;">Create New Tag</h5>
				<form action="{{ route('tags.store') }}" method="POST">
					{{ csrf_field() }}
					<div class="card-content">

						<div class="input-field">
							<input type="text" id="name" name="name" class="validate">
							<label for="name">Name</label>
																	
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

