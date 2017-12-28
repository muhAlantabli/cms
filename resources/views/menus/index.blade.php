@extends('layouts.main_admin')

@section('title', 'Menus')


@section('content')
	<div class="row" style="padding-top: 50px;">
		<div class="col s12">
			
				<a class="waves-effect waves-light btn" href="{{ route('menus.create') }}">Create New Menu Item
				</a>
			
		<table class="bordered highlight">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Type</th>
					<th>Catgeory</th>
					<th></th>
					
				</tr>
			</thead>

			<tbody>
				
					@foreach($menus as $menu)
					<tr>
						<td>{{ $menu->id }}</td>
						<td><a href="{{ route('menus.edit', $menu->id) }}">{{ $menu->paddedName() }}</a></td>
						<td>{{ $menu->type }}</td>
						<td>{{ DB::table('category_language')->where('category_id', '=', $menu->category_id)->where('language_id','=', 1)->value('title') }}</td>
						<td class="right">
						<form action="{{ route('menus.destroy', $menu->id) }}" method="POST">
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