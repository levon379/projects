<div class="row">
	<div class="inner-page-banner"> <img class="img-responsive" src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt=""></div>
</div>

<?php 
if($this->session->userdata("reservation"))
{
	$reservation_session=$this->session->userdata("reservation");
}

if($this->session->userdata("search_details"))
{
	$search_session=$this->session->userdata("search_details");
}

?>

<!--banner end-->
<link href="<?php echo base_url(); ?>assets/frontend/css/lightbox.css" rel="stylesheet"/>
<div class="row innerpage-section" id="reservation_form_div">
	<div class="container">
		<!--<h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang("Reservation"); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>-->
		<div class="row inner-content">
      		
			<div style="margin-top:20px;">
				<?php //echo $reservation_content[0]['pages_content']; ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$("#div_no_of_extra_real_adult").hide();
		$("#div_no_of_extra_adult").hide();
		$("#div_no_of_extra_kid").hide();
		$("#div_no_of_folding_bed_kid").hide();
		$("#div_no_of_folding_bed_adult").hide();
		$("#div_no_of_baby_bed").hide();
	});
	function autoPopulateAdult(){
			var cattype = $("#cat_type").val();
			var bungalow_id = $("#bungalow").val();
			var max_person = $("#max_person").val();
			var str1 = str2 = str3 = str4 = str5 = str6 = '<option value="">--<?php echo lang('Select'); ?>--</option>';

			if(cattype == "A"){
				for(var i=0;i<2;i++) {
					str3 += "<option value='"+i+"'>"+i+"</option>";
					str4 += "<option value='"+i+"'>"+i+"</option>";	
				}		
				for(var i=0;i<3;i++) str5 += "<option value='"+i+"'>"+i+"</option>";

				$("#div_no_of_extra_real_adult").hide();
				$("#div_no_of_extra_adult").hide();
				$("#div_no_of_extra_kid").hide();
				$("#div_no_of_folding_bed_kid").show();
				$("#div_no_of_folding_bed_adult").show();
				$("#div_no_of_baby_bed").show();

				$("#no_of_folding_bed_kid").html(str3);
				$("#no_of_folding_bed_adult").html(str4);
				$("#no_of_baby_bed").html(str5);
			}
			if(cattype == "B"){
				for(var i=0;i<4;i++){
					str1 += "<option value='"+i+"'>"+i+"</option>";
					str2 += "<option value='"+i+"'>"+i+"</option>";
				}
				for(var i=0;i<2;i++){
					str5 += "<option value='"+i+"'>"+i+"</option>";
				}

				$("#div_no_of_extra_real_adult").hide();
				$("#div_no_of_extra_adult").show();
				$("#div_no_of_extra_kid").show();
				$("#div_no_of_folding_bed_kid").hide();
				$("#div_no_of_folding_bed_adult").hide();
				$("#div_no_of_baby_bed").show();

				$("#no_of_extra_adult").html(str1);
				$("#no_of_extra_kid").html(str2);
				
				$("#no_of_baby_bed").html(str5);
			}		
			if(cattype == "C"){
				for(var i=0;i<3;i++){
					str1 += "<option value='"+i+"'>"+i+"</option>";
					str2 += "<option value='"+i+"'>"+i+"</option>";
				}
				for(var i=0;i<2;i++){
					str3 += "<option value='"+i+"'>"+i+"</option>";
					str4 += "<option value='"+i+"'>"+i+"</option>";
					str5 += "<option value='"+i+"'>"+i+"</option>";
				}

				$("#div_no_of_extra_real_adult").hide();
				$("#div_no_of_extra_adult").show();
				$("#div_no_of_extra_kid").show();
				$("#div_no_of_folding_bed_kid").show();
				$("#div_no_of_folding_bed_adult").show();
				$("#div_no_of_baby_bed").show();

				$("#no_of_extra_adult").html(str1);
				$("#no_of_extra_kid").html(str2);
				$("#no_of_folding_bed_kid").html(str3);
				$("#no_of_folding_bed_adult").html(str4);
				$("#no_of_baby_bed").html(str5);
			}		
			if(cattype == "D"){
				for(var i=0;i<3;i++){
					str1 += "<option value='"+i+"'>"+i+"</option>";
					str2 += "<option value='"+i+"'>"+i+"</option>";
				}
				for(var i=0;i<2;i++){
					str6 += "<option value='"+i+"'>"+i+"</option>";
					str5 += "<option value='"+i+"'>"+i+"</option>";
				}				


				$("#div_no_of_extra_real_adult").show();
				$("#div_no_of_extra_adult").show();
				$("#div_no_of_extra_kid").show();
				$("#div_no_of_folding_bed_kid").hide();
				$("#div_no_of_folding_bed_adult").hide();
				$("#div_no_of_baby_bed").show();

				$("#no_of_extra_real_adult").html(str6);
				$("#no_of_extra_adult").html(str1);
				$("#no_of_extra_kid").html(str2);				
				$("#no_of_baby_bed").html(str5);
			}	
			if(cattype == "E"){
				for(var i=0;i<3;i++){
					str1 += "<option value='"+i+"'>"+i+"</option>";
					str2 += "<option value='"+i+"'>"+i+"</option>";
					str5 += "<option value='"+i+"'>"+i+"</option>";
				}
				for(var i=0;i<2;i++){
					str3 += "<option value='"+i+"'>"+i+"</option>";
					str4 += "<option value='"+i+"'>"+i+"</option>";
				}

				$("#div_no_of_extra_real_adult").hide();
				$("#div_no_of_extra_adult").show();
				$("#div_no_of_extra_kid").show();
				$("#div_no_of_folding_bed_kid").show();
				$("#div_no_of_folding_bed_adult").show();
				$("#div_no_of_baby_bed").show();

				$("#no_of_extra_adult").html(str1);
				$("#no_of_extra_kid").html(str2);
				$("#no_of_folding_bed_kid").html(str3);
				$("#no_of_folding_bed_adult").html(str4);
				$("#no_of_baby_bed").html(str5);
			}
			if(cattype == "F"){
				for(var i=0;i<3;i++) {
					str1 += "<option value='"+i+"'>"+i+"</option>";
					str2 += "<option value='"+i+"'>"+i+"</option>";	
				}		
				for(var i=0;i<2;i++) str5 += "<option value='"+i+"'>"+i+"</option>";

				$("#div_no_of_extra_real_adult").hide();
				$("#div_no_of_extra_adult").show();
				$("#div_no_of_extra_kid").show();
				$("#div_no_of_folding_bed_kid").hide();
				$("#div_no_of_folding_bed_adult").hide();
				$("#div_no_of_baby_bed").show();

				$("#no_of_extra_adult").html(str1);
				$("#no_of_extra_kid").html(str2);
				$("#no_of_baby_bed").html(str5);
			}
			if(cattype == "G"){
				$("#div_no_of_extra_real_adult").hide();
				$("#div_no_of_extra_adult").hide();
				$("#div_no_of_extra_kid").hide();
				$("#div_no_of_folding_bed_kid").hide();
				$("#div_no_of_folding_bed_adult").hide();
				$("#div_no_of_baby_bed").hide();
			}

			/*$("#no_of_extra_adult").html(str1);
			$("#no_of_extra_kid").html(str2);
			$("#no_of_folding_bed_kid").html(str3);
			$("#no_of_folding_bed_adult").html(str4);
			$("#no_of_baby_bed").html(str5);*/
		}

		function autoPopulateExtraRealAdult(value){
			var str1 = str2 = str3 = str4 = str5 = str6 = '<option value="">--<?php echo lang('Select'); ?>--</option>';
			if(value < 1){
				for(var i=0;i<3;i++) {
					str1 += "<option value='"+i+"'>"+i+"</option>";
					str2 += "<option value='"+i+"'>"+i+"</option>";	
				}
				for(var i=0;i<3;i++) str5 += "<option value='"+i+"'>"+i+"</option>";

				$("#div_no_of_extra_adult").show();
				$("#div_no_of_extra_kid").show();
				$("#div_no_of_folding_bed_kid").hide();
				$("#div_no_of_folding_bed_adult").hide();
				$("#div_no_of_baby_bed").show();

				$("#no_of_extra_adult").html(str1);
				$("#no_of_extra_kid").html(str2);
				$("#no_of_baby_bed").html(str5);
			} else {
				for(var i=0;i<2;i++) str5 += "<option value='"+i+"'>"+i+"</option>";
				$("#div_no_of_extra_adult").hide();
				$("#div_no_of_extra_kid").hide();
				$("#no_of_baby_bed").html(str5);
			}
		}

	function autoPopulateExtraAdult(value){
		var cattype = $("#cat_type").val();
		var bungalow_id = $("#bungalow").val();
		var max_person = $("#max_person").val();
		var str1 = str2 = str3 = str4 = str5 = str6 = '<option value="">--<?php echo lang('Select'); ?>--</option>';

		if(cattype == "A"){
			if(value < 1){
				for(var i=0;i<2;i++) str4 += "<option value='"+i+"'>"+i+"</option>";	

				$("#div_no_of_folding_bed_adult").show();
				$("#no_of_folding_bed_adult").html(str4);
			} else {
				for(var i=0;i<2;i++) str5 += "<option value='"+i+"'>"+i+"</option>";

				$("#div_no_of_folding_bed_adult").hide();
				
			}
		}
		if(cattype == "B"){
			for(var i=0;i<=(3-value);i++){
				str2 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<2;i++){
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}

			$("#div_no_of_extra_kid").show();
			$("#div_no_of_baby_bed").show();

			$("#no_of_extra_kid").html(str2);
			$("#no_of_baby_bed").html(str5);
		}		
		if(cattype == "C"){
			for(var i=0;i<=(2-value);i++){
				str2 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<2;i++){
				str3 += "<option value='"+i+"'>"+i+"</option>";
				str4 += "<option value='"+i+"'>"+i+"</option>";
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}

			if(value == 2) $("#div_no_of_extra_kid").hide();
			else $("#div_no_of_extra_kid").show();
			
			$("#div_no_of_folding_bed_kid").show();
			$("#div_no_of_folding_bed_adult").show();
			$("#div_no_of_baby_bed").show();

			$("#no_of_extra_kid").html(str2);
			$("#no_of_folding_bed_kid").html(str3);
			$("#no_of_folding_bed_adult").html(str4);
			$("#no_of_baby_bed").html(str5);
		}		
		if(cattype == "D"){
			for(var i=0;i<=(2-value);i++){
				str2 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<2;i++){
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}

			$("#div_no_of_extra_kid").show();
			$("#div_no_of_baby_bed").show();

			$("#no_of_extra_kid").html(str2);
			$("#no_of_baby_bed").html(str5);
		}	
		if(cattype == "E"){
			for(var i=0;i<=(2-value);i++){
				str2 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<2;i++){
				str3 += "<option value='"+i+"'>"+i+"</option>";
				str4 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<3;i++) str5 += "<option value='"+i+"'>"+i+"</option>";

			$("#div_no_of_extra_kid").show();
			$("#div_no_of_folding_bed_kid").show();
			$("#div_no_of_folding_bed_adult").show();
			$("#div_no_of_baby_bed").show();

			$("#no_of_extra_kid").html(str2);
			$("#no_of_folding_bed_kid").html(str3);
			$("#no_of_folding_bed_adult").html(str4);
			$("#no_of_baby_bed").html(str5);
		}
		if(cattype == "F"){
			for(var i=0;i<=(2-value);i++){
				str2 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<2;i++) str5 += "<option value='"+i+"'>"+i+"</option>";

			$("#div_no_of_extra_kid").show();
			$("#div_no_of_baby_bed").show();

			$("#no_of_extra_kid").html(str2);
			$("#no_of_baby_bed").html(str5);
		}

		/*$("#no_of_extra_adult").html(str1);
		$("#no_of_extra_kid").html(str2);
		$("#no_of_folding_bed_kid").html(str3);
		$("#no_of_folding_bed_adult").html(str4);
		$("#no_of_baby_bed").html(str5);*/
	}

	function autoPopulateExtraKid(value){
		var cattype = $("#cat_type").val();
		var bungalow_id = $("#bungalow").val();
		var max_person = $("#max_person").val();
		var str1 = str2 = str3 = str4 = str5 = str6 = '<option value="">--<?php echo lang('Select'); ?>--</option>';

		if(cattype == "A"){
			if(value < 1){
				for(var i=0;i<3;i++) str5 += "<option value='"+i+"'>"+i+"</option>";		
			} else {
				for(var i=0;i<2;i++) str5 += "<option value='"+i+"'>"+i+"</option>";
			}

			$("#no_of_baby_bed").html(str5);
		}
		if(cattype == "B"){
			for(var i=0;i<2;i++){
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}
			$("#no_of_baby_bed").html(str5);
		}		
		if(cattype == "C"){
			for(var i=0;i<2;i++){
				str3 += "<option value='"+i+"'>"+i+"</option>";
				str4 += "<option value='"+i+"'>"+i+"</option>";
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}
			$("#no_of_folding_bed_kid").html(str3);
			$("#no_of_folding_bed_adult").html(str4);
			$("#no_of_baby_bed").html(str5);
		}		
		if(cattype == "D"){
			for(var i=0;i<2;i++){
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}
			$("#no_of_baby_bed").html(str5);
		}	
		if(cattype == "E"){
			for(var i=0;i<2;i++){
				str3 += "<option value='"+i+"'>"+i+"</option>";
				str4 += "<option value='"+i+"'>"+i+"</option>";
			}			
			for(var i=0;i<3;i++) str5 += "<option value='"+i+"'>"+i+"</option>";

			$("#no_of_folding_bed_kid").html(str3);
			$("#no_of_folding_bed_adult").html(str4);
			$("#no_of_baby_bed").html(str5);
		}
		if(cattype == "F"){
			for(var i=0;i<2;i++){
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}
			$("#no_of_baby_bed").html(str5);
		}

		/*$("#no_of_extra_adult").html(str1);
		$("#no_of_extra_kid").html(str2);
		$("#no_of_folding_bed_kid").html(str3);
		$("#no_of_folding_bed_adult").html(str4);
		$("#no_of_baby_bed").html(str5);*/
	}

	function autoPopulateFoldingBedKid(value){
		var cattype = $("#cat_type").val();
		var bungalow_id = $("#bungalow").val();
		var max_person = $("#max_person").val();
		var str1 = str2 = str3 = str4 = str5 = str6 = '<option value="">--<?php echo lang('Select'); ?>--</option>';

		if(cattype == "A"){
			if(value < 1){
				for(var i=0;i<2;i++) str4 += "<option value='"+i+"'>"+i+"</option>";	
				for(var i=0;i<3;i++) str5 += "<option value='"+i+"'>"+i+"</option>";		

				$("#div_no_of_folding_bed_adult").show();
				$("#no_of_folding_bed_adult").html(str4);
				$("#no_of_baby_bed").html(str5);
			} else {
				for(var i=0;i<2;i++) str5 += "<option value='"+i+"'>"+i+"</option>";

				$("#div_no_of_folding_bed_adult").hide();
				$("#no_of_baby_bed").html(str5);
			}
		}
		if(cattype == "B"){
			for(var i=0;i<(3-value);i++){
				str2 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<2;i++){
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}

			$("#no_of_extra_kid").html(str2);
			$("#no_of_baby_bed").html(str5);
		}		
		if(cattype == "C"){
			if(value < 1){
				for(var i=0;i<2;i++){
					str4 += "<option value='"+i+"'>"+i+"</option>";
					str5 += "<option value='"+i+"'>"+i+"</option>";
					$("#div_no_of_folding_bed_adult").show();
					$("#no_of_folding_bed_adult").html(str4);
				}
			}else{
				for(var i=0;i<2;i++) str5 += "<option value='"+i+"'>"+i+"</option>";
				$("#div_no_of_folding_bed_adult").hide();
			}
			$("#no_of_baby_bed").html(str5);
		}		
		if(cattype == "D"){
			for(var i=0;i<3;i++){
				str1 += "<option value='"+i+"'>"+i+"</option>";
				str2 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<2;i++){
				str3 += "<option value='"+i+"'>"+i+"</option>";
				str4 += "<option value='"+i+"'>"+i+"</option>";
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}
		}	
		if(cattype == "E"){
			if(value < 1){
				for(var i=0;i<2;i++) str4 += "<option value='"+i+"'>"+i+"</option>";	
				for(var i=0;i<3;i++) str5 += "<option value='"+i+"'>"+i+"</option>";		

				$("#div_no_of_folding_bed_adult").show();
				$("#no_of_folding_bed_adult").html(str4);
				$("#no_of_baby_bed").html(str5);
			} else {
				for(var i=0;i<2;i++) str5 += "<option value='"+i+"'>"+i+"</option>";

				$("#div_no_of_folding_bed_adult").hide();
				
				$("#no_of_baby_bed").html(str5);
			}
		}
		if(cattype == "F"){
		}

		/*$("#no_of_extra_adult").html(str1);
		$("#no_of_extra_kid").html(str2);
		$("#no_of_folding_bed_kid").html(str3);
		$("#no_of_folding_bed_adult").html(str4);
		$("#no_of_baby_bed").html(str5);*/
	}

	function autoPopulateFoldingBedAdult(value){
		var cattype = $("#cat_type").val();
		var bungalow_id = $("#bungalow").val();
		var max_person = $("#max_person").val();
		var str1 = str2 = str3 = str4 = str5 = str6 = '<option value="">--<?php echo lang('Select'); ?>--</option>';

		if(cattype == "A"){
			if(value < 1){
				for(var i=0;i<3;i++) str5 += "<option value='"+i+"'>"+i+"</option>";		
			} else {
				for(var i=0;i<2;i++) str5 += "<option value='"+i+"'>"+i+"</option>";
			}

			$("#no_of_baby_bed").html(str5);
		}
		if(cattype == "B"){
			for(var i=0;i<2;i++){
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}
			$("#no_of_baby_bed").html(str5);
		}		
		if(cattype == "C"){
			for(var i=0;i<2;i++){
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}
			$("#no_of_baby_bed").html(str5);
		}		
		if(cattype == "D"){
			for(var i=0;i<3;i++){
				str1 += "<option value='"+i+"'>"+i+"</option>";
				str2 += "<option value='"+i+"'>"+i+"</option>";
			}
			for(var i=0;i<2;i++){
				str3 += "<option value='"+i+"'>"+i+"</option>";
				str4 += "<option value='"+i+"'>"+i+"</option>";
				str5 += "<option value='"+i+"'>"+i+"</option>";
			}
		}	
		if(cattype == "E"){
			if(value < 1){
				for(var i=0;i<3;i++) str5 += "<option value='"+i+"'>"+i+"</option>";		
			} else {
				for(var i=0;i<2;i++) str5 += "<option value='"+i+"'>"+i+"</option>";
			}

			$("#no_of_baby_bed").html(str5);
		}
		if(cattype == "F"){
		}

		/*$("#no_of_extra_adult").html(str1);
		$("#no_of_extra_kid").html(str2);
		$("#no_of_folding_bed_kid").html(str3);
		$("#no_of_folding_bed_adult").html(str4);
		$("#no_of_baby_bed").html(str5);*/
	}

	function fill_reservation_form( price ){
		$("#div_extra_real_adult").hide();
		$("#div_extra_adult").hide();
		$("#div_extra_kid").hide();
		$("#div_folding_kid").hide();
		$("#div_folding_adult").hide();
		$("#div_baby_bed").hide();
		$("#div_price").hide();

		$('#selected_bungalow').html( $('#bungalow option:selected').text() );
		$('#selected_arrival_date').html( $('#arrival_date').val() );
		$('#selected_leave_date').html( $('#leave_date').val() ); 

		var val1 = ($('#no_of_adult option:selected').text() != "--Select--")?$('#no_of_adult option:selected').text():"0";
		var val2 = ($('#no_of_extra_real_adult option:selected').text() != "--Select--")?$('#no_of_extra_real_adult option:selected').text():"0";
		var val3 = ($('#no_of_extra_adult option:selected').text() != "--Select--")?$('#no_of_extra_adult option:selected').text():"0";
		var val4 = ($('#no_of_extra_kid option:selected').text() != "--Select--")?$('#no_of_extra_kid option:selected').text():"0";
		var val5 = ($('#no_of_folding_bed_kid option:selected').text()  != "--Select--")?$('#no_of_folding_bed_kid option:selected').text():"0";
		var val6 = ($('#no_of_folding_bed_adult option:selected').text()  != "--Select--")?$('#no_of_folding_bed_adult option:selected').text():"0";
		var val7 = ($('#no_of_baby_bed option:selected').text()  != "--Select--")?$('#no_of_baby_bed option:selected').text():"0";

		$('#selected_persons_adult').html( val1 );
		$('#selected_person_extra_real_adult').html( val2);
		$('#selected_person_extra_adult').html( val3 );
		$('#selected_person_extra_kid').html( val4 );
		$('#selected_person_folding_kid').html(val5);
		$('#selected_person_folding_adult').html( val6);
		$('#selected_person_baby_bed').html(val7);
		//$('#selected_persons_count').html( $('#max_person').val() );

		options = [];
		$('input.options').each( function(i,o){
		  if( this.checked ){
			  k = "#l_" + $(this).attr('id');
			  options.push( $(k).text() );
		  }
		} );

		var tot = 0;
		if(val2 > 0) tot = (parseInt(val2) * 15 * parseInt(price['day_diff']));
		if(val3 > 0) tot += (parseInt(val3) * 15 * parseInt(price['day_diff']));
		if(val6 > 0) tot += (parseInt(val6) * 15 * parseInt(price['day_diff']));
		var total = parseInt( price['stay_euro'] ) + tot + (( parseInt( price['stay_euro'] ) + tot ) * 4 / 100 );

		//$('#selected_options').html( options.join() );
		$('#stay_price').html( price['stay_euro'] + ' EUR');
		$('#option_price').html( tot + ' EUR');		
		$('#selected_price').html( total + ' EUR');

		if(val2 > 0) $("#div_extra_real_adult").show();
		if(val3 > 0) $("#div_extra_adult").show();
		if(val4 > 0) $("#div_extra_kid").show();
		if(val5 > 0) $("#div_folding_kid").show();
		if(val6 > 0) $("#div_folding_adult").show();
		if(val7 > 0) $("#div_baby_bed").show();
		if(tot > 0) $("#div_price").show();
	}

	function switch_forms_back(){
		$('#short_reservation_form').show();
		$('#big_reservation_form').hide();
	}

					 
	function show_loading(){
		$('.sub-btn').first().hide()
		$('#reservation_progress').show();
	}
	function hide_loading(){
		$('#reservation_progress').hide();
		$('.sub-btn').first().show()
	}
							
	function check_availability(){
		if($('#arrival_date').val() == "" || $('#leave_date').val() == "" || $('#bungalow').val() == "" || $('#no_of_adult').val() == ""){
			hide_loading();
			if($('#arrival_date').val() == "") $("#arrival_date_error_text").html("<?php echo lang("date_error_message"); ?>");
			if($('#leave_date').val() == "") $("#leave_date_error_text").html("<?php echo lang("date_error_message"); ?>");
			if($('#bungalow').val() == "") $("#bungalow_error_text").html("<?php echo lang("bungalow_error_message"); ?>");
			if($('#no_of_adult').val() == "") $("#error_no_of_adult").html("<?php echo lang("adult_error_message"); ?>");
			return;
			//alert( "This bungalow is unavailable. Please <span style='text-decoration:underline'><a href='mailto:j.willemin@caribwebservices.com?subject=Contact Les Balcons Website'>contact us</a></span> for more informations." );
		}
		else{
			show_loading();
			op = []
			$('input.options').each( function(i,o){
			  if( this.checked ){
			    op.push( $(this).val() )
			  }
			} )
			
			$.ajax({
				type: "POST",
				data: { arrival_date: $('#arrival_date').val(),
						leave_date:   $('#leave_date').val(),
						bungalow_id:  $('#bungalow').val(),
						options: op.join()
					  },
				dataType: 'json',
				url: '<?php echo base_url() ?>reservation/ajax_check_availability',
				success: function(msg){
					if(msg.success){
						hide_loading();		
						if(msg.available == "partial"){

							//alert( "This bungalow is unavailable. Please <span style='text-decoration:underline'><a href='mailto:j.willemin@caribwebservices.com?subject=Contact Les Balcons Website'>contact us</a></span> for more informations." );
							$("#example-popup").attr("class","popup visible");
							$("html").attr("class","overlay");
						}else{
							$('#short_reservation_form').hide();
							$('#big_reservation_form').show();
							$("#example-popup").hide();
							fill_reservation_form( msg.price );
						}
					}else {
						if($('#arrival_date').val() != "" && $('#leave_date').val() != "" && $('#bungalow').val() != "" && $('#no_of_adult').val() != ""){
							hide_loading();
							$("#example-popup").attr("class","popup visible");
							$("html").attr("class","overlay");
							//alert( "This bungalow is unavailable. Please <span style='text-decoration:underline'><a href='mailto:j.willemin@caribwebservices.com?subject=Contact Les Balcons Website'>contact us</a></span> for more informations." );
						}
						else{
							hide_loading();
							if($('#arrival_date').val() == "") $("#arrival_date_error_text").html("<?php echo lang("date_error_message"); ?>");
							if($('#leave_date').val() == "") $("#leave_date_error_text").html("<?php echo lang("date_error_message"); ?>");
							if($('#bungalow').val() == "") $("#bungalow_error_text").html("<?php echo lang("bungalow_error_message"); ?>");
							if($('#no_of_adult').val() == "") $("#error_no_of_adult").html("<?php echo lang("adult_error_message"); ?>");
						}
					}
				}
			});
		}
	}

	function get_max_person_by_bungalow_id(id){

		$("#div_no_of_extra_real_adult").hide();
		$("#div_no_of_extra_adult").hide();
		$("#div_no_of_extra_kid").hide();
		$("#div_no_of_folding_bed_kid").hide();
		$("#div_no_of_folding_bed_adult").hide();
		$("#div_no_of_baby_bed").hide();
		$("#no_of_adult").val('');
		var str1 = str2 = str3 = str4 = str5 = str6 = '<option value="">--<?php echo lang('Select'); ?>--</option>';
		
		$("#no_of_extra_real_adult").html(str6);
		$("#no_of_extra_adult").html(str1);
		$("#no_of_extra_kid").html(str2);
		$("#no_of_folding_bed_kid").html(str3);
		$("#no_of_folding_bed_adult").html(str4);
		$("#no_of_baby_bed").html(str5);

		$.ajax({
			type:"GET",
			url:"<?=base_url()?>reservation/get_max_person",
			data:{'id':id},
			success:function(data){
				var val = data.split("-");
				$('#max_person').val(val[0]);
				$('#cat_type').val(val[1]);
			}
		});
	}

	function get_options(bungalow_id)
	{
		$.post("<?php echo base_url() ?>reservation/ajax_get_options", { "bungalow_id":bungalow_id }, function(data){
			$("#options_div").html(data);
			$("#options_div").show();
		});
	}
</script>