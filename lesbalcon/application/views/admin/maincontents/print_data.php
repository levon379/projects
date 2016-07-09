<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang('Print_Data'); ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang('Home'); ?></a></li>
		<li class="active"><?php echo lang('Print_Data'); ?></li>
	</ol>
</section>
<script>
	function calcDate(date1,date2) 
	{
		var diff = Math.floor(date1.getTime() - date2.getTime());
		var day = 1000 * 60 * 60 * 24;
		var days = Math.floor(diff/day);
		var months = Math.floor(days/31);
		var years = Math.floor(months/12);
		return days;
	}
	function check_form()
	{
		var error=0;
		if($("#report_type").val().trim()=="")
		{
			$("#report_type_error").show();
			error++;
		}
		else  
		{
			$("#report_type_error").hide();
		}
		if($("#date_from").val().trim()=="")
		{
			$("#date_from_error").show();
			error++;
		}
		else  
		{
			$("#date_from_error").hide();
		}
		if($("#date_to").val().trim()=="")
		{
			$("#date_to_error").show();
			error++;
		}
		else  
		{
			var date_from=$("#date_from").val();
			var date_from_arr=$("#date_from").val().split("/");
			var valyear=date_from_arr[2];
			var valmonth=date_from_arr[1];
			var valday=date_from_arr[0];
			var today = new Date()
			var new_date_from= new Date(valyear,(valmonth-1),valday);
			
			var date_to=$("#date_to").val();
			var date_to_arr=$("#date_to").val().split("/");
			var to_year=date_to_arr[2];
			var to_month=date_to_arr[1];
			var to_day=date_to_arr[0];
			var new_to_date= new Date(to_year,(to_month-1),to_day);
			
			var result=calcDate(new_date_from, new_to_date);
		
			if(result>0)
			{
				$("#to_field_text").html(" Must be greater than From");
				$("#date_to_error").show();
				error++;
			}
			else 
			{
				$("#to_field_text").html(" To field is required");
				$("#date_to_error").hide("");
			}
		}
		if(error>0)
		{
			$(window).scrollTop($("#form").offset().top);
			return false;
		}
		else 
		{
			var report_type=$("#report_type").val();
			var from_date=$("#date_from").val();
			var to_date=$("#date_to").val();

			$.post("<?php echo base_url(); ?>admin/print_data/ajax_print_process", { "report_type":report_type, "from_date": from_date, "to_date":to_date }, function(data){
				if(data.trim()=="notavailable")
				{
					$("#error_message").show();
				}
				else 
				{
					$("#print_section").html(data);
					var divContents = $("#print_section").html();
					var printWindow = window.open('', '', 'height=400,width=1000');
					printWindow.document.write('<html><head><title>Print Data</title>');
					printWindow.document.write('</head><body >');
					printWindow.document.write(divContents);
					printWindow.document.write('</body></html>');
					printWindow.document.close();
					printWindow.print();
				}
			});
		}
	}
</script>
<!-- Main content -->

<section class="content" id="error_message" style="display:none;">
<div class="alert alert-danger alert-dismissable" style="margin-bottom:0px;">
	<i class="fa fa-ban"></i>
	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
	<b><?php echo lang('No_data_available'); ?></b>
</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url() ?>admin/print_data/print_process" method="POST" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group">
							<label for="exampleInputEmail1"> <?php echo lang('CHOOSE_REPORT'); ?><span style="color:red">*</span></label><br>
							<select name="report_type" id="report_type" class="form-control" style="width:50%;">
								<option value="">--Select--</option>
								<option value="booking"> <?php echo lang('Booking_Report'); ?></option>
								<option value="cleaning"> <?php echo lang('Cleaning_Report'); ?></option>
							</select>
							<div class="form-group has-error" id="report_type_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('Choose_Report_field_is_required'); ?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('FROM'); ?></label>
							<div class='input-group date' id='print_from_datepicker' style="width:50%;">
							<input type="text" name="date_from" id="date_from" class="form-control " placeholder="" value="" readonly style="cursor:auto;">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
							</div>
							<div class="form-group has-error" id="date_from_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"><?php echo lang('From_field_is_required'); ?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('TO');?></label>
							<div class='input-group date' id='print_to_datepicker' style="width:50%;">
							<input type="text" name="date_to" id="date_to" class="form-control " placeholder="" value="" readonly style="cursor:auto;">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
							</div>
							<div class="form-group has-error" id="date_to_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="to_field_text"> <?php echo lang('To_field_is_required'); ?></i>
								</label>
							</div>
						</div>
					</div><!-- /.box-body -->
					<div class="box-footer">
						<input type="button" class="btn btn-primary" name="save" value="<?php echo lang('Submit'); ?>" onclick="check_form()">
					</div>
				</form>
			</div><!-- /.box -->
		</div>
	</div>   <!-- /.row -->
</section><!-- /.content -->

<section class="content" id="print_section" style="display:none;">
</section>