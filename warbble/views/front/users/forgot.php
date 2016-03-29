<div class="container">
	<div class="col-sm-12">
		<div class="panel card-container">
			<div class="panel-heading">
				<div class="panel-title">Forgot</div>
			</div>
			<div class="panel-pody card">
			<?php if(!empty($message)) echo $message; ?>
				<form id="forgot" action="" method="post">
					<div  class="form-group">
					<label for="email">Email:</label>
                        <input class="form-control" type="text" name="email" id="email" value="<?php if(isset($_POST['email'])) {echo htmlentities($_POST['email']);} ?>" size="20" maxlength="80" tabindex="1" />	
                                        </div>
					<button class="btn btn-lg btn-primary btn-block btn-signin btn_" type="submit">Submit</button>
				</form>

			</div>
		</div>
	</div>
</div>



<script type="text/javascript">
    jQuery(document).ready(function($){
        $("#forgot").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email address"
                }
            }
        });
    });
</script>