<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <h1>Your order <a href="<?php echo base_url("Orders/view/$order->id") ?>">#<?php echo $order->id ?></a></h1>
    <h3><?php echo $message ?></h3>
</body>
</html>