@extends('layouts.main_admin')

@section('title', $tag->name)

@section('content')
	<div class="row" style="padding-top: 20px;">
		<div class="col s8">
		<h4>All items</h4>
		<table class="bordered highlight centered">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					
				</tr>
			</thead>

			<tbody>
				
					@foreach($items as $item)
					<tr>
						<td>{{ $item->id }}</td>
						<td><a href="{{ route('items.show', $item->id) }}">{{ $item->title }}</a></td>
						
					</tr>
					@endforeach
				
			</tbody>
		</table>	
		</div>
		
			
	</div>
	
@endsection

