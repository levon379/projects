<?php
/**
 * Created by PhpStorm.
 * User: dev31
 * Date: 02.09.15
 * Time: 13:18
 */
?>
<div id="medialibrary" class="medialibrary-picturebank" role="dialog" aria-labelledby="gridSystemModalLabel" data-user-id="<?php echo $current_user->user_id; ?>" data-type="<?php echo $type; ?>">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                <h4 class="modal-title" id="gridSystemModalLabel"><?php echo $title; ?></h4>
            </div><!-- /.modal-header -->
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 text-center dropzone" style="/*border:2px dashed deepskyblue; border-radius: 5px; position: relative; */">
                            <input type="file" id="file-dropzone" name="logo" class="logo-input" value="<?php echo ""; ?>" accept="<?php echo $accept; ?>" />
                            <div class="drag-text text-center"><?php echo $dragtext ?></div>
                            <div class="drag-logo text-center"><span class="glyphicon glyphicon-picture"></span></div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="preview-files" class="col-md-12">
                            <div class="clear-both"></div>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-body -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
