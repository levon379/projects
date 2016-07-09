<!-- IMPORTANT NOTE: CONTEXT MENU FUNCTION HAS BEEN WRITTEN IN THE FOOTER.PHP -->
<!-- header logo: style can be found in header.less --><?php
setlocale(LC_ALL, 'fr_FR');
$this->session->unset_userdata("referer_url");
$this->session->set_userdata("last_reservation_id", "");
$this->session->set_userdata("user_idd", "");
$this->session->set_userdata("name", "");
$this->session->set_userdata("phone", "");
$this->session->set_userdata("email", "");
$this->session->set_userdata("address", "");
$this->session->set_userdata("cat_type", "");
$this->session->set_userdata("max_person", "");

if($_SERVER["QUERY_STRING"] == "addsuccess"){  ?>
	<script type="text/javascript">
		url = "<?php echo base_url(); ?>admin/home";
		alert("<?php echo lang('reservation_successful') ?>"); setTimeout(function() { window.location = url; }3000);
	</script><?php
} ?>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/typeahead.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
<style type="text/css">

.typeahead-devs, .tt-hint, .tt-query {
 	border: 2px solid #CCCCCC;
    border-radius: 8px 8px 8px 8px;
    font-size: 13px;
    height: 33px;
    line-height: 30px;
    outline: medium none;
    padding: 8px 12px;
    width: 423px;
}

.tt-dropdown-menu {
  width: 423px;
  margin-top: 5px;
  padding: 8px 12px;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  border-radius: 8px 8px 8px 8px;
  font-size: 13px;
  color: #111;
  background-color: #F1F1F1;
}

	.icon{
		/*margin-top: -30px;*/
		position: static;
		padding-right:5px;
		padding-bottom: 4px;
	}
	.bname{
		font-size: 12px;
		font-weight: bold;
		position: static;
	}
	.user_name{
		position: absolute;
		/*max-width: 100px;
		overflow: hidden;*/
		white-space: nowrap;
		margin-top:-37px
	}
</style>

<div id='box' style="position: absolute; width: 152px; height: auto; z-index: 99999; background: #FFFFFF; display: none;">
	<div id="add_reservation_id" style="margin-left: 10px;">
		<a style="cursor: pointer;" onclick="add_reservation()"><?php echo lang("add_reservation"); ?></a>
	</div>
	<div id="edit_reservation_id" style="margin-left: 10px;">
		<a style="cursor: pointer;" onclick="edit_reservation()"><?php echo lang("edit_reservation"); ?></a>
	</div>
	<div id="mark_cleaning_id" style="margin-left: 10px;">
		<a style="cursor: pointer;" onclick="mark_for_cleaning()"><?php echo lang("mark_for_cleaning"); ?></a>
	</div>
	<div id="send_bill_id" style="margin-left: 10px;">
		<a style="cursor: pointer;" onclick="send_bill()"><?php echo lang("send_bill_email"); ?></a>
	</div>
	<div id="remove_cleaning_id" style="margin-left: 10px;">
		<a style="cursor: pointer;" onclick="remove_cleaning()"><?php echo lang("remove_cleaning"); ?></a>
	</div>
	<div id="print_details_id" style="margin-left: 10px;">
		<a style="cursor: pointer;" onclick="print_details()"><?php echo lang("print_details"); ?></a>
	</div>
</div>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->


<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang("Dashboard") ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang("Home") ?></a></li>
		<li class="active"><?php echo lang("Dashboard") ?></li>
	</ol>
</section>
<div id="contextMenu"></div> <?php


$messages = array(
		'addsuccess'	=>	'Reservation made successfully',
		'editsuccess'	=>	'Reservation updated successfully',
		'sent'			=>	'Invoice sent successfully',
		'saved'			=>	'Data saved Successfully'
);

$message = null;
foreach ( array_keys($messages) as $param){
	if( isset($_GET[$param]) )
		$message = $param;
		break;
}


if($message){ ?>
	<section class="content">
		<div class="alert alert-success alert-dismissable" style="margin-bottom: 0px;">
			<i class="fa fa-check"></i>
			<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
			<b><?php echo $messages[ $message ] ?></b>
		</div>
	</section><?php
} ?>


<!-- Latest Reservation -->
<!-- <section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th style="text-align: center;" colspan="7"><h4>Latest Booking</h4></th>
							</tr>
							<tr>
								<th class="sorting_disabled">Date</th>
								<th class="sorting_disabled">Arrival Date</th>
								<th class="sorting_disabled">Departure Date</th>
								<th class="sorting_disabled">Bungalow</th>
								<th class="sorting_disabled">Options</th>
								<th class="sorting_disabled">Payment Status</th>
								<th class="sorting_disabled">Source</th>
							</tr><?php

							if(count($latest_booking)>0){
								foreach ($latest_booking as $lb){ ?>
									<tr>
										<td><?php echo $lb['reservation_date'] ?></td>
										<td><?php echo $lb['arrival_date'] ?></td>
										<td><?php echo $lb['leave_date'] ?></td>
										<td><?php echo $lb['bungalow_name'] ?></td>
										<td><?php echo $lb['options'] ?></td>
										<td><?php echo $lb['payment_status'] ?></td>
										<td><?php
											if ($lb['source'] == "W") {
												echo "WEBSITE";
											}elseif ($lb['source'] == "M") {
												echo "MANUAL";
											}elseif($lb['source'] == "D") {
												echo "DIRECT";
											} ?>
										</td>
									</tr><?php
								}
							}else{ ?>
								<tr>
									<td colspan="7" align="center">No records found</td>
								</tr><?php
							} ?>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
 -->

<!------------------------------------------------------------------>

<!-- Main content -->
<section class="content">
	<!-- <div class="row">
		<div class="col-md-12">
			<div class="error-page" style="margin: top:10%; color: #3c8dbc;"></div>
		</div>
	</div> -->
        <style>

            @media print{
                body {-webkit-print-color-adjust: exact;}
                #helptag,#searchbar{ display: none;}

                .calender-style tr { height: 10px !important;}
                .calender-style td,.bunglow-style td{ height: 20px !important; line-height: 20px;}
                #helptag div { max-width: 127px; height: 20px !important;line-height: 20px; margin: 0}
                #helptag span{ margin: 0;}

            }
            .user_name{ margin-top: 0 !important;}
        </style>
        <div class="row" id="searchbar">
		<div class="col-md-6">
			<div class="form-group">
				<label for="dtp_input2" class="col-md-3 control-label">Check In/Out</label>
				<div class="input-group date form_date col-md-8" data-date="" data-start-date="-1y" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
					<input class="form-control" onchange="search_reservation()" name="search_arrival_date" id="search_arrival_date" size="16" type="text" value="" readonly	style="cursor: auto;">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-remove"></span>
					</span>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
				<p id="search_arrival_date_error" style="color: red;"></p>
				<input type="hidden" id="dtp_input2" value="" />
			</div>
		</div>
		<div class="col-md-1">
			<!--<input type="button" class="btn btn-primary" name="save" value="Aller" onclick="search_reservation()">-->
		</div>
		<div class="col-md-2">
			<ul class="navigation-sec pull-right">
				<li><a href="<?php echo $prev_month_link ?>"><?php echo img(array('src'=>"assets/images/prev-icon.png" )); ?></a></li>
				<li><a href="<?php echo $next_month_link ?>"><?php echo img(array('src'=>"assets/images/next-icon.png" )); ?></a></li>
			</ul>
		</div>
        <div class="col-md-1">
            <a href="javascript:void(0)" onclick="window.print();" class="btn btn-primary btn-flat">Imprimer</a>
		</div>
		<div class="col-md-1">
			<!--<input type="button" class="btn btn-primary" name="save" value="Aller" onclick="search_reservation()">-->
			<a href="javascript:void(0)" class="btn btn-primary btn-flat  impression_jour">Impression du jour</a>
		</div>
	</div>

	<!-- <div class="row">
		<div class="col-md-12">
			<ul class="navigation-sec pull-right">
				<li><a href="<?php echo $prev_month_link ?>"><?php echo img(array('src'=>"assets/images/prev-icon.png" )); ?></a></li>
				<li><a href="<?php echo $next_month_link ?>"><?php echo img(array('src'=>"assets/images/next-icon.png" )); ?></a></li>
			</ul>
		</div>
	</div> -->

	<div class="row">
		<div class="col-md-12 desktop_view">


			<div class="bunglow-cols" style="padding: 0px;">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="bunglow-style"> <!--Estexic arajin tablna,Bungalwo vor graca -->
					<tr>
						<td align="left" valign="top" class="toprow" height="20">&nbsp;</td>
					</tr>
					<tr>
						<td align="left" valign="top" class="toprow" height="20">&nbsp;</td>
					</tr>
					<tr>
						<td align="left" valign="top" class="toprow" height="20">&nbsp;</td>
					</tr><?php

					// If bungalows are available
					if (count ( $bungalows_arr ) > 0){
						foreach ( $bungalows_arr as $bungalows ){ ?>
								<tr>
									<td align="left" valign="middle">
										<?php
										$bunglow_arr = explode("<span>", $bungalows['bunglow_name']);
										Echo $bunglow_arr[0];
										//echo $bungalows['bunglow_name'] ?>
									</td>
								</tr> <?php
							}
						} ?>
                </table>
			</div><!-- .bunglow-cols end -->

			<div class="time-line-cols"><?php
				$reg_id = 0;
				$a1 = 0;
				$a2 = 0;
				$a3 = 0;
				$a4 = 0;
				$val = $month_no . '_' . $year_no; ?>

				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="calender-style"> <!--Es el myusna -->
					<!-- Months Name e.g January, February etc... -->
					<tr id="months">
						<td id="month_year_<?php echo $val; ?>" class="toprow2" align="left" valign="top" colspan="<?php echo $days_count_in_current_month ?>">
							<?php echo $month_name . ' ' . $year_no ?>
							<input type="hidden" id="txt_val" value="<?php echo "$month_name $year_no-$month_no"; //May 2015-5 ?>" />
						</td>
					</tr>

					<tr><?php  //<!-- Headers for Days of Month   e.g 1,2,3,4 etc... -->
						for($i=1; $i<=$days_count_in_current_month; $i++){ ?>
							<td align="left" valign="top" class="toprow2"><?php echo sprintf("%02s", $i); ?></td><?php
						} ?>
					</tr>

					<tr><?php  //<!-- Headers for Days of Month   e.g 1,2,3,4 etc... -->
						for($i=1; $i<=$days_count_in_current_month; $i++){
							$date = $year_no."-".$month_no."-".$i;
							$day = strftime('%a', strtotime( $date));
							?>
							<td align="left" valign="top" class="toprow2"><?php echo rtrim(ucfirst($day),"."); ?></td><?php
						} ?>
					</tr><?php

function getReservDate($reg_id)
{
	$getDateMonth = $_SERVER['QUERY_STRING'];
	if($getDateMonth!='')
	{
		$temp = explode("-",$getDateMonth);
		$temp2 = explode("_",$temp[0]);
		if(sizeof($temp2)>1)
			$year_no = $temp2[1];
		else
			$year_no = $temp[0];
		$month_no = $temp[1];
	}
	else
	{
		$year_no = date("Y");
		$month_no = date("m");
	}
	if($getDateMonth=='editsuccess')
	{
		$year_no = date("Y");
		$month_no = date("m");
	}
	$totcount=0;
	$sql = mysql_query("SELECT * FROM lb_reservation WHERE id='".$reg_id."'");
	$row = mysql_fetch_array($sql);
	$sdate = $row['arrival_date'];
	$edate = $row['leave_date'];
	$key_reserved_date_array = createDateRangeArray( $sdate, $edate );

	$no_of_day_in_month = cal_days_in_month(CAL_GREGORIAN, $month_no, $year_no);
	for($i=1; $i<=$no_of_day_in_month; $i++)
	{
		$current_date=$year_no."-".sprintf("%02s", $month_no )."-". sprintf("%02s",$i);
		if(in_array($current_date, $key_reserved_date_array))
		{
			$totcount++;
		}
	}
	return $totcount-1;
}
function createDateRangeArray($strDateFrom,$strDateTo)
{
    $aryRange=array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}
					//placing days according to bungalows
					if(count($bungalows_arr)>0){
						//Getting Reserved date in array
						foreach($bungalows_arr as $bungalows){
							$key_reserved_date_array=array();
							if(count($bungalows['reservation'])>0){
								foreach($bungalows['reservation'] as $key => $value){
									array_push($key_reserved_date_array, $key);
								}
							} ?>

							<tr><?php
								$j=0; $k=0;$res_id="";
								for($i=1; $i<=$days_count_in_current_month; $i++){

									$current_date=$year_no."-".sprintf("%02s", $month_no )."-". sprintf("%02s",$i);
									$cell_class = 'date_cell';

									$unique_id=$bungalows['bunglow_id'];

									$backcolor = $bungalows['reservation'][$current_date]['color_code'];
									$forecolor = "white";
									$colorcheck=strtolower($backcolor[3]);
									if($colorcheck>6 || is_numeric($colorcheck)===false)  $forecolor = "black";

									//If date is existing in reserved dates array
									if(in_array($current_date, $key_reserved_date_array)){
										if(!empty($bungalows['reservation'][$current_date]['options'])){
											$reserved_class="style='cursor:pointer;background-color:".$bungalows['reservation'][$current_date]['color_code']." !important; border-right: 1px solid ".$bungalows['reservation'][$current_date]['color_code'].";'";
											$cell_class = 'reserved paid';
										}else{
											$reserved_class="style='cursor:pointer;background-color:".$bungalows['reservation'][$current_date]['color_code']." !important; border-right: 1px solid ".$bungalows['reservation'][$current_date]['color_code'].";'";
											$cell_class = 'reserved';

										}
										$reservation_id=$bungalows['reservation'][$current_date]['reservation_id'];
										$mouse_over_function="onclick='show_details_on_mouseover(".$reservation_id.")' onmouseover='show_details_for_tooltip(".$reservation_id.", this.id)' onmouseout='hide_tooltip(this.id)' rel='tooltip' data-toggle='tooltip' data-trigger='hover' data-placement='left' data-html='true' data-title=''  data-container='body'";
									}else{
										$reserved_class="";
										$reservation_id="";
										$mouse_over_function="onmouseover='hide_all_tooltip()'";
									}

									if($bungalows['reservation'][$current_date]['payment_status'] != ""){
										$payment_st=$bungalows['reservation'][$current_date]['payment_status'];
									}else{
										$payment_st="";
									}
									//Check if date is reserved for cleaning
									//var_dump($bungalows['cleaning']);
									//var_dump($current_date);
									if(in_array($current_date, $bungalows['cleaning'])){
										$cell_class .= ' cleaning';
										$cleaning_date=$current_date;
									}else{
										$cleaning_date="";
									} ?>

									<td id="<?php echo $unique_id."-".$current_date; ?>" class="<?php echo $cell_class?> <?php if(($bungalows['reservation'][$current_date]['no_of_folding_bed_adult'] && ($bungalows['reservation'][$current_date]['no_of_folding_bed_adult']) > 0 ) || ($bungalows['reservation'][$current_date]['no_of_folding_bed_kid'] && ($bungalows['reservation'][$current_date]['no_of_folding_bed_kid']) > 0 )):?>pending_bad<?php endif;?>" align="left" valign="top" <?php echo $reserved_class; ?> <?php echo $mouse_over_function; ?>>&nbsp;<?php
										 ?>
										<span class="res_block" style=" width:3%"><!-- Width Given by Wasim-->
										<input type="hidden" id="date" name="date" value="<?php echo $current_date; ?>" />
										<input type="hidden" id="bungalow_id" name="bungalow_id" value="<?php echo $bungalows['bunglow_id']; ?>" />
										<input type="hidden" id="reservation_id" name="reservation_id" value="<?php echo $reservation_id; ?>" />
										<input type="hidden" id="cleaning_date" name="cleaning_date" value="<?php echo $cleaning_date; ?>" />

											<?php
											if($reservation_id != '' && $reservation_id != $reg_id){
												$reg_id = $reservation_id;
												if($payment_st=="En Attente" || $payment_st == ""){
													echo '<img class="pending icon" src="'.base_url().'assets/images/pending_payment.png">';
												}elseif($payment_st=="Réglé"){
													echo '<img class="completed icon" src="'.base_url().'assets/images/dollar.jpg">';
												}elseif($payment_st=="Acompte Payé"){
													echo '<img class="pending icon" src="'.base_url().'assets/images/completed_payment.png">';
												}
												if(($bungalows['reservation'][$current_date]['no_of_folding_bed_adult'] && ($bungalows['reservation'][$current_date]['no_of_folding_bed_adult']) > 0 ) || ($bungalows['reservation'][$current_date]['no_of_folding_bed_kid'] && ($bungalows['reservation'][$current_date]['no_of_folding_bed_kid']) > 0 )){
													echo '<img class="pending icon" src="'.base_url().'assets/images/folding_bed.jpg">';
												}
												if($bungalows['reservation'][$current_date]['no_of_baby_bed'] && ($bungalows['reservation'][$current_date]['no_of_baby_bed']) > 0 ){
													echo '<img class="pending icon" src="'.base_url().'assets/images/baby_bed.jpg">';
												}
											?>
											<span class="user_name" style="color: <?php echo $forecolor; ?>; width: 0%;">
											<?php
$area = getReservDate($reg_id);
$showchar = intval($area)*4;
												echo "<span class='bname'>".substr($bungalows['reservation'][$current_date]['user_name'],0,$showchar)."</span>";
											?>
											</span>
											<?php } ?>
										</span>
									</td> <?php
								} ?>
							</tr> <?php
						}
					} ?>
				</table>

			</div>
		</div> <!-- col-md-12 desktop_view END -->

		<input type="hidden" name="hidden_unique_id" id="hidden_unique_id" value="">
	</div>

	<!-- /.row -->
	<?php /*
		<div class="reserved reserved_div">
			<span>RESERVED</span>
		</div>
	*/ ?>
        <div class="row" id="helptag">
	<div class="cleaning cleaning_div">
		<span>Nettoyage</span>
	</div>

	<div class="pending_payment payment_status_div">
		<span>En Attente</span>
	</div>

	<div class="completed_payment payment_status_div">
		<span>Acompte Payé</span>
	</div>

	<div class="cancelled_payment payment_status_div">
		<span>Réglé</span>
	</div>

	<div class="folding_beds payment_status_div">
		<span>Nombre de lit pliant</span>
	</div>

	<div class="baby_beds payment_status_div">
		<span>Nombre de lit bébé</span>
	</div>
</div>
            <?php

	/*
	<div class="popup-overlay" style="z-index:999;">
		<img style="margin-top:30%; margin-left:50%;" src="<?php echo base_url() ?>assets/images/ajax-loader-big.gif" alt="" />
	</div>
	<script>
		//$('html').addClass('overlay');
		//$('html').removeClass('overlay');
	</script>
	*/ ?>
</section>


<!-- /.content -->
<!-- Div for adding reservation -->
<style>
#confirmBox{
	position: fixed;
	left: 36%;
	top: 40%;
	z-index: 11111;
	background: white;
	width: 317px;
	height: 125px;
	border: 1px solid #e5e5e5;
	padding:10px;
	display:none;
	}
</style>

<div id="confirmBox">
<div class="message" style="margin-bottom:20px;">Réservation réalisée avec success, Souhaitez vous ajouter une nouvelle réservation?</div>
    <span class="yes btn btn-primary">Yes</span>
    <span class="no btn btn-primary">No</span>
</div>


<div id="add_reservation_div" style="display: none;" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade"></div>
<!-- Div for editing reservation -->
<div id="edit_reservation_div" style="display: none;" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade"></div>
<div id="full_details_div" style="display: none;" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade"></div>

<div id="ajax_progress" style="text-align: center; display: none; margin-top: 325px;" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
	<img src="<?php echo base_url(); ?>assets/images/ajax-loader-big.gif">
</div>
<div id="print_details_div" style="display: none;"></div>


<div id="ask_for_user_type_div" style="display: none;" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">
					<i class="fa fa-wheelchair"></i><?php echo lang("user_type") ?>
				</h4>
				<div class="modal-body">
					<div class="box-body">
						<div class="form-group">
							<input type="hidden" id="hidden_bungalow_id" value="">
							<input type="hidden" id="hidden_arrival_date" value="">

							<label for="exampleInputPassword1" style="width: 50%; float: left; text-align: center;">
								<input type="radio" name="user_type" value="R" checked>&nbsp;<?php echo lang("registered_user") ?>
							</label>

							<label for="exampleInputPassword1" style="width: 50%; float: left; text-align: center;">
								<input type="radio" name="user_type" value="U">&nbsp;<?php echo lang("non_registered_user") ?>
							</label>
						</div>

						<div class="box-footer" align="center">
							<input type="button" class="btn btn-primary" name="proceed" value="<?php echo lang("Proceed") ?>" onclick="proceed_to_get_add_reservation_form()">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<script>
	function calcDate(date1,date2){
		var diff = Math.floor(date1.getTime() - date2.getTime());
		var day = 1000 * 60 * 60 * 24;
		var days = Math.floor(diff/day);
		var months = Math.floor(days/31);
		var years = Math.floor(months/12);
		return days;
	}

	//function for mark as cleaning
	function mark_for_cleaning(){
		var selected_td_id=$('#hidden_unique_id').val(); //Get selected td id from hidden_unique_id. see below

		var date=$('#'+selected_td_id).find('#date').val();
		console.log(selected_td_id,date)
		var bungalow_id=$('#'+selected_td_id).find('#bungalow_id').val();
		$.post("<?php echo base_url(); ?>admin/home/ajax_mark_for_cleaning", { "bungalow_id":bungalow_id, "date":date }, function(data){
			$('#'+selected_td_id).attr("class", "cleaning");//Set class as cleaning
			$('#'+selected_td_id).find('#cleaning_date').val(date);
			$("#box").hide();
		});
	}

	//Function for remove cleaning status
	function remove_cleaning(){
		var selected_td_id=$('#hidden_unique_id').val(); //Get selected td id from hidden_unique_id. see below
		var cleaning_date=$('#'+selected_td_id).find('#cleaning_date').val();
		var bungalow_id=$('#'+selected_td_id).find('#bungalow_id').val();
		$.post("<?php echo base_url(); ?>admin/home/ajax_remove_cleaning", { "bungalow_id":bungalow_id, "cleaning_date":cleaning_date }, function(data){
			$('#'+selected_td_id).attr("class", ""); //remove cleaning class
			$('#'+selected_td_id).find('#cleaning_date').val('');
			$("#box").hide();
		});
	}

	//Function to add a reservation
	function add_reservation(){
		//$('#add_reservation_div').modal('show');
		$("#box").hide();
		var selected_td_id=$('#hidden_unique_id').val(); //Get selected td id from hidden_unique_id. see below
		var arrival_date=$('#'+selected_td_id).find('#date').val();
		var bungalow_id=$('#'+selected_td_id).find('#bungalow_id').val();

		//Check for past date validation
		var arival_date_arr=arrival_date.split("-"); //Date is coming with YYYY-mm-dd format.
		var valyear=parseInt(arival_date_arr[0]);
		var valmonth=parseInt(arival_date_arr[1]);
		var valday=parseInt(arival_date_arr[2]);
		var today = new Date()
		var new_arrival_date= new Date(valyear,(valmonth-1),valday);
		var result=calcDate(today, new_arrival_date);

		$("#hidden_bungalow_id").val('');
		$("#hidden_arrival_date").val('');
		$("#hidden_bungalow_id").val(bungalow_id);
		$("#hidden_arrival_date").val(arrival_date);
		$("#ask_for_user_type_div").modal('show');


		/*if(result>0){
			alert("<?php echo lang('Past_dates_not_allowed'); ?>");
		}/*else if(result>-2){
			alert("Select the date of after two days");
		}*/
		/*else{
			$("#hidden_bungalow_id").val('');
			$("#hidden_arrival_date").val('');
			$("#hidden_bungalow_id").val(bungalow_id);
			$("#hidden_arrival_date").val(arrival_date);
			$("#ask_for_user_type_div").modal('show');
			/*$.post("<?php echo base_url(); ?>admin/home/ajax_get_add_reservation_form", { "bungalow_id":bungalow_id, "arrival_date":arrival_date }, function(data){
				$("#add_reservation_div").html(data);
				$('#add_reservation_div').modal('show');
			});*/
		//}
	}

	//function for getting add reservation form after selecting user type
	function proceed_to_get_add_reservation_form(){
		$("#ask_for_user_type_div").modal('hide');
		var bungalow_id=$("#hidden_bungalow_id").val();
		var arrival_date=$("#hidden_arrival_date").val();
		var selected_user_type=$('input[name=user_type]:checked').val();
		//If selected user type is registered
		if(selected_user_type=="R"){
			$('#ajax_progress').modal('show');
			$.post("<?php echo base_url(); ?>admin/home/ajax_get_add_reservation_form", { "bungalow_id":bungalow_id, "arrival_date":arrival_date }, function(data){
				$('#ajax_progress').modal('hide');
				$("#add_reservation_div").html(data);
				$('#add_reservation_div').modal('show');
			});
		}else{//If selected user type is unregistered
			$('#ajax_progress').modal('show');
			$.post("<?php echo base_url(); ?>admin/home/ajax_get_add_reservation_form_unregistered", { "bungalow_id":bungalow_id, "arrival_date":arrival_date }, function(data){
				$('#ajax_progress').modal('hide');
				$("#add_reservation_div").html(data);
				$('#add_reservation_div').modal('show');
			});
		}
	}


	//function for editing reservation
	function edit_reservation(){
		$("#box").hide();
		var selected_td_id=$('#hidden_unique_id').val(); //Get selected td id from hidden_unique_id. see below
		var reservation_id=$('#'+selected_td_id).find('#reservation_id').val();
		window.location = "<?php echo base_url(); ?>admin/payment/payment_edit/"+reservation_id;
	}

	function MaxLength(discount){
		if(discount.indexOf('.') >= 0){
			var val_part = discount.split('.');
			var val2 = val_part[1];
			if(val2.length > 2){
				//alert("<?php echo lang('enter_anount_is_more'); ?>");
				alert("You cannot add more than 2 integer after decimal.");
				$('#reservation_discount').val('0');
				return false;
			}
		}else{
			return true;
		}
	}

	function IsNumeric(e) {
		var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        var keyCode = e.which ? e.which : e.keyCode
        var ret = (keyCode >= 48 && keyCode <= 57 || keyCode == 46 || specialKeys.indexOf(keyCode) != -1);
        if(!ret) alert("Merci d'entrer que des numéros");
        return ret;
    }

	//Function for validating add reservation form which is coming from ajax
	function validate_add_reservation(){
		var error=0;
		if ($("#user_id").length > 0){
			if($("#user_id").val()==""){
				$("#user_id_error").show();
				error++;
			}else{
				$("#user_id_error").hide();
			}
		}

		if($("#reservation_name").val().trim()==""){
			$("#reservation_name_error").show();
			error++;
		}else{
			$("#reservation_name_error").hide();
		}

		if($("#no_of_adult").val().trim()==""){
			$("#no_of_adult_error").show();
			error++;
		}else{
			$("#no_of_adult_error").hide();
		}

		if($("#reservation_discount").val().trim()==""){
			$("#reservation_discount_error").show();
			error++;
		}else{
			$("#reservation_discount_error").hide();
		}

		if ($("#reservation_email").length > 0){
			if($("#reservation_email").val()==""){
				$("#reservation_email_error").show();
				error++;
			}else{
				$("#reservation_email_error").hide();
			}
		}
		/*
		if($("#reservation_contact").val().trim()==""){
			$("#reservation_contact_error").show();
			error++;
		}else{
			$("#reservation_contact_error").hide();
		}

		if ($("#reservation_address").length > 0){
			if($("#reservation_address").val()==""){
				$("#reservation_address_error").show();
				error++;
			}else{
				$("#reservation_address_error").hide();
			}
		}
		*/
		if($("#arrival_date").val().trim()==""){
			$("#arrival_date_error_text").html(" <?php echo lang('Arrival_Date_is_required'); ?>");
			$("#arrival_date_error").show();
			error++;
		}else if($("#arrival_date").val().trim()!=""){

			//Checking if arrival date is getting selected as past date
			var arrival_date=$("#arrival_date").val();
			var arival_date_arr=$("#arrival_date").val().split("/"); //This date format dd/mm/yyyy is coming from datepicker

			var valyear=arival_date_arr[2];
			var valmonth=arival_date_arr[1];
			var valday=arival_date_arr[0];
			var today = new Date()
			var new_arrival_date= new Date(valyear,(valmonth-1),valday);

			var date_after_18_month = new Date(new Date(today).setMonth(today.getMonth()+18));
			var year_after_18_months=date_after_18_month.getFullYear();
			var month_after_18_months=date_after_18_month.getMonth();
			var day_after_18_months=date_after_18_month.getDate();
			var new_date_after_18_month=new Date(year_after_18_months, month_after_18_months, day_after_18_months);

			var result=calcDate(today, new_arrival_date);

			if(result>0){

				// $("#arrival_date_error_text").html(" <?php echo lang('Past_dates_not_allowed'); ?>");
				// $("#arrival_date_error").show();
				// error++;
			}/*else if(result>-2){
				$("#arrival_date_error_text").html(" Enter the date of after two days");
				$("#arrival_date_error").show();
				error++;
			}*/else{
				//Checking if arrival date is within 18 months


				/*if(new_arrival_date > new_date_after_18_month){
					$("#arrival_date_error_text").html("<?php echo lang('Reservation_not_allowed'); ?>");
					$("#arrival_date_error").show();
					error++;
				}else{
					$("#arrival_date_error_text").html("");
					$("#arrival_date_error").hide();
				}*/
			}
		}

		if($("#leave_date").val().trim()==""){
			$("#leave_date_error_text").html("<?php echo lang('Leave_Date_is_required'); ?>");
			$("#leave_date_error").show();
			error++;
		}else{
			//Checking if leave date is less than arrival date
			var arrival_date=$("#arrival_date").val();
			var arival_date_arr=$("#arrival_date").val().split("/");
			var arrival_year=arival_date_arr[2];
			var arrival_month=arival_date_arr[1];
			var arrival_day=arival_date_arr[0];
			var new_arrival_date= new Date(arrival_year,(arrival_month-1),arrival_day);

			var leave_date=$("#leave_date").val();
			var leave_date_arr=$("#leave_date").val().split("/");
			var leave_year=leave_date_arr[2];
			var leave_month=leave_date_arr[1];
			var leave_day=leave_date_arr[0];
			var new_leave_date= new Date(leave_year,(leave_month-1),leave_day);
			var result=calcDate(new_arrival_date, new_leave_date);
			if(result>0){
				$("#leave_date_error_text").html("<?php echo lang('Leave_should_not_less_than_arrival'); ?>l");
				$("#leave_date_error").show();
				error++;
			}else{
				$("#leave_date_error_text").html("");
				$("#leave_date_error").hide();
			}
		}

		if(error>0){
			//$(window).scrollTop($("#reservation_add_form").offset().top);
			return false;
		}else{
			f($("#bungalow_ids").val(),$("#user_type").val(),$("#parent_id").val());
		}
	}

	//yrcode
	function doConfirm(msg, yesFn, noFn)
	{
		var confirmBox = $("#confirmBox");
		confirmBox.css("display","block");
		confirmBox.find(".message").text(msg);
		confirmBox.find(".yes,.no").unbind().click(function()
		{
			confirmBox.hide();
		});
		confirmBox.find(".yes").click(yesFn);
		confirmBox.find(".no").click(noFn);
		confirmBox.show();
	}

	function f(bungalow_ids,user_type,parent_id)
	{
		if(user_type == 'R') filename = "ajax_get_add_reservation_form";
		else filename = "ajax_get_add_reservation_form_unregistered";

	    var formData = $("#reservation_add_form").serialize();
	    att=$("#reservation_add_form").attr("action") ;
	    $.post(att, formData).done(function(data){ 
			 //$("html, body").animate({ scrollTop: 0 }, "slow");
			doConfirm("Réservation réalisée avec success, Souhaitez vous ajouter une nouvelle réservation?", function yes()
			{
				$.post("<?php echo base_url(); ?>admin/home/"+filename, { "parent_id" : parent_id,"user_type":user_type}, function(data){
					$('#ajax_progress').modal('hide');
					$("#add_reservation_div").html(data);
					$('#add_reservation_div').modal('show');
				});
			}, function no()
			{
				<?php
	        	$this->session->set_userdata("last_reservation_id", "");
	        	$this->session->set_userdata("user_idd", "");
	        	$this->session->set_userdata("name", "");
	        	$this->session->set_userdata("phone", "");
	        	$this->session->set_userdata("email", "");
	        	?>
	        	window.location.reload();
			});
	    });
	    return true;
	}
	function extraReservation(bungalow_ids,user_type,parent_id,user_id)
	{
		if(user_type == 'R') filename = "ajax_get_add_reservation_form";
		else filename = "ajax_get_add_reservation_form_unregistered";

	    $.post("<?php echo base_url(); ?>admin/home/"+filename, { "parent_id" : parent_id,"user_type":user_type,"user_id":user_id,"task":"extraRes"}, function(data){
			$('#full_details_div').modal('hide');
			$('#ajax_progress').modal('hide');
			$("#add_reservation_div").html(data);
			$('#add_reservation_div').modal('show');
		});

	}
	//end yrcode

	function f_bk(bungalow_ids,user_type,parent_id){
		if(user_type == 'R') filename = "ajax_get_add_reservation_form";
		else filename = "ajax_get_add_reservation_form_unregistered";

	    var formData = $("#reservation_add_form").serialize();
	    att=$("#reservation_add_form").attr("action") ;
	    $.post(att, formData).done(function(data){
	        var add_more = confirm("Réservation réalisée avec success, Souhaitez vous ajouter une nouvelle réservation?");
	        if(add_more){
	        	$.post("<?php echo base_url(); ?>admin/home/"+filename, { "parent_id" : parent_id,"user_type":user_type}, function(data){
					$('#ajax_progress').modal('hide');
					$("#add_reservation_div").html(data);
					$('#add_reservation_div').modal('show');
				});
	        }
	        else{
	        	<?php
	        	$this->session->set_userdata("last_reservation_id", "");
	        	$this->session->set_userdata("user_idd", "");
	        	$this->session->set_userdata("name", "");
	        	$this->session->set_userdata("phone", "");
	        	$this->session->set_userdata("email", "");
	        	?>
	        	window.location.reload();
	        }
	    });
	    return true;
	}

	//Function for validating edit reservation form which is coming from ajax
	function validate_edit_reservation(){
		var error=0;
		if($("#user_id").val()==""){
			$("#user_id_error").show();
			error++;
		}else{
			$("#user_id_error").hide();
		}

		if($("#reservation_name").val().trim()==""){
			$("#reservation_name_error").show();
			error++;
		}else{
			$("#reservation_name_error").hide();
		}

		if($("#no_of_adult").val().trim()==""){
			$("#no_of_adult_error").show();
			error++;
		}else{
			$("#no_of_adult_error").hide();
		}

		if($("#reservation_contact").val().trim()==""){
			$("#reservation_contact_error").show();
			error++;
		}else{
			$("#reservation_contact_error").hide();
		}

		if($("#arrival_date").val().trim()==""){
			$("#arrival_date_error_text").html(" <?php echo lang('Arrival_Date_is_required'); ?>");
			$("#arrival_date_error").show();
			error++;
		}else if($("#arrival_date").val().trim()!=""){

			//Checking if arrival date is getting selected as past date
			var arrival_date=$("#arrival_date").val();
			var arival_date_arr=$("#arrival_date").val().split("/"); //This date format dd/mm/yyyy is coming from datepicker

			var valyear=arival_date_arr[2];
			var valmonth=arival_date_arr[1];
			var valday=arival_date_arr[0];
			var today = new Date()
			var new_arrival_date= new Date(valyear,(valmonth-1),valday);


			var date_after_18_month = new Date(new Date(today).setMonth(today.getMonth()+18));
			var year_after_18_months=date_after_18_month.getFullYear();
			var month_after_18_months=date_after_18_month.getMonth();
			var day_after_18_months=date_after_18_month.getDate();
			var new_date_after_18_month=new Date(year_after_18_months, month_after_18_months, day_after_18_months);

			var result=calcDate(today, new_arrival_date);

			if(result>0){
				$("#arrival_date_error_text").html(" <?php echo lang('Past_dates_not_allowed'); ?>");
				$("#arrival_date_error").show();
				error++;
			}/*else if(result>-2){
				$("#arrival_date_error_text").html(" Enter the date of after two days");
				$("#arrival_date_error").show();
				error++;
			}*/else{
				//Checking if arrival date is within 18 months
				if(new_arrival_date > new_date_after_18_month){
					$("#arrival_date_error_text").html("<?php echo lang('Reservation_not_allowed'); ?>");
					$("#arrival_date_error").show();
					error++;
				}else{
					$("#arrival_date_error_text").html("");
					$("#arrival_date_error").hide();
				}
			}
		}

		if($("#leave_date").val().trim()==""){
			$("#leave_date_error_text").html("<?php echo lang('Leave_Date_is_required'); ?>");
			$("#leave_date_error").show();
			error++;
		}else{
			//Checking if leave date is less than arrival date
			var arrival_date=$("#arrival_date").val();
			var arival_date_arr=$("#arrival_date").val().split("/");
			var arrival_year=arival_date_arr[2];
			var arrival_month=arival_date_arr[1];
			var arrival_day=arival_date_arr[0];
			var new_arrival_date= new Date(arrival_year,(arrival_month-1),arrival_day);

			var leave_date=$("#leave_date").val();
			var leave_date_arr=$("#leave_date").val().split("/");
			var leave_year=leave_date_arr[2];
			var leave_month=leave_date_arr[1];
			var leave_day=leave_date_arr[0];
			var new_leave_date= new Date(leave_year,(leave_month-1),leave_day);
			var result=calcDate(new_arrival_date, new_leave_date);
			if(result>0){
				$("#leave_date_error_text").html("<?php echo lang('Leave_should_not_less_than_arrival'); ?>l");
				$("#leave_date_error").show();
				error++;
			}else{
				$("#leave_date_error_text").html("");
				$("#leave_date_error").hide();
			}
		}

		if(error>0){
			//$(window).scrollTop($("#reservation_add_form").offset().top);
			return false;
		}
	}

	//Function for sending bill
	function send_bill(){
		$("#box").hide();
		var selected_td_id=$('#hidden_unique_id').val(); //Get selected td id from hidden_unique_id. see below
		var reservation_id=$('#'+selected_td_id).find('#reservation_id').val();
		//location.href="<?php echo base_url(); ?>admin/home/send_invoice/"+reservation_id;
		location.href="<?php echo base_url(); ?>admin/users/invoice/"+reservation_id;
	}



	function search_reservation(){

		var error=0;
		if($("#search_arrival_date").val()==""){
			$("#search_arrival_date_error").html("<?php echo lang('Arrival_Date_is_required'); ?>");
			error++;
		}else{
			var arrival_date=$("#search_arrival_date").val();
			var arival_date_arr=$("#search_arrival_date").val().split("/");
			var arrival_year=arival_date_arr[2];
			var arrival_month=arival_date_arr[1];
			var arrival_day=arival_date_arr[0];
			var new_arrival_date= new Date(arrival_year,(arrival_month-1),arrival_day);
			$("#search_leave_date_error").html("");

			var monthNames = [ "Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre" ];
			/*var search_div_id="month_year_"+monthNames[arrival_month-1]+"_"+arrival_year;
			document.getElementById(search_div_id).scrollIntoView(true);*/
			window.location = "<?php echo base_url(); ?>admin/home/?"+monthNames[arrival_month-1]+"_"+arrival_year+"-"+arrival_month; //+"-"+arrival_day;
		}

		if(error>0){
			return false;
		}
	}


	//function for showing details on mouseover 25-11-2014
	function show_details_on_mouseover(reservation_id){
		$('#ajax_progress').modal('show');
		$.post("<?php echo base_url(); ?>admin/home/ajax_get_reservation_details", { "reservation_id":reservation_id}, function(data){
			$("#full_details_div").html(data);
			$('#ajax_progress').modal('hide');
			$('#full_details_div').modal('show');
		});
	}

	var tooltipLoader;
	//function for show details for tooltip
	function show_details_for_tooltip(reservation_id, tdid){
		clearTimeout(tooltipLoader);
		tooltipLoader = setTimeout(function(){
			 $.post("<?php echo base_url(); ?>admin/home/ajax_get_details_for_tooltip", { "reservation_id":reservation_id}, function(data){
				 	$('[rel=tooltip]').tooltip('hide');
					$('#'+tdid).attr('title', data).tooltip('fixTitle').tooltip('show');
				});
		}, 300);
	}

	//function to hide tooltip
	function hide_tooltip(tdid){
		clearTimeout(tooltipLoader);
		$('#'+tdid).attr('title', '').tooltip('fixTitle').tooltip('hide');
	}

	//function to hide all tooltips
	function hide_all_tooltip(){
		clearTimeout(tooltipLoader);
		$('[rel=tooltip]').tooltip('hide');
	}

	//Function for print details
	function print_details(){
		$("#box").hide();
		var selected_td_id=$('#hidden_unique_id').val(); //Get selected td id from hidden_unique_id. see below
		var cleaning_date=$('#'+selected_td_id).find('#cleaning_date').val();
		var reservation_id=$('#'+selected_td_id).find('#reservation_id').val();
		if(reservation_id!=""){
			$('#ajax_progress').modal('show');
			$.post("<?php echo base_url(); ?>admin/home/ajax_get_print_details", { "reservation_id":reservation_id}, function(data){
				$("#print_details_div").html(data);
				$('#ajax_progress').modal('hide');
				var divContents = $("#print_details_div").html();
				var printWindow = window.open('', '', 'height=700,width=1000');
				printWindow.document.write('<html><head><title>Print Data</title>');
				printWindow.document.write('</head><body>');
				printWindow.document.write(divContents);
				printWindow.document.write('</body></html>');
				printWindow.document.close();
				printWindow.print();
			});
		}else if(cleaning_date!=""){
			$('#ajax_progress').modal('show');
			$.post("<?php echo base_url(); ?>admin/home/ajax_get_print_cleaning_details", { "cleaning_date":cleaning_date}, function(data){
				$("#print_details_div").html(data);
				$('#ajax_progress').modal('hide');
				var divContents = $("#print_details_div").html();
				var printWindow = window.open('', '', 'height=700,width=1000');
				printWindow.document.write('<html><head><title>Print Data</title>');
				printWindow.document.write('</head><body>');
				printWindow.document.write(divContents);
				printWindow.document.write('</body></html>');
				printWindow.document.close();
				printWindow.print();
			});
		}
	}

	$(function() {

		$('div.time-line-cols').on('scroll', function () {
			var cutoff = $(this).offset().left;
			$('td.date_cell').removeClass('firstVisible').each(function () {
				var $this = $(this);
				if ($this.offset().left >= cutoff) {
					$this.addClass('firstVisible');
					return false; // stops the iteration after the first one on the screen
				}
			});
		});

		var HasTooltip = $('.hastooltip');
		HasTooltip.on('click', function(e) {
			e.preventDefault();
			var isShowing = $(this).data('isShowing');
			HasTooltip.removeData('isShowing');
			if (isShowing !== 'true'){
				HasTooltip.not(this).tooltip('hide');
				$(this).data('isShowing', "true");
				$(this).tooltip('show');
			}else{
				$(this).tooltip('hide');
			}
		}).tooltip({
			animation: true,
			trigger: 'manual'
		});


		var arr = [];
		$(".completed").each(function(n){
			//alert($(this).attr('data-id'));
			var myname= $(this).attr('id');
			if( $.inArray( myname, arr ) < 0 ){
				arr.push(myname);
			}
		});
	});


	window.onload = function () {
		if (! localStorage.justOnce) {
			localStorage.setItem("justOnce", "true");
			//window.location.reload();
		}else{
			localStorage.removeItem("justOnce");
		}
	}
</script>
<script>
	$(document).ready(function(){
		$('.impression_jour').click(function(){
			window.open("<?php echo base_url(); ?>admin/home/ajax_get_print_today_details");
		});
	});
</script>
