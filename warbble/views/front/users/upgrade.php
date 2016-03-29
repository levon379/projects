<script src="<?php echo BASE_URL; ?>assets/admin/js/changepackage.js"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>
<script>var currency_symbol = "<?PHP echo $currency["currency_symbol"] ?>";
        var currency_code = "<?PHP echo $currency["currency_code"] ?>";
</script>
<?php require_once(ABSPATH.'config/stripe.php');?>

<div class="col-md-12 tagline">
    
    <div class="tagline_wrap">

        <div class="form-wrap">

            <div id="content" class="col-xs-12 col-sm-10">

                <h1 class="page-title">Upgrade</h1>

                    <?php if(!empty($mes)) echo $mes; ?>

                    <form name="" action="" method="post">

                        <fieldset>

                            <div class="form-group">

                                <p>
                                    <input type="hidden" name="delaccount" value="delaccount" />
                                    <input type="submit" name="close" value="Close my account" style="color:black"/>

                                </p>

                            </div>

                        </fieldset>

                    </form>
                    <?PHP if ($stripe_user['status'] == 'active'){?>
                    <p>Your package is <?PHP echo $stripe_user['package']; ?> </p>
                    <p>Created in <?PHP echo($stripe_user['package_start']); ?> </p>
                    <p>End in <?PHP echo($stripe_user['package_end']); ?> </p>

                    <?php if ($current_user->package->pack == 'gold' && $current_user->package->info->is_spent): ?>
                        <p>You should update your package until Gold or Platinum version for getting the possibility to create new companies.</p>
                    <?php endif; ?>

                    <?PHP }else if($stripe_user['status'] == 'trialing'){?>
                    <p>Your package is <?PHP echo $stripe_user['package']; ?> </p>
                    <p>Trial period end in  <?PHP print_r($stripe_user['trial_end']); ?> </p>
                    <?PHP }?>
                    <p>Your cards :</p>
                    <?PHP if ($stripe_user['cards']){ ?>
                    <p id="cards">
                    <table id="table_cards">
                        <tr>
                            <td>Type</td>
                            <td>Last 4 digits</td>
                            <td>Status</td>
                            <td>Delete</td>
                        <tr>
                        <?PHP for ($i = 0;$i < count($stripe_user['cards']);$i++){?>    
                        <tr>
                            <td id="card_<?php echo $i; ?>"><?PHP echo $stripe_user['cards'][$i]->brand; ?></td>
                            <td><?PHP echo $stripe_user['cards'][$i]->last4; ?></td>
                            <td><?PHP echo ($stripe_user['cards'][$i]['default'] ? 'Default' : '<a role="button" href="../Payment/ChangeCardDefault/'.$stripe_user['cards'][$i]->id.'" style="background-color: white; border: 1px solid black; border-radius: 5px; padding: 2px 5px;">Make default</a>'); ?></td>
                            <td><a role="button" href="../Payment/DeleteCard/<?PHP echo $stripe_user['cards'][$i]->id ?>" style="background-color: white; border: 1px solid black; border-radius: 5px; padding: 2px 5px;">Delete</a></td>
                        <tr>
                        <?PHP } ?>
                    </table></p>
                    <?PHP } else { echo "<p>You have not added cards</p>" ;} ?>
                    <p><form action="../Payment/AddCard/" id="addcard"  class="get_started" method="post" >
                        
                        <button id="addcardbutton1" class="btn btn-lg btn-primary get_started">Add Card</button>
                        <script>
                            $('#addcardbutton1').click(function(){
                            var token = function(res){
                            var $input = $('<input type=hidden name=stripeToken />').val(res.id);
                            $('#addcardbutton1').closest('form').append($input).submit();
                            };

                            StripeCheckout.open({
                            key:         '<?php echo $config['publishable_key']; ?>',
                            billingAddress: true,
                            name:        'Add Card',
                            description: 'Add card to your account',
                            panelLabel:  'Checkout',
                            email:  '<?PHP echo $userlogin->email; ?>',
                            token:       token
                            });
                            return false;
                            });
                        </script>
                </form></p>
                    <p>Your next payments:</p>
                    <table id="table_cards">
                        <tr>
                            <td>Date</td>
                            <td>Amount</td>
                            <td>Currency</td>
                        <tr>
                            
                        <tr>
                            <td><?PHP echo $stripe_user['invoice_date']; ?></td>
                            <td><?PHP echo ($stripe_user['invoice_total']/100); ?></td>
                            <td><?PHP echo $stripe_user['invoice_currency']; ?></td>
                        <tr>
                        
                    </table>
                    <p>Change package</p>

                    <form action="" id="ChangePack" method="post">
                    <select   id="pack" name="pack">
                        <option selected disabled>Choose package</option>
                        <?php foreach ($config[$currency["currency_code"]] as $package_key => $package_value): ?>
                            <?PHP if ($stripe_user['package_id'] != $package_value) {?>
                                <option value="<?php echo $package_value ?>"><?php echo ucfirst($package_key) ?></option>
                            <?PHP } ?>
                        <?php endforeach; ?>
                        <?php foreach ($config["quarterly_".$currency["currency_code"]] as $package_key => $package_value): ?>
                        <?PHP if ($stripe_user['package_id'] != $package_value) {?>
                            <option value="<?php echo $package_value ?>"><?php echo "Quarterly ".ucfirst($package_key) ?></option>
                            <?PHP } ?>
                        <?php endforeach; ?>
                    </select>
                    <?PHP if ($stripe_user['cards']){ ?>
                    <p id="changebutton" class="inactive">
                    <button id="ChangePackageBtn" type="submit" value="Change" class="btn btn-lg btn-primary get_started">Change package</button>
                    </p><?PHP } ?>
                    </form>
                    <?PHP if (!$stripe_user['cards']){ ?>
                    <form action="" id="extpay"  class="get_started" method="post" >
                        <p id="AddCardChangepack" class="inactive">
                        <button id="addcardbutton2" class="btn btn-lg btn-primary get_started">Change package</button>
                        </p>
                        <script>
                            $('#addcardbutton2').click(function(){
                            var token = function(res){
                            var $input = $('<input type=hidden name=stripeToken />').val(res.id);
                            $('#extpay').closest('form').append($input).submit();
                            };

                            StripeCheckout.open({
                            key:         '<?php echo $config['publishable_key']; ?>',
                            billingAddress: true,
                            amount:      amount,
                            currency:    currency_code,
                            name:        packname,
                            description: packname +' package ('+ currency_symbol + amount / 100 + '.00)',
                            panelLabel:  'Checkout',
                            email:  '<?PHP echo $userlogin->email; ?>',
                            token:       token
                    });
                            return false;
                });
                </script>
                </form><?PHP } ?>
                    <p id="changepack"></p>
                <div id="pack_price"></div>
                    
                </div>

            </div>

            <!--End Content-->

        </div>
    </div>
</div>
<div class="gridview-overlay overlay-preloader" style="display:none;"></div>