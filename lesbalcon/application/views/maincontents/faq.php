<div class="row">
	<div class="inner-page-banner"> 
		<img src="<?php echo base_url(); ?>assets/frontend/images/about-us-banner.jpg" alt="">
	</div>
</div>
<!--banner end-->
<div class="row innerpage-section">
	<div class="container">
		<h2><img class="img-responsive" src="<?php echo base_url(); ?>assets/frontend/images/bracket-left.png" alt=""><?php echo lang('Frequently_Asked_Question'); ?><img src="<?php echo base_url(); ?>assets/frontend/images/bracket-right.png" alt=""></h2>
		<div class="row inner-content">
		<h1 style="font-size: 33px!important;
  text-align: center;
  color: #fff;">Under Construction </h1>
      		<?php 
			
			/* if(count($faq_content)>0)
			{
				?>
				<ul class="faq-list">
				<?php 
				foreach($faq_content as $faq)
				{
					?>
					<li style="cursor:pointer;" onclick="show_answer('answer<?php echo $faq['faq_id']; ?>')"><strong><?php echo $faq['faq_question'] ?></strong></li>
					<div style="display:none;" id="answer<?php echo $faq['faq_id']; ?>"><?php echo $faq['faq_answer'] ?></div>
					<?php 
				}
				?>
				</ul>
				<?php 
			}
			else 
			{
				?>
				<h2><?php echo lang('No_records_found'); ?></h2>
				<?php 
			} */
			?>
      </div>
	</div>
 </div>
<script>
function show_answer(faqid)
{
	if(document.getElementById(faqid).style.display=="none")
	{
		document.getElementById(faqid).style.display="";
	}
	else 
	{
		document.getElementById(faqid).style.display="none";
	}
}
</script>