@extends('layouts.main_admin')

@section('title', 'Roles')

@section('content')
	<div class="row" style="padding-top: 50px;">
		<div class="col s8">
			<a class="waves-effect waves-light btn" href="{{ route('roles.create') }}">Create New Role</a>
		<table class="bordered highlight">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Slug</th>
					
				</tr>
			</thead>

			<tbody>
				
					@foreach($roles as $role)
					<tr>
						<td>{{ $role->id }}</td>
						<td><a href="{{ route('roles.show', $role->id) }}">{{ $role->name }}</a></td>
						<td>{{ $role->slug }}</td>
						
						
						<td class="right"> 
						
						<form action="{{ route('roles.destroy', $role->id) }}" method="POST">
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

