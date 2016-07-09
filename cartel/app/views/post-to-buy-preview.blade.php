{{-- Post to Buy Preview --}}
@include('layouts.post-to-preview', array(
	"page" => "buy",

	"post_to_preview_css" => 'css/post-to-buy-preview.css',
	"canonical" => 'post-to-buy.php',
	"title" => 'Post To Buy - Preview | Cartel Marketing Inc. | Leamington, Ontario',

	"header_icon" => URL::asset('images/post-to-buy-icon.png'),
	"header_alt" => 'Post to Buy',
	"header_class" => 'post-to-buy-icon',
	"header_h1" => 'Post To Buy - Preview',
	"intro_text" => Lang::get('site_content.post_to_buy_Intro'),

	"display_address" => 'Receiving',
  "address_header" => "Delivery Address",
	"other_address_id" => 'other_address',
	"other_address_id2" => 'other_address2',
	"address_field_id" => 'ReceivingAddress',
  
	"address_select_name" => 'company_address_id',
	"address_select_id" => 'company_address_id',
    "address_select" => 'company_address_id',
  
	"address" => 'receiving',
  
  /* Peter Take a look at these routes */
  "submit_route" => "/post-to-buy/".$prod_details->id."/commit",
  "edit_route" => "/post-to-buy/".$prod_details->id."/edit",
  
	"post_to_js" => '<script src="'. URL::asset('js/post-to-buy-preview.js') . '"></script>',
  )
)
