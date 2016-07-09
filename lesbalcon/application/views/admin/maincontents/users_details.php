<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang("Manage_Users"); ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang("Home"); ?></a></li>
		<li class="active"><?php echo lang("Manage_Users"); ?></li>
	</ol>
</section>
<!-- Main content -->
<div class="box_horizontal">
	<a href="<?php echo base_url(); ?>admin/users/list_users" class="btn btn-primary btn-flat"><?php echo lang("Back"); ?></a>
</div>
		
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th><?php echo lang("Particulars"); ?></th>
								<th><?php echo lang("Details"); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo lang("Name"); ?>:</td>
								<td><?php echo $users_details_arr[0]['name']; ?></td>
							</tr>
							<tr>
								<td><?php echo lang("Email"); ?>:</td>
								<td><?php echo $users_details_arr[0]['email']; ?></td>
							</tr>
							<tr>
								<td><?php echo lang("ContactNumber"); ?>:</td>
								<td><?php echo $users_details_arr[0]['contact_number']; ?></td>
							</tr>
							<tr>
								<td><?php echo lang("AddressPay"); ?>:</td>
								<td><?php echo $users_details_arr[0]['address']; ?></td>
							</tr>
							<tr>
								<td><?php echo lang("Home"); ?>:</td>
								<td><?php echo $users_details_arr[0]['notes']; ?></td>
							</tr>
							<tr>
								<td><?php echo lang('More Links');?><?php //echo lang("Home"); ?>:</td>
								<td>
									<?php 
										if($users_details_arr[0]['more_links']!="")
										{
											$more_links_arr=explode("^", $users_details_arr[0]['more_links']);
											echo implode(", ", $more_links_arr);
										}
										else 
										{
											echo "N/A";
										}
									?>
								</td>
							</tr>
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
				"iDisplayLength": 5
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