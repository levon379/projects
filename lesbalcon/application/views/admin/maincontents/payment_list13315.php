<?php 
$this->session->unset_userdata("referer_url");
$current_controller=$this->uri->segment(3);
if($current_controller=="all")
{
	$page_name="All Payments";
}
elseif($current_controller=="completed")
{
	$page_name="Completed Payments";
}
elseif($current_controller=="partial")
{
	$page_name="Partial Payments";
}
elseif($current_controller=="active")
{
	$page_name="Active Payments";
}
elseif($current_controller=="deactivated")
{
	$page_name="Deactivated Payments";
}
elseif($current_controller=="cancelled")
{
	$page_name="Cancelled Payments";
}
?>
<script>
	function change_type(type)
	{
		if(type=="all")
		{
			location.href="<?php echo base_url(); ?>admin/payment/all";
		}
		else if(type=="partial")
		{
			location.href="<?php echo base_url(); ?>admin/payment/partial";
		}
		else if(type=="active")
		{
			location.href="<?php echo base_url(); ?>admin/payment/active";
		}
		else if(type=="deactivated")
		{
			location.href="<?php echo base_url(); ?>admin/payment/deactivated";
		}
		else if(type=="completed")
		{
			location.href="<?php echo base_url(); ?>admin/payment/completed";
		}
		else if(type=="cancelled")
		{
			location.href="<?php echo base_url(); ?>admin/payment/cancelled";
		}
	}
	function change_reservation_status(id, status)
	{
		$.post("<?php echo base_url(); ?>admin/payment/ajax_change_reservation_status", { "id":id, "status":status }, function(data){
			window.location.reload();
		});
	}
	function change_payment_status(id, status)
	{
		$.post("<?php echo base_url(); ?>admin/payment/ajax_change_payment_status", { "id":id, "status":status }, function(data){
			window.location.reload();
		});
	}
	function change_active_inactive(id, status, leave_date)
	{
		$('#leave_date').val(leave_date);
		$('#current_leave_date').val(leave_date);
		$('#reservation_id').val(id)
		if(status=="DEACTIVE")
		{
			$.post("<?php echo base_url(); ?>admin/payment/ajax_change_active_inactive", { "id":id, "status":status }, function(data){
				window.location.reload();
			});
		}
		else if(status=="ACTIVE")
		{
			$('#message_div').modal('show'); 
		}
		/*$.post("<?php echo base_url(); ?>admin/payment/ajax_change_active_inactive", { "id":id, "status":status }, function(data){
			window.location.reload();
		});*/
		
	}
	function delete_reservation(id)
	{
		var conf=confirm("Are you sure to delete?");
		if(conf==true)
		{
			$.post("<?php echo base_url(); ?>admin/payment/ajax_delete_payment", { "id":id}, function(data){
				window.location.reload();
			});
		}
	}
	
	function increase_leave_date()
	{
		var reservation_id=$('#reservation_id').val();
		
		var current_leave_date=$('#current_leave_date').val();
		var current_leave_date_arr=$("#current_leave_date").val().split("/");
		var current_leave_year=current_leave_date_arr[2];
		var current_leave_month=current_leave_date_arr[1];
		var current_leave_day=current_leave_date_arr[0];
		var new_current_leave_date= new Date(current_leave_year,(current_leave_month-1),current_leave_day);
		
		
		var leave_date=$('#leave_date').val();
		var leave_date_arr=$("#leave_date").val().split("/");
		var leave_year=leave_date_arr[2];
		var leave_month=leave_date_arr[1];
		var leave_day=leave_date_arr[0];
		var new_leave_date= new Date(leave_year,(leave_month-1),leave_day);
		
		var result=calcDate(new_current_leave_date, new_leave_date);

		if(result==0)
		{
			location.href=document.URL;
		}
		if(result>0)
		{
			$('#leave_date_error_text').html(" Invalid Date");
			$('#leave_date_error').show();
		}
		else 
		{
			$('#leave_date_error').hide();
			$.post("<?php echo base_url(); ?>admin/payment/ajax_increase_leave_date", { "reservation_id":reservation_id, "current_leave_date":current_leave_date, "leave_date":leave_date }, function(data){
				if(data.trim()=="available")
				{
					location.href=document.URL;
				}
				else if(data.trim()=="notavailable")
				{
					$('#leave_date_error_text').html(" Not Available")
					$('#leave_date_error').show();
				}
				else
				{
					$('#availability').html("Available on: "+data);
				}
			});	
		}
		/*$.post("<?php echo base_url(); ?>admin/payment/ajax_increase_leave_date", { "reservation_id":reservation_id, "leave_date":leave_date }, function(data){
			window.location.reload();
		});*/
	}
	function calcDate(date1,date2) 
	{
		var diff = Math.floor(date1.getTime() - date2.getTime());
		var day = 1000 * 60 * 60 * 24;

		var days = Math.floor(diff/day);
		var months = Math.floor(days/31);
		var years = Math.floor(months/12);

		return days;
	}
	function export_to_excel(value)
	{
		location.href="<?php echo base_url(); ?>admin/payment/download_as_excel/"+value;
	}
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo $page_name; ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang("Home"); ?></a></li>
		<li class="active"><?php echo $page_name; ?></li>
	</ol>
</section>
<!-- Main content -->
<?php 

if(isset($_GET["deleted"]))
{
	?>
	<section class="content">
	<div class="alert alert-success alert-dismissable" style="margin-bottom:0px;">
		<i class="fa fa-check"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b><?php echo "Data Deleted Successfully"; ?></b>
	</div>
	</section>
	<?php
}
if(isset($_GET["saved"]))
{
	?>
	<section class="content">
	<div class="alert alert-success alert-dismissable" style="margin-bottom:0px;">
		<i class="fa fa-check"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b><?php echo "Data saved Successfully"; ?></b>
	</div>
	</section>
	<?php
}
?>

<div class="box_horizontal">
	<select name="change_type" id="change_type" style="float:left; width:25%;" class="form-control" onchange="change_type(this.value)">
		<option value="all" <?php if($current_controller=="all"){ echo "selected"; } ?>>All</option>
		<option value="partial" <?php if($current_controller=="partial"){ echo "selected"; } ?>>Partial</option>
		<option value="active" <?php if($current_controller=="active"){ echo "selected"; } ?>>Active</option>
		<option value="deactivated" <?php if($current_controller=="deactivated"){ echo "selected"; } ?>>Deactivated</option>
		<option value="completed" <?php if($current_controller=="completed"){ echo "selected"; } ?>>Completed</option>
		<option value="cancelled" <?php if($current_controller=="cancelled"){ echo "selected"; } ?>>Cancelled</option>
	</select>
	<a style="cursor:pointer;" onclick="export_to_excel('<?php echo $current_controller; ?>')" class="btn btn-primary btn-flat"><?php echo lang('Download_As_Excel'); ?></a>
</div>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				
				<div class="box-body table-responsive">
					<table <?php if($all_rows){ echo 'id="data_table"'; } ?> class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl. No</th>
								<th width="5%">Date</th>
								<th>Bungalow</th>
								<th width="10%">Arrival</th>
								<th width="10%">Leave</th>
								<th class="sorting_disabled" width="15%">Reservation Status</th>
								<th class="sorting_disabled" width="15%">Payment Status</th>
								<th class="sorting_disabled" width="10%">Is Active</th>
								<th width="10%" style="text-align:center!important;" class="sorting_disabled">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if($all_rows)
							{	
								$sl_no=1;
								foreach($all_rows as $row)
								{
									?>
									<tr>
										<td><?php echo $sl_no; ?></td>
										<td><?php echo date("d/m/Y H:i:s", strtotime($row['reservation_date'])); ?></td>
										<td><?php echo $row['bunglow_name']; ?></td>
										<td><?php echo date("d/m/Y", strtotime($row['arrival_date'])); ?></td>
										<td><?php echo date("d/m/Y", strtotime($row['leave_date'])); ?></td>
										<td>
											<select id="reservation_status" onchange="change_reservation_status('<?php echo $row['id'] ?>', this.value)">
												<option value="">--Select--</option>
												<option value="PENDING" <?php if($row['reservation_status']=="PENDING"){ echo "selected"; } ?>>Pending</option>
												<option value="CONFIRMED" <?php if($row['reservation_status']=="CONFIRMED"){ echo "selected"; } ?>>Confirmed</option>
											</select>
										</td>
										<td>
											<select id="payment_status" onchange="change_payment_status('<?php echo $row['id'] ?>', this.value)">
												<option value="">--Select--</option>
												<option value="PENDING" <?php if($row['payment_status']=="PENDING"){ echo "selected"; } ?>>Pending</option>
												<option value="COMPLETED" <?php if($row['payment_status']=="COMPLETED"){ echo "selected"; } ?>>Completed</option>
												<option value="CANCELLED" <?php if($row['payment_status']=="CANCELLED"){ echo "selected"; } ?>>Cancelled</option>
											</select>
										</td>
										<td>
											<select id="is_active" onchange="change_active_inactive('<?php echo $row['id'] ?>', this.value, '<?php echo date("d/m/Y", strtotime($row['leave_date'])); ?>')">
												<option value="">--Select--</option>
												<option value="ACTIVE" <?php if($row['is_active']=="ACTIVE"){ echo "selected"; } ?>>Active</option>
												<option value="DEACTIVE" <?php if($row['is_active']=="DEACTIVE"){ echo "selected"; } ?>>Deactive</option>
											</select>
										</td>
										<td align="center">
											<a href="<?php echo base_url(); ?>admin/users/invoice/<?php echo $row['id'] ?>">
												<img width="16px" height="16px" src="<?php echo base_url(); ?>assets/admin/images/icons/invoice.png" title="Generate Invoice" alt="">
											</a>
											<a href="<?php echo base_url(); ?>admin/payment/payment_edit/<?php echo $row['id'] ?>">
												<img width="16px" height="16px" src="<?php echo base_url(); ?>assets/admin/images/icons/user_edit.png" title="To edit click here" alt="">
											</a>
											<a href="<?php echo base_url().'admin/payment/viewdetails/'.$row['id'];?>"><img width="16px" height="16px" alt="" title="View Details" src="<?php echo base_url(); ?>assets/admin/images/icons/viewdetails.png"></a>
											<a onclick="delete_reservation('<?php echo $row['id'] ?>')" style="cursor:pointer;"><img width="16px" height="16px" alt="" title="To delete click here" src="<?php echo base_url(); ?>assets/admin/images/icons/trash-can-delete.png"></a>
										</td>
									</tr>
									<?php 
									$sl_no++;
								}
							}
							else 
							{
								?>
								<tr>
									<td colspan="8" align="center">No records found!</td>
								</tr>
								<?php 
							}
							?>
							
						</tbody>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
</section><!-- /.content -->

<div id="message_div" style="display:none;" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-envelope-o"></i>Increase Leave Date</h4>
			</div>
			<input type="hidden" name="reservation_id" id="reservation_id" class="form-control" value="">
			<input type="hidden" name="current_leave_date" id="current_leave_date" class="form-control" value="">
			<div class="modal-body" style="min-height:100px;">
				<div class="box-body">
					<div class="form-group">
						<label for="exampleInputPassword1">Leave Date</label>
						<div class='input-group date' id='leave_datepicker' style="width:50%;">
							<input type="text" name="leave_date" id="leave_date" class="form-control" readonly value="">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
						<div class="form-group has-error" id="leave_date_error" style="display:none;">
							<label class="control-label" for="inputError">
							<i class="fa fa-times-circle-o" id="leave_date_error_text"> Invalid Date</i>
							</label>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<input type="button" class="btn btn-primary" name="save" value="Submit" onclick="increase_leave_date()">
				</div>
				<div class="box-body" id="availability" style="margin-top:5px;">
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function() {
		$("#data_table").dataTable(
			{
				"aoColumnDefs" : [ { "bSortable" : false, "aTargets" : [ "sorting_disabled" ] } ],
				"iDisplayLength": <?php echo $pagination_limit; ?>,
				"oLanguage": {
				  "sInfo": "<?php echo lang('Showing'); ?> _START_ <?php echo lang('to'); ?> _END_ <?php echo lang('of'); ?> _TOTAL_ <?php echo lang('entries'); ?>",
				  "sSearch": "<?php echo lang('Search'); ?>: ",
				  "sLengthMenu": "_MENU_ <?php echo lang('records_per_page'); ?>",
				  "oPaginate": { "sPrevious": "<?php echo lang('Previous'); ?>", "sNext": "<?php echo lang('Next'); ?>" }
				}
			}
		);
		
		$("#data_table_wrapper .row").find(".col-xs-6").addClass("col-sm-6").addClass("col-xs-12");
		$("#data_table_wrapper .row").find(".col-xs-6").removeClass("col-xs-6");
		/*$('#example2').dataTable({
			"bPaginate": true,
			"bLengthChange": false,
			"bFilter": false,//For disabling Search Option
			"bSort": true,
			"bInfo": true,
			"bAutoWidth": false
		});*/
		});
</script>