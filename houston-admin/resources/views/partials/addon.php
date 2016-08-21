<script id="addon-row-template" type="text/x-handlebars-template">

    <div class="col-lg-6 addon-row addon-row-{{count}}">
        <input type="hidden" id="booking-addon-id-value" name="booking_addon_id[]" value="0">
        <input type="hidden" id="addon-kid-disabled-value" name="kid_disabled[]" value="0">
        <div class="pull-right delete">
            <input type="button" class="btn btn-danger btn-xs addon-delete" value="Delete">
        </div>
        <div class="form-group">
            <label for="addons">Addon</label>
            <select class="form-control select2 addon-id" id="addon-id" name="addon_id[]">
                <option value=""></option>
            </select>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <label for="adults">Adults</label>
                    <div class="input-group spinner">
                        <input type="text" autocomplete="off" id="no-adult-addons" name="no_adult_addons[]" class="form-control integer" value="0">
                        <div class="input-group-btn-vertical">
                            <a class="btn btn-default"><i class="fa fa-caret-up"></i></a>
                            <a class="btn btn-default"><i class="fa fa-caret-down"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <label for="kids">Kids</label>
                    <div class="input-group spinner">
                        <input type="text"  autocomplete="off" id="no-children-addons" name="no_children_addons[]" class="form-control integer" value="0">
                        <div class="input-group-btn-vertical">
                            <a class="btn btn-default"><i class="fa fa-caret-up"></i></a>
                            <a class="btn btn-default"><i class="fa fa-caret-down"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <label for="total">Total</label>
                    <input type="text" id="total-pax-addons" class="form-control" value="0" readonly>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="payment-method-id">Payment Method</label>
            <select class="form-control select2" id="payment-method-id" name="payment_method_id_addons[]">
                <option value=""></option>
            </select>
        </div>
        
        <div class="form-group">
            <div class="row">
                <div class="col-lg-8 col-md-7">
                    <label for="price">Price</label>
                    <div class='input-group input-group-total' id="price" >
                        <input type='text' class="form-control booking-addon-total-price" name="total_paid_addons[]" value="0">
                        <span class="input-group-addon total-addon-price">
                            <span class="fa glyphicon fa-calculator"></span>
                        </span>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5 form-control-srow">
                    <label for="bookingaddon-paid-{{count}}">Paid?</label>
                    <div class="switch-button sm showcase-switch-button">
                        <input type="hidden" id="paid_addons" name="paid_addons[]" value="0">
                        <input id="bookingaddon-paid-{{count}}" type="checkbox">
                        <label for="bookingaddon-paid-{{count}}"></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>