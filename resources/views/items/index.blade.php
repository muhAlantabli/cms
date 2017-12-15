@extends('layouts.main_admin')

@section('title', 'Items')


@section('content')
	<div class="row" style="padding-top: 50px;">
		<div class="col s12">
			<a class="waves-effect waves-light btn" href="{{ route('items.create') }}">Create New Item</a>
		<table class="bordered highlight">
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Category</th>
					<th></th>
					
				</tr>
			</thead>

			<tbody>
				
					@foreach($items as $item)
					<tr>
						<td>{{ $item->id }}</td>
						<td><a href="{{ route('items.show', $item->id) }}">{{ $item->title }}</a></td>
						<td>{{ App\Category::where('id', $item->category_id)->value('title') }}</td>
						<td class="right">
						<form action="{{ route('items.destroy', $item->id) }}" method="POST">
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