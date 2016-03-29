<?php
/**
 * Created by PhpStorm.
 * User: dev31
 * Date: 29.10.15
 * Time: 10:19
 */?>
<h1>Delete Social Account</h1>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h2>Are you sure want to unbind <?= $socialType; ?> social account?</h2>
    <form method="post">
        <div class="row">
            <div class="input-group">
              <span class="input-group-addon">
                  <input type="checkbox" class="checkbox" name="del-messages" id="del-messages"
                  <label for="del-messages">delete all messages that were sent through Warbble site</label>
                  <input type="hidden" name="type" id="type" value="<?= $type ?>" />
              </span>
            </div>
            <input type="submit" class="btn btn-default" name="action-delete" value="cancel" /></input>
            <input type="submit" class="btn btn-danger" name="action-delete" value="delete" />
        </div>
    </form>
</div>
