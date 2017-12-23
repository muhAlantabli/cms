<!doctype html>
<html lang="{{ session('slug') }}" dir="{{ session('dir') }}">

@include('partials.header')

@include('partials.stylesheet')

<body>
<header>
	@include('partials.nav')	
</header>
@include('partials.messages')
<main>
    @yield('content')
</main>

@include('partials.footer')

@include('partials.scripts')

@yield('script')

</body>

</html>