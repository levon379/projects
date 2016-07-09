<?php 
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
			//location.href="<?php echo base_url(); ?>admin/payment/active";
		}
		else if(type=="deactivated")
		{
			//location.href="<?php echo base_url(); ?>admin/payment/deactivated";
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
	function change_active_inactive(id, status)
	{
		$.post("<?php echo base_url(); ?>admin/payment/ajax_change_active_inactive", { "id":id, "status":status }, function(data){
			window.location.reload();
		});
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
if(isset($_GET["inserted"]))
{
	?>
	<section class="content">
	<div class="alert alert-success alert-dismissable" style="margin-bottom:0px;">
		<i class="fa fa-check"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b><?php echo "Data Inserted Successfully"; ?></b>
	</div>
	</section>
	<?php
}
if(isset($_GET["updated"]))
{
	?>
	<section class="content">
	<div class="alert alert-success alert-dismissable" style="margin-bottom:0px;">
		<i class="fa fa-check"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b><?php echo "Data Updated Successfully"; ?></b>
	</div>
	</section>
	<?php
}
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
								<th width="15%">Date</th>
								<th>Bungalow</th>
								<th width="10%">Arrival</th>
								<th width="10%">Leave</th>
								<th class="sorting_disabled" width="15%">Reservation Status</th>
								<th class="sorting_disabled" width="15%">Payment Status</th>
								<th class="sorting_disabled" width="10%">Is Active</th>
								<th class="sorting_disabled">Action</th>
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
										<td><?php echo date("d/m/Y h:i:s", strtotime($row['reservation_date'])); ?></td>
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
											<select id="is_active" onchange="change_active_inactive('<?php echo $row['id'] ?>', this.value)">
												<option value="">--Select--</option>
												<option value="ACTIVE" <?php if($row['is_active']=="ACTIVE"){ echo "selected"; } ?>>Active</option>
												<option value="DEACTIVE" <?php if($row['is_active']=="DEACTIVE"){ echo "selected"; } ?>>Deactive</option>
											</select>
										</td>
										<td>
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
<script type="text/javascript">
	$(function() {
		$("#data_table").dataTable(
			{
				"aoColumnDefs" : [ { "bSortable" : false, "aTargets" : [ "sorting_disabled" ] } ],
				"iDisplayLength": '<?php echo $pagination_limit; ?>',
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