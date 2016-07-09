<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>Les Balcons | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/AdminLTE.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
		
    </head>
    <body class="bg-black">
        <div class="form-box" id="login-box">
            <form id="form_login" action="<?php echo base_url(); ?>admin/login/validate_admin_login" method="post">
				<div class="header">Login</div>
                <div class="body bg-gray">
					<?php
					if(isset($error_message))
					{
						?>
						<div class="form-group has-error">
							<label class="control-label" for="inputError">
								<i class="fa fa-times-circle-o"></i>Mauvais identifiant ou mot de passe
							</label>
						</div>
						<?php
					}
					?>
                    <div class="form-group has-error">
                        <input type="text" name="user_name" value="<?php echo get_cookie("username_cookie"); ?>" id="user_name" class="form-control" placeholder="Identifiant"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" value="<?php echo get_cookie("password_cookie"); ?>" class="form-control" placeholder="Mot de passe"/>
                    </div>          
                    <div class="form-group">
                        <input type="checkbox" name="remember_me" value="1" <?php if(get_cookie("username_cookie")){ echo "checked"; } ?>/> Se rappeler de moi
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">M’identifier</button>  
                    <p><a href="<?php echo base_url(); ?>admin/login/forgot">J’ai oublié mon mot de passe</a></p>
                </div>
            </form>
        </div>
		<?php
		if(isset($error_message))
		{
			?>
			<script>
				$( "#form_login" ).effect( "shake");
			</script>
			<?php
		}
		?>
        <!-- jQuery 2.0.2 -->
        <!-- Bootstrap -->
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>        
    </body>
</html>