<!-- Header Navbar: style can be found in header.less -->
<?php 
if(is_numeric($current_time_zone) || is_float($current_time_zone))
{
    $offset=$current_time_zone;
}
else 
{
    $timezone = new DateTimeZone($current_time_zone);
    $offset   = ($timezone->getOffset(new DateTime)/3600);
}
?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.jclock.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js" type="text/javascript"></script>
<script>
	window.onload=
	function(){
		if ($('#digital .time').length>0){ $('#digital .time').remove();}
		var offset = '<?php echo $offset ?>'; 
		if (offset == '') return;
		$('#digital').append('<span class="time"></span>');
		var options = {
		 format:'<span class=\"dt\">%d %B %Y | %I:%M:%S %P</span>',
		 //format:'<span class=\"dt\"> %I:%M:%S %P</span>',
		 timeNotation: '12h',
		 am_pm: true,
		 utc:true,
		 utc_offset: offset
		}
		$('#digital .time').jclock(options);
	}
$( document ).ready(function() {
    
    setTimeout(function(){ $('#togglebutton').trigger('click'); }, 1000);
    
});
</script>
<?php //echo $current_time_zone; ?>
<nav class="navbar navbar-static-top" role="navigation">
	<!-- Sidebar toggle button-->
        <a href="#" id="togglebutton" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</a>
	<div class="navbar-right">
		<ul class="nav navbar-nav">
			<!-- User Account: style can be found in dropdown.less -->
			<li class="dropdown user user-menu">
				<a href="<?php echo base_url(); ?>admin/admin_setting" title="<?php echo lang("Site_Setting"); ?>">
					<img src="<?php echo base_url(); ?>assets/admin/images/icons/settings.png">
				</a>
			</li>
			<li class="dropdown user user-menu timer">
				<a class="dropdown-toggle" data-toggle="dropdown" style="hover:none;">
					Time: <span id="digital"></span>
				</a>
			</li>
			<li class="dropdown user user-menu">
				<a class="dropdown-toggle" data-toggle="dropdown">
					<i class="glyphicon glyphicon-user"></i>
					<span><?php echo $this->session->userdata("username"); ?></span>
				</a>
			</li>
			<li class="dropdown user user-menu">
				<a href="<?php echo base_url(); ?>admin/login/logout">
					<span><?php echo lang("Logout"); ?></span>
				</a>
			</li>
		</ul>
	</div>
</nav>
