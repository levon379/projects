<script>
function mark(item)
{
	var all_check_boxes=document.getElementsByName("email_id[]");
	var selected_value=new Array();
	if(all_check_boxes.length>0)
	{
		for(var i=0; i<all_check_boxes.length; i++)
		{
			if(all_check_boxes[i].checked)
			{
				selected_value.push(all_check_boxes[i].value);
			}
		}
		if(selected_value.length>0)
		{
			var joined_arr=selected_value.join("^");
			var conf=confirm("Are You Sure ?");
			if(conf==true)
			{
				$.post("<?php echo base_url(); ?>admin/mail_box/ajax_delete_sent_mail", { "selected_value":joined_arr}, function(data){
					location.href="<?php echo base_url(); ?>admin/mail_box/sent_mail"
				});
			}
		}
		else 
		{
			alert("Please select a mail");
		}
	}
}
</script>
<!-- Content Header (Page header) -->
<style>
    .modal-open{ overflow: visible !important;}
    html, body{ overflow-x: visible !important;}
    .modal{ max-height: 1500px !important;}
</style>
<section class="content-header">
	<h1>
		Mailbox
	</h1>
</section>
<!-- Main content -->
<section class="content">
	<!-- MAILBOX BEGIN -->
	<div class="mailbox row">
		<div class="col-xs-12">
			<div class="box box-solid">
				<div class="box-body">
					<div class="row">
						<div class="col-md-3 col-sm-4">
							<!-- BOXES are complex enough to move the .box-header around.
								 This is an example of having the box header within the box body -->
							<div class="box-header">
								<i class="fa fa-mail-forward"></i>
								<h3 class="box-title">SENT MAILS</h3>
							</div>
							<!-- Navigation - folders-->
							<div style="border:1px solid #ccc;">
								<ul class="nav nav-pills nav-stacked">
									<li><a href="<?php echo base_url(); ?>admin/mail_box/inbox"><i class="fa fa-inbox"></i> <?php echo lang('Inbox'); ?> (<?php echo $total_inbox_email; ?>)</a></li>
									<li class="active"><a href="<?php echo base_url(); ?>admin/mail_box/sent_mail"><i class="fa fa-mail-forward"></i> <?php echo lang('Sent_Mail'); ?> (<?php echo $total_sent_email; ?>)</a></li>
									<li ><a href="<?php echo base_url(); ?>admin/mail_box/contacts_list"><i class="fa fa-user"></i> Contacts (<?php echo $total_contacts; ?>)</a></li>
								</ul>
							</div>
						</div><!-- /.col (LEFT) -->
						<div class="col-md-9 col-sm-8">
							<div class="row pad">
								<div class="col-sm-6">
									<label style="margin-right: 10px;">
										<input type="checkbox" id="check-all"/>
									</label>
									<!-- Action button -->
									<div class="btn-group">
										<select id="action" name="action" onchange="if(this.value != '') {mark(this.value);}">
											<option value="">- <?php echo lang("Action"); ?> -</option>
											<option value="DELETED"><?php echo lang("Delete"); ?></option>
										</select>
										<!-- <button type="button" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
											Action <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li><a style="cursor:pointer;" onclick="mark('DELETED')">Delete</a></li>
										</ul> -->
									</div>
								</div>
							</div><!-- /.row -->
							<div class="table-responsive">
								<!-- THE MESSAGES -->
								<table class="table table-mailbox">
									<tr>
										<th></th>
										<th><?php echo lang("From"); ?></th>
										<th><?php echo lang("Subjects"); ?></th>
										<th><?php echo lang("Time"); ?></th>
									</tr>
									<?php 
									if(count($all_sent_email_arr)>0)
									{
										foreach($all_sent_email_arr as $email)
										{
											?>
											<tr>
												<td class="small-col"><input type="checkbox" value="<?php echo $email['id']; ?>" name="email_id[]"/></td>
												<td class="name"><a style="cursor:pointer;" data-toggle="modal" data-target="#compose-modal<?php echo $email['id']; ?>"><?php echo $email['receiver_email']; ?></a></td>
												<td class="subject"><a style="cursor:pointer;" data-toggle="modal" data-target="#compose-modal<?php echo $email['id']; ?>"><?php echo $email['subject']; ?></a></td>
												<td class="time"><?php echo $email['time']; ?></td>
											</tr>
											<div class="modal fade" id="compose-modal<?php echo $email['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title"><i class="fa fa-envelope-o"></i>Message</h4>
														</div>
														<div class="modal-body" style="min-height:100px;">
															<?php echo $email['message']; ?>
														</div>
													</div>
												</div>
											</div>
											<?php 
										}
									}
									else 
									{
										?>
										<tr>
											<td align="center" colspan="4">No records found!</td>
										</tr>
										<?php 
									}
									?>
									
								</table>
							</div><!-- /.table-responsive -->
						</div><!-- /.col (RIGHT) -->
					</div><!-- /.row -->
				</div><!-- /.box-body -->
				<div class="box-footer clearfix">
					<div class="pull-right">
						<?php 
						if($total_records>count($all_sent_email_arr))
						{
							echo $pagination_link;
						}
						?>
					</div>
				</div><!-- box-footer -->
			</div><!-- /.box -->
		</div><!-- /.col (MAIN) -->
	</div>
	<!-- MAILBOX END -->
</section><!-- /.content -->