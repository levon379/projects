<div class="col-xs-12">
    <form method="post">
        <table class="table table-hover">
            <tr>
                <th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="Event[user_ids][]" value="<?php echo $user->user_id ?>">
                    </td>
                    <td><?php echo $user->user_id ?></td>
                    <td>
                        <a href="/Users/update/<?php echo $user->user_id ?>"><?php echo $user->get_name(); ?></a>
                    </td>
                    <td><?php echo $user->email ?></td>
                    <td>
                        <?php if($user->is_connect_event == Users_Model::TW_CONN_STATUS_CONNECTED): ?>
                            <div class="col-xs-12 green centered" data-toggle="tooltip" title="Connected"><i class="fa fa-check"></i></div>
                        <?php elseif($user->is_connect_event == Users_Model::TW_CONN_STATUS_DISCONNECTED): ?>
                            <div class="col-xs-12 red centered" data-toggle="tooltip" title="Disconnected"><i class="fa fa-times"></i></div>
                        <?php elseif($user->is_connect_event == Users_Model::TW_CONN_STATUS_IN_PROCESS): ?>
                            <div class="col-xs-12 gray centered" data-toggle="tooltip" title="In Process"><i class="fa fa-clock-o"></i></div>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="col-xs-12 no-padding">
            <input class="btn btn-primary" name="Event[connect]" type="submit" value="Connect">
            <input class="btn btn-danger" name="Event[disconnect]" type="submit" value="Disconnect">
        </div>
    </form>
</div>
