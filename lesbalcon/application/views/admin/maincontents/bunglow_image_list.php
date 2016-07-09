<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang('Bungalow Images');?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url()."admin"; ?>"><i class="fa fa-dashboard"></i> <?php echo lang("Home"); ?></a></li>
		<li><a href="<?php echo base_url()."admin/bunglow/list_bunglow/".$default_language_id; ?>"><?php echo lang("Manage_Bunglow_Property"); ?></a></li>
		<li class="active"><?php echo lang('Bungalow Images');?></li>
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
		<b><?php echo lang('Data_Inserted_Successfully');; ?></b>
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
		<b><?php echo lang("Data_Updated_Successfully"); ?></b>
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
		<b><?php echo lang("Data_Deleted_Successfully"); ?></b>
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
		<a style="width:30px; margin-top:5px; float:left;" title="<?php echo $language['language_name']; ?>" href="<?php echo base_url(); ?>admin/bunglow/bunglow_image_list/<?php echo $language['id']; ?>/<?php echo $this->uri->segment(5); ?>">
			<img src="<?php echo base_url(); ?>assets/upload/flag/<?php echo $language['flag_image_name']; ?>">
		</a>
		<?php
	}
	?>
	<a href="<?php echo base_url(); ?>admin/bunglow/bunglow_image_add/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5); ?>" class="btn btn-primary btn-flat"><?php echo lang("Add_New"); ?></a>
	<a href="<?php echo base_url(); ?>admin/bunglow/list_bunglow/<?php echo $default_language_id; ?>" class="btn btn-primary btn-flat"><?php echo lang('Back');?></a>
</div>
<div class="box_horizontal">
	<label style="margin-top:6px; margin-left:5px; float:left;"><?php echo $bunglow_name; ?></label>
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
								<th><?php echo lang('Image');?></th>
								<th class="sorting_disabled"><?php echo lang('Caption');?></th>
								<th class="sorting_disabled"><?php echo lang('Status');?></th>
								<th style="text-align:center!important;" class="sorting_disabled">Action</th>
							</tr>
						</thead>
						
						<tbody><?php 
						
							if($all_rows){
								$sl_no=1;
								foreach($all_rows as $row){ ?>
									<tr>
										<td><?php echo $sl_no; ?></td>
										<td><img src="<?php echo base_url();?>assets/upload/bunglow/thumb/<?php echo $row['image']; ?>" height="100" width="100" /></td>
										<td><?php echo $row['caption']; ?></td>
										<td><?php 
											if($row['is_active']=="Y"){ ?>
												<a id="status_id_<?php echo $row['id']; ?>" onclick="image_inactive('<?php echo $row['id']; ?>')" href="javascript:void(0);"><font color="green"><?php echo lang('Active');?></font></a> <?php /*
												<a href="<?php echo base_url().'admin/bunglow/image_inactive/'.$row['language_id'].'/'.$row['bunglow_id'].'/'.$row['id'];?>"><font color="green">Active</font></a> */
											}else{ ?>
												<a id="status_id_<?php echo $row['id']; ?>" onclick="image_active('<?php echo $row['id']; ?>')" href="javascript:void(0);"><font color="red"><?php echo lang('Inactive');?></font></a> <?php /*
												<a href="<?php echo base_url().'admin/bunglow/image_active/'.$row['language_id'].'/'.$row['bunglow_id'].'/'.$row['id'];?>"><font color="red">Inactive</font></a> */
											} ?>
										</td>
										<td align="center">
											<a href="<?php echo base_url().'admin/bunglow/bunglow_image_edit/'.$row['language_id']."/".$row['bunglow_id'].'/'.$row['id'];?>"><img width="20px" height="20px" alt="" title="<?php echo lang('To_Edit_Click_Here');?>" src="<?php echo base_url(); ?>assets/admin/images/icons/user_edit.png"></a>
											<?php /* <a onclick="return confirm('Are you sure to delete?')" href="<?php echo base_url().'admin/bunglow/image_delete/'.$row['language_id']."/".$row['bunglow_id'].'/'.$row['id'];?>"><img width="20px" height="20px" alt="" title="To delete click here" src="<?php echo base_url(); ?>assets/admin/images/icons/trash-can-delete.png"></a> */ ?>
											<a id="id_<?php echo $row['id']; ?>" onclick="delete_bunglow('<?php echo $row['id']; ?>')" href="javascript:void(0);"><img width="16px" height="16px" alt="" title="<?php echo lang('To_Delete_Click_Here');?>" src="<?php echo base_url(); ?>assets/admin/images/icons/trash-can-delete.png"></a>
										</td>
									</tr><?php 
									$sl_no++;
								}
							}else{ ?>
								<tr>
									<td colspan="5" align="center"><?php echo lang('No_records_found');?></td>
								</tr><?php 
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
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
</section><!-- /.content -->
<script type="text/javascript">

	function image_active(id){
		var url = window.location.href; 
		url		= url.split("?")[0];
		window.history.pushState("Les Balcons | Admin", "Les Balcons | Admin", url);
		img = '<span class="loading" style="position:relative;"><img src="<?php echo base_url(); ?>assets/images/loading.gif" title="Please wait" alt="Please wait" style="position:absolute; height:12px; margin-left:-14px; top:5px;" /></span>';
		jQuery("#status_id_"+id).append(img);
		$.post("<?php echo base_url(); ?>admin/bunglow/image_active_ajx", { "id":id }, function(data){
			window.location.reload(); 
		});
	}
	
	function image_inactive(id){
		var url = window.location.href; 
		url		= url.split("?")[0];
		window.history.pushState("Les Balcons | Admin", "Les Balcons | Admin", url);
		img = '<span class="loading" style="position:relative;"><img src="<?php echo base_url(); ?>assets/images/loading.gif" title="Please wait" alt="Please wait" style="position:absolute; height:12px; margin-left:-14px; top:5px;" /></span>';
		jQuery("#status_id_"+id).append(img);
		$.post("<?php echo base_url(); ?>admin/bunglow/image_inactive_ajx", { "id":id }, function(data){
			window.location.reload(); 
		});
	}
	
	function delete_bunglow(id){
		
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
			$.post("<?php echo base_url(); ?>admin/bunglow/image_delete_ajx", { "id":id }, function(data){
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