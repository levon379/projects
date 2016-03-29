<div id="content" class="col-xs-12 col-sm-10"><!--CONTENT--><h1>Create User</h1>

<div class="col-xs-12">
    </div>
<?php echo validation_errors(); ?>
    <form method="post" action="/Users/create" enctype="multipart/form-data">
    <div class="form-group">
        <div class="col-xs-4">
            <label for="User_first_name">First Name</label>
        </div>

        <div class="col-xs-8">
            <input type="text" name="first_name" value="<?php echo set_value('first_name'); ?>" id="User_first_name" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-4">
            <label for="User_last_name">Last Name</label>
        </div>

        <div class="col-xs-8">
            <input type="text" name="last_name" value="<?php echo set_value('last_name'); ?>" id="User_last_name" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-4">
            <label for="User_email">Email</label>
        </div>

        <div class="col-xs-8">
            <input type="email" name="email" value="<?php echo set_value('email'); ?>" id="User_email" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-4">
            <label for="User_pass">Password</label>
        </div>

        <div class="col-xs-8">
            <input type="password" name="password" value="<?php echo set_value('password'); ?>" id="User_pass" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-4">
            <label for="pass_confirm">Confirm Password</label>
        </div>

        <div class="col-xs-8">
            <input type="password" name="password1" value="<?php echo set_value('password1'); ?>" id="pass_confirm" class="form-control">
        </div>
    </div>
    <div class="col-xs-4"></div>
    <div class="col-xs-8">
        <input type="submit" value="Update" class="btn btn-success">
    </div>

</form></div>