<!DOCTYPE html>
<html lang="en-ca">


{{-- Body   --}}
<body>

{{-- Containers   --}}
{{-- ----------------------------------------------------- --}}
<div id="main">
  <div class="wrapper">
    <div class="container">

        <div id="content" class="tab-content">
          <div class="container">
			{{-- Content   --}}
			{{-- ----------------------------------------------------- --}}
			@yield('content')
      
            </div> <!-- container -->
        </div><!-- #content -->

    </div><!-- .container -->
  </div><!-- .wrapper -->
</div><!-- end #main -->


</body>
</html>
