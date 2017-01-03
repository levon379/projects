<h2>Edit an Asset</h2>
{$msg}
<form action="" method="post">
    {$csrf_protection}
    <label for="asset">Asset:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
    <label for="short_name">Short name: &nbsp;</label><input type="text" id="short_name" name="short_name" value="{$asset_info[0].short_name}" /><br />
    <label for="full_name">Full name: &nbsp;</label><input type="text" id="full_name" name="full_name" value="{$asset_info[0].full_name}" /><br />
    <input type="hidden" name="asset_type" value="{$asset_type}" />
    <input type="hidden" name="asset_id" value="{$asset_id}">
    <input type="submit" value="Submit">
</form>
