<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title" id="myModalLabel">Modify Image</h4>
</div>
<div class="modal-body">
    <?php echo Yii::$app->controller->renderPartial('_edit_image', ['fabric_image_js' => $fabric_image_js, 'id' => $id, 'save_url' => Yii::$app->urlManager->createUrl('post/save-custom-image'), 'modal' => true]); ?>
</div> <!-- / .modal-body -->
<div class="modal-footer">
    <button type="button" class="btn btn-success" id="save" data-dismiss="modal">Save</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>