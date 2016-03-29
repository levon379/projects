<div class="page-container cf">
    <div class="page-heading cf">
        <div class="heading">
            <h2>Monthly stats</h2>

            <h3>See how your projects are progressing via the new statistics engine.</h3>
        </div>
        <label class="timeline-lbl"> Timeline:
            <div class="select-style"><select name="timeline" id="timeline-select">
                    <option value="7">7 days</option>
                    <option value="14">14 days</option>
                    <option value="30">30 days</option>
                    <option value="60">60 days</option>
                </select></div>
        </label>

    </div>

    <div class="page-content">
        <div class="navi box">
            <ul>
                <li><a href="#">In progress <span>5</span></a></li>
                <li><a class="active" href="#">Accounts <span>18</span></a></li>
                <li><a href="#">Support <span>25</span></a></li>
                <li><a href="#">Cancellations <span>1</span></a></li>
            </ul>
        </div>
        <div class="table-wrapper push-right">
            <table class="wb_table box">
                <tbody class="box">
                <tr>
                    <th>ID</th>
                    <th>Account name</th>
                    <th>Address</th>
                    <th>Status</th>
                </tr>
                <?php
                $users = new ArrayIterator($users);
                while ($users->valid()): if ($users->key() === 3) break;
                    $user = $users->current(); ?>
                    <tr>
                        <td class="col_id"><?= $user->user_id ?></td>
                        <td class="col_acc-name"><?= $user->first_name.' '.$user->last_name ?></td>
                        <td class="col_addr"><a href="#"><?= $user->website ?></a></td>
                        <td class="col_status">In progress</td>
                    </tr>
                    <?php $users->next(); endwhile; ?>
                </tbody>
            </table>
        </div>
        <div class="_a_box box cf">
            <div class="_a_box-buttons">
                <a href="#" class="btn btn-red">Upgrade</a>
                <a href="#" class="btn btn-o">Suspend</a>
                <a href="#" class="btn btn-o bold">Cancel</a>
            </div>
            <div class="_a_box-text">
                <p class="_a_box-title">Lorem Ipsum</p>

                <p class="_a_box-subtitle">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                    tempor incididunt ut labore et dolore magna aliqua</p>
            </div>
        </div>
        <div class="table-wrapper push-right">
            <table class="wb_table box">
                <tbody class="box">
                <?php
                while ($users->valid()): $user = $users->current(); ?>
                    <tr>
                        <td class="col_id"><?= $user->user_id ?></td>
                        <td class="col_acc-name"><?= $user->first_name.' '.$user->last_name ?></td>
                        <td class="col_addr"><a href="#"><?= $user->website ?></a></td>
                        <td class="col_status">In progress</td>
                    </tr>
                    <?php $users->next(); endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>