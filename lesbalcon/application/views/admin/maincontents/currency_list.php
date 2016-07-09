<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Manage Currency
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Manage Currency</li>
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
?>

<div class="box_horizontal">
	<?php
	foreach($language_arr as $language)
	{
		?>
		<a style="width:30px; margin-top:5px; float:left;" title="<?php echo $language['language_name']; ?>" href="<?php echo base_url(); ?>admin/currency/list_currency/<?php echo $language['id']; ?>">
			<img src="<?php echo base_url(); ?>assets/upload/flag/<?php echo $language['flag_image_name']; ?>">
		</a>
		<?php
	}
	?>
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
								<th class="sorting_disabled">SL No.</th>
								<th class="sorting_disabled">Currency Name</th>
								<th class="sorting_disabled">Currency Symbol</th>
								<th class="sorting_disabled">Currency Code</th>
								<th class="sorting_disabled">Base Currency</th>
								<th class="sorting_disabled">Default</th>
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
										<td><?php echo ucfirst($row['currency_name']); ?></td>
										<td><?php echo $row['currency_symbol']; ?></td>
										<td><?php echo $row['currency_code']; ?></td>
										<td>
											<?php 
												if($row['is_base_currency']=="Y")
												{
													?>
													<font color="green">Base Currency</font>
													<?php
												}
												else
												{
													?>
													<!--<a href="<?php echo base_url().'admin/currency/set_base_currency/'.$row['currency_auto_id'];?>" title="To set as base currency click here"><font color="red" style="text-decoration:underline;">Set as Base Currency</font></a>-->
													--------
													<?php
												}
											?>
										</td>
										<td>
											<?php 
											if($row['set_as_default']=="Y")
											{ 
											?>
												<font color="green">Default</font>
											<?php 
											} 
											else 
											{ 
											?>
												<!--<a href="<?php echo base_url().'admin/currency/set_default/'.$row['currency_auto_id'];?>" title="To set as default click here"><font color="red" style="text-decoration:underline;" >Set as default</font></a>-->
												--------
											<?php 
											} 
											?>
										</td>
										<td align="center">
											<a href="<?php echo base_url().'admin/currency/currency_edit/'.$row['language_id']."/".$row['currency_auto_id'];?>"><img width="16px" height="16px" alt="" title="To edit click here" src="<?php echo base_url(); ?>assets/admin/images/icons/user_edit.png"></a>
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