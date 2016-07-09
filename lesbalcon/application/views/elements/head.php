<meta charset="utf-8">
<title><?php echo $title; ?></title>
<meta name="description" content="<?php echo $meta_description; ?>">
<meta name="keywords" content="<?php echo $meta_keyword; ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Roboto:100' rel='stylesheet' type='text/css'>
<!-- Bootstrap -->
<link href="<?php echo base_url(); ?>assets/frontend/css/style.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/frontend/css/bootstrap-lightbox.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/frontend/css/ekko-lightbox.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/font-awesome.min.css">
<link href="<?php echo base_url(); ?>assets/frontend/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/frontend/css/bootstrap-datetimepicker.css" />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/custom.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo base_url(); ?>assets/frontend/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/frontend/js/moment.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/bootstrap-datetimepicker.js"></script>
<link href="<?php echo base_url(); ?>assets/frontend/css/lightbox.css" rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<script type="text/javascript">
			$(function () {
				var date = new Date();
				var year = date.getFullYear() + 2;
				var month = date.getMonth();
				var future_date = new Date(year,month,date.getDate());
				date.setDate(date.getDate());
				$('#datetimepicker5').datetimepicker({
					format:'dd/mm/yyyy',
					language:  '<?php echo ($current_lang_id = $this->session->userdata("current_lang_id")==2)?'fr':'En'; ?>',
					weekStart: 1,
					todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					minView: 2,
					forceParse: 0,
					startDate: date,
					endDate: future_date
				});
				$('#mobile_search_arrival_date').on('click', function(){
					$('#datetimepicker5').find('.glyphicon-calendar').trigger('click');
				});

				$('#datetimepicker6').datetimepicker({
					format:'dd/mm/yyyy',
					language:  '<?php echo ($current_lang_id = $this->session->userdata("current_lang_id")==2)?'fr':'En'; ?>',
					weekStart: 1,
					todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					minView: 2,
					forceParse: 0,
					startDate: date,
					endDate: future_date
				});
				$('#mobile_search_leave_date').on('click', function(){
					$('#datetimepicker6').find('.glyphicon-calendar').trigger('click');
				});
				
				$('#datetimepicker7').datetimepicker({
					format:'dd/mm/yyyy',
					language:  '<?php echo ($current_lang_id = $this->session->userdata("current_lang_id")==2)?'fr':'En'; ?>',
					weekStart: 1,
					todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					minView: 2,
					forceParse: 0,
					startDate: date,
					endDate: future_date
				}).on('changeDate', function(e){
			       $('#datetimepicker8').datetimepicker('setStartDate', $("#search_arrival_date").val());
			    });
				$('#search_arrival_date').on('click', function(){
					$('#datetimepicker7').find('.glyphicon-calendar').trigger('click');
				});
				
				$('#datetimepicker8').datetimepicker({
					format:'dd/mm/yyyy',
					language:  '<?php echo ($current_lang_id = $this->session->userdata("current_lang_id")==2)?'fr':'En'; ?>',
					weekStart: 1,
					todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					minView: 2,
					forceParse: 0,
					startDate: date,
					endDate: future_date
				});
				$('#search_leave_date').on('click', function(){
					$('#datetimepicker8').find('.glyphicon-calendar').trigger('click');
				});
				
				$('#datetimepicker9').datetimepicker({
					format:'dd/mm/yyyy',
					language:  '<?php echo ($current_lang_id = $this->session->userdata("current_lang_id")==2)?'fr':'En'; ?>',
					weekStart: 1,
					todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					minView: 2,
					forceParse: 0,
					startDate: date,
					endDate: future_date
				}).on('changeDate', function(e){
			       $('#datetimepicker10').datetimepicker('setStartDate', $("#arrival_date").val());
			    });
				$('#arrival_date').on('click', function(){
					$('#datetimepicker9').find('.glyphicon-calendar').trigger('click');
				});
				
				$('#datetimepicker10').datetimepicker({
					format:'dd/mm/yyyy',
					language:  '<?php echo ($current_lang_id = $this->session->userdata("current_lang_id")==2)?'fr':'En'; ?>',
					weekStart: 1,
					todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					minView: 2,
					forceParse: 0,
					startDate: date,
					endDate: future_date
				});
				$('#leave_date').on('click', function(){
					$('#datetimepicker10').find('.glyphicon-calendar').trigger('click');
				});
			});
			
			$(document).ready(function(){
				$('.arrow_top').css("display","none");
				//alert(dh);
				$(window).scroll(function(){
				    var wh=$(window).height();
					
				    if($(window).scrollTop()>wh){
						//alert("ok");
						$('.arrow_top').fadeIn(200);
					}
					else{
						$('.arrow_top').fadeOut(200);
					}
				});
				
			});
	</script>

<?php $remove=lang('Remove'); ?>
<script type="text/javascript">
$(document).ready(function() {
    var max_fields      = 100; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><input type="text" class="login-input testi-input form-control input-md" name="phone[]" style="float:left;" onkeypress="return numbersonly(event)"/><a href="#" class="remove_field"><?php echo $remove; ?></a></div>'); //add input box
        }
    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
	
	
	
	
	
	var max_fields_email      = 100; //maximum input boxes allowed
    var wrapper_email        = $(".input_fields_wrap_email"); //Fields wrapper
    var add_button_email      = $(".add_field_button_email"); //Add button ID
   
    var x = 1; //initlal text box count
    $(add_button_email).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper_email).append('<div><input type="text" class="login-input testi-input form-control input-md" name="email[]" style="float:left;"><a href="#" class="remove_field_email"><?php echo $remove; ?></a></div>'); //add input box
        }
    });
   
    $(wrapper_email).on("click",".remove_field_email", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
</script>
<link href="<?php echo base_url(); ?>assets/frontend/css/ekko-lightbox.css" rel="stylesheet">