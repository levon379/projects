<!DOCTYPE html>
<html lang="en-ca">

{{-- Head   --}}
@include('layouts.head')

{{-- Body   --}}
<body>
  @include('layouts.modal')
  <div class="maincontain">
  
    {{-- header --}}
    @section('header')
      @include('layouts.header')
    @show
    
    {{-- nav --}}
    @section('nav')
      @include('layouts.nav')
    @show
    
    {{-- content --}}
    <div id="content" class="tab-content">
      @include('layouts.messages')
      @yield('content')
    </div><!-- #content -->
    
    {{-- footer --}}
    @include('layouts.footer')
    
  </div><!-- end #maincontain -->
  @include('layouts.bottomscripts')
  
</body>
</html>
