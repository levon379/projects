@extends("layouts.print")

@section("content")
<div id="printVoucher" class="print-voucher" style="margin-top:20px">
	<hr style="margin: 0; background:#b3d170; height:10px; border: none;" />
	<div style="width: 600px; margin: 0 auto; padding-left: 12px; padding-right: 12px;">
		<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="font-size:14px; line-height:30px; font-family: Arial;">
			<thead>
				<tr>
					<th valign="top" align="left" style="padding-top:41px;"><a href="#"><img src="[[main_logo]]" alt="ecoart tour operator" width="368" height="162" /></th>
					<th valign="top" align="right" style="padding-top:70px;"><a href="#"><img src="[[small_logo]]" alt="rome by segway" width="150" /></a></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="2" style="padding-top: 40px;">
						<hr style="margin:0; margin-bottom: 25px; border:0; background:#d8d8d7; height: 2px;" />
						<tr>
							<td  colspan="2" style="font-size: 14px; line-height: 30px; font-weight: 700; text-transform: uppercase;">Need to get in touch with us?</td>
						</tr>
						<tr>
							<td>
								[[provider_contact_details]]
							</td>
						</tr>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<tr>
					<td align="right" colspan="2" valign="top" style="padding-bottom: 40px; padding-top: 40px;">
						<time style="text-transform: uppercase; text-align: right; font-size: 16px; line-height: 21px;">[[created_at]]</time>
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="2" style="padding-bottom: 39px;">[[greeting]]</td>
				</tr>
				<tr>
					<td valign="top" colspan="2" bgcolor="#f4f4f4" style="padding-top: 30px; padding-right: 15px; padding-bottom:35px; padding-left:38px;">
						<table id="infoList" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="font-size: 14px; line-height: 30px;">
							<tr>
								<td colspan="2" valign="top" style="text-transform: uppercase;">
									<strong>Reference No.:</strong>
									<span style="text-transform: none;">[[reference_number]]</span>
								</td>
							</tr>
							<tr>
								<td colspan="2" valign="top" style="text-transform: uppercase;">
									<strong>Lead Traveler Name:</strong>
									<span style="text-transform: none;">[[name]] (Adult)</span>
								</td>
							</tr>
							<tr>
								<td colspan="2" valign="top" style="text-transform: uppercase;">
									<strong>Additional Passengers:</strong>
									<span style="text-transform: none;">[[passengers]]</span>
								</td>
							</tr>
							<tr>
								<td colspan="2" valign="top" style="text-transform: uppercase;">
									<strong>Adults:</strong>
									<span style="text-transform: none; font-weight: 700; padding-right: 40px;">[[no_adult]]</span>
									<strong>Children:</strong>
									<span style="text-transform: none; font-weight: 700; padding-right: 40px;">[[no_children]]</span>
									<strong>Total Travelers:</strong>
									<span style="text-transform: none; font-weight: 700;">[[total_pax]]</span>
								</td>
							</tr>
							<tr>
								<td colspan="2" valign="top" style="text-transform: uppercase;">
									<strong>Travel Date:</strong>
									<span style="text-transform: none;">[[travel_date]]</span>
								</td>
							</tr>
							<tr>
								<td colspan="2" valign="top" style="text-transform: uppercase;">
									<strong>Product Booked:</strong>
									<span style="text-transform: none;">[[product_name]]</span>
								</td>
							</tr>
							<tr>
								<td colspan="2" valign="top" style="text-transform: uppercase;">
									<strong>Add-ons Booked:</strong>
									<span style="text-transform: none;">[[addon_names]]</span>
								</td>
							</tr>
							<tr>
								<td colspan="2" valign="top" style="text-transform: uppercase; padding-bottom: 48px;">
									<strong>Departure Time:</strong>
									<span style="text-transform: none;">[[departure_time]]</span>
								</td>
							</tr>
							<tr>
								<td colspan="2" style="font-size: 14px; line-height: 28px; padding-bottom: 20px;" valign="top"><strong style="font-size:14px; font-weight: 700;">Meeting point instructions:</strong> [[departpoint_instructions]]</td>
							</tr>
							<tr>
								<td valign="top"><a href="https://www.google.com/maps?ll=41.888198,12.49638&z=16&t=m&hl=it-IT&gl=IT&mapclient=embed&cid=8917026822022700582"><img src="[[map_image]]" alt="image description" width="260" height="152" /></a></td>
								<td valign="top" align="right" style="text-transform: uppercase; padding-right: 25px; width:250px;"><strong>Total Amount Paid: [[total_paid]]</strong> <br> <span style="text-transform: normal;">Payment Method: [[payment_method]] </span></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" valign="top" style="padding-top: 80px; padding-right: 80px;">
						<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="font-size:14px; line-height:30px; font-family: Arial;">
							<tr>
								<td valign="top" colspan="2">
									<img style="float:left; margin-top: 0; margin-right: 18px;" src="{{ asset('assets/images/vouchers/img01.png') }}" alt="image description" width="34" height="34" />
									<div style="margin:0; overflow:hidden;">
										<h2 style="margin:0; overflow:hidden; font-size: 14px; line-height: 26px; text-transform: uppercase; font-weight: 700;">What to Bring:</h2>
										[[what_to_bring]]
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" valign="top" style="padding-top: 60px; padding-right: 80px;">
						<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="font-size:14px; line-height:30px; font-family: Arial;">
							<tr>
								<td valign="top" colspan="2">
									<img style="float:left; margin-top: 0; margin-right: 18px;" src="{{ asset('assets/images/vouchers/img02.png') }}" alt="image description" width="34" height="34" />
									<div style="margin:0; overflow:hidden;">
										<h2 style="margin:0; overflow:hidden; font-size: 14px; line-height: 26px; text-transform: uppercase; font-weight: 700;">Important Notes:</h2>
										[[additionalinfo]]
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" valign="top" style="padding-top: 60px; padding-bottom: 30px; padding-right: 80px;">
						<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="font-size:14px; line-height:30px; font-family: Arial;">
							<tr>
								<td valign="top" colspan="2">
									<img style="float:left; margin-top: 0; margin-right: 18px;" src="{{ asset('assets/images/vouchers/img01.png') }}" alt="image description" width="34" height="34" />
									<div style="margin:0; overflow:hidden;">
										<h2 style="margin:0; overflow:hidden; font-size: 14px; line-height: 26px; text-transform: uppercase; font-weight: 700;">Cancellation/Modification Policy:</h2>
										[[cancelpolicy]]
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
@stop

@section("script")
	<script>
    $(document).ready(function(){
        // remove empty values
        $("#infoList").find("tr").each(function(index, tr){
            if($(tr).find("span").html() == ""){
                $(tr).remove();
            }
        });
    });
    </script>
@stop