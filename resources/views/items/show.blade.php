@extends('layouts.main_admin')


@section('content')
	<div class="row">
		<div class="col s6">
			<h2>{{ $item->title }}</h2>
			<div>
				<img height="256" width="256" src="/images/{{$item->image}}">
			</div>
			<div>
				{{ $item->desc }}
			</div>

			<div>
				{{ $item->info }}
			</div>
		</div>
	

	
	<div class="col s4 offset-s2">
		<div class="card">
            <div class="card-content">

              <p><strong>Created At:</strong> {{$item->created_at }}</p>
              <p><strong>Updated At:</strong> {{$item->updated_at }}</p>
              <p><strong>Created By:</strong> {{$item->created_by }}</p>
              <p><strong>Updated By:</strong> {{$item->created_by }}</p>
              <p><strong>Category:</strong>{{ $item->category_id }}</p>
              

            </div>
            <div class="card-action">
              <div class="left"><a href="{{ route('items.edit', $item->id) }}" class="waves-effect waves-light btn large">&nbsp; Edit &nbsp;</a></div>
              <div class="right">
              	<form action="{{ route('items.destroy', $item->id) }}" method="POST">
					<input type="hidden" name="_method" value="DELETE">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<button class="waves-effect waves-light btn red" type="submit">Delete</button>	
				</form>
              </div>

              <div style="padding-top:50px;"><a style="padding:0 80px;" href="{{ route('items.index') }}" class="waves-effect waves-light btn blue">Show All Items</a></div>
              <div>
            </div>
          </div>
	
</div>
</div>
@endsection