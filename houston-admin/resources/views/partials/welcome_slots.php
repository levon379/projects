<script id="availability-slot-template" type="text/x-handlebars-template">
    {{#availability_slot}}
    <div class="panel panel-default panel-success availability-panel col-md-4" data-id="{{id}}"  id="availability-panel-{{../date}}-{{id}}">
        <div class="panel-heading">
            <i class="fa fa-ticket"></i> {{name}} <a class="pull-right text-white active" href="#"><i class="fa fa-chevron-down"></i></a>
        </div>
        <div class="panel-body availability-body" id="limitov-{{../date}}-{{id}}">
            <ul class="list-unstyled list-inline text-right as-totals">
                <li><h3 class="no-margn"><span class="label label-info limit-total"> {{total_bookings}} </span></h3></li>
                <li><h3 class="no-margn"><span class="label label-danger limit-remaining"> {{showremaining remaining limit_override has_override}} </span></h3></li>
                <li>
                    <div class="btn-group limitshow">
                        <button class="btn btn-warning limit-value" type="button">{{showlimit limit limit_override has_override}}</button>
                        <button class="btn btn-warning action" type="button"><i class="fa fa-pencil"></i></button>
                    </div>
                    <div class="input-group limitedit" style="display:none;">
                        <input type="text" class="form-control limit-value" value="{{showlimitedit limit limit_override has_override}}">
                        <div class="input-group-btn">
                            <div class="btn-group">
                                <button class="btn btn-default save" type="button"><i class="fa fa-check text-success"></i></button>
                                <button class="btn btn-default cancel" type="button"><i class="fa fa-remove"></i></button>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>

            {{#products}}
            <div class="panel panel-default product-panel" data-id="{{id}}" data-assign="{{assignment_id}}">
                <div class="panel-heading"><strong class="text-primary"><a href="/admin/tour-manager/{{id}}/details?d={{../../date}}&a={{../id}}"><u>{{name}}</u></a></strong></div>
                <div class="panel-body">
                        <div>
                            <div class="totals-tabs" id="tabs-{{../../date}}-{{id}}-{{../id}}">
                                <div class="col-xs-6 text-left">
                                    <span class="selected"><i class="fa fa-paperclip"></i>{{#if comments}}<i class="fa fa-circle"></i>{{/if}}</span> &nbsp;
                                    <span><i class="fa fa-bus"></i>{{#if services}}<i class="fa fa-circle"></i>{{/if}}</span>
                                </div>
                                <div class="col-xs-6 text-right">
                                    {{#if total_package}}
                                    <span class="package-rd">RD</span>
                                    <span><button class="btn btn-purple btn-xs" type="button">{{total_package}}</button></span> &nbsp;
                                    {{/if}}
                                    <span><button class="btn btn-info btn-xs" type="button">{{total_bookings}}</button></span>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="comment-panel" id="comment-{{../../date}}-{{id}}-{{../id}}" style="display:none;">
                                <div class="comment-container">
                                    {{#comments}}
                                    <div class="comment-row" data-id="{{id}}">
                                        <div><a href="#">{{name}}</a>
                                            <div class="comment-area">
                                                <div class="no-margn">{{{comment}}}</div>
                                                <small>{{time_ago}}</small>
                                            </div>
                                        </div>

                                        <div class="text-right edit-buttons"> <span><i class="fa fa-pencil editsave"></i></span> &nbsp; <span><i class="fa fa-remove"></i></span></div>
                                    </div>
                                    {{/comments}}
                                </div>
                                <div class="comment-body">
                                    <textarea class="form-control"></textarea>
                                    <button class="btn btn-purple btn-block" type="button">Add Note</button>
                                </div>
                            </div>

                            <div class="service-panel"  style="display:none" id="service-{{../../date}}-{{id}}-{{../id}}" style="display:none;">
                                <div class="service-container">
                                    {{#services}}
                                    <div class="service-row" data-id="{{id}}" data-type="{{type_id}}" data-company="{{service_id}}" data-option="{{option_id}}" data-quantity="{{quantity}}" data-total="{{computeprice total_price quantity unit_price iva}}">
                                        <div class="service-area">
                                            {{service_name}} - {{option_name}} - {{quantity}} - {{computeprice total_price quantity unit_price iva}}€
                                        </div>
                                        <div class="text-right edit-buttons">
                                            <span><i class="fa fa-pencil"></i></span> &nbsp; <span><i class="fa fa-remove"></i></span>
                                        </div>
                                    </div>
                                    {{/services}}
                                </div>
                                <div class="service-body" data-id="0">
                                    <select class="form-control panel-control service-type" id="selectst-{{../../date}}-{{id}}-{{../id}}" data-placeholder="Select Type">
                                        <option></option>
                                    </select>
                                    <select class="form-control panel-control service-company" id="selectsc-{{../../date}}-{{id}}-{{../id}}" disabled="" data-placeholder="Select Company">
                                        <option></option>
                                    </select>
                                    <select class="form-control panel-control service-option" id="selectso-{{../../date}}-{{id}}-{{../id}}" disabled="" data-placeholder="Select Option">
                                        <option></option>
                                    </select>
                                    <input type="text" placeholder="Quantity" class="form-control panel-control" id="quantity-{{../../date}}-{{id}}-{{../id}}">
                                    <div class="input-group input-group-total panel-control" id="total-{{../../date}}-{{id}}-{{../id}}">
                                        <input type="text" class="form-control service-price">
                                        <span class="input-group-addon"><span class="fa fa-calculator"></span>
                                      </span>
                                    </div>
                                    <button class="btn btn-purple btn-block panel-control save-mode" type="button" id="srvsubmit-{{../../date}}-{{id}}-{{../id}}">Add Service</button>
                                    <div class="panel-control row edit-mode" style="display:none">
                                        <div class="col-lg-6">
                                            <button class="btn btn-success btn-block" type="button">Save</button>
                                        </div>
                                        <div class="col-lg-6">
                                            <button class="btn btn-warning btn-block" type="button">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-options">
                                <div class="table-container">
                                    <table class="table table-bordered no-margn">
                                        {{#product_options}}
                                        <tr>
                                            <td>{{name}} - {{language_name}}</td>
                                            <td class="option-buttons">
                                                {{#if total_package}}
                                                <span class="package-rd">RD</span>
                                                <button class="btn btn-purple btn-xs" type="button">{{total_package}}</button>
                                                {{/if}}
                                                <span>{{total_bookings}}</span>
                                                <div class="switch-button sm showcase-switch-button">
                                                    {{#if available}}
                                                        <input id="switch-button-{{../../../../date}}-{{proptions_language_id}}" type="checkbox" checked="" data-pol="{{proptions_language_id}}">
                                                    {{else}}
                                                        <input id="switch-button-{{../../../../date}}-{{proptions_language_id}}" type="checkbox" data-pol="{{proptions_language_id}}">
                                                    {{/if}}
                                                    <label for="switch-button-{{../../../date}}-{{proptions_language_id}}"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        {{/product_options}}
                                    </table>
                                </div>
                            </div>

                            <div class="guides">
                                <dl class="guide-dropdown" id="dropdown-{{../../date}}-{{id}}-{{../id}}">
                                    <input type="hidden" id="dropval-{{../../date}}-{{id}}-{{../id}}" value="{{implodeuid guides}}" data-value="{{implodedata guides}}" data-languages="{{implodelang product_options}}">
                                    <dt>
                                        <a href="#" class="result-container">
                                            <i class="fa fa-user-plus"></i>
                                            {{#if guides}}
                                            <span class="hida" style="display:none;">Select</span>
                                            {{else}}
                                            <span class="hida">Select</span>
                                            {{/if}}
                                            {{#guides}}
                                            <div class="result-element">
                                                {{#if confirmed}}
                                                <span class="confirm text-success">
                                                    <i class="fa fa-check" data-value="{{active}}"></i>
                                                </span>
                                                {{else}}
                                                <span class="confirm text-danger">
                                                    <i class="fa fa-remove" data-value="{{active}}"></i>
                                                </span>
                                                {{/if}}
                                                {{name}}
                                            </div>
                                            {{/guides}}
                                        </a>
                                    </dt>

                                    <dd>
                                        <div class="multi-select">
                                            <ul>
                                            </ul>
                                        </div>
                                    </dd>
                                </dl>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
            {{/products}}
        </div>
    </div>
    {{/availability_slot}}
</script>