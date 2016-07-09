<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>Les Balcons | Forgot Password</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">
        <div class="form-box" id="login-box">
            <div class="header">Forgot Password ?</div>
            <form action="" method="post">
                <div class="body bg-gray">
					<?php
					if($this->session->userdata('error_message'))
					{
						?>
						<div class="form-group has-error">
							<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"></i><?php echo $this->session->userdata('error_message'); ?>
							</label>
						</div>	
						<?php
						$this->session->unset_userdata('error_message');
					}
					if($this->session->userdata('success_message_fp'))
					{
						?>
						<div class="form-group has-success">
							<label class="control-label" for="inputSuccess">
							<i class="fa fa-check"></i><?php echo $this->session->userdata('success_message_fp'); ?>
							</label>
						</div>
						<?php
						$this->session->unset_userdata('success_message_fp');
					}
					?>
                    <div class="form-group has-error">
                        <input type="text" name="email" value="" id="email" class="form-control" placeholder="Email Address"/>
                    </div>
                </div>
                <div class="footer">                                                               
                    <input type="submit" class="btn bg-olive btn-block" value="Submit" name="save">
                    <p><a href="<?php echo base_url(); ?>admin">Back to Login</a></p>
                </div>
            </form>
        </div>
        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>        
    </body>
</html>