<?php 
$this->session->unset_userdata("referer_url");
?>
<script>
	function change_reservation_status(id, status)
	{
		$.post("<?php echo base_url(); ?>admin/payment/ajax_change_reservation_status", { "id":id, "status":status }, function(data){
			window.location.reload();
		});
	}
	function change_payment_status(id, status)
	{
		$.post("<?php echo base_url(); ?>admin/payment/ajax_change_payment_status", { "id":id, "status":status }, function(data){
			window.location.reload();
		});
	}
	function change_active_inactive(id, status, leave_date)
	{
		$('#leave_date').val(leave_date);
		$('#current_leave_date').val(leave_date);
		$('#reservation_id').val(id)
		if(status=="DEACTIVE")
		{
			$.post("<?php echo base_url(); ?>admin/payment/ajax_change_active_inactive", { "id":id, "status":status }, function(data){
				window.location.reload();
			});
		}
		else if(status=="ACTIVE")
		{
			$('#message_div').modal('show'); 
		}
		/*$.post("<?php echo base_url(); ?>admin/payment/ajax_change_active_inactive", { "id":id, "status":status }, function(data){
			window.location.reload();
		});*/
		
	}
	function delete_reservation(id)
	{
		var conf=confirm("Are you sure to delete?");
		if(conf==true)
		{
			$.post("<?php echo base_url(); ?>admin/payment/ajax_delete_payment", { "id":id}, function(data){
				window.location.reload();
			});
		}
	}
	
	function increase_leave_date()
	{
		var reservation_id=$('#reservation_id').val();
		
		var current_leave_date=$('#current_leave_date').val();
		var current_leave_date_arr=$("#current_leave_date").val().split("/");
		var current_leave_year=current_leave_date_arr[2];
		var current_leave_month=current_leave_date_arr[1];
		var current_leave_day=current_leave_date_arr[0];
		var new_current_leave_date= new Date(current_leave_year,(current_leave_month-1),current_leave_day);
		
		
		var leave_date=$('#leave_date').val();
		var leave_date_arr=$("#leave_date").val().split("/");
		var leave_year=leave_date_arr[2];
		var leave_month=leave_date_arr[1];
		var leave_day=leave_date_arr[0];
		var new_leave_date= new Date(leave_year,(leave_month-1),leave_day);
		
		var result=calcDate(new_current_leave_date, new_leave_date);

		if(result==0)
		{
			location.href=document.URL;
		}
		if(result>0)
		{
			$('#leave_date_error_text').html(" Invalid Date");
			$('#leave_date_error').show();
		}
		else 
		{
			$('#leave_date_error').hide();
			$.post("<?php echo base_url(); ?>admin/payment/ajax_increase_leave_date", { "reservation_id":reservation_id, "current_leave_date":current_leave_date, "leave_date":leave_date }, function(data){
				if(data.trim()=="available")
				{
					location.href=document.URL;
				}
				else if(data.trim()=="notavailable")
				{
					$('#leave_date_error_text').html(" Not Available")
					$('#leave_date_error').show();
				}
				else
				{
					$('#availability').html("Available on: "+data);
				}
			});	
		}
		/*$.post("<?php echo base_url(); ?>admin/payment/ajax_increase_leave_date", { "reservation_id":reservation_id, "leave_date":leave_date }, function(data){
			window.location.reload();
		});*/
	}
	function calcDate(date1,date2) 
	{
		var diff = Math.floor(date1.getTime() - date2.getTime());
		var day = 1000 * 60 * 60 * 24;

		var days = Math.floor(diff/day);
		var months = Math.floor(days/31);
		var years = Math.floor(months/12);

		return days;
	}
	function export_to_excel(value)
	{
		location.href="<?php echo base_url(); ?>admin/payment/download_as_excel/"+value;
	}
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang("Manage_Users");?> &raquo; <?php echo lang("Reservation");?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang("Home"); ?></a></li>
		<li><a href="<?php echo base_url(); ?>admin/users/list_users"> <?php echo lang("Manage_Users"); ?></a></li>
		<li class="active"><?php echo lang("Reservation");?></li>
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
		<b><?php echo lang("Data_Deleted_Successfully");?></b>
	</div>
	</section>
	<?php
}
if(isset($_GET["saved"]))
{
	?>
	<section class="content">
	<div class="alert alert-success alert-dismissable" style="margin-bottom:0px;">
		<i class="fa fa-check"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b><?php echo lang("Data_saved_Successfully");?></b>
	</div>
	</section>
	<?php
}
if(isset($_GET["mailsent"]))
{
	?>
	<section class="content">
	<div class="alert alert-success alert-dismissable" style="margin-bottom:0px;">
		<i class="fa fa-check"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b><?php echo lang("Invoice_sent_successfully");?></b>
	</div>
	</section>
	<?php
}
?>
<div class="box_horizontal">
	<a href="<?php echo base_url(); ?>admin/users/list_users" class="btn btn-primary btn-flat"><?php echo lang('Back'); ?></a>
</div>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				
				<div class="box-body table-responsive">
					<table <?php if($all_rows){ echo 'id="data_table"'; } ?> class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl. No</th>
								<th width="10%"><?php echo lang("Date");?></th>
								<th><?php echo lang("Bungalows");?></th>
								<th width="5%"><?php echo lang("Arrival");?></th>
								<th width="5%"><?php echo lang("Departure");?></th>
								<th width="10%" class="sorting_disabled"><?php echo lang("Reservation_Status");?></th>
								<th width="10%" class="sorting_disabled"><?php echo lang("Payment_Status");?></th>
								<th width="9%" class="sorting_disabled"><?php echo lang("Is_Active");?></th>
								<th width="15%" style="text-align:center!important;" class="sorting_disabled"><?php echo lang("Action");?></th>
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
										<td><?php echo date("d/m/Y H:i:s", strtotime($row['reservation_date'])); ?></td>
										<td><?php echo $row['bunglow_name']; ?></td>
										<td><?php echo date("d/m/Y", strtotime($row['arrival_date'])); ?></td>
										<td><?php echo date("d/m/Y", strtotime($row['leave_date'])); ?></td>
										<td>
											<select id="reservation_status" onchange="change_reservation_status('<?php echo $row['id'] ?>', this.value)">
												<option value="">--Select--</option>
												<option value="En attente" <?php if($row['reservation_status']=="En attente"){ echo "selected"; } ?>>En attente</option>
												<option value="Confirmé" <?php if($row['reservation_status']=="Confirmé"){ echo "selected"; } ?>>Confirmé</option>
												<option value="Payé" <?php if($row['reservation_status']=="Payé"){ echo "selected"; } ?>>Payé</option>
												<option value="Annulé" <?php if($row['reservation_status']=="Annulé"){ echo "selected"; } ?>>Annulé</option>
											</select>
										</td>
										<td>
											<select id="payment_status" onchange="change_payment_status('<?php echo $row['id'] ?>', this.value)">
												<option value="">--Select--</option>
												<option value="En Attente" <?php if($row['payment_status']=="En Attente"){ echo "selected"; } ?>>En Attente</option>
												<option value="Acompte Payé" <?php if($row['payment_status']=="Acompte Payé"){ echo "selected"; } ?>>Acompte Payé</option>
												<option value="Réglé" <?php if($row['payment_status']=="Réglé"){ echo "selected"; } ?>>Réglé</option>
											</select>
										</td>
										<td>
											<select id="is_active" onchange="change_active_inactive('<?php echo $row['id'] ?>', this.value, '<?php echo date("d/m/Y", strtotime($row['leave_date'])); ?>')">
												<option value="">--Select--</option>
												<option value="Activer" <?php if($row['is_active']=="Activer"){ echo "selected"; } ?>>Activer</option>
												<option value="Desactiver" <?php if($row['is_active']=="Desactiver"){ echo "selected"; } ?>>Desactiver</option>
											</select>
										</td>
										<td align="center">
											<a href="<?php echo base_url().'admin/users/invoice/'.$row['id'];?>"><img width="20px" height="20px" alt="" title="<?php echo lang('Generate Invoice');?>" src="<?php echo base_url(); ?>assets/admin/images/icons/invoice.png"></a>&nbsp;&nbsp;
											<a href="<?php echo base_url().'admin/payment/viewdetails/'.$row['id'];?>"><img width="20px" height="20px" alt="" title="<?php echo lang('VIEW_DETAILS');?>" src="<?php echo base_url(); ?>assets/admin/images/icons/viewdetails.png"></a>&nbsp;&nbsp;
											<a onclick="delete_reservation('<?php echo $row['id'] ?>')" style="cursor:pointer;"><img width="20px" height="20px" alt="" title="<?php echo lang('To_Delete_Click_Here');?>" src="<?php echo base_url(); ?>assets/admin/images/icons/trash-can-delete.png"></a>
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
									<td colspan="9" align="center"><?php echo lang('No_records_found')?></td>
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

<div id="message_div" style="display:none;" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-envelope-o"></i>Increase Leave Date</h4>
			</div>
			<input type="hidden" name="reservation_id" id="reservation_id" class="form-control" value="">
			<input type="hidden" name="current_leave_date" id="current_leave_date" class="form-control" value="">
			<div class="modal-body" style="min-height:100px;">
				<div class="box-body">
					<div class="form-group">
						<label for="exampleInputPassword1">Departure Date</label>
						<div class='input-group date' id='leave_datepicker' style="width:50%;">
							<input type="text" name="leave_date" id="leave_date" class="form-control" readonly value="">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
						<div class="form-group has-error" id="leave_date_error" style="display:none;">
							<label class="control-label" for="inputError">
							<i class="fa fa-times-circle-o" id="leave_date_error_text"> Invalid Date</i>
							</label>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<input type="button" class="btn btn-primary" name="save" value="Submit" onclick="increase_leave_date()">
				</div>
				<div class="box-body" id="availability" style="margin-top:5px;">
				</div>
			</div>
		</div>
	</div>
</div>

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
		
		$("#data_table_wrapper .row").find(".col-xs-6").addClass("col-sm-6").addClass("col-xs-12");
		$("#data_table_wrapper .row").find(".col-xs-6").removeClass("col-xs-6");
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