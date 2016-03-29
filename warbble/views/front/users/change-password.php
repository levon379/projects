<div class="container">
    <div class="col-sm-12">
        <div class="panel card-container">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4 class="letter_spacing_1">Create Password</h4>
                    <?php if (!empty($message)) echo $message; ?>
                    <h6 class="text-uppercase create_pas_subtitle">Make it memorable and at least 6 characters</h6>
                </div>
            </div>
            <form id="change-pass" action="" method="post">
                <div class="panel-pody card">
                    <div class="form-group">
                        <label for="Reset_pass">Password</label>
                        <input class="form-control" type="password" name="Reset[pass]" id="Reset_pass" size="20" maxlength="80" tabindex="1" />
                    </div>
                    <div  class="form-group">
                        <label for="Reset_pass2">Confirm Password</label>
                        <input class="form-control" type="password" name="Reset[pass2]" id="Reset_pass2" size="20" maxlength="80" tabindex="1" />
                    </div>
                    <button class="btn btn-lg btn-primary btn-block btn-create_pas btn_ letter_spacing_2" type="submit">Save Pasword</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>



<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $("#change-pass").validate({
            submitHandler: function (form) {
                form.submit();
            },
            rules: {
                'Reset[pass]': {
                    required: true,
                    minlength: 6,
                },
                'Reset[pass2]': {
                    required: true,
                    minlength: 6,
                    equalTo: "#Reset_pass"
                },
                /*captcha: {
                 required: true,
                 minlength: 8
                 }*/
            },
            messages: {
                'Reset[pass]': {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 6 characters long"
                },
                'Reset[pass2]': {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 6 characters long",
                    equalTo: "Please enter the same password as above"
                },
                /*captcha: {
                 required: "Please enter captcha",
                 minlength: "Your captcha must be at least 8 characters long"
                 }*/
            }
        });
    });
</script>