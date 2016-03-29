<?php

    $customers = Users_Model::find('all',array('type' => 1));

?>
<div class="container">
        <div class="col-sm-12">
            <div class="panel card-container">
                <?php if(!empty($mes)) echo $mes; ?>

                <form action="" method="post" id="singup">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h4 class="letter_spacing_1">Sign Up</h4>
                        <h6 class="text-uppercase create_pas_subtitle">It only takes a minute, no credit card, cancel anytime</h6>
                    </div>
                </div>
                <div class="panel-pody card">
                    <div  class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text"  class="form-control" id="first_name" name="first_name" size="20" maxlength="20" value="<?php if(isset($_POST['first_name'])) echo $_POST['first_name']; ?>" tabindex='1' />
                    </div>
                    <div  class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" size="20" maxlength="40" value="<?php if(isset($_POST['last_name'])) echo $_POST['last_name']; ?>" class="form-control" tabindex='2' />
                    </div>
                    <div  class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="inputEmail" name="email" id="email" size="20" maxlength="80" value="<?php if(isset($_POST['email'])) echo htmlentities($_POST['email'], ENT_COMPAT, 'UTF-8'); ?>" class="form-control" tabindex='3'>
                    </div>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LegEA0TAAAAAJXAwLw17beKgByqgUVhVaocercE"></div>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block btn-create_pas btn_ letter_spacing_2" type="submit">Start Your FREE 30 Days Trial</button>
                </div>
                    </form>
            </div>
        </div>
    </div>
</div>






<script type="text/javascript">

    jQuery(document).ready(function($){

        $("#singup").validate({

            rules: {

                first_name: "required",

                last_name: "required",

//                password1: {
//
//                    required: true,
//
//                    minlength: 5
//
//                },
//
//                password2: {
//
//                    required: true,
//
//                    minlength: 5,
//
//                    equalTo: "#password"
//
//                },

                email: {

                    required: true,

                    email: true

                }

            },

            messages: {

                first_name: "Please enter your firstname",

                last_name: "Please enter your lastname",

//                password1: {
//
//                    required: "Please provide a password",
//
//                    minlength: "Your password must be at least 5 characters long"
//
//                },
//
//                password2: {
//
//                    required: "Please provide a password",
//
//                    minlength: "Your password must be at least 5 characters long",
//
//                    equalTo: "Please enter the same password as above"
//
//                },


                email: "Please enter a valid email address"

            }

        });

    });

</script>