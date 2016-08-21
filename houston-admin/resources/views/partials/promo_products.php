<script id="promos-product-row-template" type="text/x-handlebars-template">
	<div class="row promos-product-row promos-product-row-{{count}}">
		<input type="hidden" id="promos-product-id-value" name="promos_product_id[]" value="0">
		<div class="pull-right delete">
		    <input type="button" class="btn btn-danger btn-xs product-delete" value="Delete">
		</div>
		<div class="form-group">
            <div class="col-lg-5">
                <label for="product-id">Product</label>
                <select class="form-control select2" id="product-id" name="product_id[]">
                    <option value=""></option>

                </select>
            </div>
            <div class="col-lg-7">
                <label for="product-option-id">Product Options</label>
                <input class="form-control product-option" type="text" name="product_option_ids[]" id="product-option" placeholder="Choose Product Option/s" value=""/>
            </div>
            <div style="clear:both;"></div>
		</div>
		<div class="form-group">
            <div class="col-lg-12">
                <label for="product-option-id">Addons</label>
                <input class="form-control addon" type="text" name="addon_ids[]" id="addon" placeholder="Choose Addon/s" value=""/>
            </div>
		</div>
	</div>
</script>