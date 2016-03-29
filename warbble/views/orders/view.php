<h1 class="page-title">Order #<?php echo $order->id ?></h1>

<div class="col-xs-12 view-order">

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">Order Info</div>
        <div class="panel-body"></div>

        <!-- Table -->
        <table class="table">
            <tr>
                <td>ID</td>
                <td><?php echo $order->id; ?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td><?php echo $order->get_status_name(); ?></td>
            </tr>
            <tr>
                <td>Total Price</td>
                <td><?php echo price_format($order->total); ?></td>
            </tr>
            <tr>
                <td>Creation date</td>
                <td><?php echo date('h:i:s A \o\n d/m/y', $order->date) ?></td>
            </tr>
        </table>
    </div>

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">Design Info</div>
        <div class="panel-body"></div>

        <!-- Table -->
        <table class="table">
            <tr>
                <td>ID</td>
                <td><?php echo $order->page_info->id; ?></td>
            </tr>
            <tr>
                <td>Type</td>
                <td><?php echo $order->page_info->get_type_name(); ?></td>
            </tr>
            <tr>
                <td>Business Category</td>
                <td><?php echo $order->page_info->business_category; ?></td>
            </tr>
            <tr>
                <td>Business Name</td>
                <td><?php echo $order->page_info->business_name; ?></td>
            </tr>
            <tr>
                <td>Country</td>
                <td><?php echo $order->page_info->country; ?></td>
            </tr>
            <tr>
                <td>City</td>
                <td><?php echo $order->page_info->city; ?></td>
            </tr>
            <tr>
                <td>Street</td>
                <td><?php echo $order->page_info->street_address; ?></td>
            </tr>
            <tr>
                <td>Postcode</td>
                <td><?php echo $order->page_info->postcode; ?></td>
            </tr>
            <tr>
                <td>Phone number</td>
                <td><?php echo $order->page_info->phone_number; ?></td>
            </tr>
            <tr>
                <td>Website</td>
                <td>
                    <a href="<?php echo $order->page_info->website; ?>"><?php echo $order->page_info->website; ?></a>
                </td>
            </tr>
        </table>
    </div>

</div>