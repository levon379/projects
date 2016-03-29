<?php if(!empty($errors)): ?>
    <div class="alert alert-danger" role="alert">
        <?php foreach($errors as $error): ?>
            <p><?php echo $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<form class="form-signin" method="post" action="<?php echo base_url('api/register') . sprintf('?domain=%s', $domain) ?>">
    <h2 class="form-signin-heading">Please sign up</h2>
    <div class="form-group">
        <label for="Register_first_name" class="sr-only">First Name</label>
        <input name="Register[first_name]" type="text" id="Register_first_name" class="form-control" placeholder="First Name" required autofocus value="<?php echo isset($_POST['Register']['first_name'])? $_POST['Register']['first_name']: '' ?>">
    </div>

    <div class="form-group">
        <label for="Register_last_name" class="sr-only">Last Name</label>
        <input name="Register[last_name]" type="text" id="Register_last_name" class="form-control" placeholder="Last Name" required value="<?php echo isset($_POST['Register']['last_name'])? $_POST['Register']['last_name']: '' ?>">
    </div>

    <div class="form-group">
        <label for="Register_email" class="sr-only">Email</label>
        <input name="Register[email]" type="email" id="Register_email" class="form-control" placeholder="Email" required value="<?php echo isset($_POST['Register']['email'])? $_POST['Register']['email']: '' ?>">
    </div>

    <div class="form-group">
        <label for="Register_pass" class="sr-only">Password</label>
        <input name="Register[pass]" type="password" id="Register_pass" class="form-control" placeholder="Password" required>
    </div>

    <div class="form-group">
        <label for="Register_conf_pass" class="sr-only">Confirm Password</label>
        <input name="Register[conf_pass]" type="password" id="Register_conf_pass" class="form-control" placeholder="Confirm Password" required>
    </div>

    <div class="form-group">
        <a href="<?php echo sprintf('/api/login?domain=%s', urlencode($domain)) ?>">Or login</a>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
</form>