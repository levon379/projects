<script>
function calcDate(date1,date2) 
{
    var diff = Math.floor(date1.getTime() - date2.getTime());
    var day = 1000 * 60 * 60 * 24;
    var days = Math.floor(diff/day);
    var months = Math.floor(days/31);
    var years = Math.floor(months/12);
    return days;
}
function validate_desktop_search()
{
	var error=0;
	/*if($("#search_keyword").val().trim()=="" && $("#search_arrival_date").val().trim()=="" && $("#search_leave_date").val().trim()=="")
	{
		$("#search_error").html("<?php echo lang('Enter_keyword_or_dates'); ?>");
		$("#search_error").show();
		error++;
	}*/
	if($("#search_keyword").val().trim()=="" && $("#search_arrival_date").val().trim()=="" && $("#search_leave_date").val().trim()=="")
	{
		$("#search_error").html("<?php echo lang('Enter_keyword_or_dates'); ?>");
		$("#search_error").show();
		error++;
	}
	else
	{
		$("#search_error").html("");
		$("#search_error").hide();
		
		if($("#search_arrival_date").val().trim()!="")
		{
			var arrival_date=$("#search_arrival_date").val();
			var arival_date_arr=$("#search_arrival_date").val().split("/");
			
			var valyear=arival_date_arr[2];
			var valmonth=arival_date_arr[1];
			var valday=arival_date_arr[0];
			var today = new Date()
			var new_arrival_date= new Date(valyear,(valmonth-1),valday);
			var result=calcDate(today, new_arrival_date);
			if(result>0)
			{
				$("#search_arrival_date_error").html("<?php echo lang('Past_date_not_allowed'); ?>");
				error++;
			}
			else 
			{
				$("#search_arrival_date_error").html("");
			}
			
			if($("#search_leave_date").val().trim()=="")
			{
				$("#search_leave_date_error").html("<?php echo lang('Check_Out_is_required'); ?>");
				error++;
			}
			else 
			{
				$("#search_leave_date_error").html("");
			}
		}
		if($("#search_leave_date").val().trim()!="")
		{
			var arrival_date=$("#search_arrival_date").val();
			var arival_date_arr=$("#search_arrival_date").val().split("/");
			var valyear=arival_date_arr[2];
			var valmonth=arival_date_arr[1];
			var valday=arival_date_arr[0];
			var today = new Date()
			var new_arrival_date= new Date(valyear,(valmonth-1),valday);
			
			var leave_date=$("#search_leave_date").val();
			var leave_date_arr=$("#search_leave_date").val().split("/");
			var leave_year=leave_date_arr[2];
			var leave_month=leave_date_arr[1];
			var leave_day=leave_date_arr[0];
			var new_leave_date= new Date(leave_year,(leave_month-1),leave_day);
			
			var result=calcDate(new_arrival_date, new_leave_date);
			
			if(result>0)
			{
				$("#search_leave_date_error").html("<?php echo lang('Must_be_greater_than_Check_In'); ?>");
				error++;
			}
			else 
			{
				$("#search_leave_date_error").html("");
			}
			
			if($("#search_arrival_date").val().trim()=="")
			{
				$("#search_arrival_date_error").html("<?php echo lang('Check_In_is_required'); ?>");
				error++;
			}
			else 
			{
				var arrival_date=$("#search_arrival_date").val();
				var arival_date_arr=$("#search_arrival_date").val().split("/");
				var valyear=arival_date_arr[2];
				var valmonth=arival_date_arr[1];
				var valday=arival_date_arr[0];
				var today = new Date()
				var new_arrival_date= new Date(valyear,(valmonth-1),valday);
				var result=calcDate(today, new_arrival_date);
				if(result>0)
				{
					$("#search_arrival_date_error").html("<?php echo lang('Past_date_not_allowed'); ?>");
					error++;
				}
				else 
				{
					$("#search_arrival_date_error").html("");
				}
			}
		}
	}
	if(error>0)
	{
		return false;
	}
	else
	{
		$("#desktop_search_form").submit();
	}
}

function validate_mobile_search()
{
	var error=0;
	var error=0;
	if($("#mobile_search_keyword").val().trim()=="" && $("#mobile_search_arrival_date").val().trim()=="" && $("#mobile_search_leave_date").val().trim()=="")
	{
		$("#mobile_search_error").html("<?php echo lang('Enter_keyword_or_dates'); ?>");
		$("#mobile_search_error").show();
		error++;
	}
	else
	{
		$("#mobile_search_error").html("");
		$("#mobile_search_error").hide();
		
		if($("#mobile_search_arrival_date").val().trim()!="")
		{
			var arrival_date=$("#mobile_search_arrival_date").val();
			var arival_date_arr=$("#mobile_search_arrival_date").val().split("/");
			
			var valyear=arival_date_arr[2];
			var valmonth=arival_date_arr[1];
			var valday=arival_date_arr[0];
			var today = new Date()
			var new_arrival_date= new Date(valyear,(valmonth-1),valday);
			var result=calcDate(today, new_arrival_date);
			if(result>0)
			{
				$("#mobile_search_arrival_date_error").html("<?php echo lang('Past_date_not_allowed'); ?>");
				error++;
			}
			else 
			{
				$("#mobile_search_arrival_date_error").html("");
			}
			if($("#mobile_search_leave_date").val().trim()=="")
			{
				$("#mobile_search_leave_date_error").html("<?php echo lang('Check_Out_is_required'); ?>");
				error++;
			}
			else 
			{
				$("#mobile_search_leave_date_error").html("");
			}
		}
		if($("#mobile_search_leave_date").val().trim()!="")
		{
			var arrival_date=$("#mobile_search_arrival_date").val();
			var arival_date_arr=$("#mobile_search_arrival_date").val().split("/");
			var valyear=arival_date_arr[2];
			var valmonth=arival_date_arr[1];
			var valday=arival_date_arr[0];
			var today = new Date()
			var new_arrival_date= new Date(valyear,(valmonth-1),valday);
			
			var leave_date=$("#mobile_search_leave_date").val();
			var leave_date_arr=$("#mobile_search_leave_date").val().split("/");
			var leave_year=leave_date_arr[2];
			var leave_month=leave_date_arr[1];
			var leave_day=leave_date_arr[0];
			var new_leave_date= new Date(leave_year,(leave_month-1),leave_day);
			
			var result=calcDate(new_arrival_date, new_leave_date);
			
			if(result>0)
			{
				$("#mobile_search_leave_date_error").html("<?php echo lang('Must_be_greater_than_Check_In'); ?>");
				error++;
			}
			else 
			{
				$("#mobile_search_leave_date_error").html("");
			}
			
			if($("#mobile_search_arrival_date").val().trim()=="")
			{
				$("#mobile_search_arrival_date_error").html("<?php echo lang('Check_In_is_required'); ?>");
				error++;
			}
			else 
			{
				var arrival_date=$("#mobile_search_arrival_date").val();
				var arival_date_arr=$("#mobile_search_arrival_date").val().split("/");
				
				var valyear=arival_date_arr[2];
				var valmonth=arival_date_arr[1];
				var valday=arival_date_arr[0];
				var today = new Date()
				var new_arrival_date= new Date(valyear,(valmonth-1),valday);
				var result=calcDate(today, new_arrival_date);
				if(result>0)
				{
					$("#mobile_search_arrival_date_error").html("<?php echo lang('Past_date_not_allowed'); ?>");
					error++;
				}
				else 
				{
					$("#mobile_search_arrival_date_error").html("");
				}
			}
		}
	}
	if(error>0)
	{
		return false;
	}
	else
	{
		$("#mobile_search_form").submit();
	}
}
</script>


<!-- Search For Mobile--->
<div class="row search-container">
    <div class="container">
      <div class="row">
        <form class="form-horizontal" id="mobile_search_form" action="search/mobile" method="POST">
          <fieldset>
		  <div class="col-xs-12">
			<label id="mobile_search_error" style="display:none; color:red;"></label>
		  </div>
          <div class="col-xs-12">
            <label class="bunglowhd"><?php echo lang('Bungalow') ?> <span><?php echo lang('Search') ?></span></label>
          </div>
          <div class="col-xs-12">
           <?php /*?> <input id="mobile_search_keyword" name="mobile_search_keyword" placeholder="<?php echo lang('Keyword') ?>" class="form-control input-md" type="text"><?php */?>
			 <select name="mobile_search_keyword" class="form-control input-md" id="mobile_search_keyword">
			  <option value="">Please select Persons</option>
			  <option value="1">1</option>
			  <option value="2">2</option>
			  <option value="3">3</option>
			  <option value="4">4</option>
			  <option value="5">5</option>
			  <option value="6">6</option>
			  <option value="7">7</option>
			  <option value="8">8</option>
			  <option value="9">9</option>
			  <option value="10">10</option>
			  </select>
			
			<label style="color:red;" id="mobile_search_keyword_error"></label>
          </div>
          <div class="col-xs-12">
            <label class="checkin"><?php echo lang('Check_In') ?></label>
            <div class='input-group date' id='datetimepicker5'>
					<input name="mobile_search_arrival_date" id="mobile_search_arrival_date" type='text' style="cursor:auto;" class="form-control" readonly data-date-format="DD/MM/YYYY"/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
				<label style="color:red;" id="mobile_search_arrival_date_error"></label>
          </div>
		 
          <div class="col-xs-12">
            <label class="checkin"><?php echo lang('Check_Out') ?></label>
            <div class='input-group date' id='datetimepicker6'>
					<input name="mobile_search_leave_date" id="mobile_search_leave_date" type='text' style="cursor:auto;" class="form-control" readonly data-date-format="DD/MM/YYYY"/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
				<label style="color:red;" id="mobile_search_leave_date_error"></label>
          </div>
          <div class="col-xs-4 pull-right">
            <label class="control-label" for="singlebutton"></label>
            <input id="singlebutton" name="singlebutton" class="btn btn-primary btn-custom" type="button" value="<?php echo lang('Submit') ?>" onclick="validate_mobile_search()">
          </div>
          </fieldset>
        </form>
      </div>
    </div>
 </div>
 <!-- Search For Mobile End--->
 
  <!--banner start-->
  <div class="row">
    <div data-ride="carousel" class="carousel slide" id="myCarousel">
      <!-- Indicators -->
	  <?php
	  if(count($banners_arr)>1)
	  {
			?>
			<ol class="carousel-indicators">
				<?php
				$i=0;
				foreach($banners_arr as $banner)
				{	
					?>
					<li data-slide-to="<?php echo $i; ?>" data-target="#myCarousel" <?php if($i==0){ echo 'class="active"'; } ?>></li>
					<?php 
					$i++;
				}
				?>
			  </ol>
			<?php 
	  }
	  ?>
      
      <div class="carousel-inner">
		<!-- Search For Desktop--->
        <div class="container banner-search">
          <div class="search-box">
            <form class="form-horizontal" id="desktop_search_form" action="search" method="POST">
              <fieldset>
				<label id="search_error" style="display:none; color:red;"></label>
              <!-- Search input-->
              <div class="form-group">
                <!-- Form Name -->
                <div class="col-md-12">
                  <legend><?php echo lang('Bungalow') ?> <span><?php echo lang('Search') ?></span></legend>
                </div>
               <?php /*?> <div class="col-md-12">
                  <input id="search_keyword" name="search_keyword" placeholder="<?php echo lang('Keyword') ?>" class="form-control" type="text">
				  <label style="color:red;" id="search_keyword_error"></label>
                </div><?php */?>
				  <?php /*?><input id="search_keyword" name="search_keyword" placeholder="<?php echo lang('Keyword') ?>" class="form-control" type="text"><?php */?>
				<div class="col-md-12">
				   <label class="checkin"><?php echo lang('Person') ?></label>
				 
				  <select name="search_keyword" class="form-control" id="search_keyword">
				  <option value="">Please select Persons</option>
				  <option value="1">1</option>
				  <option value="2">2</option>
				  <option value="3">3</option>
				  <option value="4">4</option>
				  <option value="5">5</option>
				  <option value="6">6</option>
				  <option value="7">7</option>
				  <option value="8">8</option>
				  <option value="9">9</option>
				  <option value="10">10</option>
				  </select>
				  <label style="color:red;" id="search_keyword_error"></label>
                </div>
                <div class="col-xs-6">
            <label class="checkin"><?php echo lang('Check_In') ?></label>
            <div class='input-group date' id='datetimepicker7'>
					<input type='text' name="search_arrival_date" id="search_arrival_date" class="form-control" style="cursor:auto;" readonly data-date-format="DD/MM/YYYY"/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
				<label style="color:red;" id="search_arrival_date_error"></label>
          </div>
         		<div class="col-xs-6">
            <label class="checkin"><?php echo lang('Check_Out') ?></label>
            <div class='input-group date' id='datetimepicker8'>
					<input type='text' name="search_leave_date" id="search_leave_date" class="form-control" style="cursor:auto;" readonly data-date-format="DD/MM/YYYY"/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
				<label style="color:red;" id="search_leave_date_error"></label>
          </div>
                <!-- Button -->
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="singlebutton"></label>
                    <div class="col-md-12">
                      <input id="singlebutton" name="singlebutton" class="btn btn-primary btn-custom" type="button" value="<?php echo lang('Submit') ?>" onclick="validate_desktop_search()">
                    </div>
                  </div>
                </div>
              </div>
              
              </fieldset>
            </form>
          </div>
        </div>
		<!-- Search For Desktop--->
		<!--Banners Slider Area -->
		<?php
		if(count($banners_arr)>0)
		{
			$i=1;
			foreach($banners_arr as $banner)
			{	
				?>
				<div class="item <?php if($i==1){ echo "active"; } ?>" > <img src="<?php echo base_url(); ?>assets/upload/banner/thumb/<?php echo $banner['banner_image'] ?>" alt="<?php echo $banner['banner_alt'] ?>">
				  <div class="container">
					<div class="carousel-caption">
					  <h1><?php echo $banner['banner_title'] ?></h1>
					  <p><?php echo $banner['banner_desc'] ?></p>
					</div>
				  </div>
				</div>
				<?php 
				$i++;
			}
		}
		else 
		{
			?>
			<div class="item active" > <img src="<?php echo base_url(); ?>assets/upload/banner/thumb/no_banner.jpg" alt="">
			  <div class="container">
			  </div>
			</div>
			<?php
		}
		?>
		<!--Banners Slider Area End -->
      </div>
     </div>
  </div>
  <!--banner end-->
  <div class="row content-area">
    <div class="container">
      <h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('WELCOME_TO'); ?> <span>Les Balcons</span><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
      <?php echo $welcome_text; ?>
    </div>
    <div class="content_anchor"><img src="<?php echo base_url(); ?>assets/frontend/images/anchore.png" alt=""></div>
  </div>
  <!-- Properties listing area -->
  <!--<div class="row properties">
    <div class="container">
      <h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('Properties'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
	  <?php
	  if(count($property)>0)
	  {
			foreach($property as $pro)
			{
				?>
				<div class="col-md-6 col-sm-6 col-xs-6">
					<div class="property_box">
					  <div class="property_box_left"><img src="<?php echo base_url(); ?>assets/upload/bunglow/thumb_medium/<?php echo $pro['image']; ?>" alt=""></div>
					  <p class="property-title"><?php echo substr($pro['bunglow_name'], 0, 25); if(strlen($pro['bunglow_name'])>25){ echo "..."; } ?></p>
					  <?php echo substr(strip_tags($pro['bunglow_overview']), 0, 100); if(strlen($pro['bunglow_overview'])>100){ echo "..."; } ?>
					  <div class="readmore"><a href="<?php echo base_url(); ?>properties/<?php echo $pro['slug'] ?>"><img src="<?php echo base_url(); ?>assets/frontend/images/more-img.jpg" alt=""/></a></div>
					</div>
				  </div>
				<?php 
			}
	  }
	  else 
	  {
			echo "<h2>".lang('No_Properties_Found')."</h2>";
	  }
	  ?>
    </div>
  </div>-->
  <!-- Properties listing area end -->
  
  <!-- Bungalow listing area -->
  <div class="row bunglow">
    <div class="container">
      <div class="bunglow-gallery">
        <h2 class="bunglow-heading"><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-2-left.png" alt=""><?php echo lang('Bungalow'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-2-right.png" alt=""></h2>
		<?php 
		if(count($bungalow)>0)
		{
			?>
			<ul class="popup-gallery">
			<?php 
			$x=1;
			$z=1;
			foreach($bungalow as $bung)
			{
			?>
			  <li <?php if($x==$z){ echo "class='first'"; $z+=5;} ?> >
				<div class="popbox">
				  <div class="img-holder"><img src="<?php echo base_url(); ?>assets/upload/bunglow/thumb/<?php echo $bung['image']; ?>" alt="">
					<div class="mask">
					  <h2><?php echo substr(strip_tags($bung['bunglow_name']), 0, 25); if(strlen($bung['bunglow_name'])>25){ echo "..."; } ?></h2>
					  <a href="<?php echo base_url(); ?>bungalows/<?php echo $bung['slug'] ?>" class="info"><?php echo lang('Get_Details') ?></a> </div>
				  </div>
				  <div class="caption-text">
					<p class="caption">
					<?php if(strlen($bung['bunglow_name'])>15){ echo substr($bung['bunglow_name'], 0, 15)."..."; }else{ echo $bung['bunglow_name']; }?>
					</p>
				  </div>
				</div>
			  </li>
			<?php 
			$x++;
			}
			?>
			</ul>
			<div class="booknow">
			  <p><a href="<?php echo base_url(); ?>reservation"><?php echo lang('BOOK_NOW'); ?></a></p>
			</div>
			<?php 	
		}
		else 
		{
			?>
			<h2 class="bunglow-heading"><?php echo lang('No_Bungalow_Found'); ?></h2>
			<?php 
		}
		?>
      </div>
    </div>
  </div>
   <!-- Bungalow listing area end -->
  <div class="row testimonial">
    <div class="container">
      <h2><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""/><?php echo lang('TESTIMONIALS'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
	<?php /*?>  <?php 
	  if(count($testimonial)>0)
	  {
			?>
			<div class="pic-section"> <img src="<?php echo base_url(); ?>assets/frontend/images/profile.png" alt=""/> </div>
			  <div class="testimonial-section">
				<p class="testi-text">
					<span class="f-22">
						<img src="<?php echo base_url(); ?>assets/frontend/images/qute.png" alt="" />
					</span>
						<?php echo $testimonial[0]['content']; ?>
					<span class="f-22">
						<img src="<?php echo base_url(); ?>assets/frontend/images/qute.png" alt="" />
					</span><br>
				  <br>
				  <span><?php echo lang('By'); ?>- <?php echo $testimonial[0]['user_name']; ?></span> 
				</p>
			  </div>
			<?php 
	  }
	  else 
	  {
			?>
			<div class="pic-section"> <img src="<?php echo base_url(); ?>assets/frontend/images/profile.png" alt=""/> </div>
			<div class="testimonial-section">
				<h2 ><?php echo lang('No_Testimonials_Found'); ?></h2>
			</div>
			<?php 
	  }
	  ?><?php */?>
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
				<?php 
				if(count($testimonial)>0)
				{
					$i=0;
					foreach($testimonial as $value)
					{
						?>
						<div class="cap item <?php if($i==0){ echo "active"; } ?>">
						  <div class="custom-cap carousel-caption">
							 <p align="center"><img src="<?php echo base_url(); ?>assets/frontend/images/profile.png" alt=""/></p>
							 <p class="captionstyle"><span class="left_com"></span><span class="right_com"><?php echo $value['content']; ?></span></p>
							 <p class="name">By- <?php echo $value['user_name']; ?></p>
						  </div>
						</div>
						<?php 
						$i++;
					}
				}
				else 
				{
					?>
					<div class="cap item active">
					  <div class="custom-cap carousel-caption">
						 <p align="center"><img src="<?php echo base_url(); ?>assets/frontend/images/profile.png" alt=""/></p>
						 <h2 style="text-align:center;"><span><?php echo lang('No_Testimonials_Found'); ?></span></h2>
					  </div>
					</div>
					<?php 
				}
				?>
				</div>
				<?php 
				//If testimonials will be more than one the slide controller will be shown
				if(count($testimonial)>1)
				{
					?>
					<!-- Controls -->
					<a class="prev custom-control carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">prev</a>
					<a class="next custom-control carousel-control" href="#carousel-example-generic" role="button" data-slide="next">next</a>
					<?php 
				}
				?>
			</div>

    </div>
  </div>
  <div class="row gallery">
    <div class="container">
      <h2 class="bunglow-heading"><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-2-left.png" alt=""><?php echo lang('GALLERY'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-2-right.png" alt=""></h2>
      <div class="row img-gallery">
			<?php 
			if(count($galleries)>0)
			{
				foreach($galleries as $gallery)
				{
					?>
					<a href="<?php echo base_url(); ?>assets/upload/gallery/<?php echo $gallery['image_file_name']; ?>" data-toggle="lightbox" data-gallery="multiimages" data-title="<?php echo $gallery['title']; ?>" class="col-sm-4 col-xs-6 gal-pic">
						<img src="<?php echo base_url(); ?>assets/upload/gallery/thumb/<?php echo $gallery['image_file_name']; ?>" class="img-responsive"> 
					</a>
					<?php 
				}
				?>
				<div class="viewmore">
					<p><a href="<?php echo base_url(); ?>gallery"><?php echo lang('View_More'); ?></a></p>
				</div>
				<?php 
			}
			else 
			{
				?>
				<h2 class="bunglow-heading"><?php echo lang('No_Gallery_Found'); ?></h2>
				<?php 
			}
			?>
      </div>
      
    </div>
  </div>
  <div class="row location">
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-sm-4  col-xs-12">
          <div class="location-block">
            <div class="text-holder">
              <h3 class="small-heading"><?php echo lang('Location'); ?></h3>
              <p class="location-text"></p>
            </div>
            <div class="map-holder">
				<iframe src="http://maps.google.fr/maps/ms?hl=fr&ie=UTF8&msa=0&msid=205972261200026991781.000498c37c43f30ded1f2&t=h&ll=18.055294,-63.015647&spn=0.012118,0.012875&z=15&output=embed" width="100%" height="272" frameborder="0" style="border:0"></iframe>
			</div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="bunglow-block">
            <div class="text-holder">
              <h3 class="small-heading"><?php echo lang('Bungalow_situation'); ?></h3>
              <p class="location-text"></p>
            </div>
            <div class="map-holder"><a href="<?php echo base_url() ?>properties"><img src="<?php echo base_url(); ?>assets/frontend/images/footer-img.png" alt=""></a></div>
          </div>
        </div>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1663254547232475&version=v2.0";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="activities-block">
            <div class="text-holder">
              <h3 class="small-heading"><?php echo lang('Activities'); ?></h3>
			</div>
              <?php 
			  if(count($news)>0)
			  {
				?>
				<marquee onMouseOver="this.scrollAmount=0" onMouseOut="this.scrollAmount=2" scrollamount="2" direction="up" loop="true" style="margin-top:30px; height:272px;">
				<?php 
				foreach($news as $value)
				{
					?>
					<p class="activities-text"><a href="<?php echo base_url() ?>activity/<?php echo $value['slug']; ?>"><?php echo $value['title']; ?></a></p>
					<div class="fb-share-button" data-href="<?php echo base_url() ?>activity/<?php echo $value['slug']; ?>" data-layout="button"></div>
					<a target="_blank" href="http://twitter.com/share?url=<?php echo base_url() ?>activity/<?php echo $value['slug']; ?>&via=twitter&related=<?php echo urlencode("Les Balcons"); ?>" rel="nofollow"><img style="width:50px; height:18px;" src="<?php echo base_url(); ?>assets/frontend/images/twitter_share.png" alt=""></a>
					<?php 
				}
				?>
				</marquee>
				<?php 
			  }
			  else 
			  {
				?>
				<p class="activities-text"><?php echo lang('News_not_available'); ?></p>
				<?php 
			  }
			  ?>
          </div>
        </div>
      </div>
    </div>
  </div>