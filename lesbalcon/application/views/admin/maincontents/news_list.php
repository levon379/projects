<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang("Manage_News"); ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang("Home"); ?></a></li>
		<li class="active"><?php echo lang("Manage_News"); ?></li>
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
		<b><?php echo lang("Data_Inserted_Successfully"); ?></b>
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
		<a style="width:30px; margin-top:5px; float:left;" title="<?php echo $language['language_name']; ?>" href="<?php echo base_url(); ?>admin/news/list_news/<?php echo $language['id']; ?>">
			<img src="<?php echo base_url(); ?>assets/upload/flag/<?php echo $language['flag_image_name']; ?>">
		</a>
		<?php
	}
	?>
	<a href="<?php echo base_url(); ?>admin/news/news_add" class="btn btn-primary btn-flat"><?php echo lang("Add_New"); ?></a>
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
								<th><?php echo lang("Title"); ?></th>
								<th><?php echo lang("Content"); ?></th>
								<th class="sorting_disabled"><?php echo lang("Status"); ?></th>
								<th class="sorting_disabled"><?php echo lang("Is_Featured"); ?></th>
								<th style="text-align:center!important;" class="sorting_disabled">Action</th>
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
												echo substr($row['title'],0, 20); 
												if(strlen($row['title'])>20)
												{
													echo " ...";
												}
											?>
										</td>
										<td>
											<?php 
												echo substr(strip_tags($row['content']),0, 80); 
												if(strlen(strip_tags($row['content']))>80)
												{
													echo " ...";
												}
											?>
										</td>
										<td>
											<?php if($row['is_active']=="Y")
											{ 
											?>
												<a href="<?php echo base_url().'admin/news/inactive/'.$row['news_id'];?>" title="<?php echo lang("To_Inactive_Click_Here"); ?>"><font color="green"><?php echo lang("Active"); ?></font></a>
											<?php 
											} 
											else 
											{ ?>
												<a href="<?php echo base_url().'admin/news/active/'.$row['news_id'];?>" title="<?php echo lang("To_Active_Click_Here"); ?>"><font color="red"><?php echo lang("Inactive"); ?></font></a>
											<?php 
											} 
											?>
										</td>
										<td>
											<?php if($row['is_featured']=="Y")
											{ 
											?>
												<a href="<?php echo base_url().'admin/news/set_featured/'.$row['news_id'];?>" title="<?php echo lang("To_unset_featured_click_here"); ?>"><font color="green"><?php echo lang("Featured"); ?></font></a>
											<?php 
											} 
											else 
											{ ?>
												<a href="<?php echo base_url().'admin/news/set_featured/'.$row['news_id'];?>" title="<?php echo lang("To_set_featured_click_here"); ?>"><font color="red"><?php echo lang("Set_Featured"); ?></font></a>
											<?php 
											} 
											?>
										</td>
										<td align="center">
											<a href="<?php echo base_url().'admin/news/news_edit/'.$row['language_id']."/".$row['news_id'];?>"><img width="16px" height="16px" alt="" title="<?php echo lang("To_Edit_Click_Here"); ?>" src="<?php echo base_url(); ?>assets/admin/images/icons/user_edit.png"></a>
											<a onclick="return confirm('<?php echo lang("Are_you_sure_to_delete"); ?>?')" href="<?php echo base_url().'admin/news/delete/'.$row['news_id'];?>"><img width="16px" height="16px" alt="" title="<?php echo lang("To_Delete_Click_Here"); ?>" src="<?php echo base_url(); ?>assets/admin/images/icons/trash-can-delete.png"></a>
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