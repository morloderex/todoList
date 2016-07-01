<!DOCTYPE html>
<html lang="en">
    @include('layouts.partials.head')
    <body id="app-layout">
        @include('layouts.partials.nav')
        <div id="app" class="container">

            @yield('content')

        </div>

    @include('layouts.partials.footer')
    </body>
</html>
