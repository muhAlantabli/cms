<!doctype html>
<html lang="en">

@include('admin.partials.header')

@include('admin.partials.stylesheet')

<body>

@include('admin.partials.nav')
@if(count($errors) > 0)
	<div class="alert alert-danger">
		<ul>
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif
<main>
	@yield('content')
</main>

@include('admin.partials.footer')

@include('admin.partials.scripts')

@yield('script')

</body>

</html>