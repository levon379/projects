var isDrawingStarted = false;
var currentToolType  = "SelectionTool";
var currentFontSize  = 11;
var maxFontSize      = 72;
var minFontSize      = 3;
//var default_asset    = '';
var chart;


function run_any_chart()
{
    asset = decodeURI((RegExp("asset" + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
    if(asset!=undefined && asset!=null && asset!="null") {
        key = asset;
        $("#what").find("option").each(function() {
            if(this.text == asset)
                key = this.value;
        })
        asset = key;
        
    } else {
        var asset = $('#what option:selected').val();
        if (asset == '') {
            asset = get_default_data();
        }
    }
    var url  = 'http://' + getThisURL();
    url     += '/CommuniTraders/assets/js/';
    // Creating new chart object. 
    chart = new AnyChartStock(url + 'swf/AnyChartStock.swf?v=1.0.0r7416', url + 'swf/Preloader.swf?v=1.0.0r7416');
    // Setting XML config file.	
    
    // Set XML config file.
    chart.wMode = "opaque";
    
    chart.setXMLFile(url + 'configs/' + asset + '.xml');
    // Writing the flash object into the page DOM.
    chart.write("chartContainer");
    
    // Add flash component context menu event listeners.
    chart.onContextMenuCustomItemClick = function(id) {
        switch (id) {
            case "idMenuRemoveAllAnnotations":
                chart.removeAllAnnotations();
                selectTool("SelectionTool");
                switchPropertiesPanels("SelectionTool");
                break;
            case "idMenuRemoveSelectedAnnotation":
                chart.removeAnnotation(chart.getSelectedAnnotationId());
                break;
        };
    };
			
    // Add onAnnotationDrawingFinish event listener.
    chart.onAnnotationDrawingFinish = function(id) {
        isDrawingStarted = false;

        var annotation = chart.getAnnotationAsJSON(id);
        if (annotation == null) return;

        if (annotation.type == "Line") {
            startToolDrawing("Line");
        } else {
            selectTool("SelectionTool");
            chart.selectAnnotation(id);
        }

    }

    // Add on AnnotationSelect event listener.
    chart.onAnnotationSelect = function(id) {
        var annotation = chart.getAnnotationAsJSON(id);
        if (annotation == null) return;

        switchPropertiesPanels(annotation.type);
        updatePropertiesBySelectedAnnotation();
    }

    chart.onAnnotationDeselect = function(id) {
        switchPropertiesPanels("SelectionTool");
    } 
}
       
$(document).ready(function() {
    var reports = $('#is_report').val();
    if (!reports) {
        runWithoutGame();
        requestData();
    }
    if (reports == 1) {
        var paginate = $('#is_paginate').val();
        if (paginate == 1) {
            show_with_paginate();
        }
        else if (paginate == 0) {
            show_without_paginate();
        }
    }
    $('#second_box').hide();
    $('#strategy_promt').hide();
    var start_default = $('#main_page_tool').val();
    if (start_default == 1) {
        update_news();
    }
    if (start_default == 0) {
        updateOtherGamesInfo();
        show_all_open();
        show_all_close();
    }
    updateCurrentGame();
    
    // Main toolset handler
    $("#main-toolset").delegate(".tool a", "click", function(e) {
        // Prevent default behavior of an event - to get rid of '#' in location
        e.preventDefault();

        var tool = $(this),
        tool_name = $.trim(tool.attr("class").replace("current", ""));

        // Shortcut for a tool, which is already set as current 
        if (tool.hasClass("current")) {
            return false;
        } 
				
        // Select proper button in drawing toolbar.
        selectTool(tool_name);
				
        // Start tool drawing.
        if (tool_name != "SelectionTool") startToolDrawing(tool_name);
        else {
            isDrawingStarted = false;
            currentToolType = "SelectionTool";
            chart.stopDrawingAnnotation();
            switchPropertiesPanels("SelectionTool");
        }
    });

    // Colorpicker toolbar handler.
    $("#colorpicker").delegate("a", "click", function(e) {
        // Prevent default behavior of an event - to get rid of '#' in location
        e.preventDefault();
    
        // Set proper color item as selected in colorpicker toolbar
        var color = $(this),
        color_hex = $.trim(color.find("span").attr("class").replace(/(current|color-)/, ""));
    
        selectColor(color_hex);
    				
        // Update color for the annotation which is in drawing stage.
        restartToolDrawing();
        // Update color for the currently selected annotation on the chart.
        updateSelectedAnnotation();
    });

    // Text properties toolbar handler.
    $("#text-tools").delegate("a", "click", function(e) {
        // Prevent default behavior of an event - to get rid of '#' in location.
        e.preventDefault();
    
        var tool = $(this),
        tool_name = $.trim(tool.attr("class").replace("current", ""));
    
        // Tool specific actions.
        switch (tool_name) {
            case "bold-text":
                tool.toggleClass("current");
                break;
            case "italic-text":
                tool.toggleClass("current");
                break;
            case "increase-text-size":
                currentFontSize += 3;
                if (currentFontSize > maxFontSize) currentFontSize = maxFontSize;
                break;
            case "decrease-text-size":
                currentFontSize -= 3;
                if (currentFontSize < minFontSize) currentFontSize = minFontSize;
                break;
        }
    
        restartToolDrawing();
        updateSelectedAnnotation();
    });

    // Line tools handler
    $("#line-tools").delegate("a", "click", function(e) {
        // Prevent default behavior an of event - to get rid of '#' in location
        e.preventDefault();
    
        var tool = $(this),
        tool_name = $.trim(tool.attr("class").replace("current", ""));
    
        // Tool specific actions
        switch (tool_name) {
            case "dashed-line":
                // Should work only for dashed-line
                tool.toggleClass("current");
                break;
            default:
                tool_name = tool_name.match(/brush-(\d+)px/)[1];
                selectThickness(tool_name);
        }
        restartToolDrawing();
        updateSelectedAnnotation();
    });

    // Dialog handler
    $(".disclaimer, .help").click(function(e) {
        // Prevent default behavior of an event - to get rid of '#' in location
        e.preventDefault();
    				
        var type = $(this).attr("class"),
        dialog = $("#" + type + "-dialog"),
        shader = $(".shader")
        doc_height = $(document).height(),
        doc_width = $(document).width();
    
        dialog.css({
            top: (doc_height / 2) - 176, // 176 ~= dialog height / 2
            left: (doc_width / 2) - 336 // 336 ~= dialog width / 2
        });
    
        shader.show();
        dialog.show();
    });
    
    /* Close dialog handlers */
    // Close dialog on ESC
    $(document).keydown(function(e) {
        if (27 === e.keyCode) {
            // NOTE: do not bother finding out if the dialog is opened, just hide it
            $(".shader, #disclaimer-dialog, #help-dialog").hide();
        } else {
        // Do nothing
        }
    });
    // Close the dialog on close button click and on shader click
    $(".dialog-close-button, .shader").click(function(e) {
        // Prevent default behavior an of event - to get rid of '#' in location
        e.preventDefault();
        $(".shader, #disclaimer-dialog, #help-dialog").hide();
    });
    
    // Remove all handler
    $(".remove-all").click(function(e) {
        // Prevent default behavior of an event - to get rid of '#' in location
        e.preventDefault();
    
        chart.removeAllAnnotations();
        selectTool("SelectionTool");
        switchPropertiesPanels("SelectionTool");
    });
    // Set default settings for UI elements.
    selectTool("SelectionTool");
    selectThickness(2);
    checkDashButton(false);
    selectColor("DB2A0E");
    checkTextBold(false);
    checkTextItalic(false);
    //activate chzn select
    $(".chzn-select").chosen();


    //set asset, if one provided in url:
    asset = decodeURI((RegExp("asset" + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
    if(asset!=undefined && asset!=null) {
        key = asset;
        $("#what").find("option").each(function() {
            if(this.text == asset)
                key = this.value;
        })

        $("#what").val(key).trigger("liszt:updated");
    }
});



function getThisURL()
{
    pathArray = location.href.split("://");
    pathArray = pathArray[1].split( '/' );
    host = pathArray[0];
    return host;
}

/**
 * Request data from the server, add it to the graph and set a timeout to request again
 */
function requestData()
{
    var csvData = '';
    var json_data;
    var cct = $.cookie('ci_csrf_token');   
    var url = 'http://' + getThisURL();
    var asset = $('#what option:selected').val();
    if (asset == '') {
        asset = $('#default_asset').val();
    }
    var asset_name = $('#what option:selected').val();
    if (asset_name == 'Assets') {
        asset_name = asset;
    }
    $(".assets_name_news").html(asset_name + '&nbsp;News');
    $(".assets_name_details").html(asset_name + '&nbsp;Details');
    var selectValue = $('#strategy').val();
    var if_start = $('#run_w_g').val();
    if (if_start == 1) {
        var save_option = $('input[name="optionsRadios"]:checked').val()
        var how_to_play = $('#is_post').val();
        var expire = $('#expire').val();
        var strategy = $('#strategy').val();
        var price = $('#price').val();
        var investment = $('#investment').val();
        if (strategy == 'boundary_out' || strategy == 'boundary_inside') {
            var price_from = $('#price_from').val();
            var price_to   = $('#price_to').val();
            json_data = {
                'asset'       : asset,
                'if_start'    : if_start,
                'expire'      : expire,
                'strategy'    : strategy,
                'investment'  : investment,
                'price_from'  : price_from,
                'price_to'    : price_to,
                'save_option' : save_option,
                'how_to_play' : how_to_play,
                'ci_csrf_token': cct
            };
        }
        else {
            json_data = {
                'asset'       : asset,
                'if_start'    : if_start,
                'expire'      : expire,
                'strategy'    : strategy,
                'investment'  : investment,
                'price'       : price,
                'save_option' : save_option,
                'how_to_play' : how_to_play,
                'ci_csrf_token': cct
            };
        }
        $('#run_w_g').attr('value', 0);
    }
    else {
        json_data = {
            'asset'    : asset,
            'if_start' : if_start,
            'ci_csrf_token': cct
        }
    }
    url += '/CommuniTraders/ajax/get_data';
    $.post(url, json_data, function(data) {
        // add the values
        if (data != 'unavailable') {
        var obj = jQuery.parseJSON(data);
        $('#fiftytwo_right_price').html(obj.max_d);
        $('#fiftytwo_left_price').html(obj.min_d);
        $('#left_small_price').html(obj.t_r_min); 
        $('#right_small_price').html(obj.t_r_max);
        
        $('#asd_asset').html(obj.z);
        var curr_prices = '$' + obj.y;
        var percents    = obj.a_per;
        var regexp      = /^\-\d*/;
        $('#curr_price_1').html('Price:&nbsp;'+curr_prices);
        if((obj.a_pr * 1) < 0){
            $('#curr_price_2').html('&nbsp;&nbsp;'+obj.a_pr); 
            $('#curr_price_2').removeClass('green_price');
            $('#curr_price_2').addClass('red_price');
        }
        else{
            $('#curr_price_2').html('&nbsp;&nbsp;'+obj.a_pr); 
            $('#curr_price_2').removeClass('red_price');
            $('#curr_price_2').addClass('green_price');
        }
        if (regexp.test(percents)) {
            $('#curr_price_3').html('&nbsp;&nbsp;'+obj.a_per);
            $('#curr_price_3').removeClass('green_price'); 
            $('#curr_price_3').addClass('red_price');
        }
        else{
            $('#curr_price_3').html('&nbsp;&nbsp;'+obj.a_per);
            $('#curr_price_3').removeClass('red_price');  
            $('#curr_price_3').addClass('green_price');
        }       
        $('#current_price').attr('value', obj.y);
        if (selectValue != 'touch' && selectValue != 'no_touch') {
            $('#price').attr('value', obj.y);
        }
        $('#price').css('background-color', '');
        // Add point to chart
        var isstart = $('#isstart').val();
        //if (isstart == 1) {
            var asset_name  = $('#what option:selected').text();
            var date   = obj.x;
            var open   = obj.y;
            var high   = obj.max_d;
            if (high == 'N\/A') {
                high = obj.y;
            }
            var low = obj.min_d;
            if (low == 'N\/A') {
                low = obj.y; 
            }
            var close  = obj.close;
            var volume = obj.volume;
            //if (volume == '0') {
              //  close = open;
            //} 
            var csvData = date + "," + open + "," + high + "," + low + "," + open + "," + volume + "\n";
            //alert(csvData);
            chart.appendData('dataSet' + asset_name, csvData, 0);
            chart.commitDataChanges();
        //}
    }
    else {
        $('#curr_price_1').html('Waiting for data...');
    }
        // call it again after five seconds
        setTimeout(requestData, 5000);    
    });
}

function runWithoutGame()
{
    //requestData();
    run_any_chart();
    $("#select_status").html('');
    $('#current_price_open').html('Waiting for current price');
    $('#price').attr('value', 'Please Wait');
    $('#price').css('background-color', '#FFA500');
}

function run(how_to_play, thread_id)
{
    //$('#isstart').attr('value', 1);
    if (how_to_play == 1) {
        $('#is_post').attr('value', 1);
    }
    var asset      = '';
    var expire     = '';
    var strategy   = '';
    var price      = '';
    var price_from = '';
    var price_to   = '';
    var title      = '';
    var comment    = '';
    var forum_id   = '';
    var icon_id    = '';
    var visible    = '';
    var comment_kw = '';
    var disclosure = 0;
        
    var userCache = $('#userCache').val() * 1;
    var investment = $('#investment').val() * 1;
    if ( investment == '') {
        $("#select_status").empty();
        errorMessage = ' <div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">X</button> Please set the Investment amount.</div> '
        $("#select_status").html(errorMessage);
        $('#run_w_g').attr('value', 0);
        return false;

    }
    if ((userCache) < (investment)){
        $("#select_status").empty();
        errorMessage = ' <div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">X</button> The investment amount exceeds your balance.</div> '
        $("#select_status").html(errorMessage);
        $('#run_w_g').attr('value', 0);
        return false;
    }           
    asset = $('#what option:selected').val();
    if (asset == '') {
        $("#select_status").empty();            
        errorMessage = ' <div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">X</button> Please Set an Asset to Trade.</div> '
        $("#select_status").html(errorMessage);
        $('#run_w_g').attr('value', 0);
        return false;
    }
    expire = $('#expire').val();
    if (expire == '') {
        $("#select_status").empty();
        errorMessage = ' <div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">X</button> Please set an Expiry Time.</div>'
        $("#select_status").html(errorMessage);
        $('#run_w_g').attr('value', 0);
        return false;
    }
    strategy = $('#strategy').val();
    if (strategy == '') {
        $("#select_status").empty();
        errorMessage = ' <div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">X</button> Please choose Strategy.</div>'
        $("#select_status").html(errorMessage);
        $('#run_w_g').attr('value', 0);
        return false;
    }
    price = $('#price').val();
    if (price == '' || price == 'Input price') {
        $("#select_status").empty();
        errorMessage = ' <div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">X</button> Price can\'t be empty.</div> '
        $("#select_status").html(errorMessage);
        $('#run_w_g').attr('value', 0);
        return false;
    }
    else if (price) {
        if (!/^\d+[.,]?\d*?$/.test(price)) {
            $("#select_status").empty();
            errorMessage = ' <div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">X</button> Wrong lower price format.</div>'
            $("#select_status").html(errorMessage);
            $('#run_w_g').attr('value', 0);
            return false;
        }
    }
    price_from = $('#price_from').val();
    if (price_from == '' || price_from == 'Input price from') {
        $("#select_status").empty();
        errorMessage = ' <div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">X</button> Price feild1 can\'t stay empty</div>'
        $("#select_status").html(errorMessage);
        $('#run_w_g').attr('value', 0);
        return false;
    }
    else if (price_from){
        if (!/^\d+[.,]?\d*?$/.test(price_from)) {
            $("#select_status").empty();
            errorMessage = ' <div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">X</button> Wrong price format at field1.</div>'
            $("#select_status").html(errorMessage);
            $('#run_w_g').attr('value', 0);
            return false;
        }
    }
    price_to = $('#price_to').val();
    if (price_to == '' || price_to == 'Input price to') {
        $("#select_status").empty();
        errorMessage = ' <div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">X</button> Price feild2 can\'t stay empty.</div>'
        $("#select_status").html(errorMessage);
        $('#run_w_g').attr('value', 0);
        return false;
    }
    else if (price_to) {
        if ( !/^\d+[.,]?\d*?$/.test(price_to) ) {
            $("#select_status").empty();
            errorMessage = ' <div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">X</button> Wrong price format at field2.</div>'
            $("#select_status").html(errorMessage);
            $('#run_w_g').attr('value', 0);
            return false;
        }
    }
    if (strategy == 'touch') {
        var curr_price = $('#current_price').val() * 1;
        var percent = curr_price * 1 / 100;
        if ((curr_price + percent) < (price*1)) {
            $("#select_status").empty();
            errorMessage = ' <div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">X</button> Input price for this strategy can\'t be more than 1% of the current price.</div> '
            $("#select_status").html(errorMessage);
            $('#run_w_g').attr('value', 0);
            return false;
        }
    }
    if (strategy == 'no_touch') {
        var curr_price = $('#current_price').val() * 1;
        var percent = curr_price * 1 / 100;
        if ((price + percent) < (curr_price)) {
            $("#select_status").empty();
            errorMessage = ' <div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">X</button> Input price for this strategy can\'t be less than 1% of the current price.</div> '
            $("#select_status").html(errorMessage);
            $('#run_w_g').attr('value', 0);
            return false;
        }
    }
    var price_from = $('#price_from').val();
    var price_to = $('#price_to').val();
    if (price_to != '' || price_from != '') {
        if(price_from > price_to ){
            $("#select_status").empty();
            errorMessage = ' <div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">X</button> Price from can\'t be bigger than price to.</div>'
            $("#select_status").html(errorMessage);
            $('#run_w_g').attr('value', 0);
            return false; 
        }      
    }
    
    var how_to_play = $('#is_post').val();
    if (how_to_play == 1) {
        title   = $('#title').val();
        tinyMCE.triggerSave();
        comment = $('#comment_field').val(); 
        if (title == '' || comment == '') {
            errorMessage = ' <div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">X</button> Please add a title and description to complete this trade sharing</div> '
            $('#run_w_g').attr('value', 0);
            $("#select_status").html(errorMessage);
            return false;
        }
        disclosure = $("#post_form input[type='radio']:checked").val();
        if (!disclosure) {
            errorMessage = ' <div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">X</button> Please select one of the way of disclosures</div>'
            $('#run_w_g').attr('value', 0);
            $("#select_status").html(errorMessage);
            return false;
        }
        icon_id    = $('input[name=iconid]:checked', '#post_form').val();
        visible    = $('#visible option:selected').val();
        comment_kw = $('#comment_kw').val();
        forum_id   = $('#forumid').val();
    }
    $("#select_status").empty();
    var cct = $.cookie('ci_csrf_token');   
    var url = 'http://' + getThisURL();
    url += '/CommuniTraders/ajax/create_game';
    var save_option = $('input[name="optionsRadios"]:checked').val()
    if (strategy == 'boundary_out' || strategy == 'boundary_inside') {
        var price_from = $('#price_from').val();
        var price_to   = $('#price_to').val();
        json_data = {
            'asset'        : asset,
            'expire'       : expire,
            'strategy'     : strategy,
            'investment'   : investment,
            'price'        : 0,
            'price_from'   : price_from,
            'price_to'     : price_to,
            'save_option'  : save_option,
            'how_to_play'  : how_to_play,
            'title'        : title,
            'comment'      : comment,
            'icon_id'      : icon_id,
            'visible'      : visible,
            'comment_kw'   : comment_kw,
            'disclosure'   : disclosure,
            'forum_id'     : forum_id,
            'thread_id'      : thread_id,
            'ci_csrf_token': cct
        };
    }
    else {
        json_data = {
            'asset'        : asset,
            'expire'       : expire,
            'strategy'     : strategy,
            'investment'   : investment,
            'price'        : price,
            'save_option'  : save_option,
            'how_to_play'  : how_to_play,
            'title'        : title,
            'comment'      : comment,
            'icon_id'      : icon_id,
            'visible'      : visible,
            'comment_kw'   : comment_kw,
            'disclosure'   : disclosure,
            'forum_id'     : forum_id,
            'thread_id'      : thread_id,
            'ci_csrf_token': cct
        };
    }
    var asset_name  = $('#what option:selected').text();
    var expire_name = $('#expire option:selected').text(); 
    $.post(url, json_data, function(data) {
        if (how_to_play == 1) {
            var obj = jQuery.parseJSON(data);
            var title = $('#title').val();
            url  = 'http://' + getThisURL();
            url += '/showthread.php/' + obj.thread_id + '-' + title;
            if(obj.post_id != undefined) {
                url += '#post' + obj.post_id;
            }
            exportImage(obj.game_id);
            show_dialog(1, strategy, investment, asset_name, expire_name, url);
        }
        else {
            show_dialog(0, strategy, investment, asset_name, expire_name, '');
        }
        $('#isstart').attr('value', 1);
    });
}

function appear_disapeare(inputId)
{
    var price = $("#"+inputId).val();
    price = trim(price);
    if (price == 'Input price' || price == 'Input price from' || price == 'Input price to') {
        $("#"+inputId).attr('value', '');
    }
    else if (price == '') {
        $("#"+inputId).attr('value', 'Input price');
    }
}

function trim(s) {
    s = s.replace(/^\s+/, '');
    s = s.replace(/\s+$/, '');
    return s;
}

function saveGame()
{
    var url = 'http://' + getThisURL();
    var cct = $.cookie('ci_csrf_token');
    var json_data = {
        'ci_csrf_token' : cct
    }
    url+='/CommuniTraders/ajax/save_the_game';
    $.post(url, json_data, function(data){    
        if(data == 1) {
            window.location.reload(true);
        }
    });
    return true;
}

function postGame()
{
    var url = 'http://' + getThisURL();
    var cct = $.cookie('ci_csrf_token');
    var json_data = {
        'ci_csrf_token' : cct
    }
    url+='/CommuniTraders/ajax/post_the_game';
    $.post(url, json_data, function(data){    
        if(data == 1) {
            window.location.reload(true);
        }
    });
    return true;
}

function showAlert(title, text, replace, reload, confirm, js) {
    replace = replace || "";
    reload = reload || false;
    confirm = confirm || false;
    js = js || '#';
    $('#dialog').html('');
    var html = '<div class="modal-header">';
    html += '<button class="close" data-dismiss="modal">&times;</button>';
    html += '<h3>'+title+'</h3>';
    html += '</div>';
    html += '<div class="modal-body">';
    html += '<p>'+text+'</p>';
    html += '</div>';
    html += '<div class="modal-footer">';
    if(!confirm){
        html += '<a href="#" data-dismiss="modal" class="btn btn-primary">��������������</a>';
    }else{
        html += '<div style="float:left"><a href="#" onClick="'+js+'" class="btn btn-danger">����</a></div>';
        html += '<a href="#" data-dismiss="modal" class="btn">������</a>';
    }
    
    if(replace != "" && replace != false){  
        html += '<input type="hidden" name="replace" id="replace" value="'+replace+'" />';
        html += '<input type="hidden" name="reload" id="reload" value="0" />';
    }else{
        if(reload == true){
            html += '<input type="hidden" name="reload" id="reload" value="1" />';        
        }else{
            html += '<input type="hidden" name="reload" id="reload" value="0" />'; 
        }
        html += '<input type="hidden" name="replace" id="replace" value="" />';
    }  
    html += '</div>';
    $('#dialog').html(html);
    $('#dialog').modal('show');
    return false;
}

function setStrategyInput(currentId, currentName)
{
    $('#strategy_select').focus();
    $('#strategy_promt').empty(); 
    $('#strategy_promt').hide();
    var selectValue = currentId;
    var newInput = '';
    if(selectValue=='boundary_out' || selectValue=='boundary_inside') {
        newInput = '<input id="price_from" type="text" value="Input price from" onClick="appear_disapeare(this.id);"><p><input id="price_to" type="text" value="Input price to" onClick="appear_disapeare(this.id);"></p>';        
        $('#price_input').addClass('two_price_input'); 
        $('#price_input').html(newInput);   
    }
    else
    {     
        newInput = '<input id="price" type="text" value="Input price" onClick="appear_disapeare(this.id);">';
        $('#price_input').removeClass('two_price_input');
    }
    if (selectValue == 'put' || selectValue == 'call') {
        $('#price_input').html(newInput);
        var current_price = $('#current_price').val();
        $('#price').attr('value', current_price);
        $('#price').attr('disabled', 'disabled');
    }
    if (selectValue == 'touch' || selectValue == 'no_touch') {
        $('#price_input').html(newInput);
        $('#price').removeAttr('disabled');
    }
    $("#strategy").remove();
    $("#strategy_val").html('<input id="strategy" type="hidden" value="'+currentId+'">');
    $("#drop1").empty();
    $("#drop1").html(currentName); 
}

function prepareFormByID(form_name) {
    var form_id = '#'+form_name;
    var arr = $(form_id).serializeArray();      
    var cct = $.cookie('ci_csrf_token'); 
    var json = "";
    var data = "";
    jQuery.each(arr, function(){
        jQuery.each(this, function(i, val){
            if (i=="name") {
                json += '"' + val + '":';
            } else if (i=="value") {
                json += '"' + val.replace(/"/g, '\\"') + '",';
            }
        });
    });
    json = "{" + json.substring(0, json.length - 1) + "}";
    data = {
        "mydata" : json, 
        'ci_csrf_token': cct
    };
    return data;
}

function userSelect(form_id,back_url){
    var url = 'http://' + getThisURL();
    var cct = $.cookie('ci_csrf_token'); 
    var selectData = prepareFormByID(form_id);
    var data = {
        "selectValue" : selectData, 
        'ci_csrf_token': cct
    };
    url+='/CommuniTraders/ajax/table_select';
    $.post(url, data, function(data){    
        if(data == 1){
            window.location.href = back_url;
        }
    });
    return false;
}

function swap_posticon(imgid)
{
    var out = fetch_object("display_posticon");
    var img = fetch_object(imgid);
    if (img)
    {
        out.src = img.src;
        out.alt = img.alt;
    }
    else
    {
        out.src = "clear.gif";
        out.alt = "";
    }
}

function cap()
{
    alert('Will be added soon');
    return false;
}

function changeBoxes($div_id){
    if($div_id==0){
        $('#tool').removeClass('active');
        $('#first_box').hide();
        $('#howtoplay').addClass('active');
        $('#second_box').show();  
    }
    else{
        $('#tool').addClass('active');
        $('#first_box').show();
        $('#howtoplay').removeClass('active');
        $('#second_box').hide();   
    }
}

function confirmDelete() 
{
    if (confirm("Are you sure?")) {
        return true;
    }
    else {
        return false;
    }
}

/*Start Strategy select box block*/
function showPromt(liname){   
    var url = 'http://' + getThisURL();
    var cct = $.cookie('ci_csrf_token'); 
    var data = {
        "liname" : liname, 
        'ci_csrf_token': cct
    };
    url+='/CommuniTraders/ajax/get_promt';
    $.post(url, data, function(data){    
        $('#strategy_promt').empty(); 
        $('#strategy_promt').html(data); 
        $('#strategy_promt').show();
    });
    return false; 
}

function hidePromt(){
    $('#strategy_promt').empty(); 
    $('#strategy_promt').hide();
}

function blinks(hide) 
{
    if(hide == 1) {
        $('#lead').show();
        hide = 0;
    }
    else { 
        $('#lead').hide();
        hide = 1;
    }
    setTimeout("blinks("+hide+")",400);
}

function navBarAction(currentId)
{
    tinyMCE.triggerSave();
    alert($("#comment_field").val());

    alert('will be added soon');
}
/*End Strategy select box block*/
function updateCurrentGame()
{
    var url           = 'http://' + getThisURL();
    var start_default = $('#main_page_tool').val();
    var user_id       = $('#user_id').val();
    if (!user_id) {
        user_id = 0;
    }
    var cct = $.cookie('ci_csrf_token');
    var json_data = {
        'flag'          : start_default,
        'user_id'       : user_id,
        'ci_csrf_token' : cct
    }
    url += '/CommuniTraders/ajax/get_active_games';
    $.post(url, json_data, function(data) {
        var obj = jQuery.parseJSON(data);
        if (start_default == 1) {
            $('#open_trades').html(obj.html);           
        }
        else {
            $('#open_trades_per').html(obj.html);
        }
        $('#info_balance').html('Balance:&nbsp;$' + obj.balance);
        $('#info_oppos').html('Open position:&nbsp;$' + obj.open_pos);
        $('#info_pl').html('Today\'s P&L:&nbsp;$' + obj.t_pl);
        updateLastClosedGames();
    });
    setTimeout(updateCurrentGame, 5000);    
}

function updateLastClosedGames()
{
    var url = 'http://' + getThisURL();
    url    += '/CommuniTraders/ajax/get_last_closed_games';
    var cct = $.cookie('ci_csrf_token');
    var json_data = {
        'ci_csrf_token' : cct
    }
    $.post(url, json_data, function(data) {
        var obj = jQuery.parseJSON(data);
        $('#close_trades').html(obj.html);
    });
}

function updateOtherGamesInfo()
{
    var url = 'http://' + getThisURL();
    var cct = $.cookie('ci_csrf_token');
    var user_id = $('#user_id').val();
    var json_data = {
        'user_id'       : user_id,
        'ci_csrf_token' : cct
    };
    url += '/CommuniTraders/ajax/get_other_game_info';
    $.post(url, json_data, function(data) {
        var obj = jQuery.parseJSON(data);
        $('#closed_trades').html(obj.closed_games);
        $('#about').html(obj.about_games);
        $('#performance_table').html(obj.performance_games);
    });
    setTimeout(updateOtherGamesInfo, 5000);    
}


function lockInputPrice()
{
    var selectValue = $('#strategy').val();
    if (selectValue == 'put' || selectValue == 'call') {
        $('#price').attr('value', 'Please Wait');
        $('#price').css('background-color', '#FFA500');
    }
}

function loadClosedGame(game_id, symbol)
{
// Here will be load static graph of a closed game
}

function show_without_paginate()
{
    $('#all').dataTable({
        "bSortClasses": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": false,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": true
    });
}

function show_with_paginate()
{
     $('#all').dataTable({
        "aaSorting": [[ 0, "desc" ]],
        "bLengthChange": true,
        "bPaginate": true,
        "iDisplayLength": 100,
        "bLengthChange": false,
        "bFilter": false,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": true
    });
}

function show_all_close()
{
    $('#all').dataTable({
        //"sPaginationType": "full_numbers",
        "aaSorting": [[ 0, "desc" ]],
        "bLengthChange": true,
        //"bSortClasses": true,
        "bPaginate": true,
        "iDisplayLength": 100,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": true
    });
}

function show_all_open()
{
    $('#all_open').dataTable({
        "bSortClasses": false,
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": true
    });
}

function sendEmailAlert()
{
    var is_alert = $('#email_alert').val();
    if (is_alert == 0) {
        is_alert = 1;
    }
    else {
        is_alert = 0;
    }
    var url = 'http://' + getThisURL();
    var cct = $.cookie('ci_csrf_token');
    var json_data = {
        'is_alert'      : is_alert,
        'ci_csrf_token' : cct
    }
    url += '/CommuniTraders/ajax/change_alert_status';
    $.post(url, json_data, function(data) {
        if (is_alert == 0) {
            $('#is_alert').html('No');
            $('#email_alert').attr('value', '0');
        }
        else {
            $('#is_alert').html('Yes');
            $('#email_alert').attr('value', '1');
        }
    });
    return false;
}

function update_news()
{
    var asset = $('#what option:selected').val();
    if (asset == '') {
        asset = $('#default_asset').val();
    } 
    var url = 'http://' + getThisURL();
    var cct = $.cookie('ci_csrf_token');
    var json_data = {
        'asset'         : asset,
        'ci_csrf_token' : cct
    }
    url += '/CommuniTraders/ajax/get_news';
    $.post(url, json_data, function(data) {
        var obj = jQuery.parseJSON(data);
        $('.news_box').html(obj.news);
    });
    setTimeout(update_news, 4000);
}
function getCalendar(){
    var url = 'http://' + getThisURL();
    var cct = $.cookie('ci_csrf_token');
    var json_data = {
        'ci_csrf_token' : cct
    }
    url += '/CommuniTraders/ajax/get_calendar';
    $.post(url, json_data, function(data) {
        var obj = jQuery.parseJSON(data);
        $('#event_block').html(obj.calendar);
    });    
}

function getLeadersBoard() 
{
    var url = 'http://' + getThisURL();
    var cct = $.cookie('ci_csrf_token');
    var json_data = {
        'ci_csrf_token' : cct
    }
    url += '/CommuniTraders/ajax/get_leader_board';
    $.post(url, json_data, function(data) {
        var obj = jQuery.parseJSON(data);
        $('#leader_block').html(obj.leaders);
    });    
}

function set_default_asset(room_id)
{
    var url   = 'http://' + getThisURL();
    var cct   = $.cookie('ci_csrf_token');
    var quote = $('#quote_'+ room_id +' option:selected').val();
    var res   = '';
    var json_data = {
        'room_id'       : room_id,
        'quote'         : quote,
        'ci_csrf_token' : cct
    }
    url += '/CommuniTraders/ajax/set_default_asset';
    $.post(url, json_data, function(data) {
        if (data == 'ok') {
            $('#def').html('Defaul asset changed');
        }  
    });  
}

function set_new_link()
{
    var link = $('#link').val();
    var url  = 'http://' + getThisURL();
    var cct  = $.cookie('ci_csrf_token');
    url += '/CommuniTraders/ajax/set_real_trade_link';
    var json_data = {
        'link'          : link,
        'ci_csrf_token' : cct
    }
    $.post(url, json_data, function(data) {
        if (data == 'ok') {
            $('#changed').html(' <b>DONE!</b>');
        }
    });
}


// Selects proper button in the panel 
function selectTool( tool_name ) {
    var tool = $( "." + tool_name );

    // Mark tool as current and unmark all other tools
    tool.
    parents("UL").
    find(".current").
    removeClass("current").
    end().
    end().
    addClass("current");
}

// Selects proper color item in the colorpicker toolbar using "000000" format.
function selectColor(colorHex) {
    var color = $(".color-" + colorHex.toUpperCase()).parent();

    color.
    parents("UL").
    find(".current").
    removeClass("current").
    end().
    end().
    addClass("current");
}
		
// Selects proper color item in the colorpicker toolbar using "#000000" format.
function selectColorWSharp(colorHex) {
    selectColor(colorHex.replace("#",""));
}

// Selects proper line thickness button.
function selectThickness(value) {
    var thickness = $( "#line-tools .brush-" + value + "px" );

    thickness.
    parents("UL").
    find(".current").
    // NOTE: exclude dashed-line
    not(".dashed-line").
    removeClass("current").
    end().
    end().
    end().
    addClass("current");
}

// Returns selected line thickness.
function getSelectedThickness() {
    // NOTE: possible null
    return parseInt(
        $( "#line-tools .current" ).not(".dashed-line").attr("class").match(/brush-(\d+)px/)[1]
        );
}

// Returns boolean flag whenever dashed line style is on or off.
function isLineDashed() {
    return $( ".dashed-line" ).hasClass( "current" );
}

// Checks/Unchecks dashed line style button.
function checkDashButton(isChecked) {
    if (isChecked) $(".dashed-line").addClass("current");
    else $(".dashed-line").removeClass("current");
}

// Checks/Unchecks bold text style button.
function checkTextBold(isChecked) {
    if (isChecked) $(".bold-text").addClass("current");
    else $(".bold-text").removeClass("current");
}

// Returns boolean flag whenever bold text style is on or off.
function isTextBoldChecked() {
    return $(".bold-text").hasClass("current");
}

// Checks/Unchecks italic text style button.
function checkTextItalic(isChecked) {
    if (isChecked) $(".italic-text").addClass("current");
    else $(".italic-text").removeClass("current");
}

// Returns boolean flag whenever italic text style is on or off.
function isTextItalicChecked() {
    return $(".italic-text").hasClass("current");
}

// Shows/Hides text properties toolbar.
function showTextToolset(isVisible) {
    if (isVisible) $("#text-tools").show();
    else $("#text-tools").hide();
}

// Shows/Hides line properties toolbar.
function showLineToolset(isVisible) {
    if (isVisible) $("#line-tools").show();
    else $("#line-tools").hide();
}
		
// Gets currently selected color in the colorpicker toolbar.
function getSelectedColor() {
    return "#" + $("#colorpicker a.current").find('span').attr('class').replace(/color-/, '');
}

// Shows/Hides text and line properties toolbars depending on annotation type.
function switchPropertiesPanels(type, annotation) {
    showLineToolset(false);
    showTextToolset(false);

    switch (type) {
        case "Line":
        case "HorizontalLine":
        case "VerticalLine":
        case "InfiniteLine":
        case "Rectangle":
        case "Ray":
        case "Ellipse":
        case "Triangle":
        case "TrendChannel":
        case "AndrewsPitchfork":
        case "FibonacciFan":
        case "FibonacciArc":
            showLineToolset(true);
            break;

        case "Label":
        case "Callout":
            showTextToolset(true);
            break;
    }
}

// Starts process of annotation drawing.
function startToolDrawing(type) {

    isDrawingStarted = true;
    currentToolType = type;

    switchPropertiesPanels(type);
			
    switch (type) {
        case "Line":
            chart.startDrawingAnnotation("Line", {
                lineAnnotation: {
                    color: getSelectedColor(), 
                    settings: {
                        line: {
                            thickness: getSelectedThickness(), 
                            dashed: isLineDashed()
                            }
                        }
                }
            });
break;
case "HorizontalLine":
    chart.startDrawingAnnotation("HorizontalLine", {
        horizontalLineAnnotation: {
            color: getSelectedColor(), 
            settings: {
                line: {
                    thickness: getSelectedThickness(), 
                    dashed: isLineDashed()
                    }
                }
        }
    });
break;
case "VerticalLine":
    chart.startDrawingAnnotation("VerticalLine", {
        verticalLineAnnotation: {
            color: getSelectedColor(), 
            settings: {
                line: {
                    thickness: getSelectedThickness(), 
                    dashed: isLineDashed()
                    }
                }
        }
    });
break;
case "InfiniteLine":
    chart.startDrawingAnnotation("InfiniteLine", {
        infiniteLineAnnotation: {
            color: getSelectedColor(), 
            settings: {
                line: {
                    thickness: getSelectedThickness(), 
                    dashed: isLineDashed()
                    }
                }
        }
    });
break;
case "Ray":
    chart.startDrawingAnnotation("Ray", {
        rayAnnotation: {
            color: getSelectedColor(), 
            settings: {
                line: {
                    thickness: getSelectedThickness(), 
                    dashed: isLineDashed()
                    }
                }
        }
    });
break;
case "Rectangle":
    chart.startDrawingAnnotation("Rectangle", {
        rectangleAnnotation: {
            color: getSelectedColor(), 
            settings: {
                border: {
                    thickness:getSelectedThickness(),
                    dashed:isLineDashed()
                    }
                }
        }
    });
break;
case "Ellipse":
    chart.startDrawingAnnotation("Ellipse", {
        ellipseAnnotation: {
            color: getSelectedColor(), 
            settings: {
                border: {
                    thickness: getSelectedThickness(), 
                    dashed: isLineDashed()
                    }
                }
        }
    });
break;
case "Triangle":
    chart.startDrawingAnnotation("Triangle", {
        triangleAnnotation: {
            color: getSelectedColor(), 
            settings: {
                border: {
                    thickness: getSelectedThickness(), 
                    dashed: isLineDashed()
                    }
                }
        }
    });
break;
case "TrendChannel":
    chart.startDrawingAnnotation("TrendChannel", {
        trendChannelAnnotation: {
            color: getSelectedColor(), 
            settings: {
                firstLine: {
                    thickness: getSelectedThickness(), 
                    dashed: isLineDashed()
                    }, 
                secondLine: {
                    thickness: getSelectedThickness(), 
                    dashed: isLineDashed()
                    }
                }
        }
    });
break;
case "AndrewsPitchfork":
    chart.startDrawingAnnotation("AndrewsPitchfork", {
        andrewsPitchforkAnnotation: {
            color: getSelectedColor(), 
            settings: {
                line: {
                    thickness: getSelectedThickness(), 
                    dashed: isLineDashed()
                    }
                }
        }
    });
break;
case "FibonacciFan":
    chart.startDrawingAnnotation("FibonacciFan", {
        fibonacciFanAnnotation: {
            color: getSelectedColor(), 
            settings: {
                line: {
                    thickness: getSelectedThickness(), 
                    dashed: isLineDashed()
                    }
                }
        }
    });
break;
case "FibonacciArc":
    chart.startDrawingAnnotation("FibonacciArc", {
        fibonacciArcAnnotation: {
            color: getSelectedColor(), 
            settings: {
                line: {
                    thickness: getSelectedThickness(), 
                    dashed: isLineDashed()
                    }
                }
        }
    });
break;
case "FibonacciRetracement":
    chart.startDrawingAnnotation("FibonacciRetracement", {
        fibonacciRetracementAnnotation: {
            color: getSelectedColor()
            }
        });
break;
case "FibonacciTimzones":
    chart.startDrawingAnnotation("FibonacciTimezones", {
        fibonacciTimezonesAnnotation: {
            color: getSelectedColor()
            }
        });
break;
case "UpArrow":
    chart.startDrawingAnnotation("Arrow",{
        arrowAnnotation:{
            direction: "Up",
            color: getSelectedColor()
            }
        });					
break;
case "DownArrow":
    chart.startDrawingAnnotation("Arrow", {
        arrowAnnotation: {
            direction: "Down", 
            color: getSelectedColor()
            }
        });					
break;
case "LeftArrow":
    chart.startDrawingAnnotation("Arrow", {
        arrowAnnotation: {
            direction: "Left", 
            color: getSelectedColor()
            }
        });
break;
case "RightArrow":
    chart.startDrawingAnnotation("Arrow", {
        arrowAnnotation: {
            direction: "Right", 
            color: getSelectedColor()
            }
        });					
break;
case "Label":
    chart.startDrawingAnnotation("Label", {
        labelAnnotation: {
            color: getSelectedColor(), 
            settings: {
                font: {
                    size: currentFontSize, 
                    bold: isTextBoldChecked(), 
                    italic: isTextItalicChecked()
                    }
                }
        }
    });
break;
}
}

// Stops process of drawing of the annotation and restarts drawing with new properties.
function restartToolDrawing() {
    if (isDrawingStarted) {
        chart.stopDrawingAnnotation();
        startToolDrawing(currentToolType);
    }
}

// Updates UI controls using properties of the currently selected annotation.
function updatePropertiesBySelectedAnnotation() {
			
    var annotationId = chart.getSelectedAnnotationId();
    if (annotationId == null) return;

    var annotation = chart.getAnnotationAsJSON(annotationId);
    if (annotation == null) return;

    switch (annotation.type) {
        case "Line":
            selectColorWSharp(annotation.lineAnnotation.color);
            selectThickness(annotation.lineAnnotation.settings.line.thickness);
            checkDashButton(annotation.lineAnnotation.settings.line.dashed);
            break;
        case "HorizontalLine":
            selectColorWSharp(annotation.horizontalLineAnnotation.color);
            selectThickness(annotation.horizontalLineAnnotation.settings.line.thickness);
            checkDashButton(annotation.horizontalLineAnnotation.settings.line.dashed);
            break;
        case "VerticalLine":
            selectColorWSharp(annotation.verticalLineAnnotation.color);
            selectThickness(annotation.verticalLineAnnotation.settings.line.thickness);
            checkDashButton(annotation.verticalLineAnnotation.settings.line.dashed);
            break;
        case "InfiniteLine":
            selectColorWSharp(annotation.infiniteLineAnnotation.color);
            selectThickness(annotation.infiniteLineAnnotation.settings.line.thickness);
            checkDashButton(annotation.infiniteLineAnnotation.settings.line.dashed);
            break;
        case "Ray":
            selectColorWSharp(annotation.rayAnnotation.color);
            selectThickness(annotation.rayAnnotation.settings.line.thickness);
            checkDashButton(annotation.rayAnnotation.settings.line.dashed);
            break;
        case "Rectangle":
            selectColorWSharp(annotation.rectangleAnnotation.color);
            selectThickness(annotation.rectangleAnnotation.settings.border.thickness);
            checkDashButton(annotation.rectangleAnnotation.settings.border.dashed);
            break;
        case "Ellipse":
            selectColorWSharp(annotation.ellipseAnnotation.color);
            selectThickness(annotation.ellipseAnnotation.settings.border.thickness);
            checkDashButton(annotation.ellipseAnnotation.settings.border.dashed);
            break;
        case "Triangle":
            selectColorWSharp(annotation.triangleAnnotation.color);
            selectThickness(annotation.triangleAnnotation.settings.border.thickness);
            checkDashButton(annotation.triangleAnnotation.settings.border.dashed);
            break;
        case "TrendChannel":
            selectColorWSharp(annotation.trendChannelAnnotation.color);
            selectThickness(annotation.trendChannelAnnotation.settings.firstLine.thickness);
            checkDashButton(annotation.trendChannelAnnotation.settings.firstLine.dashed);
            break;
        case "AndrewsPitchfork":
            selectColorWSharp(annotation.andrewsPitchforkAnnotation.color);
            selectThickness(annotation.andrewsPitchforkAnnotation.settings.line.thickness);
            checkDashButton(annotation.andrewsPitchforkAnnotation.settings.line.dashed);
            break;
        case "FibonacciFan":
            selectColorWSharp(annotation.fibonacciFanAnnotation.color);
            selectThickness(annotation.fibonacciFanAnnotation.settings.line.thickness);
            checkDashButton(annotation.fibonacciFanAnnotation.settings.line.dashed);
            break;
        case "FibonacciArc":
            selectColorWSharp(annotation.fibonacciArcAnnotation.color);
            selectThickness(annotation.fibonacciArcAnnotation.settings.line.thickness);
            checkDashButton(annotation.fibonacciArcAnnotation.settings.line.dashed);
            break;
        case "FibonacciRetracement":
            selectColorWSharp(annotation.fibonacciRetracementAnnotation.color);
            break;
        case "FibonacciTimezones":
            selectColorWSharp(annotation.fibonacciTimezonesAnnotation.color);
            break;
        case "Arrow":
            selectColorWSharp(annotation.arrowAnnotation.color);
            break;
        case "Label":
            selectColorWSharp(annotation.labelAnnotation.color);
            checkTextBold(annotation.labelAnnotation.settings.font.bold);
            checkTextItalic(annotation.labelAnnotation.settings.font.italic);
            break;
    }
}
		
// Updates currently selected annotation properties using values from UI controls.
function updateSelectedAnnotation() {
    var annotationId = chart.getSelectedAnnotationId();
    if (annotationId == null) return;

    var thickness = getSelectedThickness();
    var color = getSelectedColor();
    var isDashed = isLineDashed();
    var isBold = isTextBoldChecked();
    var isItalic = isTextItalicChecked();

    var annotation = chart.getAnnotationAsJSON(annotationId);
    if (annotation == null) return;

    switch (annotation.type) {
        case "Line":
            annotation.lineAnnotation.color = color;
            annotation.lineAnnotation.settings.line.thickness = thickness;
            annotation.lineAnnotation.settings.line.dashed = isDashed;
            break;
        case "HorizontalLine":
            annotation.horizontalLineAnnotation.color = color;
            annotation.horizontalLineAnnotation.settings.line.thickness = thickness;
            annotation.horizontalLineAnnotation.settings.line.dashed = isDashed;
            break;
        case "VerticalLine":
            annotation.verticalLineAnnotation.color = color;
            annotation.verticalLineAnnotation.settings.line.thickness = thickness;
            annotation.verticalLineAnnotation.settings.line.dashed = isDashed;
            break;
        case "InfiniteLine":
            annotation.infiniteLineAnnotation.color = color;
            annotation.infiniteLineAnnotation.settings.line.thickness = thickness;
            annotation.infiniteLineAnnotation.settings.line.dashed = isDashed;
            break;
        case "Ray":
            annotation.rayAnnotation.color = color;
            annotation.rayAnnotation.settings.line.thickness = thickness;
            annotation.rayAnnotation.settings.line.dashed = isDashed;
            break;
        case "Rectangle":
            annotation.rectangleAnnotation.color = color;
            annotation.rectangleAnnotation.settings.border.thickness = thickness;
            annotation.rectangleAnnotation.settings.border.dashed = isDashed;
            break;
        case "Ellipse":
            annotation.ellipseAnnotation.color = color;
            annotation.ellipseAnnotation.settings.border.thickness = thickness;
            annotation.ellipseAnnotation.settings.border.dashed = isDashed;
            break;
        case "Triangle":
            annotation.triangleAnnotation.color = color;
            annotation.triangleAnnotation.settings.border.thickness = thickness;
            annotation.triangleAnnotation.settings.border.dashed = isDashed;
            break;
        case "TrendChannel":
            annotation.trendChannelAnnotation.color = color;
            annotation.trendChannelAnnotation.settings.firstLine.thickness = thickness;
            annotation.trendChannelAnnotation.settings.secondLine.thickness = thickness;
            annotation.trendChannelAnnotation.settings.firstLine.dashed = isDashed;
            annotation.trendChannelAnnotation.settings.secondLine.dashed = isDashed;
            break;
        case "AndrewsPitchfork":
            annotation.andrewsPitchforkAnnotation.color = color;
            annotation.andrewsPitchforkAnnotation.settings.line.thickness = thickness;
            annotation.andrewsPitchforkAnnotation.settings.line.dashed = isDashed;
            break;
        case "FibonacciFan":
            annotation.fibonacciFanAnnotation.color = color;
            annotation.fibonacciFanAnnotation.settings.line.thickness = thickness;
            annotation.fibonacciFanAnnotation.settings.line.dashed = isDashed;
            break;
        case "FibonacciArc":
            annotation.fibonacciArcAnnotation.color = color;
            annotation.fibonacciArcAnnotation.settings.line.thickness = thickness;
            annotation.fibonacciArcAnnotation.settings.line.dashed = isDashed;
            break;
        case "FibonacciRetracement":
            annotation.fibonacciRetracementAnnotation.color = color;
            break;
        case "FibonacciTimezones":
            annotation.fibonacciTimezonesAnnotation.color = color;
            break;
        case "Arrow":
            annotation.arrowAnnotation.color = color;
            break;
        case "Label":
            annotation.labelAnnotation.color = color;
            annotation.labelAnnotation.settings.font.size = currentFontSize;
            annotation.labelAnnotation.settings.font.bold = isBold;
            annotation.labelAnnotation.settings.font.italic = isItalic;
            break;
    }
			
    chart.updateAnnotation(annotationId, annotation);
}

function show_dialog(is_trade, strategy, investment, asset_name, expire_name, url)
{
    var html = '<strong>Trade Sent Successfully! You traded the ' + strategy + ' strategy with ' + investment + '$ investment on ' + asset_name + ' with ' + expire_name + ' Expiry.</strong>';
    if (is_trade == 1) {
        html += 'You can stay on this page or go to your POST on forum<br />';
        html += '<p align="center"><a href="#" onclick="location.reload(true);" data-dismiss="modal" class="btn btn-primary">Stay Here</a>';
        html += '&nbsp;&nbsp;&nbsp;<a href="#" onclick="document.location.replace(\'' + url + '\');" data-dismiss="modal" class="btn btn-success">Go To Post</a></p>';
    }
    else {
        html += '<p align="center"><a href="#" onclick="location.reload(true);" data-dismiss="modal" class="btn btn-primary">Ok</a></p>';
    }
    $('#dialog').html(html);
    $('#start_dialog').modal('show');
}

function exportImage(game_id) 
{	
    var cct     = $.cookie('ci_csrf_token');   
    var url     = 'http://' + getThisURL();
    //$('#prepare_img').attr('value', getBase64PNGImage());
    var img = getBase64PNGImage();//$('#prepare_img').val();
    url += '/CommuniTraders/ajax/save';
    $.post(url, { // post params
        'imgType': "png", 
        'timestamp': new Date().getTime(),
        'imgData': img,
        'game_id': game_id,
        'ci_csrf_token': cct
    });
}

//--------------------------------------------------------------------------------
//		Exporting
//--------------------------------------------------------------------------------
			
function getBase64PNGImage() 
{
    // object with settings
    var exportSettings = {
        backgroundColor: $("#bgColor").val(), // background color
        transparent: $("#transparent").is(":checked") // transparency
    };
				
    var useCustomSize = $("#useCustomSize").is(":checked"); // use custom or original size
    if (useCustomSize) {
        exportSettings.size = "Custom"; // custom size is used
        exportSettings.width = $("#imgWidth").val(); // custom image width
        exportSettings.height = $("#imgHeight").val(); // custom image height
        exportSettings.resizingMode = $("#resizingMode").val(); // resizing mode
        exportSettings.cutExtraSpace = $("#cropExtraSpace").is(":checked"); // cut extra space settings
    }
    else {
        exportSettings.size = "Original"; //  use original size
    }
				
    return chart.getPNGImageBase64Encoded(exportSettings);
}

function get_default_data()
{
    var asset = '';
    var url = 'http://' + getThisURL();
    var cct = $.cookie('ci_csrf_token');
    var json_data = {
        'ci_csrf_token' : cct
    }
    url += '/CommuniTraders/ajax/get_default_asset';
    
    $.ajax({
        async: false,
        type: 'post',
        url: url,
        dataType : "text",
        success: function (data) {
            asset = data;
        }
    }); 
    return asset;
}

function changeVisibility(asset_id, type, visibility)
{
    var url  = 'http://' + getThisURL();
    var cct  = $.cookie('ci_csrf_token');
    url += '/CommuniTraders/ajax/change_visibility';
    var json_data = {
        'asset_id'      : asset_id,
        'type'          : type,
        'visibility'    : visibility,
        'ci_csrf_token' : cct
    }
    $.post(url, json_data, function(data) {
         if(data == 'ok') {
            window.location.reload(true);
        }
    });
}

function make_default_room(room_id)
{
    var url  = 'http://' + getThisURL();
    var cct  = $.cookie('ci_csrf_token');
    url += '/CommuniTraders/ajax/make_default_room';
    var json_data = {
        'room_id'      : room_id,
        'ci_csrf_token' : cct
    }
    $.post(url, json_data, function(data) {
         if(data == 'ok') {
            window.location.reload(true);
        }
    });
}

function mass_assets_update()
{
    var elements_checked   = '';
    var elements_unchecked = '';
    $(":checkbox").each(function(){
        if (this.checked) {
            if (elements_checked == '') {
                elements_checked += this.value;
            }
            else {
                elements_checked += ',' + this.value;
            }
        }
        else {
            if (elements_unchecked == '') {
                elements_unchecked += this.value;
            }
            else {
                elements_unchecked += ',' + this.value;
            }
        }
    });
    var url  = 'http://' + getThisURL();
    var cct  = $.cookie('ci_csrf_token');
    url += '/CommuniTraders/ajax/mass_assets_update';
    var json_data = {
        'elements_checked'   : elements_checked,
        'elements_unchecked' : elements_unchecked
    }
    $.post(url, json_data, function(data) {
        if(data == 'ok') {
            window.location.reload(true);
        }
    });
}
