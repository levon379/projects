var xPoint = 0;
var yPoint = 0;
var activeTool = 0;
var lineCounter = 0;
var objId = 0;

function setCoordinates(x,y){    
    switch (activeTool) {
        case "line": {
            drawLine(x,y);
            break;
        }
        case "text": {
            drawTextBox(x,y);
            break;
        }
        case "image": {
            
            break;
        }
        default: {
            return true;
        }
    }  
}
function selectedTool(toolType){       
    if(activeTool != toolType){
        $('#chart_panel a').removeClass("pressedButton");
        activeTool = toolType;
        $('#'+toolType).addClass("pressedButton");
    }
    else{
        activeTool = '';
        $('#'+toolType).removeClass("pressedButton");
    }   
}
function objOperation(currentObj){
    switch (activeTool) {
        case "line": {
            alert(currentObj.name);
            break;
        }
        case "remove": {
            currentObj.remove();
            break;
        }
        case "text": {
            alert('123');
            break;
        }
        default: {
            return true;
        }
    }
}
function drawLine(x,y){    
    if(xPoint == 0){
        xPoint = [x,y];
        yPoint = 0;      
    }else{
        lineCounter = lineCounter + 1;
        yPoint = [x,y]; 
        if(yPoint != 0){
            chart.addSeries({  
                marker : {
                    enabled : true,
                    radius : 3
                },
                color: 'red',
                type: 'line',
                states: {
                    hover: {
                        lineWidth: 0
                    }
                },
                point: {
                    events: {
                        click: function(event) { // docs
                            objOperation(this.series);
                        }
                    }
                },            
                data: [xPoint,yPoint]
            });
        }       
        objId = objId +1;
        $('#draw_data').prepend('<input id="'+objId+'" type="hidden" value="['+xPoint+','+yPoint+']"/>');
        xPoint = 0;
        yPoint = 0;
    }            
}
function drawTextBox(x,y){
    chart.renderer.image('http://highcharts.com/demo/gfx/sun.png', x, y, 30, 30).add();
}