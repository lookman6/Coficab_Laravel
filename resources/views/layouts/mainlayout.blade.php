<!DOCTYPE html>
<html lang="en">
 <head>
   @include('layouts.partials.head')
 </head>
 <body>
      @include('layouts.partials.header')
      @include('layouts.partials.sidebar')
      <main id="main" class="main">
        @yield('content')
      </main>
      @include('layouts.partials.footer')
      @include('layouts.partials.footer-scripts')

</body>
</html>
