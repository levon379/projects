<div class="step step_4">
    <h1>Payment Information</h1>
    <h4>We use the latest encryption technology so that your credit card details are only used by us.</h4>

<!--    <div class="form-container form-payment">
        <form id="payment-form" method="post">
            <div class="form-row card-number-container">
                
                <input type="text" role="input-number" name="Payment[card_number]" maxlength="16" class="form-ctrl" placeholder="Card number" data-stripe="number">
                <div class="logos">
                    <div class="logo logo-visa"></div>
                    <div class="logo logo-mc"></div>
                    <div class="logo logo-ae"></div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-col-2">
                    <input type="text" role="input-number" name="Payment[month]" maxlength="2" class="form-ctrl" placeholder="MM" data-stripe="exp-month">
                </div>
                <div class="form-col-2 form-margin-left">
                    <input type="text" role="input-number" name="Payment[year]" maxlength="4" class="form-ctrl" placeholder="YYYY" data-stripe="exp-year">
                </div>
                <div class="form-col-2 pull-right">
                    <input type="text" role="input-number" name="Payment[cvv]" maxlength="4" class="form-ctrl" placeholder="CVV" data-stripe="cvc">
                </div>
                <a tabindex="0" class="form-col-2 pull-right cvv-hint" role="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="<img width='250' height='112' src='<?php echo BASE_URL . 'assets/admin/img/cvv_2.jpg' ?>'/>"></a>
            </div>
        </form>
    </div>-->
   

<p></p>
    <?PHP if ($card){ ?>
     <p>Card will be used: <br /><?PHP echo "Type: ".$card->brand." Last 4 digits: ".$card->last4; ?></p>
    <?PHP } else {?>
            <div id="button">
                <p>You don't added card yet</p>
                        <button id="addcard" class="btn btn-lg btn-primary get_started">Add Card</button>
            </div>
            <p id="card" ></p>


<script>
   $("#complete").attr("disabled", true);
   $("#complete").css("background", "#ddd");
   $('#card').css("display", "none");
   var handler = StripeCheckout.configure({
    key: '<?php echo $config['publishable_key']; ?>',

    token: function(token, args) {
      // Use the token to create the charge with a server-side script.
      // You can access the token ID with `token.id`
      //console.log(token)
        $(".gridview-overlay").css("display","block");
      $.ajax({
          url: '../Payment/AddCard/',
          type: 'post',
          dataType: "json",
          data: {stripeToken: token.id},
          success: function(card) {
            if (card) {
                console.log(card);
                $("#card").html('Card will be used: <br />Type:' + card.brand + ', Last 4 digits: ' + card.last4);
                $('#card').css("display", "block");
                $('#button').css("display", "none");
                $("#complete").removeAttr("disabled");
                $("#complete").css("background", "#fc4c7a");
                $(".gridview-overlay").css("display","none");
            }
            else {
                console.log("Success Error!");
            }

          },
          error: function(data) {
            console.log("Ajax Error!");
            console.log(data);
          }
        }); // end ajax call
    }
  });

   $('#addcard').bind('click', function(e) {
    handler.open({
        name: 'Add Card',
        billingAddress: true,
        description: 'Add card to your account',
        panelLabel:  'Add Card',
        email:  '<?PHP echo $userlogin->email; ?>'

    });
    e.preventDefault();
  });

</script>

 <?PHP }?>     
<div class="actions">
    <button type="button" class="step-btn previous_step3_submit">Previous Step</button>
    <button type="button" id="complete" class="step-btn step4_submit">Complete order</button>
    </div>
</div>