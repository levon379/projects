<script>
	$(function() {
		$('.dataTables_filter input[type="text"]').attr('placeholder','<?php echo lang('Search_Placeholder'); ?>');
	});
</script>



<!-- Bootstrap -->
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="<?php echo base_url();?>assets/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>assets/js/AdminLTE/app.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url();?>assets/js/AdminLTE/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<!-- Script for Checking all checkboxes specially for mailbox module page -->


<script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.js" type="text/javascript"></script>

<script type="text/javascript">

	$('.form_date').datetimepicker({
        language:  'En',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
</script>
<!-- Date time picker -->


<script type="text/javascript">
	$(function() {
		"use strict";
		//iCheck for checkbox and radio inputs
		$('input[type="checkbox"]').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass: 'iradio_minimal-blue'
		});

		//When unchecking the checkbox
		$("#check-all").on('ifUnchecked', function(event) {
			//Uncheck all checkboxes
			$("input[type='checkbox']", ".table-mailbox").iCheck("uncheck");
		});
		//When checking the checkbox
		$("#check-all").on('ifChecked', function(event) {
			//Check all checkboxes
			$("input[type='checkbox']", ".table-mailbox").iCheck("check");
		});
	});
</script>