{{-- Post to Sell --}}
@include('layouts.post-to', array(
	"page" => "sell",

	"post_to_css" => 'post-to-sell.css',
	"canonical" => 'post-to-sell.php',
	"title" => Lang::get('site_content.post_to_sell_Title'),

	"header_icon" => 'post-to-sell-icon.png',
	"header_alt" => Lang::get('site_content.post_to_sell_Header'),
	"header_class" => 'post-to-sell-icon',
	"header_h1" => Lang::get('site_content.post_to_sell_Header'),

	"form_action_old" => 'post-to-sell-submit',
	"form_id" => 'post-to-sell-form',

	"fa_color" => "fa-red",

	"display_address" => Lang::get('site_content.post_to_sell_Display_Address_Label'),
	"other_address_id" => 'other_address',
	"other_address_id2" => 'other_address2',
	"address_field_id" => 'ReceivingAddress',
  
	"address_select_name" => 'company_address_id',
	"address_select_id" => 'company_address_id',
    "address_select" => 'company_address_id',

	"address" => 'shipping',

	"post_to_js" => '
   <script src="'. URL::asset('js/weight-calculation.js') . '"></script>
  <script src="'. URL::asset('js/post-to.js') . '"></script>
  
  ',
  )
)
