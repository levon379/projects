<div class="container">
    <div class="col-sm-12">
        <div class="panel card-container">
            <div class="panel-heading">
                <h4 class="panel-title">Login</h4>
            </div>
            <div class="panel-pody card">
                <?php if (!empty($message)) echo $message; ?>
                <form  class="form-group" id="login" action="" method="post">
                    <div  class="form-group">
                        <label for="inputEmail">Email
                            <?php if (isset($errors) && in_array('email', $errors)) echo "<span class='warning'>Please enter your email.</span>"; ?>
                        </label>
                        <input type="email" class="form-control" name="email" id="email" value="<?php if (isset($_POST['email'])) {
                                echo htmlentities($_POST['email']);
                            } ?>" size="20" maxlength="80" tabindex="1">
                    </div>
                    <div  class="form-group">
                        <label for="exampleInputPassword1">Password
                            <?php if (isset($errors) && in_array('password', $errors)) echo "<span class='warning'>Please enter your password.</span>"; ?>
                        </label>
                        <input type="password" autocomplete="off" class="form-control" name="password" id="pass" value="" size="20" maxlength="20" tabindex="2">
                    </div>

                    <a href="<?php echo BASE_URL; ?>Users/forgot" class="forgot-password">Forgot the password? </a>
                    <button class="btn btn-lg btn-primary btn-block btn-signin btn_" type="submit">Login</button>
                </form>

            </div>
        </div>
    </div>
</div>
</div>