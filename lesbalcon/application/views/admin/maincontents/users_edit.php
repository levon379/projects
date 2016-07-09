<?php  

require('assets/admin/ckeditor/ckeditor.php');

require('assets/admin/ckfinder/ckfinder.php');

?>

<!-- Content Header (Page header) -->

<section class="content-header">

	<h1>

		<?php echo lang("Edit_Users");?>

	</h1>

	<ol class="breadcrumb">

		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang("Home");?></a></li>

		<li class="active"><?php echo lang("Edit_Users");?></li>

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

		if($("#user_contact").val().trim()=="")

		{

			$("#user_contact_error").show();

			error++;

		}

		else  

		{

			$("#user_contact_error").hide();

		}

		/*if($("#user_address").val().trim()=="")

		{

			$("#user_address_error").show();

			error++;

		}

		else  

		{

			$("#user_address_error").hide();

		}*/

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

		<b><?php echo lang("User_already_exists");?></b>

	</div>

	</section>

	<?php

}

?>

<div class="box_horizontal">

	<a href="<?php echo base_url(); ?>admin/users/list_users" class="btn btn-primary btn-flat"><?php echo lang("Back");?></a>

</div>

<section class="content">

	<div class="row">

		<div class="col-md-12">

			<!-- general form elements -->

			<div class="box box-primary">

				<form role="form" id="form" action="<?php echo base_url(); ?>admin/users/users_edit/<?php echo $this->uri->segment(4); ?>" method="POST" enctype="multipart/form-data" onsubmit="return check_form()">

					<div class="box-body">

						<input type="hidden" name="user_id" id="user_id" value="<?php echo $this->uri->segment(4); ?>">

						<div class="form-group">

							<label for="exampleInputPassword1"><?php echo lang("USER_LANGUAGE");?><span style="color:red">*</span></label>

							<select name="user_language" id="user_language" class="form-control">

								<option value="">--Select--</option>

								<?php 

								foreach($language_arr as $language)

								{

									?>

									<option value="<?php echo $language['id'] ?>" <?php if($users_arr[0]['user_language']==$language['id']){ echo "selected"; } ?>><?php echo $language['language_name']; ?></option>	

									<?php 

								}

								?>

							</select>

							<div class="form-group has-error" id="user_language_error" style="display:none;">

								<label class="control-label" for="inputError">

								<i class="fa fa-times-circle-o"> <?php echo lang("User_Language_field_is_required");?></i>

								</label>

							</div>

						</div>

						<div class="form-group">

							<label for="exampleInputPassword1"><?php echo lang("Name");?><span style="color:red">*</span></label>

							<input type="text" name="user_name" id="user_name" class="form-control" value="<?php echo $users_arr[0]['name']; ?>">

							<div class="form-group has-error" id="user_name_error" style="display:none;">

								<label class="control-label" for="inputError">

								<i class="fa fa-times-circle-o"> <?php echo lang("Name_field_is_required");?></i>

								</label>

							</div>

						</div>

						<div class="form-group">

							<label for="exampleInputPassword1"><?php echo lang("Emailer");?><span style="color:red">*</span></label>

							<input type="text" name="user_email" id="user_email" class="form-control" value="<?php echo $users_arr[0]['email']; ?>" >

							<div class="form-group has-error" id="user_email_error" style="display:none;">

								<label class="control-label" for="inputError">

								<i class="fa fa-times-circle-o" id="user_email_error_text"><?php echo lang("Password_field_is_required");?></i>

								</label>

							</div>

						</div>

						<div class="form-group">

							<label for="exampleInputPassword1"><?php echo lang("Contact_no");?><span style="color:red">*</span></label>

							<input type="text" name="user_contact" id="user_contact" class="form-control" onkeyup="validate_numeric_field(this.value, this.id)" value="<?php echo $users_arr[0]['contact_number']; ?>">

							<div class="form-group has-error" id="user_contact_error" style="display:none;">

								<label class="control-label" for="inputError">

								<i class="fa fa-times-circle-o"><?php echo lang("Contact_No_field_is_required");?></i>

								</label>

							</div>

						</div>

						<div class="form-group">

							<label for="exampleInputPassword1"><?php echo lang("AddressPay");?><!-- <span style="color:red">*</span> --></label>

							<textarea name="user_address" id="user_address" class="form-control"><?php echo $users_arr[0]['address']; ?></textarea>

							<!-- <div class="form-group has-error" id="user_address_error" style="display:none;">

								<label class="control-label" for="inputError">

								<i class="fa fa-times-circle-o"><?php echo lang("Address_field_is_required");?></i>

								</label>

							</div> -->

						</div>

						

						<div class="form-group">

							<label for="exampleInputPassword1"><?php echo lang("NOTES_Optional");?></label>

							<textarea name="user_notes" id="user_notes" class="form-control"><?php echo $users_arr[0]['contact_number']; ?></textarea>

						</div>

						<div class="form-group">

							<label for="exampleInputPassword1"><?php echo lang("LINKS_Optional");?></label>

							<div id="more_links_div">

								<?php 

								if($users_arr[0]['more_links']!="")

								{

									$more_links_arr=explode("^", $users_arr[0]['more_links']);

									$i=1;

									foreach($more_links_arr as $links)

									{

										?>

										<div id="more_links_div_<?php echo $i; ?>">

											<input type="text" name="more_links[]" class="form-control" style="width:50%; <?php if($i!=1){ echo "margin-top:5px;"; } ?>" value="<?php echo $links; ?>">

											<?php 

											if($i!=1)

											{

												?>

												<a style="cursor:pointer; text-decoration:none; width:55%;" onclick="remove_link('more_links_div_<?php echo $i; ?>')">Remove</a>

												<?php 

											} 

											?>

										</div>

										<?php

										$i++;

									}

								}

								else 

								{

									?>

									<div id="more_links_div_1">

										<input class="form-control" type="text" value="" style="width:50%;" name="more_links[]">

									</div>

									<?php

								}

								?>

							</div>

							<label><a class="text-red" style="cursor:pointer; text-decoration:underline;" onclick="add_more_links()"><?php echo lang("+Add More LinksModifier les utilisateurs");?></a></label>

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