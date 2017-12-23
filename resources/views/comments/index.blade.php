@extends('layouts.main_admin')

@section('title', 'Comments')

@section('content')
	<div class="row" style="padding-top: 50px;">
		<div class="col s12">
			
		<table class="bordered highlight">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Email</th>
					<th>Content</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				
					@foreach($comments as $comment)
					<tr>
						<td>{{ $comment->id }}</td>
						<td>{{ $comment->name }}</td>
						<td>{{ $comment->email }}</td>
						
						<td>{!! $comment->content !!}</td>
						<td class="right"> 
						<form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
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

