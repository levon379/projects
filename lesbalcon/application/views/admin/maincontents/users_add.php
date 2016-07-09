<?php  
require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Add Users
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Add Users</li>
	</ol>
</section>
<script>
	function check_form()
	{
		var error=0;
		if($("#user_language").val()=="")
		{
			$("#user_language_error").show();
			error++;
		}
		else  
		{
			$("#user_language_error").hide();
		}
		if($("#user_name").val().trim()=="")
		{
			$("#user_name_error").show();
			error++;
		}
		else  
		{
			$("#user_name_error").hide();
		}
		if($("#user_email").val().trim()=="")
		{
			$("#user_email_error").show();
			error++;
		}
		else if($("#user_email").val()!="")
		{
			var email=$("#user_email").val();
			//var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
			var reg = /^[a-zA-z0-9._%+-]+@[a-zA-z0-9.-]+\.[a-zA-z]{2,63}$/;
			if (!reg.test(email)) 
			{	
				$("#user_email_error_text").html(" Enter valid email address");
				$("#user_email_error").show();
				error++;
			}
			else 
			{
				$("#user_email_error_text").html(" Email field is required");
				$("#user_email_error").hide();
			}
		}
		if($("#user_password").val().trim()=="")
		{
			$("#user_password_error").show();
			error++;
		}
		else  
		{
			$("#user_password_error").hide();
		}
		if($("#user_contact").val().trim()=="")
		{
			$("#user_contact_error").show();
			error++;
		}
		else  
		{
			$("#user_contact_error").hide();
		}
		if($("#user_address").val().trim()=="")
		{
			$("#user_address_error").show();
			error++;
		}
		else  
		{
			$("#user_address_error").hide();
		}
		if(error>0)
		{
			$(window).scrollTop($("#form").offset().top);
			return false;
		}
	}
	function display_div(div_id)
	{
		$("#"+div_id).slideToggle("slow");
	}
	function validate_numeric_field(value, text_field_id)
	{
		if(value.match(/[^0-9]/g))
		{
			document.getElementById(text_field_id).value=value.replace(/[^0-9]/g, '');
		}
	}
	function add_more_links()
	{
		var input_length=document.getElementsByName("more_links[]").length;
		var div=document.createElement("div");
		div.setAttribute("id", "more_links_div_"+(parseInt(input_length)+1));
		div.setAttribute("style", "margin-top:5px;");
		var input=document.createElement("input");
		input.setAttribute("type", "text");
		input.setAttribute("class", "form-control");
		input.setAttribute("name", "more_links[]");
		input.setAttribute("style", "width:50%;");
		var anchor=document.createElement("a");
		anchor.innerHTML="Remove";
		anchor.setAttribute("style", "cursor:pointer; text-decoration:none; width:55%;");
		anchor.setAttribute("onclick", "remove_link('more_links_div_"+(parseInt(input_length)+1)+"')");
		div.appendChild(input);
		div.appendChild(anchor);
		document.getElementById("more_links_div").appendChild(div);
	}
	
	function remove_link(div_id)
	{
		document.getElementById(div_id).remove();
	}
	function generate_password()
	{
		$.post("<?php echo base_url(); ?>admin/users/get_new_password", function(data){
			$("#user_password").val(data.trim());
		})
	}
</script>
<!-- Main content -->
<?php 
if(isset($_GET["exists"]))
{
	?>
	<section class="content" >
	<div class="alert alert-danger alert-dismissable" style="margin-bottom:0px;">
		<i class="fa fa-ban"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b><?php echo "User already exists."; ?></b>
	</div>
	</section>
	<?php
}
?>
<div class="box_horizontal">
	<a href="<?php echo base_url(); ?>admin/users/list_users" class="btn btn-primary btn-flat">BACK</a>
</div>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/users/users_add" method="POST" enctype="multipart/form-data" onsubmit="return check_form()">
					<div class="box-body">
						<div class="form-group">
							<label for="exampleInputPassword1">USER LANGUAGE<span style="color:red">*</span></label>
							<select name="user_language" id="user_language" class="form-control">
								<option value="">--Select--</option>
								<?php 
								
								foreach($language_arr as $language)
								{
									?>
									<option value="<?php echo $language['id'] ?>"><?php echo $language['language_name']; ?></option>	
									<?php 
								}
								?>
							</select>
							<div class="form-group has-error" id="user_language_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> User Language field is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">NAME<span style="color:red">*</span></label>
							<input type="text" name="user_name" id="user_name" class="form-control">
							<div class="form-group has-error" id="user_name_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Name field is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">EMAIL<span style="color:red">*</span></label>
							<input type="text" name="user_email" id="user_email" class="form-control">
							<div class="form-group has-error" id="user_email_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="user_email_error_text"> Password field is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">PASSWORD<span style="color:red">*</span></label>
							<input type="text" name="user_password" id="user_password" class="form-control">
							<label style="background-color:#367fa9; margin-top:5px; text-align:center; width:150px; float:right;">
								<a style="cursor:pointer; color:#fff; text-decoration:none;" onclick="generate_password()">Generate Password</a>
							</label>
							<div class="form-group has-error" id="user_password_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Email field is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">CONTACT NO.<span style="color:red">*</span></label>
							<input type="text" name="user_contact" id="user_contact" class="form-control" onkeyup="validate_numeric_field(this.value, this.id)">
							<div class="form-group has-error" id="user_contact_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Contact No. field is required</i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">ADDRESS<span style="color:red">*</span></label>
							<textarea name="user_address" id="user_address" class="form-control"></textarea>
							<div class="form-group has-error" id="user_address_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> Address field is required</i>
								</label>
							</div>
						</div>
						
						<div class="form-group">
							<label for="exampleInputPassword1">NOTES (Optional)</label>
							<textarea name="user_notes" id="user_notes" class="form-control"></textarea>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">LINKS (Optional)</label>
							<div id="more_links_div">
								<div id="more_links_div_1">
									<input class="form-control" type="text" value="" style="width:50%;" name="more_links[]">
								</div>
							</div>
							<label><a class="text-red" style="cursor:pointer; text-decoration:underline;" onclick="add_more_links()">+Add More Links</a></label>
						</div>
					</div><!-- /.box-body -->
					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="save" value="Submit">
					</div>
				</form>
			</div><!-- /.box -->
		</div>
	</div>   <!-- /.row -->
</section><!-- /.content -->