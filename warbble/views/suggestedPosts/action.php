<div class="col-md-12">
    <h3>Suggested Post Message</h3>
    <p><?php echo $model->suggested_post->message ?></p>

    <?php if ($model->feedback): ?>
        <h3>Rejected Reason</h3>
        <p><?php echo $model->feedback ?></p>
    <?php endif; ?>

</div>