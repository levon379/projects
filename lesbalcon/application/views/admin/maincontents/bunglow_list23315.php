<script>
function change_order(id, current_order, changed_order)
{
	var max_order=parseInt($("#max_bunglow_order").val());
	if(changed_order.match(/[^0-9]/g))
	{
		alert("Invalid order value");
		return false;
	}
	if(changed_order=='')
	{
		alert("Please enter order number");
	}
	else if(parseInt(changed_order)==0)
	{
		alert("Sort order should not be 0");
	}
	else if(parseInt(changed_order)>max_order)
	{
		alert("Input order id more than max order");
	}
	else 
	{
		$.post("<?php echo base_url(); ?>admin/bunglow/change_order",{ "id":id, "current_order":current_order, "changed_order":changed_order }, function(data){
			 location.href="<?php echo site_url(uri_string()); ?>"; 
		});
	}
}
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Manage Bungalow/Property
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang("Home"); ?></a></li>
		<li class="active">Manage Bungalow</li>
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
	<?php
	foreach($language_arr as $language)
	{
		?>
		<a style="width:30px; margin-top:5px; float:left;" title="<?php echo $language['language_name']; ?>" href="<?php echo base_url(); ?>admin/bunglow/list_bunglow/<?php echo $language['id']; ?>">
			<img src="<?php echo base_url(); ?>assets/upload/flag/<?php echo $language['flag_image_name']; ?>">
		</a>
		<?php
	}
	?>
	<a href="<?php echo base_url(); ?>admin/bunglow/bunglow_add" class="btn btn-primary btn-flat">Add New</a>
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
								<th>Name</th>
								<th>Slug</th>
								<th class="sorting_disabled">Sort Order</th>
								<th class="sorting_disabled">Max Person</th>
								<th class="sorting_disabled">Is Featured</th>
								<th class="sorting_disabled">Status</th>
								<th width="15%" style="text-align:center!important;" class="sorting_disabled">Action</th>
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
										<td>
											<?php 
												echo substr($row['bunglow_name'],0, 20); 
												if(strlen($row['bunglow_name'])>20)
												{
													echo " ...";
												}
											?>
										</td>
										<td><?php echo $row['slug']; ?></td>
										<td align="center"><input type="text" style="width:50px; text-align:center;" name="sort_order" id="sort_order" value="<?php echo $row['sort_order']; ?>" onchange="change_order('<?php echo $row['bunglow_id']; ?>', '<?php echo $row['sort_order']; ?>', this.value)"></td>
										<td><?php echo $row['max_person']; ?></td>
										<td>
											<?php if($row['is_featured']=="Y")
											{ 
											?>
												<a href="<?php echo base_url().'admin/bunglow/set_featured/'.$row['bunglow_id'];?>" title="To unset featured click here"><font color="green">Featured</font></a>
											<?php 
											} 
											else 
											{ ?>
												<a href="<?php echo base_url().'admin/bunglow/set_featured/'.$row['bunglow_id'];?>" title="To set featured click here"><font color="red">Set Featured</font></a>
											<?php 
											} 
											?>
										</td>
										<td>
											<?php if($row['is_active']=="Y")
											{ 
											?>
												<a href="<?php echo base_url().'admin/bunglow/inactive/'.$row['bunglow_id'];?>" title="To inactive click here"><font color="green">Active</font></a>
											<?php 
											} 
											else 
											{ ?>
												<a href="<?php echo base_url().'admin/bunglow/active/'.$row['bunglow_id'];?>" title="To active click here"><font color="red">Inactive</font></a>
											<?php 
											} 
											?>
										</td>
										<td align="center">
											<a href="<?php echo base_url().'admin/bunglow/bunglow_edit/'.$row['language_id']."/".$row['bunglow_id'];?>"><img width="16px" height="16px" alt="" title="To edit click here" src="<?php echo base_url(); ?>assets/admin/images/icons/user_edit.png"></a>
											<a onclick="return confirm('Are you sure to delete?')" href="<?php echo base_url().'admin/bunglow/delete/'.$row['bunglow_id'];?>"><img width="16px" height="16px" alt="" title="To delete click here" src="<?php echo base_url(); ?>assets/admin/images/icons/trash-can-delete.png"></a>
											<a href="<?php echo base_url().'admin/bunglow/bunglow_image_list/'.$row['language_id']."/".$row['bunglow_id'];?>"><img width="16px" height="16px" alt="" title="View Bunglow Images" src="<?php echo base_url(); ?>assets/admin/images/icons/viewdetails.png"></a>
											<a href="<?php echo base_url().'admin/bunglow/view_testimonials/'.$row['language_id']."/".$row['bunglow_id'];?>"><img width="16px" height="16px" alt="" title="View Testimonials" src="<?php echo base_url(); ?>assets/admin/images/icons/viewtestimonials.png"></a>
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
						<!--<tfoot>
							<tr>
								<th>Rendering engine</th>
								<th>Browser</th>
								<th>Platform(s)</th>
								<th>Engine version</th>
								<th>CSS grade</th>
							</tr>
						</tfoot>-->
					</table>
					<input type="hidden" id="max_bunglow_order" value="<?php echo $max_order; ?>"/>
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