<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
	<!-- sidebar menu: : style can be found in sidebar.less -->
	<ul class="sidebar-menu">
		<li class="active">
			<a href="<?php echo base_url() ?>admin/home">
				<i class="fa fa-dashboard"></i> <span><?php echo lang("Dashboard") ?></span>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url() ?>admin/language">
				<i class="fa fa-compass"></i> <span><?php echo lang("Manage_Language"); ?></span>
			</a>
		</li>
		<li class="treeview">
			<a style="cursor:pointer;">
				<i class="fa fa-adjust"></i>
				<span><?php echo lang("Manage_Master"); ?></span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="<?php echo base_url(); ?>admin/welcome/welcome_text/<?php echo $default_language_id; ?>"><i class="fa fa-angle-double-right"></i><?php echo lang("Manage_Welcome_Text"); ?></a></li>
				<li><a href="<?php echo base_url(); ?>admin/tax/list_tax/<?php echo $default_language_id; ?>"><i class="fa fa-angle-double-right"></i><?php echo lang("Manage_Tax"); ?></a></li>
				<li><a href="<?php echo base_url(); ?>admin/news/list_news/<?php echo $default_language_id; ?>"><i class="fa fa-angle-double-right"></i><?php echo lang("Manage_News"); ?></a></li>
				<li><a href="<?php echo base_url(); ?>admin/faq/list_faq/<?php echo $default_language_id; ?>"><i class="fa fa-angle-double-right"></i><?php echo lang("Manage_faq"); ?></a></li>
				<!--<li><a href="<?php echo base_url(); ?>admin/sent_mail/list_sent_mail"><i class="fa fa-angle-double-right"></i><?php echo lang("Sent_Mail"); ?></a></li>-->
			</ul>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>admin/currency/list_currency/<?php echo $default_language_id; ?>">
				<i class="fa fa-usd"></i> <span><?php echo lang("Manage_Currency"); ?></span>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url() ?>admin/cms/list_cms/<?php echo $default_language_id; ?>">
				<i class="fa fa-pagelines"></i> <span><?php echo lang("Page_Management"); ?></span>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>admin/banner/list_banner/<?php echo $default_language_id; ?>">
				<i class="fa fa-picture-o"></i> <span><?php echo lang("Manage_Banners"); ?></span>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url() ?>admin/gallery/list_gallery/<?php echo $default_language_id; ?>">
				<i class="fa fa-picture-o"></i> <span><?php echo lang("Manage_Gallery"); ?></span>
			</a>
		</li>
		<li class="treeview">
			<a style="cursor:pointer;">
				<i class="fa fa-adjust"></i>
				<span><?php echo lang("Manage_Documents"); ?></span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="<?php echo base_url(); ?>admin/documents/list_documents/<?php echo $default_language_id; ?>"><i class="fa fa-angle-double-right"></i><?php echo lang("Manage_Documents"); ?></a></li>
				<li><a href="<?php echo base_url(); ?>admin/template/list_template/<?php echo $default_language_id; ?>"><i class="fa fa-angle-double-right"></i><?php echo lang("Manage_Email_Template"); ?></a></li>
				<li><a href="<?php echo base_url(); ?>admin/sent_mail_type/list_sent_mail_type/<?php echo $default_language_id; ?>"><i class="fa fa-angle-double-right"></i><?php echo lang("Sent_Mail_Categories"); ?></a></li>
				<li><a href="<?php echo base_url(); ?>admin/send_email_to_users"><i class="fa fa-angle-double-right"></i><?php echo lang("Send_Email_To_Users"); ?></a></li>
				<li><a href="<?php echo base_url(); ?>admin/mail_box/inbox"><i class="fa fa-angle-double-right"></i><?php echo lang("Mail_Box"); ?></a></li>
				<li><a href="<?php echo base_url(); ?>admin/newsletter/list_email"><i class="fa fa-angle-double-right"></i><?php echo lang("Newsletter"); ?></a></li>
				<!--<li><a href="<?php echo base_url(); ?>admin/contacts/list_contacts"><i class="fa fa-angle-double-right"></i><?php echo lang("Contact_us_form_details"); ?></a></li>-->
			</ul>
		</li>
		
		<li>
			<a href="<?php echo base_url(); ?>admin/options/list_options/<?php echo $default_language_id; ?>">
				<i class="fa fa-sun-o"></i><?php echo lang("Manage_Options"); ?>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url() ?>admin/season/list_season/<?php echo $default_language_id; ?>">
				<i class="fa fa-sun-o"></i> <span><?php echo lang("Manage_Season"); ?></span>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>admin/bunglow/list_bunglow/<?php echo $default_language_id; ?>">
				<i class="fa fa-home"></i> <span><?php echo lang("Manage_Bunglow") ?></span>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url() ?>admin/rates/list_rates/<?php echo $default_language_id; ?>">
				<i class="fa fa-money"></i> <span><?php echo lang("Manage_Rates"); ?></span>
			</a>
		</li>
		
		<!--<li>
			<a href="<?php echo base_url() ?>admin/reservation/list_reservation">
				<i class="fa fa-wheelchair"></i> <span><?php echo lang("Manage_Reservation"); ?></span>
			</a>
		</li>-->
		
		<li>
			<a href="<?php echo base_url() ?>admin/payment/all">
				<i class="fa fa-money"></i> <span><?php echo lang("Reservation_Payment"); ?></span>
			</a>
		</li>
		
		<li>
			<a href="<?php echo base_url() ?>admin/print_data">
				<i class="fa fa-paperclip"></i> <span><?php echo lang("Print_Data"); ?></span>
			</a>
		</li>
		
		<li>
			<a href="<?php echo base_url(); ?>admin/users/list_users">
				<i class="fa fa-user"></i> <span><?php echo lang("Manage_Users"); ?></span>
			</a>
		</li>

		<li class="treeview">
			<a style="cursor:pointer;">
				<i class="fa fa-user"></i> <span><?php echo lang('Manage_Web_Admin'); ?></span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="<?php echo base_url(); ?>admin/admin_setting"><i class="fa fa-angle-double-right"></i> <?php echo lang('Site_Setting'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>admin/change_username"><i class="fa fa-angle-double-right"></i> <?php echo lang('Change_Username'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>admin/change_password"><i class="fa fa-angle-double-right"></i> <?php echo lang('Change_Password'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>admin/change_email"><i class="fa fa-angle-double-right"></i> Change Email</a></li>
				<li><a href="<?php echo base_url(); ?>admin/login/logout"><i class="fa fa-angle-double-right"></i> <?php echo lang("Logout"); ?></a></li>
			</ul>
		</li>
	</ul>
</section>
<!-- /.sidebar -->