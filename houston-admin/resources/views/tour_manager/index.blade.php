@extends('layouts.master')

@section('content')
<div class="page-header pg-tourmanager"><h1>Dashboard<small> Tour Manager</small></h1></div>
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!! Session::get('success') !!}
</div>
@endif
@if(Session::has('error'))
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!! Session::get('error') !!}
</div>
@endif

<div class="clearfix">
    <div id="filter-panel" class="filter-panel" style="height: auto;">
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form-inline" role="form" method="get">
                    <div class="form-group">
                        <label for="start-date">Start Date:</label>
                        <div  class="input-group" id="start-date">
                            <input type="text" class="form-control" name="sd" value="{{ Input::get('sd') }}" autocomplete="off">
                            <span class="input-group-addon"><span class="fa fa-calendar text-orange"></span>
                            </span>
                        </div>
                    </div><!-- form group [search] -->
                    <div class="form-group">
                        <label for="no-of-days"># of Days:</label>
                        <div  class="input-group">
                            <select id="no-of-days" name="ps" class="form-control select2">
                                <option value="1" {{ Input::get('ps',7) == 1 ? 'selected' : '' }}>1</option>
                                <option value="2" {{ Input::get('ps',7) == 2 ? 'selected' : '' }}>2</option>
                                <option value="3" {{ Input::get('ps',7) == 3 ? 'selected' : '' }}>3</option>
                                <option value="4" {{ Input::get('ps',7) == 4 ? 'selected' : '' }}>4</option>
                                <option value="5" {{ Input::get('ps',7) == 5 ? 'selected' : '' }}>5</option>
                                <option value="6" {{ Input::get('ps',7) == 6 ? 'selected' : '' }}>6</option>
                                <option value="7" {{ Input::get('ps',7) == 7 ? 'selected' : '' }}>7</option>
                            </select>
                        </div>
                    </div> <!-- form group [rows] -->
                    <div class="form-group pp-group">
                        <label for="pp-filters">Show:</label>
                        <input type="hidden" name="pp" id="pp-filters-value" value="{{ Input::get('pp','1,2,3,4') }}">
                        <select class="form-control" id="pp-filters" multiple="multiple">
                            <option value="2">Rome By Segway</option>
                            <option value="1">Goseek Adventures</option>
                            <option value="3">Ecoart Travel</option>
                            <option value="4">Packages</option>
                        </select>
                    </div> <!-- form group [rows] -->
                    <div class="form-group">
                        <button class="btn btn-purple" type="submit">Apply Filters</button>
                    </div>
                    <div class="form-group pull-right">
                        @if(!$disablePrev)
                            <a href="{{$prevLink}}" class="btn btn-purple"><i class="fa fa-chevron-left"></i></a>
                        @else
                            <a href="#" class="btn btn-purple" disabled><i class="fa fa-chevron-left"></i></a>
                        @endif
                        @if(!$disableNext)
                            <a href="{{$nextLink}}" class="btn btn-purple" type="button"><i class="fa fa-chevron-right"></i></a>
                        @else
                            <a href="#" class="btn btn-purple" disabled><i class="fa fa-chevron-right"></i></a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row column-warpper" id="tour-manager-page">

    <!-- start of product -->
    @foreach($dates->dates as $index => $date)
    <div class="col-md-4 tour-column {{ ((($index+1)%2)==0) ? 'even' : 'odd' }}" data-date="{{$date->date}}" data-total="{{ $date->total_bookings }}">
        <div class="main-div">
            <h3 class="no-margn pull-right"><span class="label label-info"> {{ $date->total_bookings }}</span></h3><p class="text-white margn-b-sm form-control-static">{{ App\Libraries\Helpers::displayShortDayDate($date->date) }} </p>
            <div class="availability-slot">
                <div class="tour-preloader">
                    <img src="/assets/images/loading/tour-loading{{ ((($index+1)%2)==0) ? '2' : '' }}.gif">
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!--  Change made by manoz shahi on jan 13th 2016 - start -->

@include('partials.availability_slot')
<!-- end of product -->

<!--  Change made by manoz shahi on jan 13th 2016 - end -->

@stop

@section('script')
<script>
    $(document).ready(function(){

        var serviceTData = [];
        var guideData = [];

        $("#pp-filters").multiselect({
            //includeSelectAllOption : true,
            //selectAllValue: 0,
            numberDisplayed: 1,
            buttonWidth: '165px',
            onChange: function(option, checked, select) {
                var arr = $("#pp-filters").val();
                if(arr == null){
                    $("#pp-filters-value").val('');
                } else {
                    $("#pp-filters-value").val(arr.join());
                }
            }
        });
        //$("#pp-filters").multiselect('selectAll',false);
        //$("#pp-filters").multiselect('updateButtonText');
        var arr = $("#pp-filters-value").val();
        var ppArray = arr.split(",");
        $("#pp-filters").multiselect('select',ppArray);
        $("#pp-filters").multiselect("updateButtonText")
        $("#start-date").datetimepicker({format: 'DD/MM/YYYY' });

        $.get( "/admin/services/services/type", null).done(function(data){
            serviceTData = data;

            $(".tour-column").each(function() {
                var column = $(this);
                var date = column.data('date');
                var total = column.data('total');

                var columnContent = $("#availability-slot-template").html();
                var template = Handlebars.compile(columnContent);

                Handlebars.registerHelper('computeprice', function (total_price, quantity, price, iva) {
                    var totalPrice = parseFloat(price) + parseFloat(iva);
                    var total = parseFloat(totalPrice) * quantity;
                    total = Math.round(total * 100) / 100;
                    if (total_price) {
                        total = total_price;
                    }
                    total = total + "";
                    total = total.replace(".", ",");
                    return total;
                });


                Handlebars.registerHelper('implodeuid', function (guides) {
                    var array = [];
                    for (key in guides) {
                        array.push(guides[key].user_id);
                    }
                    return array.join();
                });

                Handlebars.registerHelper('implodelang', function (proptions) {
                    var array = [];
                    for (key in proptions) {
                        array.push(proptions[key].language_id);
                    }
                    return array.join();
                });

                Handlebars.registerHelper('implodedata', function (guides) {
                    var array = [];
                    for (key in guides) {
                        var obj = {};
                        obj[guides[key].user_id] = guides[key].confirmed;
                        array.push(obj);
                    }
                    return JSON.stringify(array);
                });

                Handlebars.registerHelper('showremaining', function (remaining, limitov, limithasov) {
                    if ((limithasov && limitov == null) || remaining == null) {
                        return 'U';
                    }
                    return remaining;
                });

                Handlebars.registerHelper('showlimit', function (limit, limitov, limithasov) {
                    return showLimit(limit, limitov, limithasov, false)
                });

                Handlebars.registerHelper('showlimitedit', function (limit, limitov, limithasov) {
                    return showLimit(limit, limitov, limithasov, true)
                });

                function showLimit(limit, limitov, limithasov, edit) {
                    if (limithasov) {
                        if (limitov == null) {
                            return edit ? '' : 'U';
                        } else {
                            return limitov;
                        }
                    } else {
                        if (limit == null) {
                            return edit ? '' : 'U';
                        } else {
                            return limit;
                        }
                    }
                }


                var params = {date: date, total_bookings: total, filters: ppArray};


                $.get("/admin/services/tour-manager/get", params).done(function (data) {
                    var html = template(data);
                    $(".availability-slot", column).html(html);

                    var serviceTSelector = "[id^='selectst-" + data.date + "']";

                    $(serviceTSelector).each(function () {
                        var select = $(this);
                        var id = select.attr("id");
                        var res = id.split("-");
                        //var product = res[4];

                        serviceTSelector = "#" + id;
                        var serviceETSelector = "select" + serviceTSelector;

                        var serviceCSelector = "#" + id.replace("selectst", "selectsc");
                        var serviceECSelector = "select" + serviceCSelector;

                        loadSelectDataFromData("#" + id, serviceTData, true);

                        var quantitySelector = "#" + id.replace("selectst", "quantity");
                        $(quantitySelector).inputmask('integer', {rightAlign: false});

                        var totalSelector = "#" + id.replace("selectst", "total");

                        $(totalSelector + " .input-group-addon").on("click", function () {
                            var select = $(this);
                            var id = select.parent().attr("id");
                            var serviceOSelector = "#" + id.replace("total", "selectso");
                            var serviceOptionId = $(serviceOSelector).val();
                            var quantitySelector = "#" + id.replace("total", "quantity");
                            var quantity = $(quantitySelector).val();
                        });


                        $(serviceTSelector).on("change", function () {
                            var serviceTypeId = $(serviceETSelector).val();
                            var select = $(this);
                            var id = select.attr("id");

                            var serviceCSelector = "#" + id.replace("selectst", "selectsc");

                            loadSelectData(serviceCSelector, "services/company", {service_type_id: serviceTypeId}, true);

                            $(serviceCSelector).prop("disabled", false);
                        });

                        $(serviceCSelector).on("change", function () {
                            var serviceId = $(serviceECSelector).val();
                            var select = $(this);
                            var id = select.attr("id");

                            var serviceOSelector = "#" + id.replace("selectsc", "selectso");

                            loadSelectData(serviceOSelector, "services/option", {service_id: serviceId}, true);

                            $(serviceOSelector).prop("disabled", false);
                        });

                    });

                    var guideSelector = "[id^='dropdown-" + data.date + "']";

                    $(guideSelector).each(function () {
                        var guide = $(this);
                        var id = guide.attr("id");
                        bindDropdown(id);
                    });

                    var tabs = "[id^='tabs-" + data.date + "']";

                    $(tabs).each(function () {
                        var tab = $(this);
                        var id = tab.attr("id");
                        bindTab(id);
                    });

                    var prOptions = "[id^='switch-button-" + data.date + "']";

                    $(prOptions).each(function () {
                        var prOption = $(this);
                        var id = prOption.attr("id");
                        bindOption(id);
                    });

                    var availabilityPanels = "[id^='availability-panel-" + data.date + "']";

                    $(availabilityPanels).each(function () {
                        var availabilityPanel = $(this);
                        var id = availabilityPanel.attr("id");
                        bindPanel(id);
                    });

                    var limitValues = "[id^='limitov-" + data.date + "']";

                    $(limitValues).each(function () {
                        var limitElement = $(this);
                        var id = limitElement.attr("id");
                        bindLimit(id);
                    });

                    var commentPanels = "[id^='comment-" + data.date + "']";

                    $(commentPanels).each(function () {
                        var commentPanel = $(this);
                        var id = commentPanel.attr("id");
                        bindComment(id);
                    });

                    var totalButtons = "[id^='total-" + data.date + "']";

                    $(totalButtons).each(function () {
                        var totalButton = $(this);
                        var id = totalButton.attr("id");
                        bindTotalButton(id);
                    });

                });

                function bindTotalButton(selector){
                    selector = "#"+selector;
                    var calculator = $(".input-group-addon", $(selector));
                    var serviceOption = selector.replace('total','selectso');
                    var quantity = selector.replace('total','quantity');
                    var totalInput = $("input", $(selector));
                    var addService = selector.replace('total','srvsubmit');
                    addService = $(addService);
                    var productAssign = $(selector).closest('.product-panel');
                    var serviceBody = $(selector).closest(".service-body");
                    var panel = $(selector).closest('.service-panel');
                    var serviceContainer = $(".service-container", panel);
                    var totalPrice = $(".service-price",serviceBody);
                    var availSlot =  $(selector).closest('.availability-panel');

                    serviceContainer.on('click','span .fa-pencil',function(){
                        var curr = $(this);
                        var row = curr.closest('.service-row');
                        var id = row.data("id");
                        var type = row.data("type");
                        var company = row.data("company");
                        var option = row.data("option");
                        var quantity = row.data("quantity");
                        var total = row.data("total");
                        $(".service-row",serviceContainer).removeClass("edit");
                        row.addClass("edit");
                        $(".edit-mode",serviceBody).show();
                        $(".save-mode",serviceBody).hide();
                        var serviceCompany = $(".service-company",serviceBody);
                        var serviceOption = $(".service-option",serviceBody);
                        var serviceType = $(".service-type",serviceBody);
                        var serviceCompanySelector = "#"+serviceCompany.attr("id");
                        serviceCompanySelector = serviceCompanySelector.replace("s2id_","");
                        var serviceOptionSelector = "#"+serviceOption.attr("id");
                        serviceOptionSelector = serviceOptionSelector.replace("s2id_","");
                        $("#"+serviceType.attr("id")).select2("val",type);
                        $(serviceCompanySelector).select2("destroy");
                        $(serviceCompanySelector).select2({minimumResultsForSearch: Infinity});
                        loadSelectDataSet(serviceCompanySelector,"services/company",{service_type_id : type}, company);
                        $(serviceCompanySelector).prop("disabled", false);
                        $(serviceOptionSelector).select2("destroy");
                        $(serviceOptionSelector).select2({minimumResultsForSearch: Infinity});
                        loadSelectDataSet(serviceOptionSelector,"services/option",{service_id : company},option);
                        $(serviceOptionSelector).prop("disabled", false);
                        var quantitySelector = serviceOptionSelector.replace('selectso','quantity');
                        var totalSelector = serviceOptionSelector.replace('selectso','total');
                        $(quantitySelector).val(quantity);
                        $(totalSelector+" input").val(total+"€");
                    });

                    serviceBody.on('click','.edit-mode .btn-warning',function(){
                        clearFields();
                    });

                    serviceBody.on('click','.edit-mode .btn-success',function(){
                        addUpdateService();
                    });


                    $(".service-price",serviceBody).inputmask('decimal',{
                        radixPoint : ',',
                        autoGroup : false ,
                        digits : 2 ,
                        digitsOptional : false,
                        suffix: ' €',
                        placeholder: '0',
                        rightAlign: false
                    });

                    function clearFields(){
                        $(".service-row",serviceContainer).removeClass("edit");
                        $(".save-mode",serviceBody).show();
                        $(".edit-mode",serviceBody).hide();
                        var serviceCompany = $(".service-company",serviceBody);
                        var serviceOption = $(".service-option",serviceBody);
                        var serviceType = $(".service-type",serviceBody);
                        var serviceCompanySelector = "#"+serviceCompany.attr("id");
                        serviceCompanySelector = serviceCompanySelector.replace("s2id_","");
                        var serviceOptionSelector = "#"+serviceOption.attr("id");
                        serviceOptionSelector = serviceOptionSelector.replace("s2id_","");
                        $("#"+serviceType.attr("id")).select2("val","");
                        $(serviceCompanySelector).select2("destroy");
                        $(serviceCompanySelector).find('option').remove().end().append('<option value=""></option>');
                        $(serviceCompanySelector).prop("disabled", true);
                        $(serviceOptionSelector).select2("destroy");
                        $(serviceOptionSelector).prop("disabled", true);
                        $(serviceOptionSelector).find('option').remove().end().append('<option value=""></option>');
                        var quantitySelector = serviceOptionSelector.replace('selectso','quantity');
                        var totalSelector = serviceOptionSelector.replace('selectso','total');
                        $(quantitySelector).val('');
                        $(totalSelector+" input").val('');
                    }

                    serviceContainer.on('click','span .fa-remove',function(){
                        var curr = $(this);
                        var row = curr.closest('.service-row');
                        var id = row.data("id");
                        row.fadeOut(500,function(){
                            row.remove();
                        });
                        $.post( "/admin/services/tour-manager/services/options/delete", {id : id }).done(function(data){
                            row.fadeOut(500,function(){
                                row.remove();
                            });
                        });
                    });

                    addService.on('click',function(){
                        addUpdateService();
                    });


                    function addUpdateService(){
                        var serviceOptionId = $(serviceOption).val();
                        var quantityValue = $(quantity).val();
                        var id = serviceBody.data("id");
                        var price = totalPrice.val();
                        var avail = availSlot.data("id");
                        var date = availSlot.data("date");
                        var product = productAssign.data('id');
                        var assign = productAssign.data('assign');

                        console.log("added:"+productAssign.data('assign'));
                        if(quantityValue && serviceOptionId) {
                            $.post( "/admin/services/tour-manager/services/options/update", {id : id,option : serviceOptionId , assign : assign, quantity : quantityValue, price : price , date: date, product: product, avail : avail}).done(function(data){
                                //service name - option name - quantity - price
                                if(data.mode > 0){
                                    var serviceRow = $("#service-row-template").html();
                                    var template = Handlebars.compile(serviceRow);
                                    var html = template({ id : data.id,
                                        service_name : data.service_name ,
                                        option_name : data.option_name,
                                        quantity : data.quantity,
                                        unit_price : data.unit_price ,
                                        iva : data.iva,
                                        type_id : data.type_id,
                                        total_price : data.total_price,
                                        service_id : data.service_id,
                                        option_id : data.option_id });
                                    productAssign.data('assign',data.assign_id);
                                    console.log("added:"+productAssign.data('assign'));
                                    serviceContainer.append(html);
                                } else {
                                    var element = $("[data-id='"+data.id+"']",serviceContainer);
                                    element.data("type",data.type_id);
                                    element.data("company",data.sevice_id);
                                    element.data("option",data.option_id);
                                    element.data("quantity",data.quantity);
                                    var totalPrice = parseFloat(data.unit_price)+parseFloat(data.iva);
                                    var total = parseFloat(totalPrice)*data.quantity;
                                    total = Math.round(total*100)/100;
                                    if(data.total_price){
                                        total = data.total_price
                                    }
                                    total = total+"";
                                    total = total.replace(".",",");
                                    element.data("total",total);
                                    var text = data.service_name + " - " + data.option_name + " - " + data.quantity + " - " + total+"€";
                                    element = $(".service-area", element);
                                    element.html(text);
                                }
                                clearFields();
                            });
                        }
                    }

                    $(quantity).on('blur',function(){
                        compute();
                    });

                    calculator.on('click',function(){
                        compute();
                    });

                    function compute(){
                        var serviceOptionId = $(serviceOption).val();
                        var quantityValue = $(quantity).val();
                        $.get( "/admin/services/tour-manager/services/options/price",{ id : serviceOptionId}).done(function(price){
                            var total = parseFloat(price)*parseFloat(quantityValue);
                            total = Math.round(total*100)/100;
                            total = total+"";
                            total = total.replace(".",",");
                            if(quantityValue){
                                totalInput.val(total+"€");
                            }
                        });
                    }
                }

                function bindComment(selector){
                    selector = "#"+selector;
                    var commentContainers = $(".comment-container",$(selector));
                    var commentBody = $(".comment-body",$(selector));
                    var productAssign = $(selector).closest('.product-panel');
                    var assign = productAssign.data('assign');
                    var addnote = $("button",commentBody);
                    var availSlot =  $(selector).closest('.availability-panel');

                    addnote.on('click',function(){
                        var body = $(this).closest('.comment-body');
                        var panel = $(this).closest('.comment-panel');
                        var cont =  $(".comment-container",panel);
                        var textarea = $("textarea",body);
                        var commentText = textarea.val().replace(/\r?\n/g, '<br>');
                        var avail = availSlot.data("id");
                        var date = availSlot.data("date");
                        var product = productAssign.data('id');
                        var assign = productAssign.data('assign');

                        if(commentText){
                            $.post( "/admin/services/tour-manager/note/update", {id : 0 , assign : assign, comment : commentText,  date: date, product: product, avail : avail}).done(function(data){
                                var saveRow = $("#comment-row-template").html();
                                var template = Handlebars.compile(saveRow);
                                var html = template({ comment : commentText , time_ago: data.time , name : data.name, id : data.id });
                                cont.append(html);
                                var lastCommentRow = $('.comment-container .comment-row:last-child',panel);
                                var lastCommentArea = $('.comment-area',lastCommentRow);
                                lastCommentArea.effect("highlight", {}, 1000);
                                textarea.val('');

                            });
                        }
                    });

                    $(commentContainers).each(function(){
                        var container = $(this);
                        container.on('click','.comment-row span .editsave',function(){
                            var curr = $(this);
                            var row = curr.closest('.comment-row');
                            var area = $(".comment-area",row);
                            var commentTime = $(".comment-area small",row);
                            var id = row.data("id");
                            if(curr.hasClass("fa-pencil")){
                                curr.removeClass("fa-pencil").addClass("fa-check");
                                var commentText = $(".comment-area div",row).html();
                                var editRow = $("#comment-edit-row-template").html();
                                var template = Handlebars.compile(editRow);
                                commentText = commentText.replace(/<br>/g,'\r\n');
                                var html = template({ comment : commentText});
                                area.html(html);

                            } else {
                                curr.removeClass("fa-check").addClass("fa-pencil");
                                var commentText = $(".comment-area textarea",row).val().replace(/\r?\n/g, '<br>');
                                $.post( "/admin/services/tour-manager/note/update", {id : id , assign : assign, comment : commentText}).done(function(data){
                                    var saveRow = $("#comment-save-row-template").html();
                                    var template = Handlebars.compile(saveRow);
                                    var html = template({ comment : commentText , time_ago: data.time });
                                    area.html(html);
                                    area.effect("highlight", {}, 1000);
                                });
                            }

                        });

                        container.on('click','.comment-row span .fa-remove',function(){
                            var curr = $(this);
                            var row = curr.closest('.comment-row');
                            var id = row.data("id");
                            $.post( "/admin/services/tour-manager/note/delete", {id : id }).done(function(data){
                                row.fadeOut(500,function(){
                                    row.remove();
                                });
                            });
                        });
                    });


                }

                function bindLimit(selector){
                    selector = "#"+selector;
                    var pencilButton = $(selector+" .limitshow .action");
                    var limitShow = $(selector+" .limitshow");
                    var limitEdit = $(selector+" .limitedit");
                    var cancelButton = $(".cancel",limitEdit);
                    var saveButton = $(".save",limitEdit);
                    var limitEditValue = $(".limit-value",limitEdit);
                    var limitShowValue = $(".limit-value",limitShow);
                    var limitTotalValue = $(".limit-total",$(selector));
                    var limitRemainingValue = $(".limit-remaining",$(selector));
                    var limitEditOldValue;
                    var availSlot =  $(selector).closest('.availability-panel');
                    var avail = availSlot.data("id");
                    var date = availSlot.data('date');

                    pencilButton.on('click',function(){
                        limitEditOldValue = limitEditValue.val();
                        limitShow.hide();
                        limitEdit.show();
                    });

                    cancelButton.on('click',function(){
                        limitEditValue.val(limitEditOldValue);
                        limitShow.show();
                        limitEdit.hide();
                    });

                    saveButton.on('click',function(){
                        limitShow.show();
                        limitEdit.hide();
                        var limitValue = limitEditValue.val();

                        if(limitValue){
                            limitShowValue.text(limitValue);
                        } else {
                            limitValue = null;
                            limitShowValue.text('U');
                        }

                        if(limitValue == null){
                            limitRemainingValue.text('U');
                        } else {
                            limitRemainingValue.text(limitValue-parseInt(limitTotalValue.text()));
                        }

                        $.ajax({
                            url: '/admin/services/tour-manager/limit/update',
                            data: {avail: avail, date: date, limit: limitValue},
                            type: 'POST',
                            dataType: 'JSON'
                        });

                    });
                }


                function bindPanel(selector){
                    selector = "#"+selector;

                    $(selector+" .panel-heading a").on('click',function(){
                        var avail = $(this);
                        var panel = avail.closest('.availability-panel');
                        var panelBody = $(".availability-body",panel);

                        var isActive = avail.hasClass('active');
                        var icon = $("i",avail);

                        if(!isActive){
                            avail.addClass("active");
                            icon.removeClass("fa-chevron-right").addClass("fa-chevron-down");
                            panelBody.slideDown("fast");
                        } else {
                            avail.removeClass('active');
                            icon.removeClass("fa-chevron-down").addClass("fa-chevron-right");
                            panelBody.slideUp("fast");
                        }
                    });
                }

                function bindOption(selector){
                    selector = "#"+selector;

                    $(selector).on('change',function(){
                        var selector = $(this);
                        selector = "#"+selector.attr('id');
                        var availSlot =  $(selector).closest('.availability-panel');
                        var date = availSlot.data('date');
                        var pol = $(selector).data('pol');
                        var dataSelector = "[data-pol='"+pol+"']";

                        var check = $(this).is(':checked');
                        var block = check ? 0 : 1;

                        $(dataSelector,availSlot).each(function(){
                            $(this).prop('checked', check);
                        })

                        $.ajax({
                            url: '/admin/services/tour-manager/option/update',
                            data: {pol: pol, date: date, block: block},
                            type: 'POST',
                            dataType: 'JSON'
                        });

                    });

                }

                function bindTab(selector){
                    selector = "#"+selector;
                    var commentSelector = selector.replace('tabs','comment');
                    var serviceSelector = selector.replace('tabs','service');
                    var allSpan = selector+" span";
                    $(selector+" span .fa-paperclip").on('click',function(event){
                        var span = $(this);
                        $(allSpan).removeClass("selected");
                        span.closest('span').addClass("selected");
                        $(commentSelector).toggle();
                        $(serviceSelector).hide();
                    });
                    $(selector+" span .fa-bus").on('click',function(event){
                        var span = $(this);
                        $(allSpan).removeClass("selected");
                        span.closest('span').addClass("selected");
                        $(serviceSelector).toggle();
                        $(commentSelector).hide();
                    });
                };

                $(document).bind('click', function(e) {
                    var $clicked = $(e.target);
                    if (!$clicked.parents().hasClass("guide-dropdown")) $(".guide-dropdown dd ul").hide();
                });

                var guideCache = {};

                function bindDropdown(selector) {
                    var plainSelector = selector;
                    guideCache[plainSelector] = [];
                    selector = "#" + selector;

                    var prefixId = plainSelector.replace("dropdown", "guide");

                    var selectedGuides = $(selector.replace("dropdown", "dropval")).data("value");
                    var languageIds = $(selector.replace("dropdown", "dropval")).data("languages");
                    var selectedGuideList = $(selector.replace("dropdown", "dropval")).val();
                    selectedGuideList = selectedGuideList.split(",");
                    selectedGuideList = removeEmptyArray(selectedGuideList);

                    var guides = [];
                    $.get( "/admin/services/guides/sort", { language_ids : languageIds}).done(function(data){
                        guideData = data;

                        $.each(guideData, function (index, value) {
                            var obj = {};
                            obj.id = value.id;
                            obj.name = value.text;
                            obj.base_id = prefixId + "-" + value.id;
                            var active = getActive(selectedGuides, value.id);
                            obj.active = active;
                            obj.unmatch = value.match ? 0 : 1;
                            if ($.inArray(value.id + "", selectedGuideList) > -1) {
                                obj.selected = 1;
                                guideCache[plainSelector].push(obj);
                            }
                            guides.push(obj);
                        });

                        var guidesContent = $("#guides-load-template").html();
                        var template = Handlebars.compile(guidesContent);
                        var html = template({guides: guides});
                        $(selector + " .multi-select ul").append(html);

                        $(selector + " dt a").on('click', function (event) {
                            event.preventDefault();
                            $(selector + " dd ul").slideToggle('fast');
                        });

                        $(selector + " dd ul li a").on('click', function () {
                            $(selector + " dd ul").hide();
                        });

                        $(selector + ' .multi-select .confirm i').on('click', function () {
                            var select = $(this);
                            var value = select.data("value");
                            var newValue = value == 0 ? 1 : 0;
                            select.data("value", newValue);
                            var id = select.closest('li').find('input').val();
                            if (value == 0) {
                                select.removeClass('fa-remove').addClass('fa-check');
                                select.parent().removeClass('text-danger').addClass('text-success');
                            } else {
                                select.removeClass('fa-check').addClass('fa-remove');
                                select.parent().removeClass('text-success').addClass('text-danger');
                            }

                            changeActive(plainSelector, id, newValue);
                            updateValues(selector, guideCache[plainSelector]);
                        });

                        $(selector + ' .multi-select ul').bind('mousewheel DOMMouseScroll', function (e) {
                            var e0 = e.originalEvent,
                                    delta = e0.wheelDelta || -e0.detail;

                            this.scrollTop += ( delta < 0 ? 1 : -1 ) * 30;
                            e.preventDefault();
                        });

                        $(selector + ' .multi-select input[type="checkbox"]').on('click', function () {
                            var name = $(this).parent().find('label').text();
                            var id = $(this).val();
                            var active = $(this).parent().find('span i').data("value");

                            var selected = {
                                name: name,
                                id: parseInt(id),
                                active: active
                            };

                            if ($(this).is(':checked')) {
                                var unmatch = $(this).data("unmatch");
                                var liContainer = $(this).parent();
                                if (unmatch) {
                                    swal(
                                        {
                                            title: "Assign anyway?",
                                            text: "Guide not enabled for any of these languages",
                                            type: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: "#d9534f",
                                            confirmButtonText: "Yes, assign it!",
                                            cancelButtonText: "Cancel",
                                            closeOnConfirm: true, closeOnCancel: true
                                        },
                                        function (isConfirm) {
                                            if (isConfirm) {
                                                $(selector + " .hida").hide();
                                                liContainer.addClass("selected");
                                                selected.unmatch = 1;
                                                guideCache[plainSelector].push(selected);
                                                updateValues(selector, guideCache[plainSelector]);
                                            }
                                        }
                                    );
                                } else {
                                    $(selector + " .hida").hide();
                                    liContainer.addClass("selected");
                                    guideCache[plainSelector].push(selected);
                                    updateValues(selector, guideCache[plainSelector]);
                                }
                            } else {
                                $(this).parent().removeClass("selected");
                                deleteGuide(plainSelector, selected.id);
                                if (guideCache[plainSelector].length < 1) {
                                    $(selector + " .hida").show();
                                }
                                updateValues(selector, guideCache[plainSelector]);
                            }
                        });
                    });
                }

                function getActive(list,id){
                    var active = 0;
                    for(var i in list){
                        var confirm =  list[i][id];
                        active = (typeof confirm == 'undefined') ? 0 : confirm;
                        if(active) break;
                    }
                    return active;
                }

                function  changeActive(selector,id, value){
                    for(var i in guideCache[selector]){
                        if(guideCache[selector][i].id == id){
                            guideCache[selector][i].active = value;
                            break;
                        }
                    }
                }

                function deleteGuide(selector,id){
                    for(var i in guideCache[selector]){
                        if(guideCache[selector][i].id == id){
                            guideCache[selector].splice(i,1);
                            break;
                        }
                    }
                }

                function updateValues(selector,guides){
                    var dropVal = selector.replace("dropdown","dropval");
                    var ids = [];
                    for(key in guides){
                        ids.push(guides[key].id);
                    }
                    $(dropVal).val(ids.join());
                    writeGuideValues(selector, guides);
                    $(selector+" .result-element").remove();
                    var guideList = { guides : guides};
                    var columnContent = $("#guides-template").html();
                    var template = Handlebars.compile(columnContent);
                    var html = template(guideList);
                    $(selector+" .result-container").append(html);
                }

                function writeGuideValues(selector,guides){
                    var productAssign = $(selector).closest('.product-panel');
                    var availSlot =  $(selector).closest('.availability-panel');
                    var assign = productAssign.data('assign');
                    var product = productAssign.data('id');
                    var date = availSlot.data('date');
                    var avail = availSlot.data('id');
                    $.ajax({
                        url: '/admin/services/tour-manager/guide/update',
                        data: {assign: assign, guides: guides, avail : avail , product : product , date: date},
                        type: 'POST',
                        dataType: 'JSON'
                    });
                }

            });
        });

    });
</script>
@stop
