@extends('layouts.main_admin')

@section('title', 'Menus')

@section('content')

	<div class="container">
		<h5>{{ $title }}</h5>

		<form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="col s12">
				<div class="input-field" style="padding-top: 20px;">
					<input type="text" id="name" name="name" class="validate">
					<label for="name">Name</label>
															
				</div>

				<div class="input-field" style="padding-top: 20px;">
				    <select class="icons" name="category_id">
				      <option value="" disabled selected>Choose your option</option>
				      @foreach($categories as $c)
						<option value="{{ $c->id }}" data-icon="/images/{{ $c->image }}" class="left circle">{{ $c->title }}</option>
				      @endforeach
				      
				    </select>
				    <label for="category_id">Category</label>
				</div>

				<div class="input-field" style="padding-top: 20px;">
				    <select name="language_id">
				      <option value="" disabled selected>Choose your option</option>
				      @foreach($languages as $language)
						<option value="{{ $language->id }}">{{ $language->name }}</option>
				      @endforeach
				      
				    </select>
				    <label for="language_id">Language</label>
				</div>

				<div class="input-field row">
					<div class="col s1">
						<label for="order">&nbsp;&nbsp;&nbsp;&nbsp;Order</label>
					</div>
					<div class="col s4">
						<select name="order">
				      	<option value="" disabled selected>Choose your option</option>
						<option value="before">Before</option>
						<option value="after">After</option>
						<option value="childOf">Child Of</option>

				    </select>
					</div>
					<div class="col s4">
					    <select name="orderPage">
					      <option value="" disabled selected>Choose your option</option>
					      @foreach($menuList as $menu_item)
							<option value="{{ $menu_item->id }}">{{ $menu_item->paddedName() }}</option>
					      @endforeach
					      
					    </select>
					</div>
				</div>

				<div style="padding-top: 20px;">
					<button type="submit" class="btn waves-effect waves-light large">Submit</button>	
				</div>
			</div>
		</form>
	</div>

@endsection

@section('script')
	<script type="text/javascript">
		$(document).ready(function() {
			$('select').material_select();
		});	
	</script>

	<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('desc');
        CKEDITOR.replace('info');
    </script>

@endsection