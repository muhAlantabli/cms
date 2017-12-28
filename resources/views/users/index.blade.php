@extends('layouts.main_admin')

@section('title', 'Users')

@section('content')
	<div class="row" style="padding-top: 50px;">
		<div class="col s8">
			<a class="waves-effect waves-light btn" href="{{ route('users.create') }}">Attach Role</a>
			
		<table class="bordered highlight">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Email</th>
					<th>Role</th>
				</tr>
			</thead>

			<tbody>
				
					@foreach($users as $user)
					<tr>
						<td>{{ $user->id }}</td>
						<td>{{ $user->name }}</td>
						<td>{{ $user->email }}</td>
						<td>{{ $user->roles->first()['name'] }}</td>
						
						<td class="right"> 
						
						<form action="{{ route('users.destroy', $user->id) }}" method="POST">
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

