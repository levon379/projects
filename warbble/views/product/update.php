<h1>Update Product</h1>

<div class="col-xs-12">
    <?php if(!empty($errors)): ?>
        <?php foreach($errors as $error): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo $error ?>
            </div>
        <?php endforeach ?>
    <?php endif; ?>
    <?php if($status == 'created'): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Product was created
        </div>
    <?php endif; ?>
</div>

<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <div class="col-xs-4">
            <label for="Product_name">Name</label>
        </div>

        <div class="col-xs-8">
            <input type="text" name="Product[name]" id="Product_name" class="form-control" value="<?php echo $product->name ?>">
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-4">
            <label for="Product_price">Price</label>
        </div>

        <div class="col-xs-8">
            <input type="text" name="Product[price]" id="Product_price" class="form-control" value="<?php echo $product->price ?>">
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-4">
            <label for="Product_type">Type</label>
        </div>

        <div class="col-xs-8">
            <div class="product-type-wrapper product-type-radio twitter <?php echo $product->type == Product_Model::TYPE_TWITTER? "selected": "" ?>">
                <input <?php echo $product->type == Product_Model::TYPE_TWITTER? "checked": "" ?> type="radio" name="Product[type]" value="<?php echo Product_Model::TYPE_TWITTER ?>">
            </div>

            <div class="product-type-wrapper product-type-radio facebook <?php echo $product->type == Product_Model::TYPE_FACEBOOK? "selected": "" ?>">
                <input <?php echo $product->type == Product_Model::TYPE_FACEBOOK? "checked": "" ?> type="radio" name="Product[type]" value="<?php echo Product_Model::TYPE_FACEBOOK ?>">
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-4">
            <label for="attachment">Attachment</label>
        </div>

        <div class="col-xs-8">
            <input type="hidden" name="Product[path]" id="Product_path">
            <div class="simple-upload">
                <div class="simple-upload-preview">
                    <img src="<?php echo BASE_URL . $product->path ?>">
                </div>
                <div class="simple-upload-section col-xs-2">
                    <div class="btn btn-default btn-upload">Image</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-4"></div>
    <div class="col-xs-8">
        <input type="submit" value="Update" class="btn btn-success">
    </div>

</form>
<?php $medialibrary->render('posts', array("title" => "Pictures bank", "dragtext" => "Drag your picture here", "accept" => 'image/*')); ?>