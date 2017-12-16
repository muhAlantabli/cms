@extends('layouts.main_admin')

@section('title', 'Categories')


@section('content')
	<div class="row" style="padding-top: 50px;">
		<div class="col s12">
			<a class="waves-effect waves-light btn" href="{{ route('categories.create') }}">Create New Category</a>
		<table class="bordered highlight">
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					
					<th>Url</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				
					@foreach($categories as $category)
					<tr>
						<td>{{ $category->id }}</td>
						<td><a href="{{ route('categories.show', $category->id) }}"	class="waves-effect waves-light">{{ $category->paddedTitle() }}</a></td>
						
						<td><a href="{{ url($category->url) }}">{{ $category->url }}</a></td>
						<td class="right"> 
						<form action="{{ route('categories.destroy', $category->id) }}" method="POST">
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
			
	</div>
	
@endsection