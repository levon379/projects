<!-- Content Header (Page header) -->
<?php 
	$uri_segment= $this->uri->segment(4); 
	if($uri_segment=="unregistered")
	{
		$bread_crumb="Unregistered";
	}
	else 
	{
		$bread_crumb="Registered";
	}
?>
<section class="content-header">
	<h1>
		<?php echo lang("Manage_Users"); ?> &raquo; <?php echo $bread_crumb; ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang("Home"); ?></a></li>
		<li class="active"><?php echo lang("Manage_Users"); ?></li>
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
<script>
	function redirect_to_page(value)
	{
		if(value=="registered")
		{
			location.href="<?php echo base_url(); ?>admin/users/list_users";
		}
		else 
		{
			location.href="<?php echo base_url(); ?>admin/users/list_users/"+value;
		}
	}
</script>	 	

<div class="box_horizontal">
	<select name="change_type" id="change_type" style="float:left; width:25%;" class="form-control" onchange="redirect_to_page(this.value)">
		<option value="registered" <?php if($uri_segment==""){ echo "selected"; } ?>>Registered</option>
		<option value="unregistered" <?php if($uri_segment=="unregistered"){ echo "selected"; } ?>>Unregistered</option>
	</select>
	<a href="<?php echo base_url(); ?>admin/users/users_add" class="btn btn-primary btn-flat"><?php echo lang("Add_New"); ?></a>
</div>
		
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body table-responsive">
					<table <?php if($all_rows){ echo 'id="data_table"'; } ?> class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>SL No.</th>
								<th>Language</th>
								<th>Name</th>
								<th>Email</th>
								<th>Contact No.</th>
								<th>Status</th>
								<th style="text-align:center!important;"  class="sorting_disabled">Action</th>
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
										<td><?php echo $row['user_language_name']; ?></td>
										<td><?php echo $row['name']; ?></td>
										<td><?php echo $row['email']; ?></td>
										<td><?php echo $row['contact_number']; ?></td>
										<td>
											<?php 
											if($row['status']=="A")
											{ 
											?>
												<a href="<?php echo base_url().'admin/users/close/'.$row['id'];?>" title="To close account click here"><font color="green">Active</font></a>
											<?php 
											} 
											else if($row['status']=="C")
											{ ?>
												<a href="<?php echo base_url().'admin/users/active/'.$row['id'];?>" title="To active account click here"><font color="red">Closed</font></a>
											<?php 
											} 
											?>
										</td>
										<td align="center">
											<a href="<?php echo base_url().'admin/users/users_edit/'.$row['id'];?>"><img width="16px" height="16px" alt="" title="To edit click here" src="<?php echo base_url(); ?>assets/admin/images/icons/user_edit.png"></a>
											<a onclick="return confirm('Are you sure to delete?')" href="<?php echo base_url().'admin/users/delete/'.$row['id'];?>"><img width="16px" height="16px" alt="" title="To delete click here" src="<?php echo base_url(); ?>assets/admin/images/icons/trash-can-delete.png"></a>
											<a href="<?php echo base_url().'admin/users/users_details/'.$row['id'];?>"><img width="16px" height="16px" alt="" title="To view details click here" src="<?php echo base_url(); ?>assets/admin/images/icons/viewdetails.png"></a>
											<?php 
											if($row['user_type']=="R")
											{
												?>
												<a href="<?php echo base_url().'admin/users/change_password/'.$row['id'];?>"><img width="16px" height="16px" alt="" title="To change password click here" src="<?php echo base_url(); ?>assets/admin/images/icons/change_password.png"></a>
												<?php 
											}
											?>
											<a href="<?php echo base_url().'admin/users/reservation/'.$row['id'];?>"><img width="16px" height="16px" alt="" title="To view reservation click here" src="<?php echo base_url(); ?>assets/admin/images/icons/reservation.png"></a>
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
									<td colspan="7" align="center">No records found!</td>
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
				"iDisplayLength": <?php echo $pagination_limit; ?>,
				"oLanguage": {
				  "sInfo": "<?php echo lang('Showing'); ?> _START_ <?php echo lang('to'); ?> _END_ <?php echo lang('of'); ?> _TOTAL_ <?php echo lang('entries'); ?>",
				  "sSearch": "<?php echo lang('Search'); ?>: ",
				  "sLengthMenu": "_MENU_ <?php echo lang('records_per_page'); ?>",
				  "oPaginate": { "sPrevious": "<?php echo lang('Previous'); ?>", "sNext": "<?php echo lang('Next'); ?>" }
				}
			}
		);
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