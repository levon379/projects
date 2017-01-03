<div class="container">
<h2>Time Zones</h2>

{if $act=='read'}
	{if $message == 'success'}
		<div id="msg">
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">×</button>        
				<div id="errors_box" class="errors"><strong>{$message_content|default:''}</strong></div>
			</div>
		</div>
	{/if}
	<div class="new-market-time"><a href="{$url}admin/dashboard/timezone/create/new" class="btn btn-custom btn-primary">New Market Time</a></div>
	<table class="table table-hover">
		<tr>
			<th>GMT NAME</th>
			<th>Open/Close</th>
			<th>Action</th>
		</tr>
		{foreach from=$m_time key=k item=v}
	   <tr>
		<td>{$v.name}</td>
		<td>{$v.open_time|date_format:$config.time}/{$v.close_time|date_format:$config.time}</td>
		<td>
			<a href="{$url}admin/dashboard/timezone/update/edit/time/{$v.id}">Edit</a>
			<a href="{$url}admin/dashboard/timezone/delete/edit/time/{$v.id}" onclick="return confirmDelete();">Delete</a>
		</td>
	</tr>
	{/foreach}


	</table>
{/if}

{if $act=='edit'}
    <h4>Edit&nbsp;<strong>{$time[0].name}</strong></h4>
    <form action="{$url}admin/dashboard/timezone/update/update/{$time[0].id}" method="post">
        {$ci_csrf_token}
        <label for="time_name">Time Name: &nbsp;</label>
		<div class="row">
			<div class='col-sm-4'>
				<div class="form-group">
					<input type="text" class="form-control" id="time_name" name="time_name" value="{$time[0].name}" required /><br />
				</div>
			</div>
		</div>
        <br/>
        <label for="open_time">Open Time: &nbsp;</label>
		<div class="row">
			<div class='col-sm-4'>
				<div class="form-group">
					<div class='input-group date' >
						<input type='text' class="form-control" id='open_time' name="open_time" value="{$time[0].open_time|date_format:$config.time}" required/>
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
		</div>
        <br/
		<label for="close_time">Close Time: &nbsp;</label>
		<div class="row">
			<div class='col-sm-4'>
				<div class="form-group">
					<div class='input-group date'>
						<input type='text' class="form-control" id="close_time" name="close_time" value="{$time[0].close_time|date_format:$config.time}" required /><br />
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
		</div>
        <br/>
        <input type="submit" class="btn btn-primary" value="Edit">
    </form>
	

	
{/if}
<!-----------------Begin  Add New Market Time  --------------->
{if $act == 'new'}
<div class="container">
	<h4>Added New Market Time</h4>
	<form action="{$url}admin/dashboard/timezone/create/add" method="post">  
        {$ci_csrf_token}
		<label for="time_name">Time Name: &nbsp;</label>
		<div class="row">
			<div class='col-sm-4'>
				<div class="form-group">
					<input type="text" class="form-control" id="time_name" name="time_name" value="" required /><br />
				</div>
			</div>
		</div>
        <br/>
		<label for="open_time">Open Time: &nbsp;</label>
		<div class="row">
			<div class='col-sm-4'>
				<div class="form-group">
					<div class='input-group date' id="date_for_open"  onclick="date_picker_open();">
						<input type='text' class="form-control" id='open_time' name="open_time" value="" required/>
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
		</div>
        <br/>
		<label for="close_time">Close Time: &nbsp;</label>
		<div class="row">
			<div class='col-sm-4'>
				<div class="form-group">
					<div class='input-group date' id="date_for_close" onclick="date_picker_close();">
						<input type='text' class="form-control" id="close_time" name="close_time" value="" required /><br />
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
		</div>
        <br/>
        <input type="submit" class="btn btn-primary" value="Add">
    </form>
</div>
{/if}
<!-----------------End  Add New Market Time  --------------->
</div>
