<?php if(!empty($errors)): ?>
    <div class="alert alert-danger" role="alert">
        <?php foreach($errors as $error): ?>
            <p><?php echo $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<form class="form-signin" method="post" action="<?php echo base_url('api/login') . sprintf('?domain=%s', $domain) ?>">
    <h2 class="form-signin-heading">Please sign in</h2>
    <div class="form-group">
        <label for="Login_email" class="sr-only">Email address</label>
        <input name="Login[email]" type="email" id="Login_email" class="form-control" placeholder="Email address" required autofocus>
    </div>

    <div class="form-group">
        <label for="Login_pass" class="sr-only">Password</label>
        <input name="Login[pass]" type="password" id="Login_pass" class="form-control" placeholder="Password" required>
    </div>

    <div class="form-group">
        <a href="<?php echo sprintf('/api/register?domain=%s', urlencode($domain)) ?>">Or register</a>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>