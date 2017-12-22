@extends('layouts.main_admin')


@section('content')
	<div class="row">
		
		<div class="col s8">
			@foreach(App\Language::all() as $language)
			@if($item->languages->find($language->id))
			<ul class="collapsible" data-collapsible="accordion">
				<li>
					<div class="collapsible-header active"><strong>Title</strong></div>
					<div class="collapsible-body">{{ $item->languages->find($language->id)->pivot->title }}</div>
				</li>

				<li>
					<div class="collapsible-header"><strong>Image</strong></div>
					<div class="collapsible-body"><img height="256" width="256" src="/images/{{$item->image}}"></div>
				</li>

				<li>
					<div class="collapsible-header"><strong>Description</strong></div>
					<div class="collapsible-body">{!! $item->languages->find($language->id)->pivot->desc !!}</div>
				</li>

				<li>
					<div class="collapsible-header"><strong>Information</strong></div>
					<div class="collapsible-body">{!! $item->languages->find($language->id)->pivot->info !!}</div>
				</li>

				@foreach($custom_fields as $custom_field)
					<li>
						<div class="collapsible-header"><strong>{{ $custom_field->field_key }}</strong></div>
						<div class="collapsible-body">{{ $custom_field->value }}</div>	
					</li>
				@endforeach
			</ul>
			@endif
			@endforeach
		</div>
	
	<div class="col s4">
		<div class="card">
            <div class="card-content">

              <p><strong>Created At:</strong> <h6>{{$item->created_at }}</h6></p>
              <p><strong>Updated At:</strong> <h6>{{$item->updated_at }}</h6></p>
              <p><strong>Created By:</strong> <h6>{{$item->created_by }}</h6></p>
              <p><strong>Updated By:</strong> <h6>{{$item->created_by }}</h6></p>             

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

              <div style="padding-top:50px;"><a style="padding:0 80px;" href="{{ route('categories.show', $item->category_id) }}" class="waves-effect waves-light btn blue">Show All Items</a></div>
              <div>
            </div>
          </div>
	
</div>
</div>
@endsection


@section('script')
	<script type="text/javascript">
		$(document).ready(function(){
    		$('.collapsible').collapsible();
  		});	
	</script>
@endsection