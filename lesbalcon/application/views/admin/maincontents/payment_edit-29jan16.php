<!-- Content Header (Page header) -->
<?php // print_r($reservation_user_details);//echo  $this->session->userdata('user_id')."aaa";?>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/typeahead.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script> 
<script type="text/javascript">
	function checkAmount(due_amount,paid_amount){
		var error_count = 0;
		var due_amount = parseFloat(due_amount);
		var paid_amount1 = parseFloat(paid_amount);
		if(paid_amount.indexOf('.') >= 0){
			var val_part = paid_amount.split('.');
			var val2 = val_part[1];
			if(val2.length > 2){
				//alert("<?php echo lang('enter_anount_is_more'); ?>");
				alert("You cannot add more than 2 integer after decimal.");
				$('#txt_amount_paid').val('');
				error_count++;
			}
		}
		if(paid_amount1 > due_amount){
			alert("<?php echo lang('enter_anount_is_more'); ?>");
			$('#txt_amount_paid').val('');
			error_count++;
		}

		if(error_count > 0){
			return false;
		}else{
			return true;
		}
	}
	$(document).ready(function(){
		$('input.user_id').typeahead({
		  name: 'user_id',
		  remote : '<?php echo base_url(); ?>assets/autocomplete/data.php?query=%QUERY'
		});

		$(".tt-dropdown-menu").click(function(){
			getUserDetails();
		});

		$("#div_no_of_extra_real_adult").hide();
		$("#div_no_of_extra_adult").hide();
		$("#div_no_of_extra_kid").hide();
		$("#div_no_of_folding_bed_kid").hide();
		$("#div_no_of_folding_bed_adult").hide();
		$("#div_no_of_baby_bed").hide();
	});
	function getUserDetails(){
		var u_id=$("#user_idd").val();

			$.ajax({
				type: "post",
				url: "<?php echo base_url(); ?>admin/home/get_userdetails_new",
				data: { u_id: u_id },
				success: function(msg){
					var myString = msg;
					var arr=myString.split("^");
					var name = arr[0].replace('"','');
					var contact = arr[1]; 

					$("#reservation_name").val(name);
					$("#reservation_contact").val(contact);
					$("#user_id").val(arr[2].replace('"',''));
			     }								  
			});
	}
	function calculatePrice(){
		$.ajax({
			type: "POST",
			data: { arrival_date: $('#arrival_date').val(),
					leave_date:   $('#leave_date').val(),
					bungalow_id:  $('#bungalow_id').val(),
					reservation_id:  $('#reservation_id').val()
				  },
			dataType: 'json',
			url: '<?php echo base_url() ?>reservation/ajax_check_availability',
			success: function(msg){
				if(msg.success && msg.available != "no"){
					if(msg.available == "partial"){
						alert( "<?php echo lang('partial_available'); ?>" );
					}
					else{
						var val1 = ($('#no_of_adult option:selected').text() != "--Sélectionner--")?$('#no_of_adult option:selected').text():"0";
						var val2 = ($('#no_of_extra_real_adult option:selected').text() != "--Sélectionner--")?$('#no_of_extra_real_adult option:selected').text():"0";
						var val3 = ($('#no_of_extra_adult option:selected').text() != "--Sélectionner--")?$('#no_of_extra_adult option:selected').text():"0";
						var val4 = ($('#no_of_extra_kid option:selected').text() != "--Sélectionner--")?$('#no_of_extra_kid option:selected').text():"0";
						var val5 = ($('#no_of_folding_bed_kid option:selected').text()  != "--Sélectionner--")?$('#no_of_folding_bed_kid option:selected').text():"0";
						var val6 = ($('#no_of_folding_bed_adult option:selected').text()  != "--Sélectionner--")?$('#no_of_folding_bed_adult option:selected').text():"0";
						var val7 = ($('#no_of_baby_bed option:selected').text()  != "--Sélectionner--")?$('#no_of_baby_bed option:selected').text():"0";
						var tot = 0;
						var price = msg.price;
						if(val2 > 0) tot = (parseInt(val2) * 15 * parseInt(price['day_diff']));
						if(val3 > 0) tot += (parseInt(val3) * 15 * parseInt(price['day_diff']));
						if(val6 > 0) tot += (parseInt(val6) * 15 * parseInt(price['day_diff']));
						var total = parseInt( price['stay_euro'] ) + tot + (( parseInt( price['stay_euro'] ) + tot ) * 4 / 100 );
						alert("<?php echo lang('price_of_the_stay'); ?> = "+price['stay_euro'] + " EUR, <?php echo lang('price_of_extra_stay'); ?> = "+tot + " EUR, <?php echo lang('total_prices'); ?> = "+total + " EUR");
					}
				}else {
					alert( "<?php echo lang('unavailable'); ?>" );
				}
			}
		});
	}
	function autoPopulateAdult(){
			var cattype = $("#cat_type").val();
			var bungalow_id = $("#bungalow_id").val();
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
		var bungalow_id = $("#bungalow_id").val();
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
		var bungalow_id = $("#bungalow_id").val();
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
		var bungalow_id = $("#bungalow_id").val();
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
		var bungalow_id = $("#bungalow_id").val();
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
	function checkDigitAfterDecimal(field_name){
		var amount = $('#'+field_name+'').val();
		if(amount.indexOf('.') >= 0){
			var val_part = amount.split('.');
			var val2 = val_part[1];
			if(val2.length > 2){
				alert("You cannot add more than 2 integer after decimal.");
				$('#'+field_name+'').val('');
				return false;
			}
		}else{
			return true;
		}
	}
</script>
<style>

.typeahead-devs, .tt-hint, .tt-query {
 	border: 2px solid #CCCCCC;
    border-radius: 8px 8px 8px 8px;
    font-size: 13px;
    height: 33px;
    line-height: 30px;
    outline: medium none;
    padding: 8px 12px;
    width: 1510px;
}

.tt-dropdown-menu {
  width: 900px;
  margin-top: 5px;
  padding: 8px 12px;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  border-radius: 8px 8px 8px 8px;
  font-size: 13px;
  color: #111;
  background-color: #F1F1F1;
}


</style>
<script>
//Function for validating edit reservation form which is coming from ajax
$(function () {
	var date = new Date();
	date.setDate(date.getDate());
			
	$('#datetimepickerpayment').datetimepicker({
		format:'dd/mm/yyyy',
		language:  'fr',
		weekStart: 1,
		todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
	});
	$('#search_arrival_date_p').on('click', function(){
		$('#datetimepickerpayment').find('.glyphicon-calendar').trigger('click');
	});
});
function validate_edit_reservation()
{
	var due_amount = parseFloat($('#hid_due_amount').val());
	var paid_amount = parseFloat($('#txt_amount_paid').val());
	if(paid_amount > due_amount){
		alert("<?php echo lang('enter_anount_is_more'); ?>");
		$('#txt_amount_paid').val('');
		return false;
	}
	var error=0;
	if($("#user_id").val()=="")
	{
		$("#user_id_error").show();
		error++;
	}
	else 
	{
		$("#user_id_error").hide();
	}

	if($("#no_of_adult").val().trim()==""){
		$("#no_of_adult_error").show();
		error++;
	}else{
		$("#no_of_adult_error").hide();
	}

	if($("#reservation_name").val().trim()=="")
	{
		$("#reservation_name_error").show();
		error++;
	}
	else 
	{
		$("#reservation_name_error").hide();
	}
	if($("#reservation_contact").val().trim()=="")
	{
		$("#reservation_contact_error").show();
		error++;
	}
	else 
	{
		$("#reservation_contact_error").hide();
	}
	
	if($("#arrival_date").val().trim()=="")
	{
		$("#arrival_date_error_text").html(" <?php echo lang('Arrival_Date_is_required'); ?>");
		$("#arrival_date_error").show();
		error++;
	}
	else if($("#arrival_date").val().trim()!="")
	{
		
		//Checking if arrival date is getting selected as past date
		var arrival_date=$("#arrival_date").val();
		var arival_date_arr=$("#arrival_date").val().split("/"); //This date format dd/mm/yyyy is coming from datepicker
		
		var valyear=arival_date_arr[2];
		var valmonth=arival_date_arr[1];
		var valday=arival_date_arr[0];
		var today = new Date()
		var new_arrival_date= new Date(valyear,(valmonth-1),valday);
		
		
		var date_after_18_month = new Date(new Date(today).setMonth(today.getMonth()+18));
		var year_after_18_months=date_after_18_month.getFullYear();
		var month_after_18_months=date_after_18_month.getMonth();
		var day_after_18_months=date_after_18_month.getDate();
		var new_date_after_18_month=new Date(year_after_18_months, month_after_18_months, day_after_18_months);
		
		var result=calcDate(today, new_arrival_date);
		
		if(result>0)
		{
			$("#arrival_date_error_text").html("<?php echo lang('Past_dates_not_allowed'); ?>");
			$("#arrival_date_error").show();
			error++;
		}
		/*else if(result>-2)
		{
			$("#arrival_date_error_text").html(" Enter the date of after two days");
			$("#arrival_date_error").show();
			error++;
		}*/
		else 
		{
			//Checking if arrival date is within 18 months
			if(new_arrival_date > new_date_after_18_month)
			{
				$("#arrival_date_error_text").html("<?php echo lang('unavailable')  ?>");
				$("#arrival_date_error").show();
				error++;
			}
			else 
			{
				$("#arrival_date_error_text").html("");
				$("#arrival_date_error").hide();
			}
		}
	}
	
	if($("#leave_date").val().trim()=="")
	{
		$("#leave_date_error_text").html(" <?php echo lang('Leave_Date_is_required')  ?>");
		$("#leave_date_error").show();
		error++;
	}
	else 
	{
		//Checking if leave date is less than arrival date
		var arrival_date=$("#arrival_date").val();
		var arival_date_arr=$("#arrival_date").val().split("/");
		var arrival_year=arival_date_arr[2];
		var arrival_month=arival_date_arr[1];
		var arrival_day=arival_date_arr[0];
		var new_arrival_date= new Date(arrival_year,(arrival_month-1),arrival_day);
		var leave_date=$("#leave_date").val();
		var leave_date_arr=$("#leave_date").val().split("/");
		var leave_year=leave_date_arr[2];
		var leave_month=leave_date_arr[1];
		var leave_day=leave_date_arr[0];
		var new_leave_date= new Date(leave_year,(leave_month-1),leave_day);
		var result=calcDate(new_arrival_date, new_leave_date);
		if(result>0)
		{
			$("#leave_date_error_text").html("<?php echo lang("Leave_should_not_less_than_arrival"); ?>");
			$("#leave_date_error").show();
			error++;
		}
		else 
		{
			$("#leave_date_error_text").html("");
			$("#leave_date_error").hide();
		}
	}
	
	if(error>0)
	{
		//$(window).scrollTop($("#reservation_add_form").offset().top);
		return false;
	}
}
</script>
<section class="content-header">
	<h1>
		<?php echo lang("edit_reservation"); ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang("Home") ?></a></li>
		<li class="active"><?php echo lang("edit_reservation"); ?></li>
	</ol>
</section>
<!-- Main content -->
<div class="box_horizontal">
	<?php if(count($linked_reservation_details)) echo "<b>MULTIPLE</b>"; ?>
	<a href="<?php echo base_url(); ?>admin/payment/all" class="btn btn-primary btn-flat"><?php echo lang("Back") ?></a>
</div>
<?php
if(isset($_GET["partial"]))
{
	?>
	<section class="content">
	<div class="alert alert-danger alert-dismissable" style="margin-bottom:0px;">
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b><?php echo lang('partial_available'); ?></b>
	</div>
	</section>
	<?php
}
else if(isset($_GET["no"]))
{
	?>
	<section class="content">
	<div class="alert alert-danger alert-dismissable" style="margin-bottom:0px;">
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b><?php echo lang('unavailable'); ?></b>
	</div>
	</section>
	<?php
}
?>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">

				<form id="reservation_add_form" action="" method="POST" onsubmit="return validate_edit_reservation()">
					<div class="box-body">
						<?php /*?><input type="hidden" name="bungalow_id" id="bungalow_id" value="<?php echo $reservation_details[0]['bunglow_id']; ?>"><?php */?>
                       <input type="hidden" name="cur_bungalow_id" id="cur_bungalow_id" value="<?php echo $reservation_details[0]['bunglow_id']; ?>">
						<input type="hidden" name="reservation_id" id="reservation_id" value="<?php echo $reservation_id; ?>">
						<input type="hidden" id="cat_type" value="<?php echo $bungalow_details[0]['cat_type']; ?>" />
						<input type="hidden" id="max_person" value="<?php echo $bungalow_details[0]['max_person']; ?>" />
						<input type="hidden" name="hid_arrival_date" id="hid_arrival_date" value="<?php echo $arrival_date; ?>">
						<input type="hidden" name="hid_leave_date" id="hid_leave_date" value="<?php echo $leave_date; ?>">
						<div class="box-body">
							<div class="form-group">
								<label for="exampleInputPassword1"><?php echo lang("Bungalows") ?></label>
                                <!-- yrcode --->
                                <select name="bungalow_id" id="bungalow_id" class="form-control">
								<?php 
$bunglow_list=$this->home_model->get_all_bunglow();
foreach($bunglow_list as $bunglow)
{
	$bungalow_name_part = explode("<span>", $bunglow['bunglow_name']);
	$bunglow_name = $bungalow_name_part[0];
?>
<option value="<?=$bunglow['id']?>" <?php if($reservation_details[0]['bunglow_id']==$bunglow['id']){ echo "selected";} ?>><?=$bunglow_name?></option>
<?php }?>
</select>
<!-- end yrcode --->
								
																			
								<?php /*?>$bungalow_name_part = explode("<span>", $bungalow_details[0]['bunglow_name']);
								$bunglow_name = $bungalow_name_part[0];?>
								<input type="text" name="bungalow_name" id="bungalow_name" class="form-control" readonly value="<?php echo $bunglow_name; ?>"><?php */?>
                               
							</div>
							<?php 
							/*if(count($bungalow_options_details)>0)
							{
								?>
								<div class="form-group">
									<label for="exampleInputPassword1">Options</label><br>
									<?php 
									foreach($bungalow_options_details as $options)
									{
										?>
										<input type="checkbox" name="options_id[]" value="<?php echo $options['options_id'] ?>" <?php if(in_array($options['options_id'], $options_ids)){ echo "checked"; } ?>>&nbsp;<?php echo $options['options_name']; ?>&nbsp;&nbsp;
										<?php 
									}
									?>
								</div>
								<?php 
							}*/
							?>
							
							<div class="form-group">
								<label for="exampleInputPassword1"><?php echo lang("user"); ?></label>
								<input type="hidden" name="user_id" id="user_id" value="<?php echo $reservation_details[0]['user_id']; ?>">
								<input type="text" name="user_idd" id="user_idd" class="form-control user_id" value="<?php echo $reservation_details[0]['name']; ?>">
								<!-- <select name="user_id" id="user_id" class="form-control">
									<option value="">--Sélectionner--</option>
									<?php 
									foreach($users_list as $user)
									{
										?>
										<option value="<?php echo $user['id']; ?>" <?php if($reservation_details[0]['user_id']==$user['id']){ echo "selected"; }  ?>><?php echo $user['email']; ?></option>
										<?php 
									}
									?>
								</select> -->
								<div class="form-group has-error" id="user_id_error" style="display:none;">
									<label class="control-label" for="inputError">
									<i class="fa fa-times-circle-o"> <?php echo lang("User_is_required"); ?></i>
									</label>
								</div>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1"><?php echo lang("Email"); ?></label>
								<input type="text" name="reservation_name" id="reservation_name" class="form-control" value="<?php echo $reservation_user_details[0]['email']; ?>">
								<div class="form-group has-error" id="reservation_name_error" style="display:none;">
									<label class="control-label" for="inputError">
									<i class="fa fa-times-circle-o"> <?php echo lang("Email_is_required"); ?></i>
									</label>
								</div>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1"><?php echo lang("Contact_no"); ?></label>
								<input type="text" name="reservation_contact" id="reservation_contact" class="form-control" value="<?php echo $reservation_user_details[0]['contact_number']; ?>">
								<div class="form-group has-error" id="reservation_contact_error" style="display:none;">
									<label class="control-label" for="inputError">
									<i class="fa fa-times-circle-o"> <?php echo lang("Contact_No_is_required"); ?></i>
									</label>
								</div>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1"><?php echo lang("Arrival_Date"); ?></label>
								<div class='input-group date' id='reservation_arrival_date'>
									<input type="text" name="arrival_date" id="arrival_date" class="form-control" readonly value="<?php echo $arrival_date; ?>">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
								<div class="form-group has-error" id="arrival_date_error" style="display:none;">
									<label class="control-label" for="inputError">
									<i class="fa fa-times-circle-o" id="arrival_date_error_text"> <?php echo lang("Arrival_Date"); ?></i>
									</label>
								</div>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1"><?php echo lang("Leave_Date"); ?></label>
								<div class='input-group date' id='reservation_leave_date'>
									<input type="text" name="leave_date" id="leave_date" class="form-control" readonly value="<?php echo $leave_date; ?>">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
								<div class="form-group has-error" id="leave_date_error" style="display:none;">
									<label class="control-label" for="inputError">
									<i class="fa fa-times-circle-o" id="leave_date_error_text"> <?php echo lang("Leave_Date"); ?></i>
									</label>
								</div>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Source</label>
								<select name="source" id="source" class="form-control">
									<option value="Amis" <?php if($source=="Amis"){ echo "selected";} ?>>Amis</option>
									<option value="Amis Recommandation" <?php if($source=="Amis Recommandation"){ echo "selected";} ?>>Amis Recommandation</option>
									<option value="Antilles Location" <?php if($source=="Antilles Location"){ echo "selected";} ?>>Antilles Location</option>
									<option value="Direct" <?php if($source=="Direct"){ echo "selected";} ?>>Direct</option>
									<option value="Gaia Voyages" <?php if($source=="Gaia Voyages"){ echo "selected";} ?>>Gaia Voyages</option>
									<option value="Lonely Planet" <?php if($source=="Lonely Planet"){ echo "selected";} ?>>Lonely Planet</option>
									<option value="Manual" <?php if($source=="Manual"){ echo "selected";} ?>>Manual</option>
									<option value="Mireille Voyage Malavey" <?php if($source=="Mireille Voyage Malavey"){ echo "selected";} ?>>Mireille Voyage Malavey</option>
									<option value="Nadige Melt" <?php if($source=="Nadige Melt"){ echo "selected";} ?>>Nadige Melt</option>
									<option value="Office du tourisme" <?php if($source=="Office du tourisme"){ echo "selected";} ?>>Office du tourisme</option>
									<option value="Paul and Susie Hammersky" <?php if($source=="Paul and Susie Hammersky"){ echo "selected";} ?>>Paul and Susie Hammersky</option>
									<option value="Propriétaire" <?php if($source=="Propriétaire"){ echo "selected";} ?>>Propriétaire</option>
									<option value="Repeat" <?php if($source=="Repeat"){ echo "selected";} ?>>Repeat</option>
									<option value="Repeat SC" <?php if($source=="Repeat SC"){ echo "selected";} ?>>Repeat SC</option>
									<option value="Ron and Andy Stein" <?php if($source=="Ron and Andy Stein"){ echo "selected";} ?>>Ron and Andy Stein</option>
									<option value="St Martin Vacation" <?php if($source=="St Martin Vacation"){ echo "selected";} ?>>St Martin Vacation</option>
									<option value="TripAdvisor" <?php if($source=="TripAdvisor"){ echo "selected";} ?>>TripAdvisor</option>
									<option value="VRBO SC" <?php if($source=="VRBO SC"){ echo "selected";} ?>>VRBO SC</option>
									<option value="Website" <?php if($source=="Website"){ echo "selected";} ?>>Website</option>
								</select>
							</div>
							<div id="saved_persons">
								<div class="form-group">
									<label for="exampleInputPassword1"><?php echo lang('no_of_adult'); ?>: </label>
									<a href="javascript:void(0)" onclick="var r = confirm('Etes-vous sûr de vouloir changer le nombre de personne');
																		  if (r == true) {
																		  	$('#saved_persons').hide(); $('#new_persons').show(); 
																		  }else {
																		  	$('#saved_persons').show(); $('#new_persons').hide(); 																		  	
																		  }">Change</a>
									<input type="text" onkeypress="return false" class="form-control" value="<?php echo $reservation_details[0]['no_of_adult']; ?>" />
								</div>
								<?php if($reservation_details[0]['no_of_extra_real_adult'] > 0){ ?>
									<div class="form-group">
										<label for="exampleInputPassword1"><?php echo lang('no_of_extra_real_adult'); ?>: </label>
										<input type="text" onkeypress="return false" class="form-control" value="<?php echo $reservation_details[0]['no_of_extra_real_adult']; ?>" />
									</div>
								<?php } if($reservation_details[0]['no_of_extra_adult'] > 0){ ?>
									<div class="form-group">
										<label for="exampleInputPassword1"><?php echo lang('no_of_extra_adult'); ?>: </label>
										<input type="text" onkeypress="return false" class="form-control" value="<?php echo $reservation_details[0]['no_of_extra_adult']; ?>" />
									</div>
								<?php } if($reservation_details[0]['no_of_extra_kid'] > 0){ ?>
									<div class="form-group">
										<label for="exampleInputPassword1"><?php echo lang('no_of_extra_kid'); ?>: </label>
										<input type="text" onkeypress="return false" class="form-control" value="<?php echo $reservation_details[0]['no_of_extra_kid']; ?>" />
									</div>
								<?php } if($reservation_details[0]['no_of_folding_bed_kid'] > 0){ ?>
									<div class="form-group">
										<label for="exampleInputPassword1"><?php echo lang('no_of_folding_bed_kid'); ?>: </label>
										<input type="text" onkeypress="return false" class="form-control" value="<?php echo $reservation_details[0]['no_of_folding_bed_kid']; ?>" />
									</div>
								<?php } if($reservation_details[0]['no_of_folding_bed_adult'] > 0){ ?>
									<div class="form-group">
										<label for="exampleInputPassword1"><?php echo lang('no_of_folding_bed_adult'); ?>: </label>
										<input type="text" onkeypress="return false" class="form-control" value="<?php echo $reservation_details[0]['no_of_folding_bed_adult']; ?>" />
									</div>
								<?php } if($reservation_details[0]['no_of_baby_bed'] > 0){ ?>
									<div class="form-group">
										<label for="exampleInputPassword1"><?php echo lang('no_of_baby_bed'); ?>: </label>
										<input type="text" onkeypress="return false" class="form-control" value="<?php echo $reservation_details[0]['no_of_baby_bed']; ?>" />
									</div>
								<?php } ?>
							</div>
							<div class="form-group" id="new_persons" style="display:none;">
								<label for="exampleInputPassword1"><?php echo lang('no_of_adult'); ?></label>
								<select name="no_of_adult" id="no_of_adult" class="form-control" onchange="autoPopulateAdult();">
									<option value="">--Sélectionner--</option>
									<?php for($i = 1;$i<=2;$i++){?> 
										<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php } ?>
								</select>
								<div class="form-group has-error" id="no_of_adult_error" style="display:none;">
									<label class="control-label" for="inputError">
									<i class="fa fa-times-circle-o"> <?php echo lang('no_of_adult'); ?> is required</i>
									</label>
								</div>
							</div>
							<div class="form-group" id="div_no_of_extra_real_adult" style="display:none;">
								<label><?php echo lang('no_of_extra_real_adult'); ?></label>
								<select name="no_of_extra_real_adult" id="no_of_extra_real_adult" class="form-control test" onchange="autoPopulateExtraRealAdult(this.value);">
									<option value="">--Sélectionner--</option>
								</select>
							</div>
							<div class="form-group" id="div_no_of_extra_adult" style="display:none;">
								<label><?php echo lang('no_of_extra_adult'); ?></label>
								<select name="no_of_extra_adult" id="no_of_extra_adult" class="form-control test" onchange="autoPopulateExtraAdult(this.value);">
									<option value="">--Sélectionner--</option>
								</select>
							</div>
							<div class="form-group" id="div_no_of_extra_kid" style="display:none;">
								<label><?php echo lang('no_of_extra_kid'); ?></label>
								<select name="no_of_extra_kid" id="no_of_extra_kid" class="form-control test" onchange="autoPopulateExtraKid(this.value);">
									<option value="">--Sélectionner--</option>
								</select>
							</div>
							<div class="form-group" id="div_no_of_folding_bed_kid" style="display:none;">
								<label><?php echo lang('no_of_folding_bed_kid'); ?></label>
								<select name="no_of_folding_bed_kid" id="no_of_folding_bed_kid" class="form-control test" onchange="autoPopulateFoldingBedKid(this.value);"> 
									<option value="">--Sélectionner--</option> 
								</select>
							</div>
							<div class="form-group" id="div_no_of_folding_bed_adult" style="display:none;">
								<label><?php echo lang('no_of_folding_bed_adult'); ?></label>
								<select name="no_of_folding_bed_adult" id="no_of_folding_bed_adult" class="form-control test" onchange="autoPopulateFoldingBedAdult(this.value);">
									<option value="">--Sélectionner--</option>
								</select>
							</div>
							<div class="form-group" id="div_no_of_baby_bed" style="display:none;">
								<label><?php echo lang('no_of_baby_bed'); ?></label>
								<select name="no_of_baby_bed" id="no_of_baby_bed" class="form-control test">
									<option value="">--Sélectionner--</option>
								</select>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1"><?php echo lang('Discount'); ?>(%)</label>
								<input type="text" name="reservation_discount" onblur="checkDigitAfterDecimal('reservation_discount');" readonly="true" id="reservation_discount" class="form-control" value="<?php echo $reservation_details[0]['discount']; ?>">
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1"><?php echo lang('Admin_Comments'); ?></label>
								<textarea class="form-control" name="admin_comments" id="admin_comments" style="height:200px;"><?php echo str_ireplace("<br />", "\n", $reservation_details[0]['admin_comments']); ?></textarea>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1"><?php echo lang('User_Comments'); ?></label>
								<textarea class="form-control" name="txt_comments" id="txt_comments" style="height:200px;"><?php echo str_ireplace("<br />", "\n", $reservation_details[0]['invoice_comments']); ?></textarea>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1"><?php echo lang('Amount_Summary'); ?>: </label><br/>
								<?php echo lang('Total_Amount'); ?>: <?php echo $reservation_details[0]["amount_to_be_paid"]; ?><br/>
								<?php echo lang('Paid_Amount'); ?>: <?php echo $reservation_details[0]["paid_amount"]; ?><br/>
								<?php echo lang('Due_Amount'); ?>: <?php echo $reservation_details[0]["due_amount"]; ?><br/>
								<input type="hidden" id="hid_due_amount" name="hid_due_amount" value="<?php echo str_replace("€", "", $reservation_details[0]["due_amount"]); ?>">
								<input type="hidden" id="hid_paid_amount" name="hid_paid_amount" value="<?php echo str_replace("€", "", $reservation_details[0]["paid_amount"]); ?>">
								<?php if($reservation_details[0]["due_amount"] != 0){ ?>
									<input type="text" id="txt_amount_paid" name="txt_amount_paid" class="form-control" onblur="checkAmount($('#hid_due_amount').val(),this.value);" /> 
								<?php } ?>
							</div>
							<div class="form-group" id="Amount_Summary">
								<label><?php echo lang('Amount_Summary'); ?></label>
								<select name="payment_mode" id="payment_mode" class="form-control test">
									<option value="">--Sélectionner--</option>
									<option value="Carte de Credit" <?php if($reservation_details[0]['payment_mode']=="Carte de Credit"){ echo "selected"; } ?>>Carte de Credit</option>
									<option value="Cash" <?php if($reservation_details[0]['payment_mode']=="Cash"){ echo "selected"; } ?>>Cash</option>
									<option value="Paypal" <?php if($reservation_details[0]['payment_mode']=="Paypal"){ echo "selected"; } ?>>Paypal</option>
									<option value="Virement" <?php if($reservation_details[0]['payment_mode']=="Virement"){ echo "selected"; } ?>>Virement</option>
								</select>
							</div>							
							<div class="form-group" id="div_date_payment_mode">
								<label><?php echo lang('Total'); ?></label>
								<div class='input-group date' id='datetimepickerpayment' style="width:200px">
									<input type='text' name="search_arrival_date_p" id="search_arrival_date_p" class="form-control" style="cursor:auto;" readonly data-date-format="DD/MM/YYYY" value="<?php echo $reservation_details[0]['date_payment_mode']; ?>" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
								<label style="color:red;" id="search_arrival_date_error"></label>		
							</div>
							<div class="form-group" id="div_pending_status">
								<label><?php echo lang('Payment_Status'); ?></label>
								<select name="sel_pending_status" id="sel_pending_status" class="form-control test">
									<option value="En Attente" <?php if($reservation_details[0]['payment_status']=="En Attente" || $reservation_details[0]['payment_status']==""){ echo "selected"; } ?>>En Attente</option>
									<option value="Acompte Payé" <?php if($reservation_details[0]['payment_status']=="Acompte Payé"){ echo "selected"; } ?>>Acompte Payé</option>
									<option value="Réglé" <?php if($reservation_details[0]['payment_status']=="Réglé"){ echo "selected"; } ?>>Réglé</option>
								</select>
							</div>
							<div class="form-group" id="div_reservation_status">
								<label><?php echo lang('Reservation_Status'); ?></label>
								<select name="sel_resrevation_status" id="sel_resrevation_status" class="form-control test">
									<option value="En Attente" <?php if($reservation_details[0]['reservation_status']=="En Attente"){ echo "selected"; } ?>>En Attente</option>
									<option value="Confirmée" <?php if($reservation_details[0]['reservation_status']=="Confirmée"){ echo "selected"; } ?>>Confirmée</option>
									<option value="Payée" <?php if($reservation_details[0]['reservation_status']=="Payée"){ echo "selected"; } ?>>Payée</option>
									<option value="Annulée" <?php if($reservation_details[0]['reservation_status']=="Annulée"){ echo "selected"; } ?>>Annulée</option>
								</select>
							</div>
						</div>
						<div class="box-footer">
							<input type="submit" class="btn btn-primary" name="save" value="<?php echo lang('payment_submit');?>">
							<input type="button" class="btn btn-primary" name="calculate" value="<?php echo lang('payment_Calculate');?>" onclick="calculatePrice();">	
							<a class="btn btn-primary" target="_blank" href="?res_id=<?php echo $reservation_id; ?>"><?php echo lang('payment_Download');?></a>	
						</div>
					</div>
					<?php if(count($linked_reservation_details)){ ?>
					<div>
						<h3>Réservations liées: </h3><ul>
						<?php for($i=0;$i<count($linked_reservation_details);$i++){ ?>							
							<li>Reservation #<?php echo ($i+1).": ".$linked_reservation_details[$i]["bunglow_name"]."( ".$linked_reservation_details[$i]["arrival_date"]." à ".$linked_reservation_details[$i]["leave_date"]." )"; ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo base_url(); ?>admin/payment/payment_edit/<?php echo $linked_reservation_details[$i]["id"]; ?>">Modifier</a></li>							
						<?php } ?>
					</ul></div>
					<?php } ?>
				</form>
				
			</div><!-- /.box -->
		</div>
	</div>   <!-- /.row -->
</section><!-- /.content -->
