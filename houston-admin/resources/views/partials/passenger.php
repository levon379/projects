<script id="passenger-row-template" type="text/x-handlebars-template">
    <div class="row passenger-row">
        <input type="hidden" id="booking-passenger-id-value" name="booking_passenger_id[]" value="0">
        <div class="col-lg-10">
            <label for="last-name-companion">Name</label>
            <input type="text" name="client_name[]" class="form-control" autocomplete="off">
        </div>
        <div class="col-lg-2 form-control-srow">
            <label class="cr-styled">
                <input type="hidden" class="adult-flag-value" name="adult_flag[]" value="0">
                <input type="checkbox" class="adult-flag">
                <i class="fa"></i>
            </label>
            Adult
        </div>
        <div class="pull-right delete">
            <input type="button" class="btn btn-danger btn-xs passenger-delete" value="Delete">
        </div>
    </div>
</script>