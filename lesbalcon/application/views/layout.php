<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $head; ?>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<?php echo $header_top; ?>
			</div>
		</div>
		<!--navigation start-->
		<div class="navigation row">
			<?php echo $header_menu; ?>
		</div>
		<!--navigation end-->

		<?php echo $content; ?>	
  
		<?php echo $footer; ?>
	</div>
</div>
<div class="arrow_top"><a href="#"><img src="<?php echo base_url(); ?>assets/frontend/images/top-arrow.png" alt="" /></a></div>
</body>
</html>
<script src="<?php echo base_url(); ?>assets/frontend/js/ekko-lightbox.js"></script>
<script type="text/javascript">
	$(document).ready(function ($) {

		// delegate calls to data-toggle="lightbox"
		$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
			event.preventDefault();
			return $(this).ekkoLightbox({
				onShown: function() {
					if (window.console) {
						return console.log('Checking our the events huh?');
					}
				}
			});
		});

		//Programatically call
		$('#open-image').click(function (e) {
			e.preventDefault();
			$(this).ekkoLightbox();
		});
		$('#open-youtube').click(function (e) {
			e.preventDefault();
			$(this).ekkoLightbox();
		});
	});
</script>