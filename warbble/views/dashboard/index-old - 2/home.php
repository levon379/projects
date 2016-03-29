<script type="text/javascript">Stripe.setPublishableKey('<?php echo $payment_config['publishable_key'] ?>');</script>

<div class="add-account-steps">
    <h3>
        <span class="hidden-xs">Connect Account</span>
        <span class="hidden-lg hidden-md">1</span>
    </h3>
    <section>
        <?php $this->view('dashboard/index/step_1') ?>
    </section>
    <h3>
        <span class="hidden-xs">Add information</span>
        <span class="hidden-lg hidden-md">2</span>
    </h3>
    <section>
        <?php $this->view('dashboard/index/step_2') ?>
    </section>
    <h3>
        <span class="hidden-xs">Choose design</span>
        <span class="hidden-lg hidden-md">3</span>
    </h3>
    <section>
        <?php $this->view('dashboard/index/step_3') ?>
    </section>
    <h3>
        <span class="hidden-xs">Payment</span>
        <span class="hidden-lg hidden-md">4</span>
    </h3>
    <section>
        <?php $this->view('dashboard/index/step_4') ?>
    </section>
    <h3>
        <span class="hidden-xs">Complete order</span>
        <span class="hidden-lg hidden-md">5</span>
    </h3>
    <section>
        <?php $this->view('dashboard/index/step_5') ?>
    </section>
</div>


