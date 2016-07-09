<script>
	$(function() {
		$('.dataTables_filter input[type="text"]').attr('placeholder','<?php echo lang('Search_Placeholder'); ?>');
	});
</script>

<style type="text/css">

#box{ display:none;}
</style>

<!-- Bootstrap -->
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="<?php echo base_url();?>assets/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>assets/js/AdminLTE/app.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url();?>assets/js/AdminLTE/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<!-- Script for Checking all checkboxes specially for mailbox module page -->


<script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.js" type="text/javascript"></script>

<script type="text/javascript">

	$('.form_date').datetimepicker({
        language:  'En',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('#print_from_datepicker').datetimepicker({
		format:'dd/mm/yyyy',
		language:  'En',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('#print_to_datepicker').datetimepicker({
		format:'dd/mm/yyyy',
		language:  'En',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('#leave_datepicker').datetimepicker({
		format:'dd/mm/yyyy',
		language:  'En',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
</script>
<!-- Date time picker -->

<script type="text/javascript">
$('pre').replaceWith(function(){
    return $("<p />", {html: $(this).html()});
});
</script>


<script type="text/javascript">
	$(function() {
		"use strict";
		//iCheck for checkbox and radio inputs
		$('input[type="checkbox"]').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass: 'iradio_minimal-blue'
		});

		//When unchecking the checkbox
		$("#check-all").on('ifUnchecked', function(event) {
			//Uncheck all checkboxes
			$("input[type='checkbox']", ".table-mailbox").iCheck("uncheck");
		});
		//When checking the checkbox
		$("#check-all").on('ifChecked', function(event) {
			//Check all checkboxes
			$("input[type='checkbox']", ".table-mailbox").iCheck("check");
		});
	});
</script>



<script type="text/javascript">

$(document).ready(function() {
	
	//var tableWd = $("#months td").eq(3).outerWidth(true);
	//alert(tableWd)
	
	var counter = -1
	var moyhArray = [775,700,775,750,775,750,775,775,750,775,750,775]
	
	//alert(arrayMonth)
	
	
	//$('body').append("<div id='box' style='position:absolute;width:200px;height:200px;border:1px solid #000;z-index:9999; background:#c2c2c2;'></div>")764+11,689,764,739,764,739,764,764,739,764,739,764
	$(".next_month").click(function(e)
	{
		e.preventDefault();
		if(counter<11)
		{
			counter++;	
		}
		var left= $(".time-line-cols").scrollLeft();
		console.log(left)
		$(".time-line-cols").scrollLeft(left+moyhArray[counter]);
		console.log($(".time-line-cols").scrollLeft())
		
		
	});
	
	$(".prev_month").click(function(e)
	{
		e.preventDefault();
		if(counter>0)
		{
			counter--;
		}
		var left= $(".time-line-cols").scrollLeft();
		$(".time-line-cols").scrollLeft(left-moyhArray[counter]);
		
	});
	
	//$("#box").hide();
	
	$('.time-line-cols').bind('contextmenu',function(e){
      e.preventDefault();
	  console.log(e.pageX+":"+e.pageY);
	  $("#box").css({'left':e.pageX,'top':e.pageY});
	  $("#box").show();
      //alert('Right Click is not allowed on div');
      });
	  
	  $("body").click(function(){
		 
		  $("#box").hide();
	  });
	  
	  $("#box").click(function(e)
	  {
		  e.stopPropagation();
	  });
	  
	  
	 // var mobileWidth = $(window).width();
	  //alert(mobileWidth)
	
	
});


//Function for oncontext menu click
$(function(){
	$('.time-line-cols td').on('contextmenu', function(e) {
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
				$('#box').find('#add_reservation_id').show();//Add Reservation will show
				$('#box').find('#mark_cleaning_id').show();//Mark for cleaning will show
				$('#box').find('#edit_reservation_id').hide();//edit reservation will hide
				$('#box').find('#send_bill_id').hide();//Send Bill will hide
				$('#box').find('#remove_cleaning_id').hide();//Remove Cleaning will hide
			}
			else if(reservation_id!="")// if date is reserved
			{
				$('#box').find('#add_reservation_id').hide();//Add Reservation will hide
				$('#box').find('#mark_cleaning_id').hide();//Mark for cleaning will hide
				$('#box').find('#edit_reservation_id').show();//edit reservation will show
				$('#box').find('#send_bill_id').show();//Send Bill will show
				$('#box').find('#remove_cleaning_id').hide();//Remove Cleaning will hide
			}
			else if(cleaning_date!="")// if date is reserved for cleaning
			{
				$('#box').find('#add_reservation_id').hide();//Add Reservation will hide
				$('#box').find('#mark_cleaning_id').hide();//Mark for cleaning will hide
				$('#box').find('#edit_reservation_id').hide();//edit reservation will show
				$('#box').find('#send_bill_id').hide();//Send Bill will show
				$('#box').find('#remove_cleaning_id').show();//Remove Cleaning will hide
			}
		}
		else
		{
			return false;
		}
	});
});

var current_month_scroll="<?php echo "month_year_".date("F_Y") ?>";
//var leftposition=$("#"+current_month_scroll).position().left;
//$(".time-line-cols").scrollLeft(leftposition-250);
document.getElementById(current_month_scroll).scrollIntoView(true);


</script>