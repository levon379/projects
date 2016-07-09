<script>
function change_order(id, current_order, changed_order)
{
	var max_order=parseInt($("#max_banner_order").val());
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
		$.post("<?php echo base_url(); ?>admin/banner/change_order",{ "id":id, "current_order":current_order, "changed_order":changed_order }, function(data){
			 location.href="<?php echo site_url(uri_string()); ?>"; 
		});
	}
}
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang("Manage_Banners"); ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang("Home"); ?></a></li>
		<li class="active"><?php echo lang("Manage_Banners"); ?></li>
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
		<a style="width:30px; margin-top:5px; float:left;" title="<?php echo $language['language_name']; ?>" href="<?php echo base_url(); ?>admin/banner/list_banner/<?php echo $language['id']; ?>">
			<img src="<?php echo base_url(); ?>assets/upload/flag/<?php echo $language['flag_image_name']; ?>">
		</a>
		<?php
	}
	?>
	<a href="<?php echo base_url(); ?>admin/banner/banner_add" class="btn btn-primary btn-flat"><?php echo lang("Add_New"); ?></a>
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
								<th><?php echo lang("Banner_Title"); ?></th>
								<th class="sorting_disabled"><?php echo lang("Banner Image"); ?></th>
								<th class="sorting_disabled"><?php echo lang("Sort Order"); ?></th>
								<th class="sorting_disabled"><?php echo lang('Status');?></th>
								<th style="text-align:center!important;" class="sorting_disabled">Action</th>
							</tr>
						</thead>
						<tbody> <?php 
						
							if($all_rows){	
								$sl_no=1;
								foreach($all_rows as $row){ ?>
									<tr>
										<td><?php echo $sl_no; ?></td>
										<td><?php echo $row['banner_title']; ?></td>
										<td><img src="<?php echo base_url();?>assets/upload/banner/thumb/<?php echo $row['banner_image']; ?>" height="100" width="100" title="<?php echo $row['banner_title']; ?>" alt="<?php echo $row['banner_alt']; ?>" /></td>
										<td align="center"><input type="text" style="width:50px; text-align:center;" name="sort_order" id="sort_order" value="<?php echo $row['sort_order']; ?>" onchange="change_order('<?php echo $row['banner_id']; ?>', '<?php echo $row['sort_order']; ?>', this.value)"></td>
										<td><?php 
											if($row['is_active']=="Y"){ ?>
												<a id="status_id_<?php echo $row['banner_id']; ?>" onclick="banner_inactive('<?php echo $row['banner_id']; ?>')" href="javascript:void(0);"><font color="green"><?php echo lang('Active');?></font></a> <?php /*
												<a href="<?php echo base_url().'admin/banner/inactive/'.$row['banner_id'];?>" title="To inactive click here"><font color="green">Active</font></a> <?php */
											}else{ ?>
												<a id="status_id_<?php echo $row['banner_id']; ?>" onclick="banner_active('<?php echo $row['banner_id']; ?>')" href="javascript:void(0);"><font color="red"><?php echo lang('Inactive');?></font></a> <?php /*
												<a href="<?php echo base_url().'admin/banner/active/'.$row['banner_id'];?>" title="To active click here"><font color="red">Inactive</font></a> <?php */
											} ?>
										</td>
										<td align="center">
											<a href="<?php echo base_url().'admin/banner/banner_edit/'.$row['language_id']."/".$row['banner_id'];?>"><img width="16px" height="16px" alt="" title="<?php echo lang('To_Edit_Click_Here');?>" src="<?php echo base_url(); ?>assets/admin/images/icons/user_edit.png"></a>
											<?php /* <a onclick="return confirm('Are you sure to delete?')" href="<?php echo base_url().'admin/banner/delete/'.$row['banner_id'];?>"><img width="16px" height="16px" alt="" title="To delete click here" src="<?php echo base_url(); ?>assets/admin/images/icons/trash-can-delete.png"></a> */ ?>
											<a id="id_<?php echo $row['banner_id']; ?>" onclick="delete_banner('<?php echo $row['banner_id']; ?>')" href="javascript:void(0);"><img width="16px" height="16px" alt="" title="<?php echo lang('To_Delete_Click_Here');?>" src="<?php echo base_url(); ?>assets/admin/images/icons/trash-can-delete.png"></a>
										</td>
									</tr> <?php 
									$sl_no++;
								}
							}else{?>
								<tr>
									<td colspan="6" align="center"><?php echo lang('No_records_found');?></td>
								</tr> <?php 
							} ?> 
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
					<input type="hidden" id="max_banner_order" value="<?php echo $max_order; ?>"/>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
</section><!-- /.content -->
<script type="text/javascript">

	function banner_active(id){
		var url = window.location.href; 
		url		= url.split("?")[0];
		window.history.pushState("Les Balcons | Admin", "Les Balcons | Admin", url);
		img = '<span class="loading" style="position:relative;"><img src="<?php echo base_url(); ?>assets/images/loading.gif" title="Please wait" alt="Please wait" style="position:absolute; height:12px; margin-left:-14px; top:5px;" /></span>';
		jQuery("#status_id_"+id).append(img);
		$.post("<?php echo base_url(); ?>admin/banner/active_ajx", { "id":id }, function(data){
			window.location.reload(); 
		});
	}
	
	function banner_inactive(id){
		var url = window.location.href; 
		url		= url.split("?")[0];
		window.history.pushState("Les Balcons | Admin", "Les Balcons | Admin", url);
		img = '<span class="loading" style="position:relative;"><img src="<?php echo base_url(); ?>assets/images/loading.gif" title="Please wait" alt="Please wait" style="position:absolute; height:12px; margin-left:-14px; top:5px;" /></span>';
		jQuery("#status_id_"+id).append(img);
		$.post("<?php echo base_url(); ?>admin/banner/inactive_ajx", { "id":id }, function(data){
			window.location.reload(); 
		});
	}
	
	
	function delete_banner(id){
		var url = window.location.href; 
		url		= url.split("?")[0]; 				
		if (url.indexOf('?') > -1){
		   url += '&deleted'
		}else{
		   url += '?deleted'
		} 
		window.history.pushState("Les Balcons | Admin", "Les Balcons | Admin", url);
		
		var confirm_msg = confirm('Are you sure to delete?');
		img = '<span class="loading" style="position:relative;"><img src="<?php echo base_url(); ?>assets/images/loading.gif" title="Please wait" alt="Please wait" style="position:absolute; height:12px; margin-left:-14px; top:5px;" /></span>';
		jQuery("#id_"+id).append(img);
			
		if (confirm_msg == true){
			$.post("<?php echo base_url(); ?>admin/banner/delete_ajx", { "id":id }, function(data){
				window.location.reload(); 
			});
		}else{
			jQuery(".loading").remove(); 
			return false;
		}
	}
	
	
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