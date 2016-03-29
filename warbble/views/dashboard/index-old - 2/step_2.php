<div class="step step_2">
    <h1>Fill out your Page Information</h1>
    <h4>Please fill in the below fields with your business information. This helps others find your business on <span class="type-text"></span>.</h4>

    <div class="form-container form-page-info">
        <form id="page-info-form" method="post">
            <input type="hidden" name="PageInfo[type]" id="PageInfo_type"/>
            <div class="form-row">
                <div class="col-xs-6">
                    <div class="form-dropdown">
                        <div class="arrow"></div>
                        <select name="PageInfo[business_category]" id="PageInfo_business_category" class="form-ctrl"></select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <input type="text" name="PageInfo[street_address]" class="form-ctrl" placeholder="Street Address">
                </div>
            </div>

            <div class="form-row">
                <div class="col-xs-6">
                    <input type="text" name="PageInfo[business_name]" class="form-ctrl" placeholder="Business name"
                        value="<?= $current_user->first_name . " " . $current_user->last_name; ?>">
                </div>
                <div class="col-xs-6">
                    <input type="text" name="PageInfo[postcode]" class="form-ctrl" placeholder="Postcode">
                </div>
            </div>

            <div class="form-row">
                <div class="col-xs-6">
                    <input type="text" name="PageInfo[country]" class="form-ctrl" placeholder="Country">
                </div>
                <div class="col-xs-6">
                    <input type="text" name="PageInfo[phone_number]" class="form-ctrl" placeholder="Phone number">
                </div>
            </div>

            <div class="form-row">
                <div class="col-xs-6">
                    <input type="text" name="PageInfo[city]" class="form-ctrl" placeholder="City">
                </div>
                <div class="col-xs-6">
                    <input type="text" name="PageInfo[website]" class="form-ctrl" placeholder="Website"
                        value="<?= $current_user->website?$current_user->website:'' ?>">
                </div>
            </div>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="step-btn previous_step1_submit">Previous Step</button>
        <button type="button" class="step-btn step2_submit">Next Step</button>
    </div>
</div>