<!doctype html>
<html lang="en">

@include('partials.header')

@include('partials.stylesheet')

<body>

@include('partials.nav')
@include('partials.messages')
<main>
    @yield('content')
</main>

@include('partials.footer')

@include('partials.scripts')

@yield('script')

</body>

</html>