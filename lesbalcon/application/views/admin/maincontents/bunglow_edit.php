<?php  

require('assets/admin/ckeditor/ckeditor.php');
require('assets/admin/ckfinder/ckfinder.php');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang('Edit Bungalow');?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang('Home');?></a></li>
		<li class="active"><?php echo lang('Edit Bungalow');?></li>
	</ol>
</section>
<script>
	function check_form()
	{
		var virtual_tour_code = document.getElementById('virtual_tour_code').value;
		var str = virtual_tour_code;
		var res = str.replace("<iframe", "");
		res = res.replace("></iframe>", "");
		//var virtual_tour_code = $('#virtual_tour_code').val();
		//alert(res);
		//return false;
		//return true;
		$('#virtual_tour_code').val(res);
		//return true;
		var error=0;
		if($("#type").val()=="")
		{
			$("#type_error").show();
			error++;
		}
		else 
		{
			$("#type_error").hide();
		}
		/*if($("#bunglow_slug").val()=="")
		{
			$("#bunglow_slug_error").show();
			error++;
		}
		else 
		{
			$("#bunglow_slug_error").hide();
		}*/
		
		var image_arr=document.getElementsByName("bunglow_image[]");
		for(var i=0; i<image_arr.length; i++)
		{
			var image_name=image_arr[i].value;
			if(image_name!="")
			{
				var extension=image_name.split('.').pop();
				if(extension=="jpg" || extension=="jpeg" || extension=="gif" || extension=="png")
				{
					$("#bunglow_image_error").hide();
					continue;
				}
				else  
				{
					$("#bunglow_image_text").html("Only jpg, jpeg, gif, png file allowed");
					$("#bunglow_image_error").show();
					error++;
					break;
				}
			}
		}
		
		if($("#max_person").val().trim()=="")
		{
			$("#max_person_error").show();
			error++;
		}
		else  
		{
			$("#max_person_error").hide();
		}
		
		if($("#virtual_tour_code").val().trim()=="")
		{
			$("#virtual_tour_code_error").show();
			error++;
		}
		else
		{
			$("#virtual_tour_code_error").hide();
		}
		
		var language_ids=$("#language_id_arr").val();
		var language_id_arr=new Array();
		language_id_arr=language_ids.split("^");
		for(var x=0; x<language_id_arr.length; x++)
		{
			if($("#bunglow_name"+language_id_arr[x]).val().trim()=="")
			{
				$("#bunglow_name_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#bunglow_name_error"+language_id_arr[x]).hide();
			}
			if(CKEDITOR.instances['overview'+language_id_arr[x]].getData()=="")
			{
				$("#overview_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#overview_error"+language_id_arr[x]).hide();
			}
			if($("#meta_title"+language_id_arr[x]).val().trim()=="")
			{
				$("#meta_title_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#meta_title_error"+language_id_arr[x]).hide();
			}
			if($("#meta_keyword"+language_id_arr[x]).val().trim()=="")
			{
				$("#meta_keyword_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#meta_keyword_error"+language_id_arr[x]).hide();
			}
			if($("#meta_desc"+language_id_arr[x]).val().trim()=="")
			{
				$("#meta_desc_error"+language_id_arr[x]).show();
				error++;
			}
			else  
			{
				$("#meta_desc_error"+language_id_arr[x]).hide();
			}
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
	function add_more_image()
	{
		var div_row=document.createElement("div");
		div_row.setAttribute("class", "row");
		var div_md4=document.createElement("div");
		div_md4.setAttribute("class", "col-md-4");
		var input_name=document.createElement("input");
		input_name.setAttribute("type", "file");
		input_name.setAttribute("name", "bunglow_image[]");
		input_name.setAttribute("id", "bunglow_image[]");
		div_md4.appendChild(input_name);
		div_row.appendChild(div_md4);
		var language_ids=$("#language_id_arr").val();
		var language_id_arr=new Array();
		language_id_arr=language_ids.split("^");
		document.getElementById("img_div").appendChild(div_row);
		for(var i=0; i<language_id_arr.length; i++)
		{
			var div_md4=document.createElement("div");
			div_md4.setAttribute("class", "col-md-4");
			var input_caption=document.createElement("input");
			input_caption.setAttribute("type", "text");
			input_caption.setAttribute("name", "caption_lang"+language_id_arr[i]+"[]");
			input_caption.setAttribute("placeholder", "Caption");
			div_md4.appendChild(input_caption);
			div_row.appendChild(div_md4);
		}
		document.getElementById("img_div").appendChild(div_row);
	}
</script>
<!-- Main content -->
<?php 
if(isset($_GET["size"]))
{
	?>
	<section class="content" >
	<div class="alert alert-danger alert-dismissable" style="margin-bottom:0px;">
		<i class="fa fa-ban"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b><?php echo lang('L\'image ne doit pas être plus que 488px de large et 241px de haut'); ?></b>
	</div>
	</section>
	<?php
}
?>

<div class="box_horizontal">
	<a href="<?php echo base_url(); ?>admin/bunglow/list_bunglow/<?php echo $default_language_id; ?>" class="btn btn-primary btn-flat"><?php echo lang('Back');?></a>
</div>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<form role="form" id="form" action="<?php echo base_url(); ?>admin/bunglow/bunglow_edit/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5)?>" method="POST" enctype="multipart/form-data" onsubmit="return check_form()">
					<div class="box-body">
						<div class="horizontal_div_full">
							<?php echo lang('Set_Language_independent_content');?>
						</div>
						<input type="hidden" value="<?php echo $this->uri->segment(5); ?>" name="bunglow_id">
						<input type="hidden" value="<?php echo $this->uri->segment(4); ?>" name="language_id">
						<div class="form-group">
							<label for="exampleInputEmail1"><?php echo lang('TYPE');?><span style="color:red">*</span></label><br>
							<select name="type" id="type" class="form-control" style="width:50%;">
								<!--<option value="">--Select--</option>-->
								<option value="B" <?php if($bunglow_unique_details[0]['type']=="B"){ echo "selected";} ?>>Bungalow</option>
								<!--<option value="P" <?php if($bunglow_unique_details[0]['type']=="P"){ echo "selected";} ?>>Property</option>-->
							</select>
							<div class="form-group has-error" id="type_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('Type field is required');?></i>
								</label>
							</div>
						</div>
						<!-- <div class="form-group">
							<label for="exampleInputEmail1">OPTIONS</label><br>
							<?php
								$options_available=explode(",",$bunglow_unique_details[0]['option_id']);
								if(count($options_arr)>0)
								{
									foreach($options_arr as $options)
									{
										?>
										<input type="checkbox" name="bunglow_options[]" <?php if(in_array($options['options_id'], $options_available)){ echo "checked"; } ?> value=<?php echo $options['options_id'] ?> >&nbsp;<?php echo $options['options_name'] ?>&nbsp;&nbsp;
										<?php 
									}
								}
								else 
								{
									echo lang('Options Not Available');
								}
							?>
						</div> -->
						
						<div class="form-group">
							<label for="exampleInputEmail1"><?php echo lang('TAXES');?></label><br>
							<?php
								$tax_available=explode(",",$bunglow_unique_details[0]['tax_id']);
								if(count($tax_arr)>0)
								{
									foreach($tax_arr as $tax)
									{
										?>
										<input type="checkbox" name="bunglow_tax[]" <?php if(in_array($tax['tax_id'], $tax_available)){ echo "checked"; } ?> value=<?php echo $tax['tax_id'] ?> >&nbsp;<?php echo $tax['tax_name'] ?>&nbsp;&nbsp;
										<?php 
									}
								}
								else 
								{
									echo lang('Taxes Not Available').'.';
								}
							?>
						</div>
						
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('Slug');?></label>
							<input type="text" name="bunglow_slug" id="bunglow_slug" class="form-control" placeholder="Bungalow Slug" value="<?php echo $bunglow_unique_details[0]['slug']; ?>" readonly>
							<div class="form-group has-error" id="bunglow_slug_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('Bungalow Slug field is required');?></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1"><?php echo lang('BUNGALOW IMAGE');?><span style="color:red">*</span></label>
							<span class="text-light-blue"> <!--( Image size should be Width of 488px & Height of 241px )--></span>
							<a class="text-red" style="cursor:pointer; text-decoration:underline;" href="<?php echo base_url().'admin/bunglow/bunglow_image_list/'.$this->uri->segment(4)."/".$this->uri->segment(5);?>"><?php echo lang('Add_More');?></a>&nbsp;

							<!-- <div class="row">
								<div class="col-md-4">
									Image
								</div>
								<?php 
									foreach($language_arr as $language)
									{
										?>
										<div class="col-md-4">
											<img src="<?php echo base_url(); ?>assets/upload/flag/<?php echo $language['flag_image_name']; ?>"> 
										</div> 
										<?php 
									}
								?>
							</div>
							<div id="img_div">
								<div class="row" >
									<div class="col-md-4">
										<input type="file" name="bunglow_image[]" id="bunglow_image[]" />
									</div>
									<?php 
										foreach($language_arr as $language)
										{
											?>
											<div class="col-md-4">
												<input type="text" name="caption_lang<?php echo $language['id'] ?>[]" placeholder="Caption"/>
											</div> 
											<?php 
										}
									?>
								</div>
							</div>
							
							<div class="form-group has-error" id="bunglow_image_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o" id="bunglow_image_text"> Bungalow Image field is required</i>
								</label>
							</div> -->
						</div>
						
						<!-- <div class="form-group">
							<label for="exampleInputEmail1">SET FEATURED</label><br>
							<input type="radio" name="is_featured" value="Y" <?php if($bunglow_unique_details[0]['is_featured']=="Y"){ echo "checked";} ?>>&nbsp;Yes&nbsp;&nbsp;
							<input type="radio" name="is_featured" value="N" <?php if($bunglow_unique_details[0]['is_featured']=="N"){ echo "checked";} ?>>&nbsp;No
						</div> -->
						
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('Max Person');?><span style="color:red">*</span></label>
							<input type="text" name="max_person" id="max_person" class="form-control" placeholder="Max Person" value="<?php echo $bunglow_unique_details[0]['max_person']; ?>">
							<div class="form-group has-error" id="max_person_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"><?php echo lang('Max Person field is required');?></i>
								</label>
							</div>
						</div>
						
						<div class="form-group">
							<label for="exampleInputPassword1"><?php echo lang('VIRTUAL TOUR CODE');?><span style="color:red">*</span></label>
							<textarea class="form-control" placeholder="Virtual Tour Code" rows="3" name="virtual_tour_code" id="virtual_tour_code"><?php echo $bunglow_unique_details[0]['virtual_tour_code']; ?></textarea>
							<div class="form-group has-error" id="virtual_tour_code_error" style="display:none;">
								<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"> <?php echo lang('Virtual Tour Code field is required');?></i>
								</label>
							</div>
						</div>
						
						<div class="horizontal_div_full">
							<?php echo lang('Set_language_Specific_content');?>
						</div>
						<?php 
						$language_id_arr=array();
						foreach($bunglow_arr as $language)
						{
							array_push($language_id_arr, $language['id']);
							?>
							<div class="horizontal_div">
								<a style="cursor:pointer;" onclick="display_div('div_<?php echo $language['id']; ?>')">
								<img src="<?php echo base_url(); ?>assets/upload/flag/<?php echo $language['flag_image_name']; ?>">
								<?php echo lang('Define_content_for'); ?> <?php echo lang($language['language_name'].'1'); ?>
								</a>
							</div>
							<div id="div_<?php echo $language['id']; ?>">
								<div class="form-group">
									<label for="exampleInputPassword1"><?php echo lang('Bungalow_Name');?><span style="color:red">*</span></label>
									<input type="text" name="bunglow_name<?php echo $language['id'] ?>" id="bunglow_name<?php echo $language['id'] ?>" class="form-control" placeholder="Bungalow Name" value="<?php echo $language['bunglow_name']; ?>">
									<div class="form-group has-error" id="bunglow_name_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> <?php echo lang('Bungalow Name field is required');?></i>
										</label>
									</div>
								</div>
								
								<div class="form-group">
									<label for="exampleInputPassword1"><?php echo lang('BUNGALOW OVERVIEW');?><span style="color:red">*</span></label>
									<?php								
										$basePathUrl=base_url()."assets/admin";
										$CKEditor = new CKEditor();
										$CKEditor->basePath = base_url().'assets/admin/ckeditor/';
										$CKEditor->config['height'] = 200;
										$CKEditor->config['width'] = '100%';
										$CKEditor->config['uiColor'] = "#E4ECEF";
								
										//########################################################################//
										//################ SET ckfinder PATH FOR IMAGE UPLOAD ####################//
										//########################################################################//
								
										$CKEditor->config['filebrowserBrowseUrl'] = $basePathUrl."/ckfinder/ckfinder.html";
										$CKEditor->config['filebrowserImageBrowseUrl'] = $basePathUrl."/ckfinder/ckfinder.html?Type=Images";
										$CKEditor->config['filebrowserFlashBrowseUrl'] = $basePathUrl."/ckfinder/ckfinder.html?Type=Flash";
										$CKEditor->config['filebrowserUploadUrl'] = $basePathUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files";
										$CKEditor->config['filebrowserImageUploadUrl'] = $basePathUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images";
										$CKEditor->config['filebrowserFlashUploadUrl'] = $basePathUrl."/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash";
								
										//########################################################################//
										//################ SET ckfinder PATH FOR IMAGE UPLOAD ####################//
										//########################################################################//
								
										$CKEditor->returnOutput = true;
										$code = $CKEditor->editor("overview".$language['id'], $language['bunglow_overview']);
										echo $code;
									?>
									<div class="form-group has-error" id="overview_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> <?php echo lang('Bungalow Overview field is required');?></i>
										</label>
									</div>
								</div>
								
								<div class="form-group">
									<label for="exampleInputPassword1"><?php echo lang('Meta_Title');?><span style="color:red">*</span></label>
									<input type="text" name="meta_title<?php echo $language['id'] ?>" id="meta_title<?php echo $language['id'] ?>" class="form-control" placeholder="Meta Title" value="<?php echo $language['meta_title']; ?>">
									<div class="form-group has-error" id="meta_title_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> <?php echo lang('Meta Title field is required');?></i>
										</label>
									</div>
								</div>
								
								<div class="form-group">
									<label for="exampleInputPassword1"><?php echo lang('Meta_Keyword');?><span style="color:red">*</span></label>
									<input type="text" name="meta_keyword<?php echo $language['id'] ?>" id="meta_keyword<?php echo $language['id'] ?>" class="form-control" placeholder="Meta Keyword" value="<?php echo $language['meta_keyword']; ?>">
									<div class="form-group has-error" id="meta_keyword_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> <?php echo lang('Meta Keyword field is required');?></i>
										</label>
									</div>
								</div>
								
								<div class="form-group">
									<label for="exampleInputPassword1"><?php echo lang('META DESCRIPTION');?><span style="color:red">*</span></label>
									<input type="text" name="meta_desc<?php echo $language['id'] ?>" id="meta_desc<?php echo $language['id'] ?>" class="form-control" placeholder="Meta Description" value="<?php echo $language['meta_description']; ?>">
									<div class="form-group has-error" id="meta_desc_error<?php echo $language['id'] ?>" style="display:none;">
										<label class="control-label" for="inputError">
										<i class="fa fa-times-circle-o"> <?php echo lang('Meta Description field is required');?></i>
										</label>
									</div>
								</div>
							</div>
							<?php 
						}
						?>
						<input type="hidden" value="<?php echo implode("^", $language_id_arr); ?>" name="language_id_arr" id="language_id_arr">
					</div><!-- /.box-body -->
					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="save" id="save" value="<?php echo lang('Submit');?>">
					</div>
				</form>
			</div><!-- /.box -->
		</div>
	</div>   <!-- /.row -->
</section><!-- /.content -->