<h1>Create User</h1>

<div class="col-xs-12">
    <?php if(!empty($errors)): ?>
        <?php foreach($errors as $error): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo $error ?>
            </div>
        <?php endforeach ?>
    <?php endif; ?>
</div>

<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <div class="col-xs-4">
            <label for="User_first_name">First Name</label>
        </div>

        <div class="col-xs-8">
            <input type="text" name="User[first_name]" id="User_first_name" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-4">
            <label for="User_last_name">Last Name</label>
        </div>

        <div class="col-xs-8">
            <input type="text" name="User[last_name]" id="User_last_name" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-4">
            <label for="User_email">Email</label>
        </div>

        <div class="col-xs-8">
            <input type="email" name="User[email]" id="User_email" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-4">
            <label for="User_pass">Password</label>
        </div>

        <div class="col-xs-8">
            <input type="password" name="User[pass]" id="User_pass" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-4">
            <label for="pass_confirm">Confirm Password</label>
        </div>

        <div class="col-xs-8">
            <input type="password" name="pass_confirm" id="pass_confirm" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-4">
            <label for="Role_level">Role</label>
        </div>

        <div class="col-xs-8">
            <?php echo Roles_Model::dropdown_allow_roles() ?>
        </div>
    </div>


    <div class="col-xs-4"></div>
    <div class="col-xs-8">
        <input type="submit" value="Create" class="btn btn-success">
    </div>

</form>