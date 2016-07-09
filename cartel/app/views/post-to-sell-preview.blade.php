{{-- Post to Buy Preview --}}
@include('layouts.post-to-preview', array(
	"page" => "sell",

	"post_to_preview_css" => URL::asset('css/post-to-sell-preview.css'),
	"canonical" => 'post-to-sell.php',
	"title" => 'Post To Sell - Preview | Cartel Marketing Inc. | Leamington, Ontario',
	"header_icon" => URL::asset('images/post-to-sell-icon.png'),
	"header_alt" => 'Post to Sell',
	"header_class" => 'post-to-buy-icon',
	"header_h1" => 'Post To Sell - Preview',
	"display_address" => 'Shipping',
  "address_header" => "Shipping Address",
  
	"other_address_id" => 'other_address',
	"other_address_id2" => 'other_address2',
	"address_field_id" => 'ReceivingAddress',
  
	"address_select_name" => 'company_address_id',
	"address_select_id" => 'company_address_id',
  "address_select" => 'company_address_id',
  
	"address" => 'receiving',
  
  "submit_route" => "/post-to-sell/".$prod_details->id."/commit",
  "edit_route" => "/post-to-sell/".$prod_details->id."/edit",
  
	"post_to_js" => '<script src="'. URL::asset('js/post-to-sell-preview.js') . '"></script>',
  )
)
