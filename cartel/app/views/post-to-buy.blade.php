{{-- Post to Buy --}}
@include('layouts.post-to', array(
	"page" => "buy",

	"post_to_css" => 'post-to-buy.css',
	"canonical" => 'post-to-buy.php',
	"title" => Lang::get('site_content.post_to_buy_Title'),

	"header_icon" => 'post-to-buy-icon.png',
	"header_alt" => Lang::get('site_content.post_to_buy_Header'),
	"header_class" => 'post-to-buy-icon',
	"header_h1" => Lang::get('site_content.post_to_buy_Header'),

	"form_action_old" => 'post-to-buy-submit',
	"form_id" => 'post-to-buy-form',

	"fa_color" => "fa-green",

	"display_address" => Lang::get('site_content.post_to_buy_Display_Address_Label'),
	"other_address_id" => 'other_address',
	"other_address_id2" => 'other_address2',
	"address_field_id" => 'ReceivingAddress',
  
	"address_select_name" => 'company_address_id',
	"address_select_id" => 'company_address_id',
    "address_select" => 'company_address_id',
  
	"address" => 'receiving',
  
	"post_to_js" => '
   <script src="'. URL::asset('js/weight-calculation.js') . '"></script>
  <script src="'. URL::asset('js/post-to.js') . '"></script>
  ',
  )
)
