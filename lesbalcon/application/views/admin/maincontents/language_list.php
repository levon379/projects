<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang("Manage_Language"); ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang("Home"); ?></a></li>
		<li class="active"><?php echo lang("Manage_Language"); ?></li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<!--<div class="box-header">
					<h3 class="box-title">Data Table With Full Features</h3>                                    
				</div> -->
				
				<div class="box-body table-responsive">
					<table <?php if($rows){ echo 'id="data_table"'; } ?> class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="sorting_disabled">SL No.</th>
								<th class="sorting_disabled"><?php echo lang("Language_Name"); ?></th>
								<th class="sorting_disabled"><?php echo lang("Language_Code"); ?></th>
								<th class="sorting_disabled"><?php echo lang("Flag"); ?></th>
								<th class="sorting_disabled"><?php echo lang("Status"); ?></th>
								<th style="text-align:center!important;" class="sorting_disabled">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if($rows)
							{	
								$sl_no=1;
								foreach($rows as $row)
								{
									if($row['language_name']=="English")
									{
										$language_name="English";
									}
									if($row['language_name']=="French")
									{
										$language_name="Française";
									}
									?>
									<tr>
										<td><?php echo $sl_no; ?></td>
										<td><?php echo $language_name; ?></td>
										<td><?php echo $row['language_code']; ?></td>
										<td><img src="<?php echo base_url();?>assets/upload/flag/<?php echo $row['flag_image_name']; ?>" height="24" width="24" /></td>
										<td>
											<?php 
											if($row['is_active']=="Y")
											{ 
											?>
												<a href="<?php echo base_url().'admin/language/inactive/'.$row['id'];?>" title="<?php echo lang("To_Inactive_Click_Here"); ?>"><font color="green"><?php echo lang("Active"); ?></font></a>
											<?php 
											} 
											else 
											{ 
											?>
												<a href="<?php echo base_url().'admin/language/active/'.$row['id'];?>" title="<?php echo lang("To_Active_Click_Here"); ?>"><font color="red"><?php echo lang("Inactive"); ?></font></a>
											<?php 
											} 
											?>
										</td>
										<td align="center">
											<?php 
											if($row['set_as_default']=="Y")
											{ 
											?>
												<font color="green"><?php echo lang("Default"); ?></font>
											<?php 
											} 
											else 
											{ 
											?>
												<a href="<?php echo base_url().'admin/language/set_default/'.$row['id'];?>" title="<?php echo lang("To_Set_As_Default_Click_Here"); ?>"><font color="red" style="text-decoration:underline;"><?php echo lang("Set_as_default"); ?></font></a>
											<?php 
											} 
											?>
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
									<td colspan="6" align="center">No records found!</td>
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
				"bPaginate": false,
				"bInfo": false,
				"bFilter": false
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