var isDrawingStarted = false;
var currentToolType = "SelectionTool";
var currentFontSize = 11;
var maxFontSize = 72;
var minFontSize = 3;
var chart;

function saveImg(){
     pngImage=chart.getPNG();
}

function run_any_chart()
{
    var asset   = $('#short_asset').val();
    var game_id = $('#curr_game').val();
    var url  = 'http://' + getThisURL();
    url     += '/CommuniTraders/assets/js/';

    // Creating new chart object. 
    chart = new AnyChartStock(url + 'swf/AnyChartStock.swf?v=1.0.0r7416', url + 'swf/Preloader.swf?v=1.0.0r7416');
    // Setting XML config file.	
    
    // Set XML config file.
    chart.wMode = "opaque";
    
    //var url = 'http://' + getThisURL();
    //url += '/CommuniTraders/ajax/get_game_xml/' + game_id;

    //chart.setXMLFile(url);
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

function getThisURL()
{
    pathArray = location.href.split("://");
    pathArray = pathArray[1].split( '/' );
    host = pathArray[0];
    return host;
}


$(document).ready(function() {
    run_any_chart();
    requestData();
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
    
});

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
            chart.startDrawingAnnotation("Line", {lineAnnotation: {color: getSelectedColor(), settings: {line: {thickness: getSelectedThickness(), dashed: isLineDashed()}}}});
        break;
        case "HorizontalLine":
            chart.startDrawingAnnotation("HorizontalLine", {horizontalLineAnnotation: {color: getSelectedColor(), settings: {line: {thickness: getSelectedThickness(), dashed: isLineDashed()}}}});
        break;
        case "VerticalLine":
            chart.startDrawingAnnotation("VerticalLine", {verticalLineAnnotation: {color: getSelectedColor(), settings: {line: {thickness: getSelectedThickness(), dashed: isLineDashed()}}}});
        break;
        case "InfiniteLine":
            chart.startDrawingAnnotation("InfiniteLine", {infiniteLineAnnotation: {color: getSelectedColor(), settings: {line: {thickness: getSelectedThickness(), dashed: isLineDashed()}}}});
        break;
        case "Ray":
            chart.startDrawingAnnotation("Ray", {rayAnnotation: {color: getSelectedColor(), settings: {line: {thickness: getSelectedThickness(), dashed: isLineDashed()}}}});
        break;
        case "Rectangle":
            chart.startDrawingAnnotation("Rectangle", {rectangleAnnotation: {color: getSelectedColor(), settings: {border: {thickness:getSelectedThickness(),dashed:isLineDashed()}}}});
        break;
        case "Ellipse":
            chart.startDrawingAnnotation("Ellipse", {ellipseAnnotation: {color: getSelectedColor(), settings: {border: {thickness: getSelectedThickness(), dashed: isLineDashed()}}}});
        break;
        case "Triangle":
            chart.startDrawingAnnotation("Triangle", {triangleAnnotation: {color: getSelectedColor(), settings: {border: {thickness: getSelectedThickness(), dashed: isLineDashed()}}}});
        break;
        case "TrendChannel":
            chart.startDrawingAnnotation("TrendChannel", {trendChannelAnnotation: {color: getSelectedColor(), settings: {firstLine: {thickness: getSelectedThickness(), dashed: isLineDashed()}, secondLine: {thickness: getSelectedThickness(), dashed: isLineDashed()}}}});
        break;
        case "AndrewsPitchfork":
            chart.startDrawingAnnotation("AndrewsPitchfork", {andrewsPitchforkAnnotation: {color: getSelectedColor(), settings: {line: {thickness: getSelectedThickness(), dashed: isLineDashed()}}}});
        break;
        case "FibonacciFan":
            chart.startDrawingAnnotation("FibonacciFan", {fibonacciFanAnnotation: {color: getSelectedColor(), settings: {line: {thickness: getSelectedThickness(), dashed: isLineDashed()}}}});
        break;
        case "FibonacciArc":
            chart.startDrawingAnnotation("FibonacciArc", {fibonacciArcAnnotation: {color: getSelectedColor(), settings: {line: {thickness: getSelectedThickness(), dashed: isLineDashed()}}}});
        break;
        case "FibonacciRetracement":
            chart.startDrawingAnnotation("FibonacciRetracement", {fibonacciRetracementAnnotation: {color: getSelectedColor()}});
        break;
        case "FibonacciTimzones":
            chart.startDrawingAnnotation("FibonacciTimezones", {fibonacciTimezonesAnnotation: {color: getSelectedColor()}});
        break;
        case "UpArrow":
            chart.startDrawingAnnotation("Arrow",{arrowAnnotation:{direction: "Up",color: getSelectedColor()}});					
        break;
        case "DownArrow":
            chart.startDrawingAnnotation("Arrow", {arrowAnnotation: {direction: "Down", color: getSelectedColor()}});					
        break;
        case "LeftArrow":
            chart.startDrawingAnnotation("Arrow", {arrowAnnotation: {direction: "Left", color: getSelectedColor()}});
        break;
        case "RightArrow":
            chart.startDrawingAnnotation("Arrow", {arrowAnnotation: {direction: "Right", color: getSelectedColor()}});					
        break;
        case "Label":
            chart.startDrawingAnnotation("Label", {labelAnnotation: {color: getSelectedColor(), settings: {font: {size: currentFontSize, bold: isTextBoldChecked(), italic: isTextItalicChecked()}}}});
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
			
function exportImage() 
{	
    var cct     = $.cookie('ci_csrf_token');   
    var url     = 'http://' + getThisURL();
    var game_id = $('#curr_game').val();
    $('#prepare_img').attr('value', getBase64PNGImage());
    var img = $('#prepare_img').val();
    url += '/CommuniTraders/ajax/save';
    $.post(url, { // post params
        'imgType': "png", 
        'timestamp': new Date().getTime(),
        'imgData': img,
        'game_id': game_id,
        'ci_csrf_token': cct
    },
    function(data) { // load handler
        alert ("Image was saved successfuly");
    });
}

function requestData()
{
    var cct        = $.cookie('ci_csrf_token');   
    var url        = 'http://' + getThisURL();
    var game_id    = $('#curr_game').val();
    var asset_name = $('#asset').val();
    var json_data  = {
        'game_id'       : game_id,
        'ci_csrf_token' : cct
    }
    url += '/CommuniTraders/ajax/get_data_draw';
     $.post(url, json_data, function(data) {
        var csvData = data;
        // add created row and remove the one row from the beggining of the dataset
        chart.onChartDraw = null;
        chart.appendData('dataSet' + asset_name, csvData, 0);
        // appply changes
        chart.commitDataChanges();
        // call it again after five seconds
        setTimeout(requestData, 7000);    
    });    
}
