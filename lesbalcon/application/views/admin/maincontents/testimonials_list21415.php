<?php /*?><script>
	function status_change(id, status)
	{
		if(status!="")
		{
			$.post("<?php echo base_url(); ?>admin/bunglow/ajax_testomial_status", { 'test_id':id, 'status':status }, 
			function(data)
			{
				window.location.reload();
			});
		}
	}
</script>
<?php */?><!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Testimonials
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url()."admin"; ?>"><i class="fa fa-dashboard"></i> <?php echo lang("Home"); ?></a></li>
		<?php /*?><li><a href="<?php echo base_url()."admin/bunglow/list_bunglow/".$default_language_id; ?>"><?php echo lang("Manage_Bunglow_Property"); ?></a></li><?php */?>
		<li class="active">Testimonials</li>
	</ol>
</section>
<!-- Main content -->
<?php 
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
	<?php
	foreach($language_arr as $language)
	{
		?>
		<a style="width:30px; margin-top:5px; float:left;" title="<?php echo $language['language_name']; ?>" href="<?php echo base_url(); ?>admin/testimonials/view_testimonials/<?php echo $language['id']; ?>">
			<img src="<?php echo base_url(); ?>assets/upload/flag/<?php echo $language['flag_image_name']; ?>">
		</a>
		<?php
	}
	?>
	
</div>

<div class="box_horizontal">
	<?php /*?><label style="margin-top:6px; margin-left:5px; float:left;"><?php echo $bunglow_name; ?></label><?php */?>
	<a href="<?php echo base_url(); ?>admin/testimonials/add_testimonials" class="btn btn-primary btn-flat"><?php echo lang("Add_New"); ?></a>
	<?php /*?><a href="<?php echo base_url(); ?>admin/testimonials/<?php echo $default_language_id; ?>" class="btn btn-primary btn-flat">BACK</a><?php */?>
</div>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<!--<div class="box-header">
					<h3 class="box-title">Data Table With Full Features</h3>                                    
				</div> -->
				
				<div class="box-body table-responsive">
					<table <?php if($all_rows){ echo 'id="data_table"'; } ?> class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>SL No.</th>
								<th>User Name</th>
								<th>User Email</th>
								<!--<th>Subject</th>-->
								<th>Created On</th>
								<th class="sorting_disabled">Status</th>
								<th>Action</th>
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
										<td><?php echo $row['user_name']; ?></td>
										<td><?php echo $row['user_email']; ?></td>
									    <?php /*?>	<td><?php echo $row['subject']; ?></td><?php */?>
									    <td><?php echo $row['user_email']; ?></td>
										<td><?php echo $row['status']; ?></td>
										<?php /*?><td align="center">
											<select name="status_change" id="status_change" class="form-control" style="width:120px;" onchange="status_change('<?php echo $row['id']; ?>', this.value)">
												<option value="">--SELECT--</option>
												<option value="PENDING" <?php if($row['status']=="PENDING"){ echo "selected"; } ?>>PENDING</option>
												<option value="APPROVED" <?php if($row['status']=="APPROVED"){ echo "selected"; } ?>>APPROVED</option> 
											</select>
										</td><?php */?>
										<td>
										<a href="<?php echo base_url().'admin/testimonials/edit_testimonials/'.$row['language_id']."/".$row['testimonials_id'];?>"><img width="16px" height="16px" alt="" title="To edit click here" src="<?php echo base_url(); ?>assets/admin/images/icons/user_edit.png"></a>
										<a onclick="return confirm('Are you sure to delete?')" href="<?php echo base_url().'admin/testimonials/delete_testimonials/'.$this->uri->segment(4).'/'.$row['testimonials_id'];?>"><img width="16px" height="16px" alt="" title="To delete click here" src="<?php echo base_url(); ?>assets/admin/images/icons/trash-can-delete.png"></a>
										<a style="cursor:pointer;" data-toggle="modal" data-target="#message_div<?php echo $row['id']; ?>"><img width="16px" height="16px" alt="" title="View Message" src="<?php echo base_url(); ?>assets/admin/images/icons/viewdetails.png"></a>
										</td>
									</tr>

									<div id="message_div<?php echo $row['id']; ?>" style="display:none;" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title"><i class="fa fa-envelope-o"></i>Testimonial</h4>
												</div>
												<div class="modal-body" style="min-height:100px;">
													<?php echo $row['content']; ?>
												</div>
											</div>
										</div>
									</div>

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