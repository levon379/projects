<meta charset="UTF-8">
<title>Les Balcons | Admin</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!-- bootstrap 3.0.2 -->
<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- font Awesome -->
<link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- Ionicons -->
<link href="<?php echo base_url();?>assets/css/ionicons.min.css" rel="stylesheet" type="text/css" />
<!-- Morris chart -->
<link href="<?php echo base_url();?>assets/css/morris/morris.css" rel="stylesheet" type="text/css" />
<!-- jvectormap -->
<link href="<?php echo base_url();?>assets/css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
<!-- fullCalendar -->
<link href="<?php echo base_url();?>assets/css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
<!-- Daterange picker -->
<link href="<?php echo base_url();?>assets/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<!-- bootstrap wysihtml5 - text editor -->
<link href="<?php echo base_url();?>assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
<!-- iCheck for checkboxes and radio inputs -->
<link href="<?php echo base_url();?>assets/css/iCheck/minimal/blue.css" rel="stylesheet" type="text/css" />
<!-- Theme style -->
<link href="<?php echo base_url();?>assets/css/AdminLTE.css" rel="stylesheet" type="text/css" />
<!-- DATA TABLES -->

<link href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
<!-- Date time Picker -->

<link href="<?php echo base_url();?>assets/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
<!-- Bootstrap -->

<script src="<?php echo base_url();?>assets/js/jquery-1.8.3.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(e) {
    
	$(".mobile_table").click(function(e)
	{
		//alert(999)
		var xt = $("#box_moblie").css({'left':e.pageX});
		
		
		if(e.pageX>182)
		{
			//alert(898)
			$("#box_moblie").css({'left':e.pageX-150,'top':e.pageY});
			$("#box_moblie").show();
		}else{
			$("#box_moblie").css({'left':e.pageX,'top':e.pageY});
			$("#box_moblie").show();
		}
		console.log(e.pageX+":"+e.pageY);
	});
	
	
	  
	  $("#box_moblie .cls").click(function(e)
	  {
		  //e.stopPropagation();
		  $("#box_moblie").hide();
	  });
	
});


$(function(){
	$('.mobile_table td').on('click', function(e) {
		var unique_id=$(this).attr('id');
		if(unique_id)
		{
			$('#hidden_unique_id').val(unique_id); //Store unique id in the input field which is in home_mobile.php
			var date=$('#'+unique_id).find('#date').val();
			var bungalow_id=$('#'+unique_id).find('#bungalow_id').val();
			var reservation_id=$('#'+unique_id).find('#reservation_id').val();
			var cleaning_date=$('#'+unique_id).find('#cleaning_date').val();
			if(reservation_id=="" && cleaning_date=="")// if date is not reserved and not reserved for cleaning
			{
				$('#box_moblie').find('#add_reservation_id').show();//Add Reservation will show
				$('#box_moblie').find('#mark_cleaning_id').show();//Mark for cleaning will show
				$('#box_moblie').find('#edit_reservation_id').hide();//edit reservation will hide
				$('#box_moblie').find('#send_bill_id').hide();//Send Bill will hide
				$('#box_moblie').find('#remove_cleaning_id').hide();//Remove Cleaning will hide
			}
			else if(reservation_id!="")// if date is reserved
			{
				$('#box_moblie').find('#add_reservation_id').hide();//Add Reservation will hide
				$('#box_moblie').find('#mark_cleaning_id').hide();//Mark for cleaning will hide
				$('#box_moblie').find('#edit_reservation_id').show();//edit reservation will show
				$('#box_moblie').find('#send_bill_id').show();//Send Bill will show
				$('#box_moblie').find('#remove_cleaning_id').hide();//Remove Cleaning will hide
			}
			else if(cleaning_date!="")// if date is reserved for cleaning
			{
				$('#box_moblie').find('#add_reservation_id').hide();//Add Reservation will hide
				$('#box_moblie').find('#mark_cleaning_id').hide();//Mark for cleaning will hide
				$('#box_moblie').find('#edit_reservation_id').hide();//edit reservation will show
				$('#box_moblie').find('#send_bill_id').hide();//Send Bill will show
				$('#box_moblie').find('#remove_cleaning_id').show();//Remove Cleaning will hide
			}
		}
		else
		{
			return false;
		}
	});
});
</script>


