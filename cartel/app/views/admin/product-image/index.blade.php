@extends('layouts.master')

{{-- Meta canonical   --}}
{{-- ----------------------------------------------------- --}}
@section('canonical')
	<link rel="canonical" href="http://www.example.com/admin-origin" />
@stop

{{-- Css files   --}}
{{-- ----------------------------------------------------- --}}
@section('css')
	<link rel="stylesheet" href="css/admin.css" />
@stop

{{-- Page Title   --}}
{{-- ----------------------------------------------------- --}}
@section('title')
 Product Image Administration | Cartel Marketing Inc. | Leamington, Ontario
@stop


{{-- JS head   --}}
{{-- ----------------------------------------------------- --}}
@section('js_head')
<script type="text/javascript">
  $(function(){
    $('[data-method]').append(function(){
          return "\n"+
          "<form action='"+$(this).attr('href')+"' method='POST' style='display:none'>\n"+
          "   <input type='hidden' name='_method' value='"+$(this).attr('data-method')+"'>\n"+
          "</form>\n"
    })
    .removeAttr('href')
    .attr('style','cursor:pointer;')
    .attr('onclick','$(this).find("form").submit(); ');
  });
</script>

@stop

{{-- Content   --}}
{{-- ----------------------------------------------------- --}}
@section('content')
  <h1>Product Image Administration</h1>
  <a href="/admin_menu">Back to Admin Menu</a><br /><br />
  <a href="/admin-product-image/create"><i class="fa fa-plus fa-lg fa-grey"></i> Add New Product Image</a>

	<div class="table-responsive">
		<table class="table table-bordered table-striped"> 
			<thead>
				<tr>
					<th>Product Name</th>
					<th>Product Variety</th>
					<th>Colour</th>
					<th>Thumb</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
          @foreach($product_images as $product_image)
          <tr>
          
            <!-- Product name -->
            <td>{{{ $product_image['category_name'] }}}</td>
            <!-- Variety name -->
            <td>{{{ $product_image['variety_name'] }}}</td>
            <!-- Colour -->
            <td>{{{ $product_image['colour_name'] }}}</td>
            
            <!-- Thumb -->
            <td><a href="uplds/productimages/{{{ $product_image['filename'] }}}"><img src="uplds/productimages/th-{{{ $product_image['filename'] }}}" /></a></td>
            
            <td>
              <!-- Edit -->
              <a href="admin-product-image/{{{ $product_image['id'] }}}/edit"><i class="fa fa-pencil fa-lg"></i></a>
              
              <!-- Delete -->
              <a href="admin-product-image/{{{ $product_image['filename'] }}}" data-method="DELETE">
                <i class="fa fa-trash-o fa-lg"> </i>
              </a>
            </td>
            
          </tr>
				@endforeach
			</tbody> 
    </table>
  </div>
@stop

{{-- Additional Scripts   --}}
{{-- ----------------------------------------------------- --}}
@section('bottomscripts')
@stop
    
