
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang("Manage_Rates"); ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> <?php echo lang("Home"); ?></a></li>
		<li class="active"><?php echo lang("Manage_Rates"); ?></li>
	</ol>
</section>
<!-- Main content -->
<?php 
if(isset($_GET["inserted"]))
{
	?>
	<section class="content">
	<div class="alert alert-success alert-dismissable" style="margin-bottom:0px;">
		<i class="fa fa-check"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b><?php echo lang("Data_Inserted_Successfully"); ?></b>
	</div>
	</section>
	<?php
}
if(isset($_GET["updated"]))
{
	?>
	<section class="content">
	<div class="alert alert-success alert-dismissable" style="margin-bottom:0px;">
		<i class="fa fa-check"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b><?php echo lang('Data_Updated_Successfully'); ?></b>
	</div>
	</section>
	<?php
}
if(isset($_GET["deleted"]))
{
	?>
	<section class="content">
	<div class="alert alert-success alert-dismissable" style="margin-bottom:0px;">
		<i class="fa fa-check"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b><?php echo lang('Data_Deleted_Successfully'); ?></b>
	</div>
	</section>
	<?php
}
?>
	

<div class="box_horizontal">
	<?php
	foreach($language_arr as $language)
	{
		?>
		<a style="width:30px; margin-top:5px; float:left;" title="<?php echo $language['language_name']; ?>" href="<?php echo base_url(); ?>admin/rates/list_rates/<?php echo $language['id']; ?>">
			<img src="<?php echo base_url(); ?>assets/upload/flag/<?php echo $language['flag_image_name']; ?>">
		</a>
		<?php
	}
	?>
	<a href="<?php echo base_url(); ?>admin/rates/rates_add" class="btn btn-primary btn-flat"><?php echo lang("Add_New"); ?></a>
</div>
		
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				
				<div class="box-body table-responsive">
				  <div class="table-outer-scroll"><!--width="857" height="209" -->
					<?php /*?><table width="99%" class="table table-bordered table-striped" <?php if($all_rows){ echo 'id="data_table"'; } ?>>
						<thead>
							<tr>
								<th width="315" class="sorting_disabled">BUNGLOW NAME</th>
								<?php 
								foreach($seasons_rows as $seasons)
								{
									?>
									<th width="393" class="sorting_disabled"><?php echo strtoupper($seasons['season_name'])."<br>".strtoupper($seasons['months'])."<br>".strtoupper($seasons['season_name'])." Per Night |".strtoupper($seasons['season_name'])." Per Week "."<br> &euro;&nbsp;|&nbsp;&dollar;&nbsp;|&nbsp;Disc(%)"; ?></th>
									<?php 
								}
								?>
								<th width="133" class="sorting_disabled" style="text-align:center!important;">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if($all_rows)
							{	
								$sl_no=1;
								foreach($all_rows as $row)
								{
									?>
									<tr>
										<td>
											<?php 
												echo substr($row['bunglow_name'],0, 50);
												if(strlen($row['bunglow_name'])>50)
												{
													echo "...";
												}
											?>
										</td>
										<?php 
										foreach($seasons_rows as $seasons)
										{
											$season_id=$seasons['season_id'];
											?>
											<td>
												<?php echo $row['bunglow_rates'][$season_id]['rate_per_day_euro'] ?>&nbsp;|&nbsp;<?php echo $row['bunglow_rates'][$season_id]['rate_per_day_dollar'] ?>&nbsp;|&nbsp;	<?php echo $row['bunglow_rates'][$season_id]['rate_per_week_euro'] ?>&nbsp;|&nbsp;<?php echo $row['bunglow_rates'][$season_id]['rate_per_week_dollar'] ?>&nbsp;|&nbsp;<?php echo $row['bunglow_rates'][$season_id]['discount'] ?>
											</td>
											<?php 
										}
										?>
										<td align="center">
											<a href="<?php echo base_url(); ?>admin/rates/rates_edit/<?php echo $row['bunglow_id'] ?>"><img width="16px" height="16px" alt="" title="To edit click here" src="<?php echo base_url(); ?>assets/admin/images/icons/user_edit.png"></a>
											<a onclick="return confirm('Are you sure to delete?')" href="<?php echo base_url().'admin/rates/delete/'.$row['bunglow_id'];?>"><img width="16px" height="16px" alt="" title="To delete click here" src="<?php echo base_url(); ?>assets/admin/images/icons/trash-can-delete.png"></a>
										</td>
									</tr>
									<?php 
								}
							}
							else 
							{
								?>
								<tr>
									<td colspan="<?php echo count($seasons_rows)+2; ?>" align="center">No records found!</td>
								</tr>
								<?php 
							}
							?>
						</tbody>
				  </table><?php */?>
					

<!--<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td rowspan="2">&nbsp;</td>
    <td rowspan="2">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>-->
					
					
					<table width="100%" border="0" cellspacing="1" cellpadding="0" class="post-analys-view" <?php if($all_rows){ echo 'id="data_table"'; } ?>>
<!--<td rowspan="2">&nbsp;</td>
    <td rowspan="2">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td> -->                     
<tr>
                        <th rowspan="2" valign="top">Sl</th>
                        <th rowspan="2" valign="top" width="170"><?php echo lang('Rates for the maximum number count for each bunglow');?></th>
							   <?php 
								/*foreach($seasons_rows as $seasons)
								{
								$date_format_arr=explode(":", strtoupper($seasons['months'])); //date format is yyyy-mm-dd. so change it to dd/mm/yyyy
								//$new_date_format=$date_format_arr[0]."X".$date_format_arr[1]."Y";echo $new_date_format;//die;
								$new_date_format=$date_format_arr[0].$date_format_arr[1];
								$date_format_arr1=explode("/", $date_format_arr[0]);
								
								$new_date_format1=$date_format_arr1[0]."-".$date_format_arr1[1];
								
								$date_format_arr2=explode("/", $date_format_arr[1]);
								$new_date_format2=$date_format_arr2[0]."-".$date_format_arr2[1];*/
								//print_r($date_format_arr);die;
								
								?>
                      <?php /*?>  <th colspan="2">
						<?php echo strtoupper($seasons['season_name']);?>  <br/>
(From <?php echo $new_date_format1;?> to <?php echo $new_date_format2;?>)</th>
								<?php
								}
								?></th><?php */?>
				 <th colspan="3"><?php echo lang('High Season');?><br />
				<?php echo lang('(From 15th December to 14th April)');?></th>
				<th colspan="3"><?php echo lang('Low Season');?><br />
<?php echo lang('(From April 15th to December 14th)');?></th>
                        <th>&nbsp;</th>
                      </tr>

<!--<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>-->
                      <tr>
                      
                        <th class="head2" align="center"><?php echo $seasons_rows[0]['season_name'];?><?php echo lang('Per Night');?><br /> € | $ | Disc(%)</th>
                        <th class="head2" align="center"><?php echo $seasons_rows[0]['season_name'];?> <?php echo lang('Per Week');?><br /> € | $ | Disc(%)</th>
                        <th class="head2" align="center"><?php echo lang('Extra night after week rental');?> <br /> € | $</th>
						<th class="head2" align="center"><?php echo $seasons_rows[1]['season_name'];?> <?php echo lang('Per Night');?><br /> € | $ | Disc(%)</th>
                        <th class="head2" align="center"><?php echo $seasons_rows[1]['season_name'];?> <?php echo lang('Per Week');?><br /> € | $ | Disc(%)</th>
                        <th class="head2" align="center"><?php echo lang('Extra night after week rental');?> <br /> € | $</th>
						<th class="head2" width="110"><?php echo lang('Manage_Rates');?>.</th>
                      </tr>
                      
                    <?php 
					if($all_rows)
					{	
						$sl_no=1;
						foreach($all_rows as $row)
						{
					?>
                      <tr>
                        <td>1</td>
                        <td><p class="bunglow-name">
						<?php 
						echo substr($row['bunglow_name'],0, 50);
						if(strlen($row['bunglow_name'])>50)
						{
							echo "...";
						}
						?>
                        </p>
                        </td>
						<!--<td>Test 123</td>-->
                        <?php /*?><td class="rates" colspan="3">
                        <?php 
						foreach($seasons_rows as $seasons)
						{
							$season_id=$seasons['season_id'];
						?>
                         <?php echo $row['bunglow_rates'][$season_id]['rate_per_day_euro'] ?>
 | <?php echo $row['bunglow_rates'][$season_id]['rate_per_day_dollar'] ?> 

|<?php echo $row['bunglow_rates'][$season_id]['discount_per_night'] ?>
 &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo $row['bunglow_rates'][$season_id]['rate_per_week_euro'] ?>
 |  <?php echo $row['bunglow_rates'][$season_id]['rate_per_week_dollar'] ?>
 | <?php echo $row['bunglow_rates'][$season_id]['discount_per_week'] ?>
&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       
                        <?php 
						}
						?>
                        </td><?php */?>
    <?php 
	foreach($seasons_rows as $seasons)
	{
		$season_id=$seasons['season_id'];
	?>
	<td><?php echo $row['bunglow_rates'][$season_id]['rate_per_day_euro'] ?> | <?php echo $row['bunglow_rates'][$season_id]['rate_per_day_dollar'] ?> | <?php echo $row['bunglow_rates'][$season_id]['discount_per_night'] ?></td>
	<td><?php echo $row['bunglow_rates'][$season_id]['rate_per_week_euro'] ?> | <?php echo $row['bunglow_rates'][$season_id]['rate_per_week_dollar'] ?> | <?php echo $row['bunglow_rates'][$season_id]['discount_per_week'] ?></td>
	<td><?php echo $row['bunglow_rates'][$season_id]['extranight_perday_europrice'] ?> | <?php echo $row['bunglow_rates'][$season_id]['extranight_perday_dollerprice'] ?></td>
   <?php 
	}
	?>                     
                        <td><a href="<?php echo base_url(); ?>admin/rates/rates_edit/<?php echo $row['bunglow_id'] ?>"><img width="16px" height="16px" alt="" title="<?php echo lang('To_Edit_Click_Here');?>" src="<?php echo base_url(); ?>assets/admin/images/icons/user_edit.png"></a>
						<a onclick="return confirm('Are you sure to delete?')" href="<?php echo base_url().'admin/rates/delete/'.$row['bunglow_id'];?>"><img width="16px" height="16px" alt="" title="<?php echo lang('To_Delete_Click_Here');?>" src="<?php echo base_url(); ?>assets/admin/images/icons/trash-can-delete.png"></a></td>
                      </tr>
                       <?php 
						}
						}
						else 
						{
						?>
						<tr>
                        <td colspan="<?php echo count($seasons_rows)+2; ?>" align="center"><?php echo lang('No_records_found');?></td>
                        </tr>
                        <?php 
						}
						?>
                    </table>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
</section><!-- /.content -->
<script type="text/javascript">
	$(function() {
		$("#data_table").dataTable(
			{
				"aoColumnDefs" : [ { "bSortable" : false, "aTargets" : [ "sorting_disabled" ] } ],
				"iDisplayLength": <?php echo $pagination_limit; ?>,
				"oLanguage": {
				  "sInfo": "<?php echo lang('Showing'); ?> _START_ <?php echo lang('to'); ?> _END_ <?php echo lang('of'); ?> _TOTAL_ <?php echo lang('entries'); ?>",
				  "sSearch": "<?php echo lang('Search'); ?>: ",
				  "sLengthMenu": "_MENU_ <?php echo lang('records_per_page'); ?>",
				  "oPaginate": { "sPrevious": "<?php echo lang('Previous'); ?>", "sNext": "<?php echo lang('Next'); ?>" }
				}
			}
		);
	});
</script>