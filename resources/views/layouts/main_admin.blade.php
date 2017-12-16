<!doctype html>
<html lang="en">

@include('admin.partials.header')

@include('admin.partials.stylesheet')

<body>

@include('admin.partials.nav')

<main>
	@include('admin.partials.messages')
	@yield('content')
</main>

@include('admin.partials.footer')

@include('admin.partials.scripts')

@yield('script')

</body>

</html>