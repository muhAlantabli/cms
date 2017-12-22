@extends('layouts.main_admin')


@section('content')
	<div class="row">
		
		@foreach(App\Language::all() as $language)
		<div class="col s8">
			@if($category->languages->find($language->id))
			<ul class="collapsible" data-collapsible="accordion">
				
				<li>
					<div class="collapsible-header active"><strong>Title</strong></div>
					<div class="collapsible-body">{{ $category->languages->find($language->id)->pivot->title }}</div>
				</li>

				<li>
					<div class="collapsible-header"><strong>Image</strong></div>
					<div class="collapsible-body"><img height="256" width="256" src="/images/{{$category->image}}"></div>
				</li>

				<li>
					<div class="collapsible-header"><strong>Description</strong></div>
					<div class="collapsible-body">{!! $category->languages->find($language->id)->pivot->desc !!}</div>
				</li>
				
			</ul>
			@endif
		</div>
		@endforeach
	

	
	<div class="col s4">
		<div class="card">
            <div class="card-content">

              <p><strong>Created At:</strong> <h6>{{$category->created_at }}</h6></p>
              <p><strong>Updated At:</strong> <h6>{{$category->updated_at }}</h6></p>
              <p><strong>Created By:</strong> <h6>{{$category->created_by }}</h6></p>
              <p><strong>Updated By:</strong> <h6>{{$category->created_by }}</h6></p>             

            </div>
            <div class="card-action">
              <div class="left"><a href="{{ route('categories.edit', $category->id) }}" class="waves-effect waves-light btn large">&nbsp; Edit &nbsp;</a></div>
              <div class="right">
              	<form action="{{ route('categories.destroy', $category->id) }}" method="POST">
					<input type="hidden" name="_method" value="DELETE">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<button class="waves-effect waves-light btn red" type="submit">Delete</button>	
				</form>
              </div>

              <div style="padding-top:50px;"><a style="padding:0 80px;" href="{{ route('categories.index') }}" class="waves-effect waves-light btn blue">Show All Items</a></div>
              <div>
            </div>
          </div>
		</div>
	</div>
	<div class="row">
		<div class="col s8">
			<a class="waves-effect waves-light btn" href="{{ url('/') }}/backend/items/create/{{ $category->id }}">Create New Item</a>
		<table class="bordered highlight">
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th></th>
					
				</tr>
			</thead>

			<tbody>
					@foreach($items as $item)
					<tr>
						<td>{{ $item->id }}</td>
						<td><a href="{{ route('items.show', $item->id) }}">{{ $item->languages()->first()->pivot->title }}</a></td>
						
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

		@if(auth()->user()->type == 'admin')
			<div class="col s4 offset-s8">
				<div class="card">
					<div class="center" style="padding-top: 20px;">
						<i>Extra Catgeory Fields</i>
					</div>
		            <div class="card-content">
					
						<table class="bordered">
							<thead>
								<tr>
									<th>key</th>
									<th>Type</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($custom_fields as $custom_field)
								<tr>
									<td>{{ $custom_field->field_key }}</td>
									<td>{{ $custom_field->type }}</td>
									<td>
										<form action="{{ route('categories.delete_custom_field', [ 'category_id' => $category->id, 'id' => $custom_field->id]) }}" 
											method="POST">
											<input type="hidden" name="_method" value="DELETE">
											<input type="hidden" name="_token" value="{{ csrf_token() }}">
											<button class="waves-effect waves-light btn red tiny" type="submit" href="#">Delete</button>
										</form>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
		              
		            </div>
		            <div class="card-action">
		              <div class="center"><a style="padding:0 100px;" href="{{ route('categories.create_custom_field', $category->id) }}" class="waves-effect waves-light btn ">Create</a></div>
		              <div>
		            </div>
		          </div>
				</div>
			</div>
			@endif
			
	</div>
	
	
@endsection


@section('script')
	<script type="text/javascript">

		$(document).ready(function(){
    		$('.collapsible').collapsible();
  		});	
	</script>
@endsection