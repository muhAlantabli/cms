<!DOCTYPE html>
<html>

@include('partials.header')

    <body>
        @include('partials.nav')

        <div class="container">
          @include('partials.messages')

          @yield('content')

        </div>

        @include('partials.javascript')

        @yield('scripts')
    </body>
    @include('partials.footer')
</html>