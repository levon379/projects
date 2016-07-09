<!DOCTYPE html>
<html <?php if($this->uri->segment(2) == 'home'):?>class="remove_overflow"<?php endif;?>>
    <head>
        <?php echo $head; ?>
    </head>
    <body class="skin-blue <?php if($this->uri->segment(2) == 'home'):?>remove_overflow<?php endif;?>" >
        <!-- header logo: style can be found in header.less -->
        <header class="header"><!--Logo Area-->
            <a href="<?php echo base_url(); ?>admin" class="logo">
				<img src="<?php echo base_url(); ?>assets/images/logo.png" width="190px" height="42px" style="margin-top:-5px;">
            </a>
            <?php echo $header_top; ?>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left active relative">
            <!-- Left sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <?php echo $left_side_bar; ?>
            </aside>

			<!-- Right side content page -->
            <aside class="right-side">
				<?php echo $content; ?>
			</aside>
		
        </div>
        <?php echo $footer; ?>
		
    </body>
</html>