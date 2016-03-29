<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<h1 style="color:red;">Post was not created!</h1>
<table>
    <tr>
        <td>#ID:</td>
        <td><?php echo $post->id ?></td>
    </tr>
    <tr>
        <td>Date:</td>
        <td><?php echo date('h:i:s A \o\n d/m/y', $post->date) ?></td>
    </tr>
    <tr>
        <td>Message:</td>
        <td><?php echo $post->text ?></td>
    </tr>
    <tr>
        <td>User:</td>
        <td><?php echo $post->user->get_name() ?></td>
    </tr>
</table>
<?php echo $message ?>
</body>
</html>