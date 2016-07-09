<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang("Contact_Details"); ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang("Home"); ?></a></li>
		<li class="active"><?php echo lang("Contact_Details"); ?></li>
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
		<b><?php echo lang("Data_Deleted_Successfully"); ?></b>
	</div>
	</section>
	<?php
}
?>
		
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body table-responsive">
					<table <?php if($all_rows){ echo 'id="data_table"'; } ?> class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>SL No.</th>
								<th><?php echo lang("Name"); ?></th>
								<th>Email</th>
								<th class="sorting_disabled">Phone No.</th>
								<th class="sorting_disabled">Date</th>
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
										<td><?php echo $row['name']; ?></td>
										<td><?php echo $row['email']; ?></td>
										<td><?php echo $row['contact_no']; ?></td>
										<td><?php echo $row['created_time']; ?></td>
										<td>
											<a onclick="return confirm('<?php echo lang("Are_you_sure_to_delete"); ?>?')" href="<?php echo base_url().'admin/contacts/delete/'.$row['id'];?>"><img width="16px" height="16px" alt="" title="<?php echo lang("To_Delete_Click_Here"); ?>" src="<?php echo base_url(); ?>assets/admin/images/icons/trash-can-delete.png"></a>
											<a style="cursor:pointer;" data-toggle="modal" data-target="#message_div<?php echo $row['id']; ?>"><img width="16px" height="16px" alt="" title="View Message" src="<?php echo base_url(); ?>assets/admin/images/icons/viewdetails.png"></a>
										</td>
									</tr>
									<div id="message_div<?php echo $row['id']; ?>" style="display:none;" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title"><i class="fa fa-envelope-o"></i>Message</h4>
												</div>
												<div class="modal-body" style="min-height:100px;">
													<?php echo $row['message']; ?>
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
									<td colspan="5" align="center"><?php echo lang("No_records_found"); ?></td>
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