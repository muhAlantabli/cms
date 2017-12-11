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
					<th>Parent</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				
					@foreach($categories as $category)
					<tr>
						<td>{{ $category->id }}</td>
						<td>{{ $category->title }}</td>
						<td>{{ $category->parent }}</td>
						<td><a href="{{ route('categories.show', $category->id) }}"	class="waves-effect waves-light btn tiny">Show</a></td>
						<td>
						<a href="{{ route('categories.edit', $category->id) }}" class="waves-effect waves-light btn tiny">Update</a>
						</td>
						<td>
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