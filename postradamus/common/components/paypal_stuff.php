<?php

include("db.inc.php");

/*  PHP Paypal IPN Integration Class Demonstration File
 *  4.16.2005 - Micah Carrick, email@micahcarrick.com
 *
 *  This file demonstrates the usage of paypal.class.php, a class designed  
 *  to aid in the interfacing between your website, paypal, and the instant
 *  payment notification (IPN) interface.  This single file serves as 4 
 *  virtual pages depending on the "action" varialble passed in the URL. It's
 *  the processing page which processes form data being submitted to paypal, it
 *  is the page paypal returns a user to upon success, it's the page paypal
 *  returns a user to upon canceling an order, and finally, it's the page that
 *  handles the IPN request from Paypal.
 *
 *  I tried to comment this file, aswell as the acutall class file, as well as
 *  I possibly could.  Please email me with questions, comments, and suggestions.
 *  See the header of paypal.class.php for additional resources and information.
*/

// Setup class
require_once('/home/lib/paypal.class.php');  // include the class file
$p = new paypal_class;             // initiate an instance of the class
//$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url

// setup a variable for this script (ie: 'http://www.micahcarrick.com/paypal.php')
$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

// if there is not action variable, set the default action of 'process'
if (empty($_GET['action'])) $_GET['action'] = 'process';

switch ($_GET['action']) {

    case 'process':      // Process and order...

        // There should be no output at this point.  To process the POST data,
        // the submit_paypal_post() function will output all the HTML tags which
        // contains a FORM which is submited instantaneously using the BODY onload
        // attribute.  In other words, don't echo or printf anything when you're
        // going to be calling the submit_paypal_post() function.

        // This is where you would have your form validation  and all that jazz.
        // You would take your POST vars and load them into the class like below,
        // only using the POST values instead of constant string expressions.

        // For example, after ensureing all the POST variables from your custom
        // order form are valid, you might have:
        //
        // $p->add_field('first_name', $_POST['first_name']);
        // $p->add_field('last_name', $_POST['last_name']);

        $p->add_field('business', 'natesanden@gmail.com');
        $p->add_field('return', $this_script.'?action=success');
        $p->add_field('cancel_return', $this_script.'?action=cancel');
        $p->add_field('notify_url', $this_script.'?action=ipn');
        $p->add_field('item_name', 'Escaping the Timeshare Trap (e-book)');
        $p->add_field('amount', '3.99');

        $p->submit_paypal_post(); // submit the fields to paypal
        //$p->dump_fields();      // for debugging, output a table of all the fields
        break;

    case 'success':      // Order was successful...

        // This is where you would probably want to thank the user for their order
        // or what have you.  The order information at this point is in POST
        // variables.  However, you don't want to "process" the order until you
        // get validation from the IPN.  That's where you would have the code to
        // email an admin, update the database with payment status, activate a
        // membership, etc.

        echo "<html><head><title>Success</title></head><body><h3>Thank you for your order.</h3>";
        $sql = "
         SELECT payment_status
         FROM _paypal_ipn_log
         WHERE txn_id = '" . $_POST['txn_id'] . "'
      ";
        $query = mysql_query($sql);
        $data = mysql_fetch_array($query);
        if($data["payment_status"] == "Completed") {
            echo "<p>You may now <a href='paypal_download.php?id=" . md5($_POST['txn_id']) . "'>download</a> your copy of Escaping the Timeshare Trap.</p>";
            echo "<p>Note: An email has also been sent to you with a copy of this link. The link will expire within 48 hours.</p>";
        } else {
            echo "<p>In just a moment you should receive an email containing a link to download your copy of Escaping the Timeshare Trap.</p>";
        }
        ?>
        <script type="text/javascript">
            var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
            document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
        </script>
        <script type="text/javascript">
            try {
                var pageTracker = _gat._getTracker("UA-145467-6");
                pageTracker._trackPageview();
            } catch(err) {}</script>
        <?php
        echo '</body></html>';

        // You could also simply re-direct them to another page, or your own
        // order status page which presents the user with the status of their
        // order based on a database (which can be modified with the IPN code
        // below).

        break;

    case 'cancel':       // Order was canceled...

        // The order was canceled before being completed.

        echo "<html><head><title>Canceled</title></head><body><h3>The order was canceled.</h3>";
        echo "</body></html>";

        break;

    case 'ipn':          // Paypal is calling page for IPN validation...

        // It's important to remember that paypal is calling this script.  There
        // is no output here.  This is where you validate the IPN data and if it's
        // valid, update your database to signify that the user has payed.  If
        // you try and use an echo or printf function here it's not going to do you
        // a bit of good.  This is on the "backend".  That is why, by default, the
        // class logs all IPN data to a text file.

        if ($p->validate_ipn()) {

            // Payment has been recieved and IPN is verified.  This is where you
            // update your database to activate or process the order, or setup
            // the database with the user's order details, email an administrator,
            // etc.  You can access a slew of information via the ipn_data() array.

            // Check the paypal documentation for specifics on what information
            // is available in the IPN POST variables.  Basically, all the POST vars
            // which paypal sends, which we send back for validation, are now stored
            // in the ipn_data() array.

            // For this example, we'll just email ourselves ALL the data.

            //mail it
            $subject = 'Instant Payment Notification - Recieved Payment';
            $to = 'ulikecoke@gmail.com';    //  your email
            $body =  "An instant payment notification was successfully recieved\n";
            $body .= "from ".$p->ipn_data['payer_email']." on ".date('m/d/Y');
            $body .= " at ".date('g:i A')."\n\nDetails:\n";
            foreach ($p->ipn_data as $key => $value) {
                $body .= "\n$key: $value";
            }
            $body .= "\n\n" . mysql_error();
            mail($to, $subject, $body, "FROM: Timeshare Trap <info@savingadvice.com>");

            //db insert
            $sql = "
            INSERT INTO _paypal_ipn_log
            SET txn_id = '" . $p->ipn_data['txn_id'] . "',
                txn_type = 'Timeshare Trap Ebook',
                first_name = '" . $p->ipn_data['first_name'] . "',
                last_name = '" . $p->ipn_data['last_name'] . "',
                email_address = '" . $p->ipn_data['payer_email'] . "',
                amount = '" . $p->ipn_data['mc_gross'] . "',
                ipn_data = '" . $body . "',
                payment_status = '" . $p->ipn_data['payment_status'] . "'
         ";
            @mysql_query($sql);

            //mail customer
            $subject = 'Thank you for your order';
            $to = $p->ipn_data['payer_email'];
            $body = "Thank you for ordering the Escaping the Timeshare Trap ebook.\n\n";
            $body .= "You can download your copy here.\n";
            $body .= "http://www.timesharetrap.com/paypal_download.php?id=" . md5($_POST['txn_id']) . "\n";
            $body .= "Please note: This link is set to expire in 48 hours.\n";
            $body .= "If you have any questions or concerns about your order please don't hesitate to reply to this email.";
            mail($to, $subject, $body, "FROM: Timeshare Trap <info@savingadvice.com>");
        }
        break;
}

?>