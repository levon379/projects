if(!AmCharts)var AmCharts={};
    
AmCharts.inheriting={};
AmCharts.Class=function(a){
    var b=function(){
        arguments[0]!==AmCharts.inheriting&&(this.events={},this.construct.apply(this,arguments))
        };
        
    a.inherits?(b.prototype=new a.inherits(AmCharts.inheriting),b.base=a.inherits.prototype,delete a.inherits):(b.prototype.createEvents=function(){
        for(var a=0,b=arguments.length;a<b;a++)this.events[arguments[a]]=[]
            },b.prototype.listenTo=function(a,b,d){
        a.events[b].push({
            handler:d,
            scope:this
        })
        },b.prototype.addListener=function(a,b,d){
        this.events[a].push({
            handler:b,
            scope:d
        })
        },
    b.prototype.removeListener=function(a,b,d){
        a=a.events[b];
        for(b=a.length-1;0<=b;b--)a[b].handler===d&&a.splice(b,1)
            },b.prototype.fire=function(a,b){
        for(var d=this.events[a],h=0,i=d.length;h<i;h++){
            var j=d[h];
            j.handler.call(j.scope,b)
            }
        });
for(var d in a)b.prototype[d]=a[d];return b
    };
    
AmCharts.charts=[];
AmCharts.addChart=function(a){
    AmCharts.charts.push(a)
    };
    
AmCharts.removeChart=function(a){
    for(var b=AmCharts.charts,d=b.length-1;0<=d;d--)b[d]==a&&b.splice(d,1)
        };
        
AmCharts.IEversion=0;
-1!=navigator.appVersion.indexOf("MSIE")&&document.documentMode&&(AmCharts.IEversion=Number(document.documentMode));
if(document.addEventListener||window.opera)AmCharts.isNN=!0,AmCharts.isIE=!1,AmCharts.dx=0.5,AmCharts.dy=0.5;
document.attachEvent&&(AmCharts.isNN=!1,AmCharts.isIE=!0,9>AmCharts.IEversion&&(AmCharts.dx=0,AmCharts.dy=0));
window.chrome&&(AmCharts.chrome=!0);
AmCharts.handleResize=function(){
    for(var a=AmCharts.charts,b=0;b<a.length;b++){
        var d=a[b];
        d&&d.div&&d.handleResize()
        }
    };
AmCharts.handleMouseUp=function(a){
    for(var b=AmCharts.charts,d=0;d<b.length;d++){
        var e=b[d];
        e&&e.handleReleaseOutside(a)
        }
    };
    
AmCharts.handleMouseMove=function(a){
    for(var b=AmCharts.charts,d=0;d<b.length;d++){
        var e=b[d];
        e&&e.handleMouseMove(a)
        }
    };
    
AmCharts.resetMouseOver=function(){
    for(var a=AmCharts.charts,b=0;b<a.length;b++){
        var d=a[b];
        d&&(d.mouseIsOver=!1)
        }
    };
    
AmCharts.onReadyArray=[];
AmCharts.ready=function(a){
    AmCharts.onReadyArray.push(a)
    };
AmCharts.handleLoad=function(){
    for(var a=AmCharts.onReadyArray,b=0;b<a.length;b++)(0,a[b])()
        };
        
AmCharts.useUTC=!1;
AmCharts.updateRate=40;
AmCharts.uid=0;
AmCharts.getUniqueId=function(){
    AmCharts.uid++;
    return"AmChartsEl-"+AmCharts.uid
    };
    
AmCharts.isNN&&(document.addEventListener("mousemove",AmCharts.handleMouseMove,!0),window.addEventListener("resize",AmCharts.handleResize,!0),document.addEventListener("mouseup",AmCharts.handleMouseUp,!0),window.addEventListener("load",AmCharts.handleLoad,!0));
AmCharts.isIE&&(document.attachEvent("onmousemove",AmCharts.handleMouseMove),window.attachEvent("onresize",AmCharts.handleResize),document.attachEvent("onmouseup",AmCharts.handleMouseUp),window.attachEvent("onload",AmCharts.handleLoad));
AmCharts.AmChart=AmCharts.Class({
    construct:function(){
        this.version="2.8.2";
        AmCharts.addChart(this);
        this.createEvents("dataUpdated","init");
        this.height=this.width="100%";
        this.dataChanged=!0;
        this.chartCreated=!1;
        this.previousWidth=this.previousHeight=0;
        this.backgroundColor="#FFFFFF";
        this.borderAlpha=this.backgroundAlpha=0;
        this.color=this.borderColor="#000000";
        this.fontFamily="Verdana";
        this.fontSize=11;
        this.numberFormatter={
            precision:-1,
            decimalSeparator:".",
            thousandsSeparator:","
        };
        
        this.percentFormatter=

        {
            precision:2,
            decimalSeparator:".",
            thousandsSeparator:","
        };
        
        this.labels=[];
        this.allLabels=[];
        this.titles=[];
        this.marginRight=this.marginLeft=this.autoMarginOffset=0;
        this.timeOuts=[];
        var a=document.createElement("div"),b=a.style;
        b.overflow="hidden";
        b.position="relative";
        b.textAlign="left";
        this.chartDiv=a;
        a=document.createElement("div");
        b=a.style;
        b.overflow="hidden";
        b.position="relative";
        this.legendDiv=a;
        this.balloon=new AmCharts.AmBalloon;
        this.balloon.chart=this;
        this.titleHeight=0;
        this.prefixesOfBigNumbers=
        [{
            number:1E3,
            prefix:"k"
        },{
            number:1E6,
            prefix:"M"
        },{
            number:1E9,
            prefix:"G"
        },{
            number:1E12,
            prefix:"T"
        },{
            number:1E15,
            prefix:"P"
        },{
            number:1E18,
            prefix:"E"
        },{
            number:1E21,
            prefix:"Z"
        },{
            number:1E24,
            prefix:"Y"
        }];
        this.prefixesOfSmallNumbers=[{
            number:1E-24,
            prefix:"y"
        },{
            number:1E-21,
            prefix:"z"
        },{
            number:1E-18,
            prefix:"a"
        },{
            number:1E-15,
            prefix:"f"
        },{
            number:1E-12,
            prefix:"p"
        },{
            number:1E-9,
            prefix:"n"
        },{
            number:1E-6,
            prefix:"\u03bc"
        },{
            number:0.001,
            prefix:"m"
        }];
        this.panEventsEnabled=!1;
        AmCharts.bezierX=3;
        AmCharts.bezierY=
        6;
        this.product="amcharts"
        },
    drawChart:function(){
        this.drawBackground();
        this.redrawLabels();
        this.drawTitles()
        },
    drawBackground:function(){
        var a=this.container,b=this.backgroundColor,d=this.backgroundAlpha,e=this.set,f=this.updateWidth();
        this.realWidth=f;
        var g=this.updateHeight();
        this.realHeight=g;
        this.background=b=AmCharts.polygon(a,[0,f-1,f-1,0],[0,0,g-1,g-1],b,d,1,this.borderColor,this.borderAlpha);
        e.push(b);
        if(b=this.backgroundImage)this.path&&(b=this.path+b),this.bgImg=a=a.image(b,0,0,f,g),e.push(a)
            },
    drawTitles:function(){
        var a=this.titles;
        if(AmCharts.ifArray(a))for(var b=20,d=0;d<a.length;d++){
            var e=a[d],f=e.color;
            void 0==f&&(f=this.color);
            var g=e.size;
            isNaN(e.alpha);
            var h=this.marginLeft,f=AmCharts.text(this.container,e.text,f,this.fontFamily,g);
            f.translate(h+(this.realWidth-this.marginRight-h)/2,b);
            h=!0;
            void 0!=e.bold&&(h=e.bold);
            h&&f.attr({
                "font-weight":"bold"
            });
            b+=g+6;
            this.freeLabelsSet.push(f)
            }
        },
write:function(a){
    var b=this.balloon;
    b&&!b.chart&&(b.chart=this);
    a="object"!=typeof a?document.getElementById(a):
    a;
    a.innerHTML="";
    this.div=a;
    a.style.overflow="hidden";
    a.style.textAlign="left";
    var b=this.chartDiv,d=this.legendDiv,e=this.legend,f=d.style,g=b.style;
    this.measure();
    if(e)switch(e.position){
        case "bottom":
            a.appendChild(b);
            a.appendChild(d);
            break;
        case "top":
            a.appendChild(d);
            a.appendChild(b);
            break;
        case "absolute":
            var h=document.createElement("div"),i=h.style;
            i.position="relative";
            i.width=a.style.width;
            i.height=a.style.height;
            a.appendChild(h);
            f.position="absolute";
            g.position="absolute";
            void 0!=e.left&&
            (f.left=e.left+"px");
            void 0!=e.right&&(f.right=e.right+"px");
            void 0!=e.top&&(f.top=e.top+"px");
            void 0!=e.bottom&&(f.bottom=e.bottom+"px");
            e.marginLeft=0;
            e.marginRight=0;
            h.appendChild(b);
            h.appendChild(d);
            break;
        case "right":
            h=document.createElement("div");
            i=h.style;
            i.position="relative";
            i.width=a.style.width;
            i.height=a.style.height;
            a.appendChild(h);
            f.position="relative";
            g.position="absolute";
            h.appendChild(b);
            h.appendChild(d);
            break;
        case "left":
            h=document.createElement("div"),i=h.style,i.position="relative",
            i.width=a.style.width,i.height=a.style.height,a.appendChild(h),f.position="absolute",g.position="relative",h.appendChild(b),h.appendChild(d)
            }else a.appendChild(b);
    this.listenersAdded||(this.addListeners(),this.listenersAdded=!0);
    this.initChart()
    },
createLabelsSet:function(){
    AmCharts.remove(this.labelsSet);
    this.labelsSet=this.container.set();
    this.freeLabelsSet.push(this.labelsSet)
    },
initChart:function(){
    this.divIsFixed=AmCharts.findIfFixed(this.chartDiv);
    this.previousHeight=this.realHeight;
    this.previousWidth=
    this.realWidth;
    this.destroy();
    var a=0;
    document.attachEvent&&!window.opera&&(a=1);
    AmCharts.isNN&&AmCharts.findIfAuto(this.chartDiv)&&(a=3);
    this.mouseMode=a;
    this.container=new AmCharts.AmDraw(this.chartDiv,this.realWidth,this.realHeight);
    if(AmCharts.VML||AmCharts.SVG)a=this.container,this.set=a.set(),this.gridSet=a.set(),this.graphsBehindSet=a.set(),this.bulletBehindSet=a.set(),this.columnSet=a.set(),this.graphsSet=a.set(),this.trendLinesSet=a.set(),this.axesLabelsSet=a.set(),this.axesSet=a.set(),this.cursorSet=
        a.set(),this.scrollbarsSet=a.set(),this.bulletSet=a.set(),this.freeLabelsSet=a.set(),this.balloonsSet=a.set(),this.balloonsSet.setAttr("id","balloons"),this.zoomButtonSet=a.set(),this.linkSet=a.set(),this.drb(),this.renderFix()
        },
measure:function(){
    var a=this.div,b=this.chartDiv,d=a.offsetWidth,e=a.offsetHeight,f=this.container;
    a.clientHeight&&(d=a.clientWidth,e=a.clientHeight);
    var g=AmCharts.removePx(AmCharts.getStyle(a,"padding-left")),h=AmCharts.removePx(AmCharts.getStyle(a,"padding-right")),i=
    AmCharts.removePx(AmCharts.getStyle(a,"padding-top")),j=AmCharts.removePx(AmCharts.getStyle(a,"padding-bottom"));
    isNaN(g)||(d-=g);
    isNaN(h)||(d-=h);
    isNaN(i)||(e-=i);
    isNaN(j)||(e-=j);
    g=a.style;
    a=g.width;
    g=g.height;
    -1!=a.indexOf("px")&&(d=AmCharts.removePx(a));
    -1!=g.indexOf("px")&&(e=AmCharts.removePx(g));
    a=AmCharts.toCoordinate(this.width,d);
    g=AmCharts.toCoordinate(this.height,e);
    if(a!=this.previousWidth||g!=this.previousHeight)b.style.width=a+"px",b.style.height=g+"px",f&&f.setSize(a,g),this.balloon.setBounds(2,
        2,a-2,g);
    this.realWidth=a;
    this.realHeight=g;
    this.divRealWidth=d;
    this.divRealHeight=e
    },
destroy:function(){
    this.chartDiv.innerHTML="";
    this.clearTimeOuts()
    },
clearTimeOuts:function(){
    var a=this.timeOuts;
    if(a)for(var b=0;b<a.length;b++)clearTimeout(a[b]);
    this.timeOuts=[]
    },
clear:function(a){
    AmCharts.callMethod("clear",[this.chartScrollbar,this.scrollbarV,this.scrollbarH,this.chartCursor]);
    this.chartCursor=this.scrollbarH=this.scrollbarV=this.chartScrollbar=null;
    this.clearTimeOuts();
    this.container&&(this.container.remove(this.chartDiv),
        this.container.remove(this.legendDiv));
    a||AmCharts.removeChart(this)
    },
setMouseCursor:function(a){
    "auto"==a&&AmCharts.isNN&&(a="default");
    this.chartDiv.style.cursor=a;
    this.legendDiv.style.cursor=a
    },
redrawLabels:function(){
    this.labels=[];
    var a=this.allLabels;
    this.createLabelsSet();
    for(var b=0;b<a.length;b++)this.drawLabel(a[b])
        },
drawLabel:function(a){
    if(this.container){
        var b=a.y,d=a.text,e=a.align,f=a.size,g=a.color,h=a.rotation,i=a.alpha,j=a.bold,k=AmCharts.toCoordinate(a.x,this.realWidth),b=AmCharts.toCoordinate(b,
            this.realHeight);
        k||(k=0);
        b||(b=0);
        void 0==g&&(g=this.color);
        isNaN(f)&&(f=this.fontSize);
        e||(e="start");
        "left"==e&&(e="start");
        "right"==e&&(e="end");
        "center"==e&&(e="middle",h?b=this.realHeight-b+b/2:k=this.realWidth/2-k);
        void 0==i&&(i=1);
        void 0==h&&(h=0);
        b+=f/2;
        d=AmCharts.text(this.container,d,g,this.fontFamily,f,e,j,i);
        d.translate(k,b);
        0!=h&&d.rotate(h);
        a.url&&(d.setAttr("cursor","pointer"),d.click(function(){
            AmCharts.getURL(a.url)
            }));
        this.labelsSet.push(d);
        this.labels.push(d)
        }
    },
addLabel:function(a,
    b,d,e,f,g,h,i,j,k){
    a={
        x:a,
        y:b,
        text:d,
        align:e,
        size:f,
        color:g,
        alpha:i,
        rotation:h,
        bold:j,
        url:k
    };
    
    this.container&&this.drawLabel(a);
    this.allLabels.push(a)
    },
clearLabels:function(){
    for(var a=this.labels,b=a.length-1;0<=b;b--)a[b].remove();
    this.labels=[];
    this.allLabels=[]
    },
updateHeight:function(){
    var a=this.divRealHeight,b=this.legend;
    if(b){
        var d=this.legendDiv.offsetHeight,b=b.position;
        if("top"==b||"bottom"==b)a-=d,0>a&&(a=0),this.chartDiv.style.height=a+"px"
            }
            return a
    },
updateWidth:function(){
    var a=this.divRealWidth,
    b=this.divRealHeight,d=this.legend;
    if(d){
        var e=this.legendDiv,f=e.offsetWidth,g=e.offsetHeight,e=e.style,h=this.chartDiv.style,d=d.position;
        if("right"==d||"left"==d)a-=f,0>a&&(a=0),h.width=a+"px","left"==d?h.left=f+"px":e.left=a+"px",e.top=(b-g)/2+"px"
            }
            return a
    },
getTitleHeight:function(){
    var a=0,b=this.titles;
    if(0<b.length)for(var a=15,d=0;d<b.length;d++)a+=b[d].size+6;
    return a
    },
addTitle:function(a,b,d,e,f){
    isNaN(b)&&(b=this.fontSize+2);
    a={
        text:a,
        size:b,
        color:d,
        alpha:e,
        bold:f
    };
    
    this.titles.push(a);
    return a
    },
addListeners:function(){
    var a=this,b=a.chartDiv;
    AmCharts.isNN&&(a.panEventsEnabled&&"ontouchstart"in document.documentElement&&(b.addEventListener("touchstart",function(b){
        a.handleTouchMove.call(a,b);
        a.handleTouchStart.call(a,b)
        },!0),b.addEventListener("touchmove",function(b){
        a.handleTouchMove.call(a,b)
        },!0),b.addEventListener("touchend",function(b){
        a.handleTouchEnd.call(a,b)
        },!0)),b.addEventListener("mousedown",function(b){
        a.handleMouseDown.call(a,b)
        },!0),b.addEventListener("mouseover",
        function(b){
            a.handleMouseOver.call(a,b)
            },!0),b.addEventListener("mouseout",function(b){
        a.handleMouseOut.call(a,b)
        },!0));
    AmCharts.isIE&&(b.attachEvent("onmousedown",function(b){
        a.handleMouseDown.call(a,b)
        }),b.attachEvent("onmouseover",function(b){
        a.handleMouseOver.call(a,b)
        }),b.attachEvent("onmouseout",function(b){
        a.handleMouseOut.call(a,b)
        }))
    },
dispDUpd:function(){
    var a;
    this.dispatchDataUpdated&&(this.dispatchDataUpdated=!1,a="dataUpdated",this.fire(a,{
        type:a,
        chart:this
    }));
    this.chartCreated||(a="init",
        this.fire(a,{
            type:a,
            chart:this
        }))
    },
drb:function(){
    var a=this.product,b=a+".com",d=window.location.hostname.split(".");
    if(2<=d.length)var e=d[d.length-2]+"."+d[d.length-1];
    AmCharts.remove(this.bbset);
    if(e!=b){
        var b=b+"/?utm_source=swf&utm_medium=demo&utm_campaign=jsDemo"+a,f="chart by ",d=145;
        "ammap"==a&&(f="tool by ",d=125);
        e=AmCharts.rect(this.container,d,20,"#FFFFFF",1);
        f=AmCharts.text(this.container,f+a+".com","#000000","Verdana",11,"start");
        f.translate(7,9);
        e=this.container.set([e,f]);
        "ammap"==
        a&&e.translate(this.realWidth-d,0);
        this.bbset=e;
        this.linkSet.push(e);
        e.setAttr("cursor","pointer");
        e.click(function(){
            window.location.href="http://"+b
            });
        for(a=0;a<e.length;a++)e[a].attr({
            cursor:"pointer"
        })
        }
        },
validateSize:function(){
    var a=this;
    a.measure();
    var b=a.legend;
    if((a.realWidth!=a.previousWidth||a.realHeight!=a.previousHeight)&&0<a.realWidth&&0<a.realHeight){
        a.sizeChanged=!0;
        if(b){
            clearTimeout(a.legendInitTO);
            var d=setTimeout(function(){
                b.invalidateSize()
                },100);
            a.timeOuts.push(d);
            a.legendInitTO=
            d
            }
            a.marginsUpdated=!1;
        clearTimeout(a.initTO);
        d=setTimeout(function(){
            a.initChart()
            },150);
        a.timeOuts.push(d);
        a.initTO=d
        }
        a.renderFix();
    b&&b.renderFix()
    },
invalidateSize:function(){
    var a=this;
    a.previousWidth=NaN;
    a.previousHeight=NaN;
    a.marginsUpdated=!1;
    clearTimeout(a.validateTO);
    var b=setTimeout(function(){
        a.validateSize()
        },5);
    a.timeOuts.push(b);
    a.validateTO=b
    },
validateData:function(a){
    this.chartCreated&&(this.dataChanged=!0,this.marginsUpdated=!1,this.initChart(a))
    },
validateNow:function(){
    this.listenersAdded=
    !1;
    this.write(this.div)
    },
showItem:function(a){
    a.hidden=!1;
    this.initChart()
    },
hideItem:function(a){
    a.hidden=!0;
    this.initChart()
    },
hideBalloon:function(){
    var a=this;
    a.hoverInt=setTimeout(function(){
        a.hideBalloonReal.call(a)
        },80)
    },
cleanChart:function(){},
hideBalloonReal:function(){
    var a=this.balloon;
    a&&a.hide()
    },
showBalloon:function(a,b,d,e,f){
    var g=this;
    clearTimeout(g.balloonTO);
    g.balloonTO=setTimeout(function(){
        g.showBalloonReal.call(g,a,b,d,e,f)
        },1)
    },
showBalloonReal:function(a,b,d,e,f){
    this.handleMouseMove();
    var g=this.balloon;
    g.enabled&&(g.followCursor(!1),g.changeColor(b),d||g.setPosition(e,f),g.followCursor(d),a&&g.showBalloon(a))
    },
handleTouchMove:function(a){
    this.hideBalloon();
    var b=this.chartDiv;
    a.touches&&(a=a.touches.item(0),this.mouseX=a.pageX-AmCharts.findPosX(b),this.mouseY=a.pageY-AmCharts.findPosY(b))
    },
handleMouseOver:function(){
    AmCharts.resetMouseOver();
    this.mouseIsOver=!0
    },
handleMouseOut:function(){
    AmCharts.resetMouseOver();
    this.mouseIsOver=!1
    },
handleMouseMove:function(a){
    if(this.mouseIsOver){
        var b=
        this.chartDiv;
        a||(a=window.event);
        var d,e;
        if(a){
            switch(this.mouseMode){
                case 1:
                    d=a.clientX-AmCharts.findPosX(b);
                    e=a.clientY-AmCharts.findPosY(b);
                    if(!this.divIsFixed){
                    if(a=document.body)var f=a.scrollLeft,g=a.scrollTop;
                    if(a=document.documentElement)var h=a.scrollLeft,i=a.scrollTop;
                    f=Math.max(f,h);
                    g=Math.max(g,i);
                    d+=f;
                    e+=g
                    }
                    break;
                case 3:
                    d=a.pageX-AmCharts.findPosX(b);
                    e=a.pageY-AmCharts.findPosY(b);
                    break;
                case 0:
                    this.divIsFixed?(d=a.clientX-AmCharts.findPosX(b),e=a.clientY-AmCharts.findPosY(b)):(d=a.pageX-
                    AmCharts.findPosX(b),e=a.pageY-AmCharts.findPosY(b))
                }
                this.mouseX=d;
            this.mouseY=e
            }
        }
},
handleTouchStart:function(a){
    this.handleMouseDown(a)
    },
handleTouchEnd:function(a){
    AmCharts.resetMouseOver();
    this.handleReleaseOutside(a)
    },
handleReleaseOutside:function(){},
handleMouseDown:function(a){
    AmCharts.resetMouseOver();
    this.mouseIsOver=!0;
    a&&a.preventDefault&&a.preventDefault()
    },
addLegend:function(a){
    AmCharts.extend(a,new AmCharts.AmLegend);
    this.legend=a;
    a.chart=this;
    a.div=this.legendDiv;
    var b=this.handleLegendEvent;
    this.listenTo(a,"showItem",b);
    this.listenTo(a,"hideItem",b);
    this.listenTo(a,"clickMarker",b);
    this.listenTo(a,"rollOverItem",b);
    this.listenTo(a,"rollOutItem",b);
    this.listenTo(a,"rollOverMarker",b);
    this.listenTo(a,"rollOutMarker",b);
    this.listenTo(a,"clickLabel",b)
    },
removeLegend:function(){
    this.legend=void 0;
    this.legendDiv.innerHTML=""
    },
handleResize:function(){
    (AmCharts.isPercents(this.width)||AmCharts.isPercents(this.height))&&this.invalidateSize();
    this.renderFix()
    },
renderFix:function(){
    if(!AmCharts.VML){
        var a=
        this.container;
        a&&a.renderFix()
        }
    },
getSVG:function(){
    if(AmCharts.hasSVG)return this.container
        }
    });
AmCharts.Slice=AmCharts.Class({
    construct:function(){}
});
AmCharts.SerialDataItem=AmCharts.Class({
    construct:function(){}
});
AmCharts.GraphDataItem=AmCharts.Class({
    construct:function(){}
});
AmCharts.Guide=AmCharts.Class({
    construct:function(){}
});
AmCharts.toBoolean=function(a,b){
    if(void 0==a)return b;
    switch(String(a).toLowerCase()){
        case "true":case "yes":case "1":
            return!0;
        case "false":case "no":case "0":case null:
            return!1;
        default:
            return Boolean(a)
            }
        };

AmCharts.removeFromArray=function(a,b){
    for(var d=a.length-1;0<=d;d--)a[d]==b&&a.splice(d,1)
        };
AmCharts.getStyle=function(a,b){
    var d="";
    document.defaultView&&document.defaultView.getComputedStyle?d=document.defaultView.getComputedStyle(a,"").getPropertyValue(b):a.currentStyle&&(b=b.replace(/\-(\w)/g,function(a,b){
        return b.toUpperCase()
        }),d=a.currentStyle[b]);
    return d
    };
    
AmCharts.removePx=function(a){
    return Number(a.substring(0,a.length-2))
    };
AmCharts.getURL=function(a,b){
    if(a)if("_self"==b||!b)window.location.href=a;
        else if("_top"==b&&window.top)window.top.location.href=a;
        else if("_parent"==b&&window.parent)window.parent.location.href=a;
        else{
        var d=document.getElementsByName(b)[0];
        d?d.src=a:window.open(a)
        }
    };
    
AmCharts.formatMilliseconds=function(a,b){
    if(-1!=a.indexOf("fff")){
        var d=b.getMilliseconds(),e=String(d);
        10>d&&(e="00"+d);
        10<=d&&100>d&&(e="0"+d);
        a=a.replace(/fff/g,e)
        }
        return a
    };
AmCharts.ifArray=function(a){
    return a&&0<a.length?!0:!1
    };
    
AmCharts.callMethod=function(a,b){
    for(var d=0;d<b.length;d++){
        var e=b[d];
        if(e){
            if(e[a])e[a]();
            var f=e.length;
            if(0<f)for(var g=0;g<f;g++){
                var h=e[g];
                if(h&&h[a])h[a]()
                    }
                }
            }
};

AmCharts.toNumber=function(a){
    return"number"==typeof a?a:Number(String(a).replace(/[^0-9\-.]+/g,""))
    };
AmCharts.toColor=function(a){
    if(""!=a&&void 0!=a)if(-1!=a.indexOf(","))for(var a=a.split(","),b=0;b<a.length;b++){
        var d=a[b].substring(a[b].length-6,a[b].length);
        a[b]="#"+d
        }else a=a.substring(a.length-6,a.length),a="#"+a;
    return a
    };
    
AmCharts.toCoordinate=function(a,b,d){
    var e;
    void 0!=a&&(a=String(a),d&&d<b&&(b=d),e=Number(a),-1!=a.indexOf("!")&&(e=b-Number(a.substr(1))),-1!=a.indexOf("%")&&(e=b*Number(a.substr(0,a.length-1))/100));
    return e
    };
AmCharts.fitToBounds=function(a,b,d){
    a<b&&(a=b);
    a>d&&(a=d);
    return a
    };
    
AmCharts.isDefined=function(a){
    return void 0==a?!1:!0
    };
    
AmCharts.stripNumbers=function(a){
    return a.replace(/[0-9]+/g,"")
    };
    
AmCharts.extractPeriod=function(a){
    var b=AmCharts.stripNumbers(a),d=1;
    b!=a&&(d=Number(a.slice(0,a.indexOf(b))));
    return{
        period:b,
        count:d
    }
};
AmCharts.resetDateToMin=function(a,b,d,e){
    void 0==e&&(e=1);
    var f=a.getFullYear(),g=a.getMonth(),h=a.getDate(),i=a.getHours(),j=a.getMinutes(),k=a.getSeconds(),l=a.getMilliseconds(),a=a.getDay();
    switch(b){
        case "YYYY":
            f=Math.floor(f/d)*d;
            g=0;
            h=1;
            l=k=j=i=0;
            break;
        case "MM":
            g=Math.floor(g/d)*d;
            h=1;
            l=k=j=i=0;
            break;
        case "WW":
            0==a&&0<e&&(a=7);
            h=h-a+e;
            l=k=j=i=0;
            break;
        case "DD":
            h=Math.floor(h/d)*d;
            l=k=j=i=0;
            break;
        case "hh":
            i=Math.floor(i/d)*d;
            l=k=j=0;
            break;
        case "mm":
            j=Math.floor(j/d)*d;
            l=k=0;
            break;
        case "ss":
            k=
            Math.floor(k/d)*d;
            l=0;
            break;
        case "fff":
            l=Math.floor(l/d)*d
            }
            return a=new Date(f,g,h,i,j,k,l)
    };
    
AmCharts.getPeriodDuration=function(a,b){
    void 0==b&&(b=1);
    var d;
    switch(a){
        case "YYYY":
            d=316224E5;
            break;
        case "MM":
            d=26784E5;
            break;
        case "WW":
            d=6048E5;
            break;
        case "DD":
            d=864E5;
            break;
        case "hh":
            d=36E5;
            break;
        case "mm":
            d=6E4;
            break;
        case "ss":
            d=1E3;
            break;
        case "fff":
            d=1
            }
            return d*b
    };
    
AmCharts.roundTo=function(a,b){
    if(0>b)return a;
    var d=Math.pow(10,b);
    return Math.round(a*d)/d
    };
AmCharts.toFixed=function(a,b){
    var d=String(Math.round(a*Math.pow(10,b)));
    if(0<b){
        var e=d.length;
        if(e<b)for(var f=0;f<b-e;f++)d="0"+d;
        e=d.substring(0,d.length-b);
        ""==e&&(e=0);
        return e+"."+d.substring(d.length-b,d.length)
        }
        return String(d)
    };
    
AmCharts.intervals={
    s:{
        nextInterval:"ss",
        contains:1E3
    },
    ss:{
        nextInterval:"mm",
        contains:60,
        count:0
    },
    mm:{
        nextInterval:"hh",
        contains:60,
        count:1
    },
    hh:{
        nextInterval:"DD",
        contains:24,
        count:2
    },
    DD:{
        nextInterval:"",
        contains:Infinity,
        count:3
    }
};
AmCharts.getMaxInterval=function(a,b){
    var d=AmCharts.intervals;
    return a>=d[b].contains?(a=Math.round(a/d[b].contains),b=d[b].nextInterval,AmCharts.getMaxInterval(a,b)):"ss"==b?d[b].nextInterval:b
    };
AmCharts.formatDuration=function(a,b,d,e,f,g){
    var h=AmCharts.intervals,i=g.decimalSeparator;
    if(a>=h[b].contains){
        var j=a-Math.floor(a/h[b].contains)*h[b].contains;
        "ss"==b&&(j=AmCharts.formatNumber(j,g),1==j.split(i)[0].length&&(j="0"+j));
        if(("mm"==b||"hh"==b)&&10>j)j="0"+j;
        d=j+""+e[b]+""+d;
        a=Math.floor(a/h[b].contains);
        b=h[b].nextInterval;
        return AmCharts.formatDuration(a,b,d,e,f,g)
        }
        "ss"==b&&(a=AmCharts.formatNumber(a,g),1==a.split(i)[0].length&&(a="0"+a));
    if(("mm"==b||"hh"==b)&&10>a)a="0"+a;
    d=a+""+
    e[b]+""+d;
    if(h[f].count>h[b].count)for(a=h[b].count;a<h[f].count;a++)b=h[b].nextInterval,"ss"==b||"mm"==b||"hh"==b?d="00"+e[b]+""+d:"DD"==b&&(d="0"+e[b]+""+d);
    ":"==d.charAt(d.length-1)&&(d=d.substring(0,d.length-1));
    return d
    };
AmCharts.formatNumber=function(a,b,d,e,f){
    a=AmCharts.roundTo(a,b.precision);
    isNaN(d)&&(d=b.precision);
    var g=b.decimalSeparator,b=b.thousandsSeparator,h=0>a?"-":"",a=Math.abs(a),i=String(a),j=!1;
    -1!=i.indexOf("e")&&(j=!0);
    0<=d&&(0!=a&&!j)&&(i=AmCharts.toFixed(a,d));
    if(j)j=i;
    else{
        for(var i=i.split("."),j="",k=String(i[0]),l=k.length;0<=l;l-=3)j=l!=k.length?0!=l?k.substring(l-3,l)+b+j:k.substring(l-3,l)+j:k.substring(l-3,l);
        void 0!=i[1]&&(j=j+g+i[1]);
        void 0!=d&&(0<d&&"0"!=j)&&(j=AmCharts.addZeroes(j,
            g,d))
        }
        j=h+j;
    ""==h&&(!0==e&&0!=a)&&(j="+"+j);
    !0==f&&(j+="%");
    return j
    };
    
AmCharts.addZeroes=function(a,b,d){
    a=a.split(b);
    void 0==a[1]&&0<d&&(a[1]="0");
    return a[1].length<d?(a[1]+="0",AmCharts.addZeroes(a[0]+b+a[1],b,d)):void 0!=a[1]?a[0]+b+a[1]:a[0]
    };
AmCharts.scientificToNormal=function(a){
    var b,a=String(a).split("e");
    if("-"==a[1].substr(0,1)){
        b="0.";
        for(var d=0;d<Math.abs(Number(a[1]))-1;d++)b+="0";
        b+=a[0].split(".").join("")
        }else{
        var e=0;
        b=a[0].split(".");
        b[1]&&(e=b[1].length);
        b=a[0].split(".").join("");
        for(d=0;d<Math.abs(Number(a[1]))-e;d++)b+="0"
            }
            return b
    };
AmCharts.toScientific=function(a,b){
    if(0==a)return"0";
    var d=Math.floor(Math.log(Math.abs(a))*Math.LOG10E);
    Math.pow(10,d);
    mantissa=String(mantissa).split(".").join(b);
    return String(mantissa)+"e"+d
    };
    
AmCharts.randomColor=function(){
    return"#"+("00000"+(16777216*Math.random()<<0).toString(16)).substr(-6)
    };
AmCharts.hitTest=function(a,b,d){
    var e=!1,f=a.x,g=a.x+a.width,h=a.y,i=a.y+a.height,j=AmCharts.isInRectangle;
    e||(e=j(f,h,b));
    e||(e=j(f,i,b));
    e||(e=j(g,h,b));
    e||(e=j(g,i,b));
    !e&&!0!=d&&(e=AmCharts.hitTest(b,a,!0));
    return e
    };
    
AmCharts.isInRectangle=function(a,b,d){
    return a>=d.x-5&&a<=d.x+d.width+5&&b>=d.y-5&&b<=d.y+d.height+5?!0:!1
    };
    
AmCharts.isPercents=function(a){
    if(-1!=String(a).indexOf("%"))return!0
        };
        
AmCharts.dayNames="Sunday Monday Tuesday Wednesday Thursday Friday Saturday".split(" ");
AmCharts.shortDayNames="Sun Mon Tue Wed Thu Fri Sat".split(" ");
AmCharts.monthNames="January February March April May June July August September October November December".split(" ");
AmCharts.shortMonthNames="Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec".split(" ");
AmCharts.formatDate=function(a,b){
    var d,e,f,g,h,i,j,k;
    AmCharts.useUTC?(d=a.getUTCFullYear(),e=a.getUTCMonth(),f=a.getUTCDate(),g=a.getUTCDay(),h=a.getUTCHours(),i=a.getUTCMinutes(),j=a.getUTCSeconds(),k=a.getUTCMilliseconds()):(d=a.getFullYear(),e=a.getMonth(),f=a.getDate(),g=a.getDay(),h=a.getHours(),i=a.getMinutes(),j=a.getSeconds(),k=a.getMilliseconds());
    var l=String(d).substr(2,2),m=e+1;
    9>e&&(m="0"+m);
    var s=f;
    10>f&&(s="0"+f);
    var p="0"+g,q=h;
    24==q&&(q=0);
    var n=q;
    10>n&&(n="0"+n);
    b=b.replace(/JJ/g,
        n);
    b=b.replace(/J/g,q);
    q=h;
    0==q&&(q=24);
    n=q;
    10>n&&(n="0"+n);
    b=b.replace(/HH/g,n);
    b=b.replace(/H/g,q);
    q=h;
    11<q&&(q-=12);
    n=q;
    10>n&&(n="0"+n);
    b=b.replace(/KK/g,n);
    b=b.replace(/K/g,q);
    q=h;
    0==q&&(q=12);
    12<q&&(q-=12);
    n=q;
    10>n&&(n="0"+n);
    b=b.replace(/LL/g,n);
    b=b.replace(/L/g,q);
    q=i;
    10>q&&(q="0"+q);
    b=b.replace(/NN/g,q);
    b=b.replace(/N/g,i);
    i=j;
    10>i&&(i="0"+i);
    b=b.replace(/SS/g,i);
    b=b.replace(/S/g,j);
    j=k;
    10>j&&(j="00"+j);
    100>j&&(j="0"+j);
    i=k;
    10>i&&(i="00"+i);
    b=b.replace(/QQQ/g,j);
    b=b.replace(/QQ/g,i);
    b=b.replace(/Q/g,
        k);
    b=12>h?b.replace(/A/g,"am"):b.replace(/A/g,"pm");
    b=b.replace(/YYYY/g,"@IIII@");
    b=b.replace(/YY/g,"@II@");
    b=b.replace(/MMMM/g,"@XXXX@");
    b=b.replace(/MMM/g,"@XXX@");
    b=b.replace(/MM/g,"@XX@");
    b=b.replace(/M/g,"@X@");
    b=b.replace(/DD/g,"@RR@");
    b=b.replace(/D/g,"@R@");
    b=b.replace(/EEEE/g,"@PPPP@");
    b=b.replace(/EEE/g,"@PPP@");
    b=b.replace(/EE/g,"@PP@");
    b=b.replace(/E/g,"@P@");
    b=b.replace(/@IIII@/g,d);
    b=b.replace(/@II@/g,l);
    b=b.replace(/@XXXX@/g,AmCharts.monthNames[e]);
    b=b.replace(/@XXX@/g,AmCharts.shortMonthNames[e]);
    b=b.replace(/@XX@/g,m);
    b=b.replace(/@X@/g,e+1);
    b=b.replace(/@RR@/g,s);
    b=b.replace(/@R@/g,f);
    b=b.replace(/@PPPP@/g,AmCharts.dayNames[g]);
    b=b.replace(/@PPP@/g,AmCharts.shortDayNames[g]);
    b=b.replace(/@PP@/g,p);
    return b=b.replace(/@P@/g,g)
    };
    
AmCharts.findPosX=function(a){
    var b=a.offsetLeft;
    if(a.offsetParent)for(;a=a.offsetParent;)b+=a.offsetLeft,a!=document.body&&a!=document.documentElement&&(b-=a.scrollLeft);
    return b
    };
AmCharts.findPosY=function(a){
    var b=a.offsetTop;
    if(a.offsetParent)for(;a=a.offsetParent;)b+=a.offsetTop,a!=document.body&&a!=document.documentElement&&(b-=a.scrollTop);
    return b
    };
    
AmCharts.findIfFixed=function(a){
    if(a.offsetParent)for(;a=a.offsetParent;)if("fixed"==AmCharts.getStyle(a,"position"))return!0;return!1
    };
    
AmCharts.findIfAuto=function(a){
    return a.style&&"auto"==AmCharts.getStyle(a,"overflow")?!0:a.parentNode?AmCharts.findIfAuto(a.parentNode):!1
    };
AmCharts.findScrollLeft=function(a,b){
    a.scrollLeft&&(b+=a.scrollLeft);
    return a.parentNode?AmCharts.findScrollLeft(a.parentNode,b):b
    };
    
AmCharts.findScrollTop=function(a,b){
    a.scrollTop&&(b+=a.scrollTop);
    return a.parentNode?AmCharts.findScrollTop(a.parentNode,b):b
    };
    
AmCharts.formatValue=function(a,b,d,e,f,g,h,i){
    if(b){
        void 0==f&&(f="");
        for(var j=0;j<d.length;j++){
            var k=d[j],l=b[k];
            void 0!=l&&(l=g?AmCharts.addPrefix(l,i,h,e):AmCharts.formatNumber(l,e),a=a.replace(RegExp("\\[\\["+f+""+k+"\\]\\]","g"),l))
            }
        }
        return a
};
AmCharts.formatDataContextValue=function(a,b){
    if(a)for(var d=a.match(/\[\[.*?\]\]/g),e=0;e<d.length;e++){
        var f=d[e],f=f.substr(2,f.length-4);
        void 0!=b[f]&&(a=a.replace(RegExp("\\[\\["+f+"\\]\\]","g"),b[f]))
        }
        return a
    };
    
AmCharts.massReplace=function(a,b){
    for(var d in b){
        var e=b[d];
        void 0==e&&(e="");
        a=a.replace(d,e)
        }
        return a
    };
    
AmCharts.cleanFromEmpty=function(a){
    return a.replace(/\[\[[^\]]*\]\]/g,"")
    };
AmCharts.addPrefix=function(a,b,d,e){
    var f=AmCharts.formatNumber(a,e),g="",h;
    if(0==a)return"0";
    0>a&&(g="-");
    a=Math.abs(a);
    if(1<a)for(h=b.length-1;-1<h;h--){
        if(a>=b[h].number){
            a/=b[h].number;
            e=Number(e.precision);
            1>e&&(e=1);
            a=AmCharts.roundTo(a,e);
            f=g+""+a+""+b[h].prefix;
            break
        }
    }else for(h=0;h<d.length;h++)if(a<=d[h].number){
    a/=d[h].number;
    e=Math.abs(Math.round(Math.log(a)*Math.LOG10E));
    a=AmCharts.roundTo(a,e);
    f=g+""+a+""+d[h].prefix;
    break
}
return f
};

AmCharts.remove=function(a){
    a&&a.remove()
    };
AmCharts.copyProperties=function(a,b){
    for(var d in a)"events"!=d&&(void 0!=a[d]&&"function"!=typeof a[d])&&(b[d]=a[d])
        };
        
AmCharts.recommended=function(){
    var a="js";
    document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#BasicStructure","1.1")||swfobject&&swfobject.hasFlashPlayerVersion("8")&&(a="flash");
    return a
    };
    
AmCharts.getEffect=function(a){
    ">"==a&&(a="easeOutSine");
    "<"==a&&(a="easeInSine");
    "elastic"==a&&(a="easeOutElastic");
    return a
    };
AmCharts.extend=function(a,b){
    for(var d in b)void 0==a[d]&&(a[d]=b[d])
        };
        
AmCharts.fixNewLines=function(a){
    9>AmCharts.IEversion&&0<AmCharts.IEversion&&(a=AmCharts.massReplace(a,{
        "\n":"\r"
    }));
    return a
    };
    
AmCharts.Bezier=AmCharts.Class({
    construct:function(a,b,d,e,f,g,h,i,j,k){
        "object"==typeof h&&(h=h[0]);
        "object"==typeof i&&(i=i[0]);
        g={
            fill:h,
            "fill-opacity":i,
            "stroke-width":g
        };
        
        void 0!=j&&0<j&&(g["stroke-dasharray"]=j);
        isNaN(f)||(g["stroke-opacity"]=f);
        e&&(g.stroke=e);
        e="M"+Math.round(b[0])+","+Math.round(d[0]);
        f=[];
        for(j=0;j<b.length;j++)f.push({
            x:Number(b[j]),
            y:Number(d[j])
            });
        1<f.length&&(b=this.interpolate(f),e+=this.drawBeziers(b));
        k?e+=k:AmCharts.VML||(e+="M0,0 L0,0");
        this.path=a.path(e).attr(g)
        },
    interpolate:function(a){
        var b=[];
        b.push({
            x:a[0].x,
            y:a[0].y
            });
        var d=a[1].x-a[0].x,e=a[1].y-a[0].y,f=AmCharts.bezierX,g=AmCharts.bezierY;
        b.push({
            x:a[0].x+d/f,
            y:a[0].y+e/g
            });
        for(var h=1;h<a.length-1;h++){
            var i=a[h-1],j=a[h],e=a[h+1],d=e.x-j.x,e=e.y-i.y,i=j.x-i.x;
            i>d&&(i=d);
            b.push({
                x:j.x-i/f,
                y:j.y-e/g
                });
            b.push({
                x:j.x,
                y:j.y
                });
            b.push({
                x:j.x+i/f,
                y:j.y+e/g
                })
            }
            e=a[a.length-1].y-a[a.length-2].y;
        d=a[a.length-1].x-a[a.length-2].x;
        b.push({
            x:a[a.length-1].x-d/f,
            y:a[a.length-1].y-e/g
            });
        b.push({
            x:a[a.length-1].x,
            y:a[a.length-1].y
            });
        return b
        },
    drawBeziers:function(a){
        for(var b="",d=0;d<(a.length-1)/3;d++)b+=this.drawBezierMidpoint(a[3*d],a[3*d+1],a[3*d+2],a[3*d+3]);
        return b
        },
    drawBezierMidpoint:function(a,b,d,e){
        var f=Math.round,g=this.getPointOnSegment(a,b,0.75),h=this.getPointOnSegment(e,d,0.75),i=(e.x-a.x)/16,j=(e.y-a.y)/16,k=this.getPointOnSegment(a,b,0.375),a=this.getPointOnSegment(g,h,0.375);
        a.x-=i;
        a.y-=j;
        b=this.getPointOnSegment(h,g,0.375);
        b.x+=i;
        b.y+=j;
        d=this.getPointOnSegment(e,d,0.375);
        i=this.getMiddle(k,
            a);
        g=this.getMiddle(g,h);
        h=this.getMiddle(b,d);
        k=" Q"+f(k.x)+","+f(k.y)+","+f(i.x)+","+f(i.y);
        k+=" Q"+f(a.x)+","+f(a.y)+","+f(g.x)+","+f(g.y);
        k+=" Q"+f(b.x)+","+f(b.y)+","+f(h.x)+","+f(h.y);
        return k+=" Q"+f(d.x)+","+f(d.y)+","+f(e.x)+","+f(e.y)
        },
    getMiddle:function(a,b){
        return{
            x:(a.x+b.x)/2,
            y:(a.y+b.y)/2
            }
        },
getPointOnSegment:function(a,b,d){
    return{
        x:a.x+(b.x-a.x)*d,
        y:a.y+(b.y-a.y)*d
        }
    }
});
AmCharts.Cuboid=AmCharts.Class({
    construct:function(a,b,d,e,f,g,h,i,j,k,l,m,s){
        this.set=a.set();
        this.container=a;
        this.h=Math.round(d);
        this.w=Math.round(b);
        this.dx=e;
        this.dy=f;
        this.colors=g;
        this.alpha=h;
        this.bwidth=i;
        this.bcolor=j;
        this.balpha=k;
        this.colors=g;
        s?0>b&&0==l&&(l=180):0>d&&270==l&&(l=90);
        this.gradientRotation=l;
        0==e&&0==f&&(this.cornerRadius=m);
        this.draw()
        },
    draw:function(){
        var a=this.set;
        a.clear();
        var b=this.container,d=this.w,e=this.h,f=this.dx,g=this.dy,h=this.colors,i=this.alpha,j=this.bwidth,
        k=this.bcolor,l=this.balpha,m=this.gradientRotation,s=this.cornerRadius,p=h,q=h;
        "object"==typeof h&&(p=h[0],q=h[h.length-1]);
        if(0<f||0<g){
            var n=q,q=AmCharts.adjustLuminosity(p,-0.2),q=AmCharts.adjustLuminosity(p,-0.2),r=AmCharts.polygon(b,[0,f,d+f,d,0],[0,g,g,0,0],q,i,0,0,0,m);
            if(0<l)var t=AmCharts.line(b,[0,f,d+f],[0,g,g],k,l,j);
            var u=AmCharts.polygon(b,[0,0,d,d,0],[0,e,e,0,0],q,i,0,0,0,0,m);
            u.translate(f,g);
            if(0<l)var w=AmCharts.line(b,[f,f],[g,g+e],k,1,j);
            var y=AmCharts.polygon(b,[0,0,f,f,0],[0,
                e,e+g,g,0],q,i,0,0,0,m),z=AmCharts.polygon(b,[d,d,d+f,d+f,d],[0,e,e+g,g,0],q,i,0,0,0,m);
            if(0<l)var v=AmCharts.line(b,[d,d+f,d+f,d],[0,g,e+g,e],k,l,j);
            q=AmCharts.adjustLuminosity(n,0.2);
            n=AmCharts.polygon(b,[0,f,d+f,d,0],[e,e+g,e+g,e,e],q,i,0,0,0,m);
            if(0<l)var x=AmCharts.line(b,[0,f,d+f],[e,e+g,e+g],k,l,j)
                }
                1>Math.abs(e)&&(e=0);
        1>Math.abs(d)&&(d=0);
        b=0==e?AmCharts.line(b,[0,d],[0,0],p,l,j):0==d?AmCharts.line(b,[0,0],[0,e],p,l,j):0<s?AmCharts.rect(b,d,e,h,i,j,k,l,s,m):AmCharts.polygon(b,[0,0,d,d,0],
            [0,e,e,0,0],h,i,j,k,l,m);
        e=0>e?[r,t,u,w,y,z,v,n,x,b]:[n,x,u,w,y,z,r,t,v,b];
        for(r=0;r<e.length;r++)(t=e[r])&&a.push(t)
            },
    width:function(a){
        this.w=a;
        this.draw()
        },
    height:function(a){
        this.h=a;
        this.draw()
        },
    animateHeight:function(a,b){
        var d=this;
        d.easing=b;
        d.totalFrames=1E3*a/AmCharts.updateRate;
        d.rh=d.h;
        d.frame=0;
        d.height(1);
        setTimeout(function(){
            d.updateHeight.call(d)
            },AmCharts.updateRate)
        },
    updateHeight:function(){
        var a=this;
        a.frame++;
        var b=a.totalFrames;
        a.frame<=b&&(b=a.easing(0,a.frame,1,a.rh-1,b),a.height(b),
            setTimeout(function(){
                a.updateHeight.call(a)
                },AmCharts.updateRate))
        },
    animateWidth:function(a,b){
        var d=this;
        d.easing=b;
        d.totalFrames=1E3*a/AmCharts.updateRate;
        d.rw=d.w;
        d.frame=0;
        d.width(1);
        setTimeout(function(){
            d.updateWidth.call(d)
            },AmCharts.updateRate)
        },
    updateWidth:function(){
        var a=this;
        a.frame++;
        var b=a.totalFrames;
        a.frame<=b&&(b=a.easing(0,a.frame,1,a.rw-1,b),a.width(b),setTimeout(function(){
            a.updateWidth.call(a)
            },AmCharts.updateRate))
        }
    });
AmCharts.AmLegend=AmCharts.Class({
    construct:function(){
        this.createEvents("rollOverMarker","rollOverItem","rollOutMarker","rollOutItem","showItem","hideItem","clickMarker","rollOverItem","rollOutItem","clickLabel");
        this.position="bottom";
        this.borderColor=this.color="#000000";
        this.borderAlpha=0;
        this.markerLabelGap=5;
        this.verticalGap=10;
        this.align="left";
        this.horizontalGap=0;
        this.spacing=10;
        this.markerDisabledColor="#AAB3B3";
        this.markerType="square";
        this.markerSize=16;
        this.markerBorderAlpha;
        this.markerBorderThickness=
        1;
        this.marginBottom=this.marginTop=0;
        this.marginLeft=this.marginRight=20;
        this.autoMargins=!0;
        this.valueWidth=50;
        this.switchable=!0;
        this.switchType="x";
        this.switchColor="#FFFFFF";
        this.rollOverColor="#CC0000";
        this.selectedColor;
        this.reversedOrder=!1;
        this.labelText="[[title]]";
        this.valueText="[[value]]";
        this.useMarkerColorForLabels=!1;
        this.rollOverGraphAlpha=1;
        this.textClickEnabled=!1;
        this.equalWidths=!0;
        this.dateFormat="DD-MM-YYYY";
        this.backgroundColor="#FFFFFF";
        this.backgroundAlpha=0;
        this.ly;
        this.lx;
        this.showEntries=!0
        },
    setData:function(a){
        this.data=a;
        this.invalidateSize()
        },
    invalidateSize:function(){
        this.destroy();
        this.entries=[];
        this.valueLabels=[];
        AmCharts.ifArray(this.data)&&this.drawLegend()
        },
    drawLegend:function(){
        var a=this.chart,b=this.position,d=this.width,e=a.divRealWidth,f=a.divRealHeight,g=this.div,h=this.data;
        isNaN(this.fontSize)&&(this.fontSize=a.fontSize);
        if("right"==b||"left"==b)this.maxColumns=1,this.marginLeft=this.marginRight=10;
        else if(this.autoMargins){
            this.marginRight=a.marginRight;
            this.marginLeft=a.marginLeft;
            var i=a.autoMarginOffset;
            "bottom"==b?(this.marginBottom=i,this.marginTop=0):(this.marginTop=i,this.marginBottom=0)
            }
            this.divWidth=b=void 0!=d?AmCharts.toCoordinate(d,e):a.realWidth;
        g.style.width=b+"px";
        this.container=new AmCharts.AmDraw(g,b,f);
        this.lx=0;
        this.ly=8;
        f=this.markerSize;
        f>this.fontSize&&(this.ly=f/2-1);
        0<f&&(this.lx+=f+this.markerLabelGap);
        this.titleWidth=0;
        if(f=this.title)a=AmCharts.text(this.container,f,this.color,a.fontFamily,this.fontSize,"start",!0),a.translate(0,
            this.marginTop+this.verticalGap+this.ly+1),a=a.getBBox(),this.titleWidth=a.width+15,this.titleHeight=a.height+6;
        this.index=this.maxLabelWidth=0;
        if(this.showEntries){
            for(a=0;a<h.length;a++)this.createEntry(h[a]);
            for(a=this.index=0;a<h.length;a++)this.createValue(h[a])
                }
                this.arrangeEntries();
        this.updateValues()
        },
    arrangeEntries:function(){
        var a=this.position,b=this.marginLeft+this.titleWidth,d=this.marginRight,e=this.marginTop,f=this.marginBottom,g=this.horizontalGap,h=this.div,i=this.divWidth,j=this.maxColumns,
        k=this.verticalGap,l=this.spacing,m=i-d-b,s=0,p=0,q=this.container,n=q.set();
        this.set=n;
        q=q.set();
        n.push(q);
        for(var r=this.entries,t=0;t<r.length;t++){
            var u=r[t].getBBox(),w=u.width;
            w>s&&(s=w);
            u=u.height;
            u>p&&(p=u)
            }
            for(var y=w=0,z=g,t=0;t<r.length;t++){
            var v=r[t];
            this.reversedOrder&&(v=r[r.length-t-1]);
            var u=v.getBBox(),x;
            this.equalWidths?x=g+y*(s+l+this.markerLabelGap):(x=z,z=z+u.width+g+l);
            x+u.width>m&&0<t&&(w++,y=0,x=g,z=x+u.width+g+l);
            v.translate(x,(p+k)*w);
            y++;
            !isNaN(j)&&y>=j&&(y=0,w++);
            q.push(v)
            }
            u=
        q.getBBox();
        j=u.height+2*k-1;
        "left"==a||"right"==a?(i=u.width+2*g,h.style.width=i+b+d+"px"):i=i-b-d-1;
        d=AmCharts.polygon(this.container,[0,i,i,0],[0,0,j,j],this.backgroundColor,this.backgroundAlpha,1,this.borderColor,this.borderAlpha);
        n.push(d);
        n.translate(b,e);
        d.toBack();
        b=g;
        if("top"==a||"bottom"==a||"absolute"==a)"center"==this.align?b=g+(i-u.width)/2:"right"==this.align&&(b=g+i-u.width);
        q.translate(b,k+1);
        this.titleHeight>j&&(j=this.titleHeight);
        a=j+e+f+1;
        0>a&&(a=0);
        h.style.height=Math.round(a)+
        "px"
        },
    createEntry:function(a){
        if(!1!==a.visibleInLegend){
            var b=this.chart,d=a.markerType;
            d||(d=this.markerType);
            var e=a.color,f=a.alpha;
            a.legendKeyColor&&(e=a.legendKeyColor());
            a.legendKeyAlpha&&(f=a.legendKeyAlpha());
            !0==a.hidden&&(e=this.markerDisabledColor);
            var g=this.createMarker(d,e,f);
            this.addListeners(g,a);
            f=this.container.set([g]);
            this.switchable&&f.setAttr("cursor","pointer");
            var h=this.switchType;
            if(h){
                var i;
                i="x"==h?this.createX():this.createV();
                i.dItem=a;
                !0!=a.hidden?"x"==h?i.hide():i.show():
                "x"!=h&&i.hide();
                this.switchable||i.hide();
                this.addListeners(i,a);
                a.legendSwitch=i;
                f.push(i)
                }
                h=this.color;
            a.showBalloon&&(this.textClickEnabled&&void 0!=this.selectedColor)&&(h=this.selectedColor);
            this.useMarkerColorForLabels&&(h=e);
            !0==a.hidden&&(h=this.markerDisabledColor);
            e=AmCharts.massReplace(this.labelText,{
                "[[title]]":a.title
                });
            i=this.fontSize;
            var j=this.markerSize;
            if(g&&j<i){
                var k=0;
                if("bubble"==d||"circle"==d)k=j/2;
                g.translate(k,k+this.ly-i/2+(i+2-j)/2)
                }
                if(e){
                var l=AmCharts.text(this.container,
                    e,h,b.fontFamily,i,"start");
                l.translate(this.lx,this.ly);
                f.push(l);
                b=l.getBBox().width;
                this.maxLabelWidth<b&&(this.maxLabelWidth=b)
                }
                this.entries[this.index]=f;
            a.legendEntry=this.entries[this.index];
            a.legendLabel=l;
            this.index++
        }
    },
addListeners:function(a,b){
    var d=this;
    a&&a.mouseover(function(){
        d.rollOverMarker(b)
        }).mouseout(function(){
        d.rollOutMarker(b)
        }).click(function(){
        d.clickMarker(b)
        })
    },
rollOverMarker:function(a){
    this.switchable&&this.dispatch("rollOverMarker",a);
    this.dispatch("rollOverItem",a)
    },
rollOutMarker:function(a){
    this.switchable&&this.dispatch("rollOutMarker",a);
    this.dispatch("rollOutItem",a)
    },
clickMarker:function(a){
    this.switchable?!0==a.hidden?this.dispatch("showItem",a):this.dispatch("hideItem",a):this.textClickEnabled&&this.dispatch("clickMarker",a)
    },
rollOverLabel:function(a){
    a.hidden||(this.textClickEnabled&&a.legendLabel&&a.legendLabel.attr({
        fill:this.rollOverColor
        }),this.dispatch("rollOverItem",a))
    },
rollOutLabel:function(a){
    if(!a.hidden){
        if(this.textClickEnabled&&a.legendLabel){
            var b=
            this.color;
            void 0!=this.selectedColor&&a.showBalloon&&(b=this.selectedColor);
            this.useMarkerColorForLabels&&(b=a.lineColor,void 0==b&&(b=a.color));
            a.legendLabel.attr({
                fill:b
            })
            }
            this.dispatch("rollOutItem",a)
        }
    },
clickLabel:function(a){
    this.textClickEnabled?a.hidden||this.dispatch("clickLabel",a):this.switchable&&(!0==a.hidden?this.dispatch("showItem",a):this.dispatch("hideItem",a))
    },
dispatch:function(a,b){
    this.fire(a,{
        type:a,
        dataItem:b,
        target:this,
        chart:this.chart
        })
    },
createValue:function(a){
    var b=this,
    d=b.fontSize;
    if(!1!==a.visibleInLegend){
        var e=b.maxLabelWidth;
        b.equalWidths||(b.valueAlign="left");
        "left"==b.valueAlign&&(e=a.legendEntry.getBBox().width);
        var f=e;
        if(b.valueText){
            var g=b.color;
            b.useMarkerColorForLabels&&(g=a.color);
            !0==a.hidden&&(g=b.markerDisabledColor);
            var h=b.valueText,e=e+b.lx+b.markerLabelGap+b.valueWidth,i="end";
            "left"==b.valueAlign&&(e-=b.valueWidth,i="start");
            g=AmCharts.text(b.container,h,g,b.chart.fontFamily,d,i);
            g.translate(e,b.ly);
            b.entries[b.index].push(g);
            f+=b.valueWidth+
            b.markerLabelGap;
            g.dItem=a;
            b.valueLabels.push(g)
            }
            b.index++;
        g=b.markerSize;
        g<d+7&&(g=d+7,AmCharts.VML&&(g+=3));
        d=b.container.rect(b.markerSize+b.markerLabelGap,0,f,g,0,0).attr({
            stroke:"none",
            fill:"#FFFFFF",
            "fill-opacity":0.005
        });
        d.dItem=a;
        b.entries[b.index-1].push(d);
        d.mouseover(function(){
            b.rollOverLabel(a)
            }).mouseout(function(){
            b.rollOutLabel(a)
            }).click(function(){
            b.clickLabel(a)
            })
        }
    },
createV:function(){
    var a=this.markerSize;
    return AmCharts.polygon(this.container,[a/5,a/2,a-a/5,a/2],[a/3,a-a/5,a/
        5,a/1.7],this.switchColor)
    },
createX:function(){
    var a=this.markerSize-3,b={
        stroke:this.switchColor,
        "stroke-width":3
    },d=this.container,e=AmCharts.line(d,[3,a],[3,a]).attr(b),a=AmCharts.line(d,[3,a],[a,3]).attr(b);
    return this.container.set([e,a])
    },
createMarker:function(a,b,d){
    var e=this.markerSize,f=this.container,g,h=this.markerBorderColor;
    h||(h=b);
    var i=this.markerBorderThickness,j=this.markerBorderAlpha;
    switch(a){
        case "square":
            g=AmCharts.polygon(f,[0,e,e,0],[0,0,e,e],b,d,i,h,j);
            break;
        case "circle":
            g=
            AmCharts.circle(f,e/2,b,d,i,h,j);
            g.translate(e/2,e/2);
            break;
        case "line":
            g=AmCharts.line(f,[0,e],[e/2,e/2],b,d,i);
            break;
        case "dashedLine":
            g=AmCharts.line(f,[0,e],[e/2,e/2],b,d,i,3);
            break;
        case "triangleUp":
            g=AmCharts.polygon(f,[0,e/2,e,e],[e,0,e,e],b,d,i,h,j);
            break;
        case "triangleDown":
            g=AmCharts.polygon(f,[0,e/2,e,e],[0,e,0,0],b,d,i,h,j);
            break;
        case "bubble":
            g=AmCharts.circle(f,e/2,b,d,i,h,j,!0),g.translate(e/2,e/2)
            }
            return g
    },
validateNow:function(){
    this.invalidateSize()
    },
updateValues:function(){
    for(var a=
        this.valueLabels,b=this.chart,d=0;d<a.length;d++){
        var e=a[d],f=e.dItem;
        if(void 0!=f.type){
            var g=f.currentDataItem;
            if(g){
                var h=this.valueText;
                f.legendValueText&&(h=f.legendValueText);
                f=h;
                f=b.formatString(f,g);
                e.text(f)
                }else e.text(" ")
                }else g=b.formatString(this.valueText,f),e.text(g)
            }
        },
renderFix:function(){
    if(!AmCharts.VML){
        var a=this.container;
        a&&a.renderFix()
        }
    },
destroy:function(){
    this.div.innerHTML="";
    AmCharts.remove(this.set)
    }
});
AmCharts.AmBalloon=AmCharts.Class({
    construct:function(){
        this.enabled=!0;
        this.fillColor="#CC0000";
        this.fillAlpha=1;
        this.borderThickness=2;
        this.borderColor="#FFFFFF";
        this.borderAlpha=1;
        this.cornerRadius=6;
        this.maximumWidth=220;
        this.horizontalPadding=8;
        this.verticalPadding=5;
        this.pointerWidth=10;
        this.pointerOrientation="V";
        this.color="#FFFFFF";
        this.textShadowColor="#000000";
        this.adjustBorderColor=!1;
        this.showBullet=!0;
        this.show=this.follow=!1;
        this.bulletSize=3;
        this.textAlign="middle"
        },
    draw:function(){
        var a=
        this.pointToX,b=this.pointToY,d=this.textAlign;
        if(!isNaN(a)){
            var e=this.chart,f=e.container,g=this.set;
            AmCharts.remove(g);
            AmCharts.remove(this.pointer);
            this.set=g=f.set();
            e.balloonsSet.push(g);
            if(this.show){
                var h=this.l,i=this.t,j=this.r,k=this.b,l=this.textShadowColor;
                this.color==l&&(l=void 0);
                var m=this.balloonColor,s=this.fillColor,p=this.borderColor;
                void 0!=m&&(this.adjustBorderColor?p=m:s=m);
                var q=this.horizontalPadding,n=this.verticalPadding,m=this.pointerWidth,r=this.pointerOrientation,t=this.cornerRadius,
                u=e.fontFamily,w=this.fontSize;
                void 0==w&&(w=e.fontSize);
                e=AmCharts.text(f,this.text,this.color,u,w,d);
                g.push(e);
                if(void 0!=l){
                    var y=AmCharts.text(f,this.text,l,u,w,d,!1,0.4);
                    g.push(y)
                    }
                    u=e.getBBox();
                l=u.height+2*n;
                n=u.width+2*q;
                window.opera&&(l+=2);
                var z,w=w/2+5;
                switch(d){
                    case "middle":
                        z=n/2;
                        break;
                    case "left":
                        z=q;
                        break;
                    case "right":
                        z=n-q
                        }
                        e.translate(z,w);
                y&&y.translate(z+1,w+1);
                "H"!=r?(z=a-n/2,d=b<i+l+10&&"down"!=r?b+m:b-l-m):(2*m>l&&(m=l/2),d=b-l/2,z=a<h+(j-h)/2?a+m:a-n-m);
                d+l>=k&&(d=k-l);
                d<i&&(d=
                    i);
                z<h&&(z=h);
                z+n>j&&(z=j-n);
                0<t||0==m?(p=AmCharts.rect(f,n,l,s,this.fillAlpha,this.borderThickness,p,this.borderAlpha,this.cornerRadius),this.showBullet&&(f=AmCharts.circle(f,this.bulletSize,s,this.fillAlpha),f.translate(a,b),this.pointer=f)):(k=[],t=[],"H"!=r?(h=a-z,h>n-m&&(h=n-m),h<m&&(h=m),k=[0,h-m,a-z,h+m,n,n,0,0],t=b<i+l+10&&"down"!=r?[0,0,b-d,0,0,l,l,0]:[l,l,b-d,l,l,0,0,l]):(i=b-d,i>l-m&&(i=l-m),i<m&&(i=m),t=[0,i-m,b-d,i+m,l,l,0,0],k=a<h+(j-h)/2?[0,0,a-z,0,0,n,n,0]:[n,n,a-z,n,n,0,0,n]),p=AmCharts.polygon(f,
                    k,t,s,this.fillAlpha,this.borderThickness,p,this.borderAlpha));
                g.push(p);
                p.toFront();
                y&&y.toFront();
                e.toFront();
                a=1;
                9>AmCharts.IEversion&&this.follow&&(a=6);
                g.translate(z-a,d);
                u=p.getBBox();
                this.bottom=d+u.y+u.height;
                this.yPos=u.y+d
                }
            }
    },
followMouse:function(){
    if(this.follow&&this.show){
        var a=this.chart.mouseX,b=this.chart.mouseY-3;
        this.pointToX=a;
        this.pointToY=b;
        if(a!=this.previousX||b!=this.previousY)if(this.previousX=a,this.previousY=b,0==this.cornerRadius)this.draw();
            else{
            var d=this.set;
            if(d){
                var e=
                d.getBBox(),a=a-e.width/2,f=b-e.height-10;
                a<this.l&&(a=this.l);
                a>this.r-e.width&&(a=this.r-e.width);
                f<this.t&&(f=b+10);
                d.translate(a,f)
                }
            }
        }
},
changeColor:function(a){
    this.balloonColor=a
    },
setBounds:function(a,b,d,e){
    this.l=a;
    this.t=b;
    this.r=d;
    this.b=e
    },
showBalloon:function(a){
    this.text=a;
    this.show=!0;
    this.draw()
    },
hide:function(){
    this.follow=this.show=!1;
    this.destroy()
    },
setPosition:function(a,b,d){
    this.pointToX=a;
    this.pointToY=b;
    d&&(a!=this.previousX||b!=this.previousY)&&this.draw();
    this.previousX=a;
    this.previousY=b
    },
followCursor:function(a){
    var b=this;
    (b.follow=a)?(b.pShowBullet=b.showBullet,b.showBullet=!1):void 0!=b.pShowBullet&&(b.showBullet=b.pShowBullet);
    clearInterval(b.interval);
    var d=b.chart.mouseX,e=b.chart.mouseY;
    !isNaN(d)&&a&&(b.pointToX=d,b.pointToY=e-3,b.interval=setInterval(function(){
        b.followMouse.call(b)
        },40))
    },
destroy:function(){
    clearInterval(this.interval);
    AmCharts.remove(this.set);
    AmCharts.remove(this.pointer)
    }
});
AmCharts.AmCoordinateChart=AmCharts.Class({
    inherits:AmCharts.AmChart,
    construct:function(){
        AmCharts.AmCoordinateChart.base.construct.call(this);
        this.createEvents("rollOverGraphItem","rollOutGraphItem","clickGraphItem","doubleClickGraphItem");
        this.plotAreaFillColors="#FFFFFF";
        this.plotAreaFillAlphas=0;
        this.plotAreaBorderColor="#000000";
        this.plotAreaBorderAlpha=0;
        this.startAlpha=1;
        this.startDuration=0;
        this.startEffect="elastic";
        this.sequencedAnimation=!0;
        this.colors="#FF6600 #FCD202 #B0DE09 #0D8ECF #2A0CD0 #CD0D74 #CC0000 #00CC00 #0000CC #DDDDDD #999999 #333333 #990000".split(" ");
        this.balloonDateFormat="MMM DD, YYYY";
        this.valueAxes=[];
        this.graphs=[]
        },
    initChart:function(){
        AmCharts.AmCoordinateChart.base.initChart.call(this);
        this.createValueAxes();
        AmCharts.VML&&(this.startAlpha=1);
        var a=this.legend;
        a&&a.setData(this.graphs)
        },
    createValueAxes:function(){
        if(0==this.valueAxes.length){
            var a=new AmCharts.ValueAxis;
            this.addValueAxis(a)
            }
        },
parseData:function(){
    this.processValueAxes();
    this.processGraphs()
    },
parseSerialData:function(){
    AmCharts.AmSerialChart.base.parseData.call(this);
    var a=
    this.graphs,b={},d=this.seriesIdField;
    d||(d=this.categoryField);
    this.chartData=[];
    var e=this.dataProvider;
    if(e){
        var f=!1;
        this.categoryAxis&&(f=this.categoryAxis.parseDates);
        if(f)var g=AmCharts.extractPeriod(this.categoryAxis.minPeriod),h=g.period,g=g.count;
        var i={};
        
        this.lookupTable=i;
        for(var j=0;j<e.length;j++){
            var k={},l=e[j],m=l[this.categoryField];
            k.category=String(m);
            i[l[d]]=k;
            f&&(m=isNaN(m)?new Date(m.getFullYear(),m.getMonth(),m.getDate(),m.getHours(),m.getMinutes(),m.getSeconds(),m.getMilliseconds()):
                new Date(m),m=AmCharts.resetDateToMin(m,h,g),k.category=m,k.time=m.getTime());
            var s=this.valueAxes;
            k.axes={};
            
            k.x={};
            
            for(var p=0;p<s.length;p++){
                var q=s[p].id;
                k.axes[q]={};
                
                k.axes[q].graphs={};
                
                for(var n=0;n<a.length;n++){
                    var m=a[n],r=m.id,t=m.periodValue;
                    if(m.valueAxis.id==q){
                        k.axes[q].graphs[r]={};
                        
                        var u={};
                        
                        u.index=j;
                        m.dataProvider&&(l=b);
                        u.values=this.processValues(l,m,t);
                        this.processFields(m,u,l);
                        u.category=k.category;
                        u.serialDataItem=k;
                        u.graph=m;
                        k.axes[q].graphs[r]=u
                        }
                    }
                }
            this.chartData[j]=k
        }
    }
for(b=
    0;b<a.length;b++)m=a[b],m.dataProvider&&this.parseGraphData(m)
    },
processValues:function(a,b,d){
    var e={},f=!1;
    if(("candlestick"==b.type||"ohlc"==b.type)&&""!=d)f=!0;
    var g=Number(a[b.valueField+d]);
    isNaN(g)||(e.value=g);
    f&&(d="Open");
    g=Number(a[b.openField+d]);
    isNaN(g)||(e.open=g);
    f&&(d="Close");
    g=Number(a[b.closeField+d]);
    isNaN(g)||(e.close=g);
    f&&(d="Low");
    g=Number(a[b.lowField+d]);
    isNaN(g)||(e.low=g);
    f&&(d="High");
    g=Number(a[b.highField+d]);
    isNaN(g)||(e.high=g);
    return e
    },
parseGraphData:function(a){
    var b=
    a.dataProvider,d=a.seriesIdField;
    d||(d=this.seriesIdField);
    d||(d=this.categoryField);
    for(var e=0;e<b.length;e++){
        var f=b[e],g=this.lookupTable[String(f[d])],h=a.valueAxis.id;
        g&&(h=g.axes[h].graphs[a.id],h.serialDataItem=g,h.values=this.processValues(f,a,a.periodValue),this.processFields(a,h,f))
        }
    },
addValueAxis:function(a){
    a.chart=this;
    this.valueAxes.push(a);
    this.validateData()
    },
removeValueAxesAndGraphs:function(){
    for(var a=this.valueAxes,b=a.length-1;-1<b;b--)this.removeValueAxis(a[b])
        },
removeValueAxis:function(a){
    var b=
    this.graphs,d;
    for(d=b.length-1;0<=d;d--){
        var e=b[d];
        e&&e.valueAxis==a&&this.removeGraph(e)
        }
        b=this.valueAxes;
    for(d=b.length-1;0<=d;d--)b[d]==a&&b.splice(d,1);
    this.validateData()
    },
addGraph:function(a){
    this.graphs.push(a);
    this.chooseGraphColor(a,this.graphs.length-1);
    this.validateData()
    },
removeGraph:function(a){
    for(var b=this.graphs,d=b.length-1;0<=d;d--)b[d]==a&&(b.splice(d,1),a.destroy());
    this.validateData()
    },
processValueAxes:function(){
    for(var a=this.valueAxes,b=0;b<a.length;b++){
        var d=a[b];
        d.chart=
        this;
        d.id||(d.id="valueAxis"+b+"_"+(new Date).getTime());
        if(!0===this.usePrefixes||!1===this.usePrefixes)d.usePrefixes=this.usePrefixes
            }
        },
processGraphs:function(){
    for(var a=this.graphs,b=0;b<a.length;b++){
        var d=a[b];
        d.chart=this;
        d.valueAxis||(d.valueAxis=this.valueAxes[0]);
        d.id||(d.id="graph"+b+"_"+(new Date).getTime())
        }
    },
formatString:function(a,b){
    var d=b.graph,e=d.valueAxis;
    e.duration&&b.values.value&&(e=AmCharts.formatDuration(b.values.value,e.duration,"",e.durationUnits,e.maxInterval,e.numberFormatter),
        a=a.split("[[value]]").join(e));
    a=AmCharts.massReplace(a,{
        "[[title]]":d.title,
        "[[description]]":b.description,
        "<br>":"\n"
    });
    a=AmCharts.fixNewLines(a);
    return a=AmCharts.cleanFromEmpty(a)
    },
getBalloonColor:function(a,b){
    var d=a.lineColor,e=a.balloonColor,f=a.fillColors;
    "object"==typeof f?d=f[0]:void 0!=f&&(d=f);
    if(b.isNegative){
        var f=a.negativeLineColor,g=a.negativeFillColors;
        "object"==typeof g?f=g[0]:void 0!=g&&(f=g);
        void 0!=f&&(d=f)
        }
        void 0!=b.color&&(d=b.color);
    void 0==e&&(e=d);
    return e
    },
getGraphById:function(a){
    return this.getObjById(this.graphs,
        a)
    },
getValueAxisById:function(a){
    return this.getObjById(this.valueAxes,a)
    },
getObjById:function(a,b){
    for(var d,e=0;e<a.length;e++){
        var f=a[e];
        f.id==b&&(d=f)
        }
        return d
    },
processFields:function(a,b,d){
    if(a.itemColors){
        var e=a.itemColors,f=b.index;
        b.color=f<e.length?e[f]:AmCharts.randomColor()
        }
        e="lineColor color alpha fillColors description bullet customBullet bulletSize bulletConfig url".split(" ");
    for(f=0;f<e.length;f++){
        var g=e[f],h=a[g+"Field"];
        h&&(h=d[h],AmCharts.isDefined(h)&&(b[g]=h))
        }
        b.dataContext=
    d
    },
chooseGraphColor:function(a,b){
    if(void 0==a.lineColor){
        var d;
        d=this.colors.length>b?this.colors[b]:AmCharts.randomColor();
        a.lineColor=d
        }
    },
handleLegendEvent:function(a){
    var b=a.type;
    if(a=a.dataItem){
        var d=a.hidden,e=a.showBalloon;
        switch(b){
            case "clickMarker":
                e?this.hideGraphsBalloon(a):this.showGraphsBalloon(a);
                break;
            case "clickLabel":
                e?this.hideGraphsBalloon(a):this.showGraphsBalloon(a);
                break;
            case "rollOverItem":
                d||this.highlightGraph(a);
                break;
            case "rollOutItem":
                d||this.unhighlightGraph();
                break;
            case "hideItem":
                this.hideGraph(a);
                break;
            case "showItem":
                this.showGraph(a)
                }
            }
},
highlightGraph:function(a){
    var b=this.graphs,d,e=0.2;
    this.legend&&(e=this.legend.rollOverGraphAlpha);
    if(1!=e)for(d=0;d<b.length;d++){
        var f=b[d];
        f!=a&&f.changeOpacity(e)
        }
    },
unhighlightGraph:function(){
    this.legend&&(alpha=this.legend.rollOverGraphAlpha);
    if(1!=alpha)for(var a=this.graphs,b=0;b<a.length;b++)a[b].changeOpacity(1)
        },
showGraph:function(a){
    a.hidden=!1;
    this.dataChanged=!0;
    this.marginsUpdated=!1;
    this.initChart()
    },
hideGraph:function(a){
    this.dataChanged=
    !0;
    this.marginsUpdated=!1;
    a.hidden=!0;
    this.initChart()
    },
hideGraphsBalloon:function(a){
    a.showBalloon=!1;
    this.updateLegend()
    },
showGraphsBalloon:function(a){
    a.showBalloon=!0;
    this.updateLegend()
    },
updateLegend:function(){
    this.legend&&this.legend.invalidateSize()
    },
animateAgain:function(){
    var a=this.graphs;
    if(a)for(var b=0;b<a.length;b++)a[b].animationPlayed=!1
        }
    });
AmCharts.AmRectangularChart=AmCharts.Class({
    inherits:AmCharts.AmCoordinateChart,
    construct:function(){
        AmCharts.AmRectangularChart.base.construct.call(this);
        this.createEvents("zoomed");
        this.marginRight=this.marginBottom=this.marginTop=this.marginLeft=20;
        this.verticalPosition=this.horizontalPosition=this.depth3D=this.angle=0;
        this.heightMultiplier=this.widthMultiplier=1;
        this.zoomOutText="Show all";
        this.zbSet;
        this.zoomOutButton={
            backgroundColor:"#b2e1ff",
            backgroundAlpha:1
        };
        
        this.trendLines=[];
        this.autoMargins=
        !0;
        this.marginsUpdated=!1;
        this.autoMarginOffset=10
        },
    initChart:function(){
        AmCharts.AmRectangularChart.base.initChart.call(this);
        this.updateDxy();
        var a=!0;
        !this.marginsUpdated&&this.autoMargins&&(this.resetMargins(),a=!1);
        this.updateMargins();
        this.updatePlotArea();
        this.updateScrollbars();
        this.updateTrendLines();
        this.updateChartCursor();
        this.updateValueAxes();
        a&&(this.scrollbarOnly||this.updateGraphs())
        },
    drawChart:function(){
        AmCharts.AmRectangularChart.base.drawChart.call(this);
        this.drawPlotArea();
        if(AmCharts.ifArray(this.chartData)){
            var a=
            this.chartCursor;
            a&&a.draw();
            a=this.zoomOutText;
            ""!=a&&a&&this.drawZoomOutButton()
            }
        },
resetMargins:function(){
    var a={};
    
    if("serial"==this.chartType){
        for(var b=this.valueAxes,d=0;d<b.length;d++){
            var e=b[d];
            e.ignoreAxisWidth||(e.setOrientation(this.rotate),e.fixAxisPosition(),a[e.position]=!0)
            }
            if((d=this.categoryAxis)&&!d.ignoreAxisWidth)d.setOrientation(!this.rotate),d.fixAxisPosition(),d.fixAxisPosition(),a[d.position]=!0
            }else{
        e=this.xAxes;
        b=this.yAxes;
        for(d=0;d<e.length;d++){
            var f=e[d];
            f.ignoreAxisWidth||
            (f.setOrientation(!0),f.fixAxisPosition(),a[f.position]=!0)
            }
            for(d=0;d<b.length;d++)e=b[d],e.ignoreAxisWidth||(e.setOrientation(!1),e.fixAxisPosition(),a[e.position]=!0)
            }
            a.left&&(this.marginLeft=0);
    a.right&&(this.marginRight=0);
    a.top&&(this.marginTop=0);
    a.bottom&&(this.marginBottom=0);
    this.fixMargins=a
    },
measureMargins:function(){
    var a=this.valueAxes,b,d=this.autoMarginOffset,e=this.fixMargins,f=this.realWidth,g=this.realHeight,h=d,i=d,j=f-d;
    b=g-d;
    for(var k=0;k<a.length;k++)b=this.getAxisBounds(a[k],
        h,j,i,b),h=b.l,j=b.r,i=b.t,b=b.b;
    if(a=this.categoryAxis)b=this.getAxisBounds(a,h,j,i,b),h=b.l,j=b.r,i=b.t,b=b.b;
    e.left&&h<d&&(this.marginLeft=Math.round(-h+d));
    e.right&&j>f-d&&(this.marginRight=Math.round(j-f+d));
    e.top&&i<d&&(this.marginTop=Math.round(this.marginTop-i+d+this.titleHeight));
    e.bottom&&b>g-d&&(this.marginBottom=Math.round(b-g+d));
    this.animateAgain();
    this.initChart()
    },
getAxisBounds:function(a,b,d,e,f){
    if(!a.ignoreAxisWidth){
        var g=a.labelsSet,h=a.tickLength;
        a.inside&&(h=0);
        if(g)switch(g=
            a.getBBox(),a.position){
        case "top":
            a=g.y;
            e>a&&(e=a);
            break;
            case "bottom":
            a=g.y+g.height;
            f<a&&(f=a);
            break;
            case "right":
            a=g.x+g.width+h+3;
            d<a&&(d=a);
            break;
            case "left":
            a=g.x-h,b>a&&(b=a)
            }
        }
        return{
    l:b,
    t:e,
    r:d,
    b:f
}
},
drawZoomOutButton:function(){
    var a=this,b=a.container.set();
    a.zoomButtonSet.push(b);
    var d=a.color,e=a.fontSize,f=a.zoomOutButton;
    f&&(f.fontSize&&(e=f.fontSize),f.color&&(d=f.color));
    d=AmCharts.text(a.container,a.zoomOutText,d,a.fontFamily,e,"start");
    e=d.getBBox();
    d.translate(29,6+e.height/2);
    f=AmCharts.rect(a.container,e.width+40,e.height+15,f.backgroundColor,f.backgroundAlpha);
    b.push(f);
    a.zbBG=f;
    void 0!=a.pathToImages&&(f=a.container.image(a.pathToImages+"lens.png",0,0,16,16),f.translate(7,e.height/2-1),f.toFront(),b.push(f));
    d.toFront();
    b.push(d);
    f=b.getBBox();
    b.translate(a.marginLeftReal+a.plotAreaWidth-f.width,a.marginTopReal);
    b.hide();
    b.mouseover(function(){
        a.rollOverZB()
        }).mouseout(function(){
        a.rollOutZB()
        }).click(function(){
        a.clickZB()
        }).touchstart(function(){
        a.rollOverZB()
        }).touchend(function(){
        a.rollOutZB();
        a.clickZB()
        });
    for(f=0;f<b.length;f++)b[f].attr({
        cursor:"pointer"
    });
    a.zbSet=b
    },
rollOverZB:function(){
    this.zbBG.show()
    },
rollOutZB:function(){
    this.zbBG.hide()
    },
clickZB:function(){
    this.zoomOut()
    },
zoomOut:function(){
    this.updateScrollbar=!0;
    this.zoom()
    },
drawPlotArea:function(){
    var a=this.dx,b=this.dy,d=this.marginLeftReal,e=this.marginTopReal,f=this.plotAreaWidth,g=this.plotAreaHeight,h=this.plotAreaFillColors,i=this.plotAreaFillAlphas,j=this.plotAreaBorderColor,k=this.plotAreaBorderAlpha;
    this.trendLinesSet.clipRect(d,
        e,f,g);
    "object"==typeof i&&(i=i[0]);
    h=AmCharts.polygon(this.container,[0,f,f,0],[0,0,g,g],h,i,1,j,k,this.plotAreaGradientAngle);
    h.translate(d+a,e+b);
    this.set.push(h);
    0!=a&&0!=b&&(h=this.plotAreaFillColors,"object"==typeof h&&(h=h[0]),h=AmCharts.adjustLuminosity(h,-0.15),f=AmCharts.polygon(this.container,[0,a,f+a,f,0],[0,b,b,0,0],h,i,1,j,k),f.translate(d,e+g),this.set.push(f),a=AmCharts.polygon(this.container,[0,0,a,a,0],[0,g,g+b,b,0],h,i,1,j,k),a.translate(d,e),this.set.push(a))
    },
updatePlotArea:function(){
    var a=
    this.updateWidth(),b=this.updateHeight(),d=this.container;
    this.realWidth=a;
    this.realWidth=b;
    d&&this.container.setSize(a,b);
    a=a-this.marginLeftReal-this.marginRightReal-this.dx;
    b=b-this.marginTopReal-this.marginBottomReal;
    1>a&&(a=1);
    1>b&&(b=1);
    this.plotAreaWidth=Math.round(a);
    this.plotAreaHeight=Math.round(b)
    },
updateDxy:function(){
    this.dx=this.depth3D*Math.cos(this.angle*Math.PI/180);
    this.dy=-this.depth3D*Math.sin(this.angle*Math.PI/180)
    },
updateMargins:function(){
    var a=this.getTitleHeight();
    this.titleHeight=
    a;
    this.marginTopReal=this.marginTop-this.dy+a;
    this.marginBottomReal=this.marginBottom;
    this.marginLeftReal=this.marginLeft;
    this.marginRightReal=this.marginRight
    },
updateValueAxes:function(){
    for(var a=this.valueAxes,b=this.marginLeftReal,d=this.marginTopReal,e=this.plotAreaHeight,f=this.plotAreaWidth,g=0;g<a.length;g++){
        var h=a[g];
        h.axisRenderer=AmCharts.RecAxis;
        h.guideFillRenderer=AmCharts.RecFill;
        h.axisItemRenderer=AmCharts.RecItem;
        h.dx=this.dx;
        h.dy=this.dy;
        h.viW=f-1;
        h.viH=e-1;
        h.marginsChanged=!0;
        h.viX=b;
        h.viY=d;
        this.updateObjectSize(h)
        }
    },
updateObjectSize:function(a){
    a.width=(this.plotAreaWidth-1)*this.widthMultiplier;
    a.height=(this.plotAreaHeight-1)*this.heightMultiplier;
    a.x=this.marginLeftReal+this.horizontalPosition;
    a.y=this.marginTopReal+this.verticalPosition
    },
updateGraphs:function(){
    for(var a=this.graphs,b=0;b<a.length;b++){
        var d=a[b];
        d.x=this.marginLeftReal+this.horizontalPosition;
        d.y=this.marginTopReal+this.verticalPosition;
        d.width=this.plotAreaWidth*this.widthMultiplier;
        d.height=this.plotAreaHeight*
        this.heightMultiplier;
        d.index=b;
        d.dx=this.dx;
        d.dy=this.dy;
        d.rotate=this.rotate;
        d.chartType=this.chartType
        }
    },
updateChartCursor:function(){
    var a=this.chartCursor;
    a&&(a.x=this.marginLeftReal,a.y=this.marginTopReal,a.width=this.plotAreaWidth-1,a.height=this.plotAreaHeight-1,a.chart=this)
    },
updateScrollbars:function(){},
addChartCursor:function(a){
    AmCharts.callMethod("destroy",[this.chartCursor]);
    a&&(this.listenTo(a,"changed",this.handleCursorChange),this.listenTo(a,"zoomed",this.handleCursorZoom));
    this.chartCursor=
    a
    },
removeChartCursor:function(){
    AmCharts.callMethod("destroy",[this.chartCursor]);
    this.chartCursor=null
    },
zoomTrendLines:function(){
    for(var a=this.trendLines,b=0;b<a.length;b++){
        var d=a[b];
        d.valueAxis.recalculateToPercents?d.set&&d.set.hide():(d.x=this.marginLeftReal+this.horizontalPosition,d.y=this.marginTopReal+this.verticalPosition,d.draw())
        }
    },
addTrendLine:function(a){
    this.trendLines.push(a)
    },
removeTrendLine:function(a){
    for(var b=this.trendLines,d=b.length-1;0<=d;d--)b[d]==a&&b.splice(d,1)
        },
adjustMargins:function(a,
    b){
    var d=a.scrollbarHeight;
    "top"==a.position?b?this.marginLeftReal+=d:this.marginTopReal+=d:b?this.marginRightReal+=d:this.marginBottomReal+=d
    },
getScrollbarPosition:function(a,b,d){
    a.position=b?"bottom"==d||"left"==d?"bottom":"top":"top"==d||"right"==d?"bottom":"top"
    },
updateChartScrollbar:function(a,b){
    if(a){
        a.rotate=b;
        var d=this.marginTopReal,e=this.marginLeftReal,f=a.scrollbarHeight,g=this.dx,h=this.dy;
        "top"==a.position?b?(a.y=d,a.x=e-f):(a.y=d-f+h,a.x=e+g):b?(a.y=d+h,a.x=e+this.plotAreaWidth+g):
        (a.y=d+this.plotAreaHeight+1,a.x=this.marginLeftReal)
        }
    },
showZB:function(a){
    var b=this.zbSet;
    b&&(a?b.show():b.hide(),this.zbBG.hide())
    },
handleReleaseOutside:function(a){
    AmCharts.AmRectangularChart.base.handleReleaseOutside.call(this,a);
    (a=this.chartCursor)&&a.handleReleaseOutside()
    },
handleMouseDown:function(a){
    AmCharts.AmRectangularChart.base.handleMouseDown.call(this,a);
    var b=this.chartCursor;
    b&&b.handleMouseDown(a)
    },
handleCursorChange:function(){}
});
AmCharts.TrendLine=AmCharts.Class({
    construct:function(){
        this.createEvents("click");
        this.isProtected=!1;
        this.dashLength=0;
        this.lineColor="#00CC00";
        this.lineThickness=this.lineAlpha=1
        },
    draw:function(){
        var a=this;
        a.destroy();
        var b=a.chart,d=b.container,e,f,g,h,i=a.categoryAxis,j=a.initialDate,k=a.initialCategory,l=a.finalDate,m=a.finalCategory,s=a.valueAxis,p=a.valueAxisX,q=a.initialXValue,n=a.finalXValue,r=a.initialValue,t=a.finalValue,u=s.recalculateToPercents;
        i&&(j&&(e=i.dateToCoordinate(j)),k&&(e=
            i.categoryToCoordinate(k)),l&&(f=i.dateToCoordinate(l)),m&&(f=i.categoryToCoordinate(m)));
        p&&!u&&(isNaN(q)||(e=p.getCoordinate(q)),isNaN(n)||(f=p.getCoordinate(n)));
        s&&!u&&(isNaN(r)||(g=s.getCoordinate(r)),isNaN(t)||(h=s.getCoordinate(t)));
        !isNaN(e)&&(!isNaN(f)&&!isNaN(g)&&!isNaN(g))&&(b.rotate?(i=[g,h],f=[e,f]):(i=[e,f],f=[g,h]),g=a.lineColor,e=AmCharts.line(d,i,f,g,a.lineAlpha,a.lineThickness,a.dashLength),f=AmCharts.line(d,i,f,g,0.005,5),d=d.set([e,f]),d.translate(b.marginLeftReal,b.marginTopReal),
            b.trendLinesSet.push(d),a.line=e,a.set=d,f.mouseup(function(){
                a.handleLineClick()
                }).mouseover(function(){
                a.handleLineOver()
                }).mouseout(function(){
                a.handleLineOut()
                }),f.touchend&&f.touchend(function(){
                a.handleLineClick()
                }))
        },
    handleLineClick:function(){
        var a={
            type:"click",
            trendLine:this,
            chart:this.chart
            };
            
        this.fire(a.type,a)
        },
    handleLineOver:function(){
        var a=this.rollOverColor;
        void 0!=a&&this.line.attr({
            stroke:a
        })
        },
    handleLineOut:function(){
        this.line.attr({
            stroke:this.lineColor
            })
        },
    destroy:function(){
        AmCharts.remove(this.set)
        }
    });
AmCharts.AmSerialChart=AmCharts.Class({
    inherits:AmCharts.AmRectangularChart,
    construct:function(){
        AmCharts.AmSerialChart.base.construct.call(this);
        this.createEvents("changed");
        this.columnSpacing=5;
        this.columnWidth=0.8;
        this.updateScrollbar=!0;
        var a=new AmCharts.CategoryAxis;
        a.chart=this;
        this.categoryAxis=a;
        this.chartType="serial";
        this.zoomOutOnDataUpdate=!0;
        this.skipZoom=!1;
        this.minSelectedTime=0
        },
    initChart:function(){
        AmCharts.AmSerialChart.base.initChart.call(this);
        this.updateCategoryAxis();
        this.dataChanged&&
        (this.updateData(),this.dataChanged=!1,this.dispatchDataUpdated=!0);
        var a=this.chartCursor;
        a&&a.updateData();
        for(var a=this.countColumns(),b=this.graphs,d=0;d<b.length;d++)b[d].columnCount=a;
        this.updateScrollbar=!0;
        this.drawChart();
        this.autoMargins&&!this.marginsUpdated&&(this.marginsUpdated=!0,this.measureMargins())
        },
    validateData:function(a){
        this.marginsUpdated=!1;
        this.zoomOutOnDataUpdate&&!a&&(this.endTime=this.end=this.startTime=this.start=NaN);
        AmCharts.AmSerialChart.base.validateData.call(this)
        },
    drawChart:function(){
        AmCharts.AmSerialChart.base.drawChart.call(this);
        var a=this.chartData;
        if(AmCharts.ifArray(a)){
            var b=this.chartScrollbar;
            b&&b.draw();
            if(0<this.realWidth&&0<this.realHeight){
                var b=a.length-1,d,e;
                d=this.categoryAxis;
                if(d.parseDates&&!d.equalSpacing){
                    if(d=this.startTime,e=this.endTime,isNaN(d)||isNaN(e))d=a[0].time,e=a[b].time
                        }else if(d=this.start,e=this.end,isNaN(d)||isNaN(e))d=0,e=b;
                this.endTime=this.startTime=this.end=this.start=void 0;
                this.zoom(d,e)
                }
            }else this.cleanChart();
    this.dispDUpd();
    this.chartCreated=!0
    },
cleanChart:function(){
    AmCharts.callMethod("destroy",[this.valueAxes,this.graphs,this.categoryAxis,this.chartScrollbar,this.chartCursor])
    },
updateCategoryAxis:function(){
    var a=this.categoryAxis;
    a.id="categoryAxis";
    a.rotate=this.rotate;
    a.axisRenderer=AmCharts.RecAxis;
    a.guideFillRenderer=AmCharts.RecFill;
    a.axisItemRenderer=AmCharts.RecItem;
    a.setOrientation(!this.rotate);
    a.x=this.marginLeftReal;
    a.y=this.marginTopReal;
    a.dx=this.dx;
    a.dy=this.dy;
    a.width=this.plotAreaWidth-1;
    a.height=
    this.plotAreaHeight-1;
    a.viW=this.plotAreaWidth-1;
    a.viH=this.plotAreaHeight-1;
    a.viX=this.marginLeftReal;
    a.viY=this.marginTopReal;
    a.marginsChanged=!0
    },
updateValueAxes:function(){
    AmCharts.AmSerialChart.base.updateValueAxes.call(this);
    for(var a=this.valueAxes,b=0;b<a.length;b++){
        var d=a[b],e=this.rotate;
        d.rotate=e;
        d.setOrientation(e);
        e=this.categoryAxis;
        if(!e.startOnAxis||e.parseDates)d.expandMinMax=!0
            }
        },
updateData:function(){
    this.parseData();
    for(var a=this.graphs,b=0;b<a.length;b++)a[b].data=this.chartData
        },
updateMargins:function(){
    AmCharts.AmSerialChart.base.updateMargins.call(this);
    var a=this.chartScrollbar;
    a&&(this.getScrollbarPosition(a,this.rotate,this.categoryAxis.position),this.adjustMargins(a,this.rotate))
    },
updateScrollbars:function(){
    this.updateChartScrollbar(this.chartScrollbar,this.rotate)
    },
zoom:function(a,b){
    var d=this.categoryAxis;
    d.parseDates&&!d.equalSpacing?this.timeZoom(a,b):this.indexZoom(a,b)
    },
timeZoom:function(a,b){
    var d=this.maxSelectedTime;
    isNaN(d)||(b!=this.endTime&&b-a>d&&(a=
        b-d,this.updateScrollbar=!0),a!=this.startTime&&b-a>d&&(b=a+d,this.updateScrollbar=!0));
    var e=this.minSelectedTime;
    if(0<e&&b-a<e)var f=Math.round(a+(b-a)/2),e=Math.round(e/2),a=f-e,b=f+e;
    var g=this.chartData,f=this.categoryAxis;
    if(AmCharts.ifArray(g)&&(a!=this.startTime||b!=this.endTime)){
        var h=f.minDuration();
        this.firstTime=e=g[0].time;
        var i=g[g.length-1].time;
        this.lastTime=i;
        a||(a=e,isNaN(d)||(a=i-d));
        b||(b=i);
        a>i&&(a=i);
        b<e&&(b=e);
        a<e&&(a=e);
        b>i&&(b=i);
        b<a&&(b=a+h);
        this.startTime=a;
        this.endTime=
        b;
        d=g.length-1;
        h=this.getClosestIndex(g,"time",a,!0,0,d);
        g=this.getClosestIndex(g,"time",b,!1,h,d);
        f.timeZoom(a,b);
        f.zoom(h,g);
        this.start=AmCharts.fitToBounds(h,0,d);
        this.end=AmCharts.fitToBounds(g,0,d);
        this.zoomAxesAndGraphs();
        this.zoomScrollbar();
        a!=e||b!=i?this.showZB(!0):this.showZB(!1);
        this.updateColumnsDepth();
        this.dispatchTimeZoomEvent()
        }
    },
indexZoom:function(a,b){
    var d=this.maxSelectedSeries;
    isNaN(d)||(b!=this.end&&b-a>d&&(a=b-d,this.updateScrollbar=!0),a!=this.start&&b-a>d&&(b=a+d,this.updateScrollbar=
        !0));
    if(a!=this.start||b!=this.end){
        var e=this.chartData.length-1;
        isNaN(a)&&(a=0,isNaN(d)||(a=e-d));
        isNaN(b)&&(b=e);
        b<a&&(b=a);
        b>e&&(b=e);
        a>e&&(a=e-1);
        0>a&&(a=0);
        this.start=a;
        this.end=b;
        this.categoryAxis.zoom(a,b);
        this.zoomAxesAndGraphs();
        this.zoomScrollbar();
        0!=a||b!=this.chartData.length-1?this.showZB(!0):this.showZB(!1);
        this.updateColumnsDepth();
        this.dispatchIndexZoomEvent()
        }
    },
updateGraphs:function(){
    AmCharts.AmSerialChart.base.updateGraphs.call(this);
    for(var a=this.graphs,b=0;b<a.length;b++){
        var d=
        a[b];
        d.columnWidth=this.columnWidth;
        d.categoryAxis=this.categoryAxis
        }
    },
updateColumnsDepth:function(){
    var a,b=this.graphs;
    AmCharts.remove(this.columnsSet);
    this.columnsArray=[];
    for(a=0;a<b.length;a++){
        var d=b[a],e=d.columnsArray;
        if(e)for(var f=0;f<e.length;f++)this.columnsArray.push(e[f])
            }
            this.columnsArray.sort(this.compareDepth);
    if(0<this.columnsArray.length){
        b=this.container.set();
        this.columnSet.push(b);
        for(a=0;a<this.columnsArray.length;a++)b.push(this.columnsArray[a].column.set);
        d&&b.translate(d.x,
            d.y);
        this.columnsSet=b
        }
    },
compareDepth:function(a,b){
    return a.depth>b.depth?1:-1
    },
zoomScrollbar:function(){
    var a=this.chartScrollbar,b=this.categoryAxis;
    a&&this.updateScrollbar&&(b.parseDates&&!b.equalSpacing?a.timeZoom(this.startTime,this.endTime):a.zoom(this.start,this.end),this.updateScrollbar=!0)
    },
updateTrendLines:function(){
    for(var a=this.trendLines,b=0;b<a.length;b++){
        var d=a[b];
        d.chart=this;
        d.valueAxis||(d.valueAxis=this.valueAxes[0]);
        d.categoryAxis=this.categoryAxis
        }
    },
zoomAxesAndGraphs:function(){
    if(!this.scrollbarOnly){
        for(var a=
            this.valueAxes,b=0;b<a.length;b++)a[b].zoom(this.start,this.end);
        a=this.graphs;
        for(b=0;b<a.length;b++)a[b].zoom(this.start,this.end);
        this.zoomTrendLines();
        (b=this.chartCursor)&&b.zoom(this.start,this.end,this.startTime,this.endTime)
        }
    },
countColumns:function(){
    for(var a=0,b=this.valueAxes.length,d=this.graphs.length,e,f,g=!1,h,i=0;i<b;i++){
        f=this.valueAxes[i];
        var j=f.stackType;
        if("100%"==j||"regular"==j){
            g=!1;
            for(h=0;h<d;h++)e=this.graphs[h],!e.hidden&&(e.valueAxis==f&&"column"==e.type)&&(!g&&e.stackable&&
                (a++,g=!0),e.stackable||a++,e.columnIndex=a-1)
            }
            if("none"==j||"3d"==j)for(h=0;h<d;h++)e=this.graphs[h],!e.hidden&&(e.valueAxis==f&&"column"==e.type)&&(e.columnIndex=a,a++);
        if("3d"==j){
            for(i=0;i<d;i++)e=this.graphs[i],e.depthCount=a;
            a=1
            }
        }
    return a
},
parseData:function(){
    AmCharts.AmSerialChart.base.parseData.call(this);
    this.parseSerialData()
    },
getCategoryIndexByValue:function(a){
    for(var b=this.chartData,d,e=0;e<b.length;e++)b[e].category==a&&(d=e);
    return d
    },
handleCursorChange:function(a){
    this.updateLegendValues(a.index)
    },
handleCursorZoom:function(a){
    this.updateScrollbar=!0;
    this.zoom(a.start,a.end)
    },
handleScrollbarZoom:function(a){
    this.updateScrollbar=!1;
    this.zoom(a.start,a.end)
    },
dispatchTimeZoomEvent:function(){
    if(this.prevStartTime!=this.startTime||this.prevEndTime!=this.endTime){
        var a={
            type:"zoomed"
        };
        
        a.startDate=new Date(this.startTime);
        a.endDate=new Date(this.endTime);
        a.startIndex=this.start;
        a.endIndex=this.end;
        this.startIndex=this.start;
        this.endIndex=this.end;
        this.startDate=a.startDate;
        this.endDate=a.endDate;
        this.prevStartTime=this.startTime;
        this.prevEndTime=this.endTime;
        var b=this.categoryAxis,d=AmCharts.extractPeriod(b.minPeriod).period,b=b.dateFormatsObject[d];
        a.startValue=AmCharts.formatDate(a.startDate,b);
        a.endValue=AmCharts.formatDate(a.endDate,b);
        a.chart=this;
        a.target=this;
        this.fire(a.type,a)
        }
    },
dispatchIndexZoomEvent:function(){
    if(this.prevStartIndex!=this.start||this.prevEndIndex!=this.end){
        this.startIndex=this.start;
        this.endIndex=this.end;
        var a=this.chartData;
        if(AmCharts.ifArray(a)&&!isNaN(this.start)&&
            !isNaN(this.end)){
            var b={
                chart:this,
                target:this,
                type:"zoomed"
            };
            
            b.startIndex=this.start;
            b.endIndex=this.end;
            b.startValue=a[this.start].category;
            b.endValue=a[this.end].category;
            this.categoryAxis.parseDates&&(this.startTime=a[this.start].time,this.endTime=a[this.end].time,b.startDate=new Date(this.startTime),b.endDate=new Date(this.endTime));
            this.prevStartIndex=this.start;
            this.prevEndIndex=this.end;
            this.fire(b.type,b)
            }
        }
},
updateLegendValues:function(a){
    for(var b=this.graphs,d=0;d<b.length;d++){
        var e=
        b[d];
        e.currentDataItem=isNaN(a)?void 0:this.chartData[a].axes[e.valueAxis.id].graphs[e.id]
        }
        this.legend&&this.legend.updateValues()
    },
getClosestIndex:function(a,b,d,e,f,g){
    0>f&&(f=0);
    g>a.length-1&&(g=a.length-1);
    var h=f+Math.round((g-f)/2),i=a[h][b];
    if(1>=g-f){
        if(e)return f;
        e=a[g][b];
        return Math.abs(a[f][b]-d)<Math.abs(e-d)?f:g
        }
        return d==i?h:d<i?this.getClosestIndex(a,b,d,e,f,h):this.getClosestIndex(a,b,d,e,h,g)
    },
zoomToIndexes:function(a,b){
    this.updateScrollbar=!0;
    var d=this.chartData;
    if(d){
        var e=d.length;
        0<e&&(0>a&&(a=0),b>e-1&&(b=e-1),e=this.categoryAxis,e.parseDates&&!e.equalSpacing?this.zoom(d[a].time,d[b].time):this.zoom(a,b))
        }
    },
zoomToDates:function(a,b){
    this.updateScrollbar=!0;
    var d=this.chartData;
    if(this.categoryAxis.equalSpacing){
        var e=this.getClosestIndex(d,"time",a.getTime(),!0,0,d.length),d=this.getClosestIndex(d,"time",b.getTime(),!1,0,d.length);
        this.zoom(e,d)
        }else this.zoom(a.getTime(),b.getTime())
        },
zoomToCategoryValues:function(a,b){
    this.updateScrollbar=!0;
    this.zoom(this.getCategoryIndexByValue(a),
        this.getCategoryIndexByValue(b))
    },
formatString:function(a,b){
    var d=b.graph;
    if(-1!=a.indexOf("[[category]]")){
        var e=b.serialDataItem.category;
        if(this.categoryAxis.parseDates){
            var f=this.balloonDateFormat,g=this.chartCursor;
            g&&(f=g.categoryBalloonDateFormat);
            -1!=a.indexOf("[[category]]")&&(f=AmCharts.formatDate(e,f),-1!=f.indexOf("fff")&&(f=AmCharts.formatMilliseconds(f,e)),e=f)
            }
            a=a.replace(/\[\[category\]\]/g,String(e))
        }
        d=d.numberFormatter;
    d||(d=this.numberFormatter);
    e=b.graph.valueAxis;
    if((f=e.duration)&&
        !isNaN(b.values.value))e=AmCharts.formatDuration(b.values.value,f,"",e.durationUnits,e.maxInterval,d),a=a.replace(RegExp("\\[\\[value\\]\\]","g"),e);
    e="value open low high close total".split(" ");
    f=this.percentFormatter;
    a=AmCharts.formatValue(a,b.percents,e,f,"percents.");
    a=AmCharts.formatValue(a,b.values,e,d,"",this.usePrefixes,this.prefixesOfSmallNumbers,this.prefixesOfBigNumbers);
    a=AmCharts.formatValue(a,b.values,["percents"],f);
    -1!=a.indexOf("[[")&&(a=AmCharts.formatDataContextValue(a,b.dataContext));
    return a=AmCharts.AmSerialChart.base.formatString.call(this,a,b)
    },
addChartScrollbar:function(a){
    AmCharts.callMethod("destroy",[this.chartScrollbar]);
    a&&(a.chart=this,this.listenTo(a,"zoomed",this.handleScrollbarZoom));
    this.rotate?void 0==a.width&&(a.width=a.scrollbarHeight):void 0==a.height&&(a.height=a.scrollbarHeight);
    this.chartScrollbar=a
    },
removeChartScrollbar:function(){
    AmCharts.callMethod("destroy",[this.chartScrollbar]);
    this.chartScrollbar=null
    },
handleReleaseOutside:function(a){
    AmCharts.AmSerialChart.base.handleReleaseOutside.call(this,
        a);
    AmCharts.callMethod("handleReleaseOutside",[this.chartScrollbar])
    }
});
AmCharts.AmRadarChart=AmCharts.Class({
    inherits:AmCharts.AmCoordinateChart,
    construct:function(){
        AmCharts.AmRadarChart.base.construct.call(this);
        this.marginRight=this.marginBottom=this.marginTop=this.marginLeft=0;
        this.chartType="radar";
        this.radius="35%"
        },
    initChart:function(){
        AmCharts.AmRadarChart.base.initChart.call(this);
        this.dataChanged&&(this.updateData(),this.dataChanged=!1,this.dispatchDataUpdated=!0);
        this.drawChart()
        },
    updateData:function(){
        this.parseData();
        for(var a=this.graphs,b=0;b<a.length;b++)a[b].data=
            this.chartData
            },
    updateGraphs:function(){
        for(var a=this.graphs,b=0;b<a.length;b++){
            var d=a[b];
            d.index=b;
            d.width=this.realRadius;
            d.height=this.realRadius;
            d.x=this.marginLeftReal;
            d.y=this.marginTopReal;
            d.chartType=this.chartType
            }
        },
parseData:function(){
    AmCharts.AmRadarChart.base.parseData.call(this);
    this.parseSerialData()
    },
updateValueAxes:function(){
    for(var a=this.valueAxes,b=0;b<a.length;b++){
        var d=a[b];
        d.axisRenderer=AmCharts.RadAxis;
        d.guideFillRenderer=AmCharts.RadarFill;
        d.axisItemRenderer=AmCharts.RadItem;
        d.autoGridCount=!1;
        d.x=this.marginLeftReal;
        d.y=this.marginTopReal;
        d.width=this.realRadius;
        d.height=this.realRadius
        }
    },
drawChart:function(){
    AmCharts.AmRadarChart.base.drawChart.call(this);
    var a=this.updateWidth(),b=this.updateHeight(),d=this.marginTop+this.getTitleHeight(),e=this.marginLeft,b=b-d-this.marginBottom;
    this.marginLeftReal=e+(a-e-this.marginRight)/2;
    this.marginTopReal=d+b/2;
    this.realRadius=AmCharts.toCoordinate(this.radius,a,b);
    this.updateValueAxes();
    this.updateGraphs();
    a=this.chartData;
    if(AmCharts.ifArray(a)){
        if(0<this.realWidth&&0<this.realHeight){
            a=a.length-1;
            e=this.valueAxes;
            for(d=0;d<e.length;d++)e[d].zoom(0,a);
            e=this.graphs;
            for(d=0;d<e.length;d++)e[d].zoom(0,a)
                }
            }else this.cleanChart();
    this.dispDUpd();
    this.chartCreated=!0
    },
formatString:function(a,b){
    var d=b.graph;
    -1!=a.indexOf("[[category]]")&&(a=a.replace(/\[\[category\]\]/g,String(b.serialDataItem.category)));
    d=d.numberFormatter;
    d||(d=this.numberFormatter);
    a=AmCharts.formatValue(a,b.values,["value"],d,"",this.usePrefixes,
        this.prefixesOfSmallNumbers,this.prefixesOfBigNumbers);
    return a=AmCharts.AmRadarChart.base.formatString.call(this,a,b)
    },
cleanChart:function(){
    this.callMethod("destroy",[this.valueAxes,this.graphs])
    }
});
AmCharts.AxisBase=AmCharts.Class({
    construct:function(){
        this.viY=this.viX=this.y=this.x=this.dy=this.dx=0;
        this.axisWidth;
        this.axisThickness=1;
        this.axisColor="#000000";
        this.axisAlpha=1;
        this.gridCount=this.tickLength=5;
        this.gridAlpha=0.15;
        this.gridThickness=1;
        this.gridColor="#000000";
        this.dashLength=0;
        this.labelFrequency=1;
        this.showLastLabel=this.showFirstLabel=!0;
        this.fillColor="#FFFFFF";
        this.fillAlpha=0;
        this.labelsEnabled=!0;
        this.labelRotation=0;
        this.autoGridCount=!0;
        this.valueRollOverColor="#CC0000";
        this.offset=0;
        this.guides=[];
        this.visible=!0;
        this.counter=0;
        this.guides=[];
        this.ignoreAxisWidth=this.inside=!1;
        this.titleColor;
        this.titleFontSize;
        this.titleBold=!0
        },
    zoom:function(a,b){
        this.start=a;
        this.end=b;
        this.dataChanged=!0;
        this.draw()
        },
    fixAxisPosition:function(){
        var a=this.position;
        "H"==this.orientation?("left"==a&&(a="bottom"),"right"==a&&(a="top")):("bottom"==a&&(a="left"),"top"==a&&(a="right"));
        this.position=a
        },
    draw:function(){
        var a=this.chart;
        void 0==this.titleColor&&(this.titleColor=a.color);
        isNaN(this.titleFontSize)&&(this.titleFontSize=a.fontSize+1);
        this.allLabels=[];
        this.counter=0;
        this.destroy();
        this.fixAxisPosition();
        this.labels=[];
        var b=a.container,d=b.set();
        a.gridSet.push(d);
        this.set=d;
        b=b.set();
        a.axesLabelsSet.push(b);
        this.labelsSet=b;
        this.axisLine=new this.axisRenderer(this);
        this.autoGridCount&&("V"==this.orientation?(a=this.height/35,3>a&&(a=3)):a=this.width/75,this.gridCount=a);
        this.axisWidth=this.axisLine.axisWidth;
        this.addTitle()
        },
    setOrientation:function(a){
        this.orientation=
        a?"H":"V"
        },
    addTitle:function(){
        var a=this.title;
        if(a){
            var b=this.chart;
            this.titleLabel=AmCharts.text(b.container,a,this.titleColor,b.fontFamily,this.titleFontSize,"middle",this.titleBold)
            }
        },
positionTitle:function(){
    var a=this.titleLabel;
    if(a){
        var b,d,e=this.labelsSet,f={};
        
        0<e.length()?f=e.getBBox():(f.x=0,f.y=0,f.width=this.viW,f.height=this.viH);
        e.push(a);
        var e=f.x,g=f.y;
        AmCharts.VML&&(this.rotate?e-=this.x:g-=this.y);
        var h=f.width,f=f.height,i=this.viW,j=this.viH;
        a.getBBox();
        var k=0,l=this.titleFontSize/
        2,m=this.inside;
        switch(this.position){
            case "top":
                b=i/2;
                d=g-10-l;
                break;
            case "bottom":
                b=i/2;
                d=g+f+10+l;
                break;
            case "left":
                b=e-10-l;
                m&&(b-=5);
                d=j/2;
                k=-90;
                break;
            case "right":
                b=e+h+10+l-3,m&&(b+=7),d=j/2,k=-90
                }
                this.marginsChanged?(a.translate(b,d),this.tx=b,this.ty=d):a.translate(this.tx,this.ty);
        this.marginsChanged=!1;
        0!=k&&a.rotate(k)
        }
    },
pushAxisItem:function(a){
    var b=a.graphics();
    0<b.length()&&this.set.push(b);
    (a=a.getLabel())&&this.labelsSet.push(a)
    },
addGuide:function(a){
    this.guides.push(a)
    },
removeGuide:function(a){
    for(var b=
        this.guides,d=0;d<b.length;d++)b[d]==a&&b.splice(d,1)
        },
handleGuideOver:function(a){
    clearTimeout(this.chart.hoverInt);
    var b=a.graphics.getBBox(),d=b.x+b.width/2,b=b.y+b.height/2,e=a.fillColor;
    void 0==e&&(e=a.lineColor);
    this.chart.showBalloon(a.balloonText,e,!0,d,b)
    },
handleGuideOut:function(){
    this.chart.hideBalloon()
    },
addEventListeners:function(a,b){
    var d=this;
    a.mouseover(function(){
        d.handleGuideOver(b)
        });
    a.mouseout(function(){
        d.handleGuideOut(b)
        })
    },
getBBox:function(){
    var a=this.labelsSet.getBBox();
    AmCharts.VML||(a={
        x:a.x+this.x,
        y:a.y+this.y,
        width:a.width,
        height:a.height
        });
    return a
    },
destroy:function(){
    AmCharts.remove(this.set);
    AmCharts.remove(this.labelsSet);
    var a=this.axisLine;
    a&&AmCharts.remove(a.set);
    AmCharts.remove(this.grid0)
    }
});
AmCharts.ValueAxis=AmCharts.Class({
    inherits:AmCharts.AxisBase,
    construct:function(){
        this.createEvents("axisChanged","logarithmicAxisFailed","axisSelfZoomed","axisZoomed");
        AmCharts.ValueAxis.base.construct.call(this);
        this.dataChanged=!0;
        this.gridCount=8;
        this.stackType="none";
        this.position="left";
        this.unitPosition="right";
        this.recalculateToPercents=this.includeHidden=this.includeGuidesInMinMax=this.integersOnly=!1;
        this.duration;
        this.durationUnits={
            DD:"d. ",
            hh:":",
            mm:":",
            ss:""
        };
        
        this.scrollbar=!1;
        this.maxDecCount;
        this.baseValue=0;
        this.radarCategoriesEnabled=!0;
        this.gridType="polygons";
        this.useScientificNotation=!1;
        this.axisTitleOffset=10;
        this.minMaxMultiplier=1
        },
    updateData:function(){
        0>=this.gridCount&&(this.gridCount=1);
        this.totals=[];
        this.data=this.chart.chartData;
        "xy"!=this.chart.chartType&&(this.stackGraphs("smoothedLine"),this.stackGraphs("line"),this.stackGraphs("column"),this.stackGraphs("step"));
        this.recalculateToPercents&&this.recalculate();
        this.synchronizationMultiplier&&this.synchronizeWithAxis?
        this.foundGraphs=!0:(this.foundGraphs=!1,this.getMinMax())
        },
    draw:function(){
        AmCharts.ValueAxis.base.draw.call(this);
        var a=this.chart,b=this.set;
        "duration"==this.type&&(this.duration="ss");
        !0==this.dataChanged&&(this.updateData(),this.dataChanged=!1);
        if(this.logarithmic&&(0>=this.getMin(0,this.data.length-1)||0>=this.minimum))this.fire("logarithmicAxisFailed",{
            type:"logarithmicAxisFailed",
            chart:a
        });
        else{
            this.grid0=null;
            var d,e,f=a.dx,g=a.dy,h=!1,i=this.logarithmic,j=a.chartType;
            if(!isNaN(this.min)&&
                !isNaN(this.max)&&this.foundGraphs&&Infinity!=this.min&&-Infinity!=this.max){
                var k=this.labelFrequency,l=this.showFirstLabel,m=this.showLastLabel,s=1,p=0,q=Math.round((this.max-this.min)/this.step)+1;
                if(!0==i){
                    var n=Math.log(this.max)*Math.LOG10E-Math.log(this.minReal)*Math.LOG10E;
                    this.stepWidth=this.axisWidth/n;
                    2<n&&(q=Math.ceil(Math.log(this.max)*Math.LOG10E)+1,p=Math.round(Math.log(this.minReal)*Math.LOG10E),q>this.gridCount&&(s=Math.ceil(q/this.gridCount)))
                    }else this.stepWidth=this.axisWidth/
                    (this.max-this.min);
                d=0;
                1>this.step&&-1<this.step&&(d=this.getDecimals(this.step));
                this.integersOnly&&(d=0);
                d>this.maxDecCount&&(d=this.maxDecCount);
                isNaN(this.precision)||(d=this.precision);
                this.max=AmCharts.roundTo(this.max,this.maxDecCount);
                this.min=AmCharts.roundTo(this.min,this.maxDecCount);
                var r={};
                
                r.precision=d;
                r.decimalSeparator=a.numberFormatter.decimalSeparator;
                r.thousandsSeparator=a.numberFormatter.thousandsSeparator;
                this.numberFormatter=r;
                var t=this.guides,u=t.length;
                if(0<u){
                    var w=this.fillAlpha;
                    for(e=this.fillAlpha=0;e<u;e++){
                        var y=t[e],z=NaN;
                        if(!isNaN(y.toValue)){
                            var z=this.getCoordinate(y.toValue),v=new this.axisItemRenderer(this,z,"",!0,NaN,NaN,y);
                            this.pushAxisItem(v)
                            }
                            var x=NaN;
                        isNaN(y.value)||(x=this.getCoordinate(y.value),v=new this.axisItemRenderer(this,x,y.label,!0,NaN,(z-x)/2,y),this.pushAxisItem(v));
                        isNaN(z-x)||(v=new this.guideFillRenderer(this,x,z,y),this.pushAxisItem(v),v=v.graphics(),y.graphics=v,y.balloonText&&this.addEventListeners(v,y))
                        }
                        this.fillAlpha=w
                    }
                    t=!1;
                for(e=p;e<q;e+=
                    s)v=AmCharts.roundTo(this.step*e+this.min,d),-1!=String(v).indexOf("e")&&(t=!0,String(v).split("e"));
                this.duration&&(this.maxInterval=AmCharts.getMaxInterval(this.max,this.duration));
                for(e=p;e<q;e+=s)if(p=this.step*e+this.min,p=AmCharts.roundTo(p,this.maxDecCount+1),!(this.integersOnly&&Math.round(p)!=p)){
                    !0==i&&(0==p&&(p=this.minReal),2<n&&(p=Math.pow(10,e)),t=-1!=String(p).indexOf("e")?!0:!1);
                    this.useScientificNotation&&(t=!0);
                    this.usePrefixes&&(t=!1);
                    t?(v=-1==String(p).indexOf("e")?p.toExponential(15):
                        String(p),v=v.split("e"),d=Number(v[0]),v=Number(v[1]),d=AmCharts.roundTo(d,14),10==d&&(d=1,v+=1),v=d+"e"+v,0==p&&(v="0"),1==p&&(v="1")):(i&&(d=String(p).split("."),r.precision=d[1]?d[1].length:-1),v=this.usePrefixes?AmCharts.addPrefix(p,a.prefixesOfBigNumbers,a.prefixesOfSmallNumbers,r):AmCharts.formatNumber(p,r,r.precision));
                    this.duration&&(v=AmCharts.formatDuration(p,this.duration,"",this.durationUnits,this.maxInterval,r));
                    this.recalculateToPercents?v+="%":(d=this.unit)&&(v="left"==this.unitPosition?
                        d+v:v+d);
                    Math.round(e/k)!=e/k&&(v=void 0);
                    if(0==e&&!l||e==q-1&&!m)v=" ";
                    d=this.getCoordinate(p);
                    v=new this.axisItemRenderer(this,d,v);
                    this.pushAxisItem(v);
                    if(p==this.baseValue&&"radar"!=j){
                        var A,F,u=this.viW,w=this.viH,p=this.viX,v=this.viY;
                        "H"==this.orientation?0<=d&&d<=u+1&&(A=[d,d,d+f],F=[w,0,g]):0<=d&&d<=w+1&&(A=[0,u,u+f],F=[d,d,d+g]);
                        A&&(d=AmCharts.fitToBounds(2*this.gridAlpha,0,1),d=AmCharts.line(a.container,A,F,this.gridColor,d,1,this.dashLength),d.translate(p,v),this.grid0=d,a.axesSet.push(d),
                            d.toBack())
                        }
                    }
                e=this.baseValue;
            this.min>this.baseValue&&this.max>this.baseValue&&(e=this.min);
            this.min<this.baseValue&&this.max<this.baseValue&&(e=this.max);
            i&&e<this.minReal&&(e=this.minReal);
            this.baseCoord=this.getCoordinate(e);
            a={
                type:"axisChanged",
                target:this,
                chart:a
            };
            
            a.min=i?this.minReal:this.min;
            a.max=this.max;
            this.fire("axisChanged",a);
            this.axisCreated=!0
            }else h=!0;
        i=this.axisLine.set;
        a=this.labelsSet;
        this.positionTitle();
        "radar"!=j?(j=this.viX,e=this.viY,b.translate(j,e),a.translate(j,e)):
        i.toFront();
        !this.visible||h?(b.hide(),i.hide(),a.hide()):(b.show(),i.show(),a.show())
        }
    },
getDecimals:function(a){
    var b=0;
    isNaN(a)||(a=String(a),-1!=a.indexOf("e-")?b=Number(a.split("-")[1]):-1!=a.indexOf(".")&&(b=a.split(".")[1].length));
    return b
    },
stackGraphs:function(a){
    var b=this.stackType;
    "stacked"==b&&(b="regular");
    "line"==b&&(b="none");
    "100% stacked"==b&&(b="100%");
    this.stackType=b;
    var d=[],e=[],f=[],g=[],h,i=this.chart.graphs,j,k,l,m,s=this.baseValue;
    if("line"==a||"step"==a||"smoothedLine"==
        a)linetype=!0;
    for(m=this.start;m<=this.end;m++){
        var p=0;
        for(l=0;l<i.length;l++)if(k=i[l],!k.hidden&&(j=k.type,k.chart==this.chart&&(k.valueAxis==this&&a==j&&k.stackable)&&(j=this.data[m].axes[this.id].graphs[k.id],h=j.values.value,!isNaN(h)))){
            var q=this.getDecimals(h);
            p<q&&(p=q);
            g[m]=isNaN(g[m])?Math.abs(h):g[m]+Math.abs(h);
            g[m]=AmCharts.roundTo(g[m],p);
            k=k.fillToGraph;
            linetype&&k&&(j.values.open=this.data[m].axes[this.id].graphs[k.id].values.value);
            "regular"==b&&(linetype&&(isNaN(d[m])?(d[m]=h,
                j.values.close=h,j.values.open=this.baseValue):(j.values.close=isNaN(h)?d[m]:h+d[m],j.values.open=d[m],d[m]=j.values.close)),"column"==a&&!isNaN(h)&&(j.values.close=h,0>h?(j.values.close=h,isNaN(e[m])?j.values.open=s:(j.values.close+=e[m],j.values.open=e[m]),e[m]=j.values.close):(j.values.close=h,isNaN(f[m])?j.values.open=s:(j.values.close+=f[m],j.values.open=f[m]),f[m]=j.values.close)))
            }
        }
        for(m=this.start;m<=this.end;m++)for(l=0;l<i.length;l++)k=i[l],k.hidden||(j=k.type,k.chart==this.chart&&(k.valueAxis==
    this&&a==j&&k.stackable)&&(j=this.data[m].axes[this.id].graphs[k.id],h=j.values.value,isNaN(h)||(d=100*(h/g[m]),j.values.percents=d,j.values.total=g[m],"100%"==b&&(isNaN(e[m])&&(e[m]=0),isNaN(f[m])&&(f[m]=0),0>d?(j.values.close=AmCharts.fitToBounds(d+e[m],-100,100),j.values.open=e[m],e[m]=j.values.close):(j.values.close=AmCharts.fitToBounds(d+f[m],-100,100),j.values.open=f[m],f[m]=j.values.close)))))
    },
recalculate:function(){
    for(var a=this.chart.graphs,b=0;b<a.length;b++){
        var d=a[b];
        if(d.valueAxis==
            this){
            var e="value";
            if("candlestick"==d.type||"ohlc"==d.type)e="open";
            var f,g,h=this.end+2,h=AmCharts.fitToBounds(this.end+1,0,this.data.length-1),i=this.start;
            0<i&&i--;
            for(var j=this.start;j<=h&&!(g=this.data[j].axes[this.id].graphs[d.id],f=g.values[e],!isNaN(f));j++);
            for(e=i;e<=h;e++){
                g=this.data[e].axes[this.id].graphs[d.id];
                g.percents={};
                
                var i=g.values,k;
                for(k in i)g.percents[k]="percents"!=k?100*(i[k]/f)-100:i[k]
                    }
                }
        }
},
getMinMax:function(){
    for(var a=!1,b=this.chart,d=b.graphs,e=0;e<d.length;e++){
        var f=
        d[e].type;
        if("line"==f||"step"==f||"smoothedLine"==f)this.expandMinMax&&(a=!0)
            }
            a&&(0<this.start&&this.start--,this.end<this.data.length-1&&this.end++);
    "serial"==b.chartType&&!0==b.categoryAxis.parseDates&&!a&&this.end<this.data.length-1&&this.end++;
    a=this.minMaxMultiplier;
    this.min=this.getMin(this.start,this.end);
    this.max=this.getMax();
    a=(this.max-this.min)*(a-1);
    this.min-=a;
    this.max+=a;
    a=this.guides.length;
    if(this.includeGuidesInMinMax&&0<a)for(b=0;b<a;b++)d=this.guides[b],d.toValue<this.min&&(this.min=
        d.toValue),d.value<this.min&&(this.min=d.value),d.toValue>this.max&&(this.max=d.toValue),d.value>this.max&&(this.max=d.value);
    isNaN(this.minimum)||(this.min=this.minimum);
    isNaN(this.maximum)||(this.max=this.maximum);
    this.min>this.max&&(a=this.max,this.max=this.min,this.min=a);
    isNaN(this.minTemp)||(this.min=this.minTemp);
    isNaN(this.maxTemp)||(this.max=this.maxTemp);
    this.minReal=this.min;
    this.maxReal=this.max;
    0==this.min&&0==this.max&&(this.max=9);
    this.min>this.max&&(this.min=this.max-1);
    a=this.min;
    b=this.max;
    d=this.max-this.min;
    e=0==d?Math.pow(10,Math.floor(Math.log(Math.abs(this.max))*Math.LOG10E))/10:Math.pow(10,Math.floor(Math.log(Math.abs(d))*Math.LOG10E))/10;
    isNaN(this.maximum)&&isNaN(this.maxTemp)&&(this.max=Math.ceil(this.max/e)*e+e);
    isNaN(this.minimum)&&isNaN(this.minTemp)&&(this.min=Math.floor(this.min/e)*e-e);
    0>this.min&&0<=a&&(this.min=0);
    0<this.max&&0>=b&&(this.max=0);
    "100%"==this.stackType&&(this.min=0>this.min?-100:0,this.max=0>this.max?0:100);
    d=this.max-this.min;
    e=Math.pow(10,
        Math.floor(Math.log(Math.abs(d))*Math.LOG10E))/10;
    this.step=Math.ceil(d/this.gridCount/e)*e;
    d=Math.pow(10,Math.floor(Math.log(Math.abs(this.step))*Math.LOG10E));
    d=d.toExponential(0).split("e");
    e=Number(d[1]);
    9==Number(d[0])&&e++;
    d=this.generateNumber(1,e);
    e=Math.ceil(this.step/d);
    5<e&&(e=10);
    5>=e&&2<e&&(e=5);
    this.step=Math.ceil(this.step/(d*e))*d*e;
    1>d?(this.maxDecCount=Math.abs(Math.log(Math.abs(d))*Math.LOG10E),this.maxDecCount=Math.round(this.maxDecCount),this.step=AmCharts.roundTo(this.step,this.maxDecCount+
        1)):this.maxDecCount=0;
    this.min=this.step*Math.floor(this.min/this.step);
    this.max=this.step*Math.ceil(this.max/this.step);
    0>this.min&&0<=a&&(this.min=0);
    0<this.max&&0>=b&&(this.max=0);
    1<this.minReal&&1<this.max-this.minReal&&(this.minReal=Math.floor(this.minReal));
    d=Math.pow(10,Math.floor(Math.log(Math.abs(this.minReal))*Math.LOG10E));
    0==this.min&&(this.minReal=d);
    0==this.min&&1<this.minReal&&(this.minReal=1);
    0<this.min&&0<this.minReal-this.step&&(this.minReal=this.min+this.step<this.minReal?this.min+
        this.step:this.min);
    d=Math.log(b)*Math.LOG10E-Math.log(a)*Math.LOG10E;
    this.logarithmic&&(2<d?(this.minReal=this.min=Math.pow(10,Math.floor(Math.log(Math.abs(a))*Math.LOG10E)),this.max=Math.pow(10,Math.ceil(Math.log(Math.abs(b))*Math.LOG10E))):(b=Math.pow(10,Math.floor(Math.log(Math.abs(this.min))*Math.LOG10E))/10,a=Math.pow(10,Math.floor(Math.log(Math.abs(a))*Math.LOG10E))/10,b<a&&(this.minReal=this.min=10*a)))
    },
generateNumber:function(a,b){
    var d="",e;
    e=0>b?Math.abs(b)-1:Math.abs(b);
    for(var f=0;f<
        e;f++)d+="0";
    return 0>b?Number("0."+d+String(a)):Number(String(a)+d)
    },
getMin:function(a,b){
    for(var d,e=a;e<=b;e++){
        var f=this.data[e].axes[this.id].graphs,g;
        for(g in f){
            var h=this.chart.getGraphById(g);
            if(h.includeInMinMax&&(!h.hidden||this.includeHidden)){
                isNaN(d)&&(d=Infinity);
                this.foundGraphs=!0;
                h=f[g].values;
                this.recalculateToPercents&&(h=f[g].percents);
                var i;
                if(this.minMaxField)i=h[this.minMaxField],i<d&&(d=i);else for(var j in h)"percents"!=j&&"total"!=j&&(i=h[j],i<d&&(d=i))
                    }
                }
        }
        return d
},
getMax:function(){
    for(var a,
        b=this.start;b<=this.end;b++){
        var d=this.data[b].axes[this.id].graphs,e;
        for(e in d){
            var f=this.chart.getGraphById(e);
            if(f.includeInMinMax&&(!f.hidden||this.includeHidden)){
                isNaN(a)&&(a=-Infinity);
                this.foundGraphs=!0;
                f=d[e].values;
                this.recalculateToPercents&&(f=d[e].percents);
                var g;
                if(this.minMaxField)g=f[this.minMaxField],g>a&&(a=g);else for(var h in f)"percents"!=h&&"total"!=h&&(g=f[h],g>a&&(a=g))
                    }
                }
        }
        return a
},
dispatchZoomEvent:function(a,b){
    var d={
        type:"axisZoomed",
        startValue:a,
        endValue:b,
        target:this,
        chart:this.chart
        };
        
    this.fire(d.type,d)
    },
zoomToValues:function(a,b){
    if(b<a)var d=b,b=a,a=d;
    a<this.min&&(a=this.min);
    b>this.max&&(b=this.max);
    d={
        type:"axisSelfZoomed"
    };
    
    d.chart=this.chart;
    d.valueAxis=this;
    d.multiplier=this.axisWidth/Math.abs(this.getCoordinate(b)-this.getCoordinate(a));
    d.position="V"==this.orientation?this.reversed?this.getCoordinate(a)-this.y:this.getCoordinate(b)-this.y:this.reversed?this.getCoordinate(b)-this.x:this.getCoordinate(a)-this.x;
    this.fire(d.type,d)
    },
coordinateToValue:function(a){
    if(isNaN(a))return NaN;
    var b=this.axisWidth,d=this.stepWidth,e=this.reversed,f=this.rotate,g=this.min,h=this.minReal;
    return!0==this.logarithmic?Math.pow(10,(f?!0==e?(b-a)/d:a/d:!0==e?a/d:(b-a)/d)+Math.log(h)*Math.LOG10E):!0==e?f?g-(a-b)/d:a/d+g:f?a/d+g:g-(a-b)/d
    },
getCoordinate:function(a){
    if(isNaN(a))return NaN;
    var b=this.rotate,d=this.reversed,e=this.axisWidth,f=this.stepWidth,g=this.min,h=this.minReal;
    !0==this.logarithmic?(a=Math.log(a)*Math.LOG10E-Math.log(h)*Math.LOG10E,b=b?!0==d?e-f*a:f*a:!0==d?f*a:e-f*a):b=!0==d?
    b?e-f*(a-g):f*(a-g):b?f*(a-g):e-f*(a-g);
    b=this.rotate?b+(this.x-this.viX):b+(this.y-this.viY);
    return Math.round(b)
    },
synchronizeWithAxis:function(a){
    this.synchronizeWithAxis=a;
    this.removeListener(this.synchronizeWithAxis,"axisChanged",this.handleSynchronization);
    this.listenTo(this.synchronizeWithAxis,"axisChanged",this.handleSynchronization)
    },
handleSynchronization:function(){
    var a=this.synchronizeWithAxis,b=a.min,d=a.max,a=a.step,e=this.synchronizationMultiplier;
    e&&(this.min=b*e,this.max=d*e,this.step=
        a*e,b=Math.pow(10,Math.floor(Math.log(Math.abs(this.step))*Math.LOG10E)),b=Math.abs(Math.log(Math.abs(b))*Math.LOG10E),this.maxDecCount=b=Math.round(b),this.draw())
    }
});
AmCharts.CategoryAxis=AmCharts.Class({
    inherits:AmCharts.AxisBase,
    construct:function(){
        AmCharts.CategoryAxis.base.construct.call(this);
        this.minPeriod="DD";
        this.equalSpacing=this.parseDates=!1;
        this.position="bottom";
        this.startOnAxis=!1;
        this.firstDayOfWeek=1;
        this.gridPosition="middle";
        this.boldPeriodBeginning=!0;
        this.periods=[{
            period:"ss",
            count:1
        },{
            period:"ss",
            count:5
        },{
            period:"ss",
            count:10
        },{
            period:"ss",
            count:30
        },{
            period:"mm",
            count:1
        },{
            period:"mm",
            count:5
        },{
            period:"mm",
            count:10
        },{
            period:"mm",
            count:30
        },

        {
            period:"hh",
            count:1
        },{
            period:"hh",
            count:3
        },{
            period:"hh",
            count:6
        },{
            period:"hh",
            count:12
        },{
            period:"DD",
            count:1
        },{
            period:"DD",
            count:2
        },{
            period:"WW",
            count:1
        },{
            period:"MM",
            count:1
        },{
            period:"MM",
            count:2
        },{
            period:"MM",
            count:3
        },{
            period:"MM",
            count:6
        },{
            period:"YYYY",
            count:1
        },{
            period:"YYYY",
            count:2
        },{
            period:"YYYY",
            count:5
        },{
            period:"YYYY",
            count:10
        },{
            period:"YYYY",
            count:50
        },{
            period:"YYYY",
            count:100
        }];
        this.dateFormats=[{
            period:"fff",
            format:"JJ:NN:SS"
        },{
            period:"ss",
            format:"JJ:NN:SS"
        },{
            period:"mm",
            format:"JJ:NN"
        },

        {
            period:"hh",
            format:"JJ:NN"
        },{
            period:"DD",
            format:"MMM DD"
        },{
            period:"WW",
            format:"MMM DD"
        },{
            period:"MM",
            format:"MMM"
        },{
            period:"YYYY",
            format:"YYYY"
        }];
        this.nextPeriod={};
        
        this.nextPeriod.fff="ss";
        this.nextPeriod.ss="mm";
        this.nextPeriod.mm="hh";
        this.nextPeriod.hh="DD";
        this.nextPeriod.DD="MM";
        this.nextPeriod.MM="YYYY"
        },
    draw:function(){
        AmCharts.CategoryAxis.base.draw.call(this);
        this.generateDFObject();
        var a=this.chart.chartData;
        this.data=a;
        if(AmCharts.ifArray(a)){
            var b=this.chart,d=this.start,e=this.labelFrequency,
            f=0,g=this.end-d+1,h=this.gridCount,i=this.showFirstLabel,j=this.showLastLabel,k,l="",l=AmCharts.extractPeriod(this.minPeriod);
            k=AmCharts.getPeriodDuration(l.period,l.count);
            var m,s,p,q,n;
            m=this.rotate;
            var r=this.firstDayOfWeek,t=this.boldPeriodBeginning,a=AmCharts.resetDateToMin(new Date(a[a.length-1].time+1.05*k),this.minPeriod,1,r).getTime();
            this.endTime>a&&(this.endTime=a);
            if(this.parseDates&&!this.equalSpacing){
                if(this.timeDifference=this.endTime-this.startTime,d=this.choosePeriod(0),e=d.period,
                    m=d.count,s=AmCharts.getPeriodDuration(e,m),s<k&&(e=l.period,m=l.count,s=k),a=e,"WW"==a&&(a="DD"),this.stepWidth=this.getStepWidth(this.timeDifference),h=Math.ceil(this.timeDifference/s)+1,l=AmCharts.resetDateToMin(new Date(this.startTime-s),e,m,r).getTime(),a==e&&1==m&&(p=s*this.stepWidth),this.cellWidth=k*this.stepWidth,g=Math.round(l/s),d=-1,g/2==Math.round(g/2)&&(d=-2,l-=s),0<this.gridCount)for(g=d;g<=h;g++){
                    q=l+1.5*s;
                    q=AmCharts.resetDateToMin(new Date(q),e,m,r).getTime();
                    k=(q-this.startTime)*
                    this.stepWidth;
                    n=!1;
                    this.nextPeriod[a]&&(n=this.checkPeriodChange(this.nextPeriod[a],1,q,l));
                    var u=!1;
                    n?(l=this.dateFormatsObject[this.nextPeriod[a]],u=!0):l=this.dateFormatsObject[a];
                    t||(u=!1);
                    l=AmCharts.formatDate(new Date(q),l);
                    if(g==d&&!i||g==h&&!j)l=" ";
                    k=new this.axisItemRenderer(this,k,l,!1,p,0,!1,u);
                    this.pushAxisItem(k);
                    l=q
                    }
                }else if(this.parseDates){
            if(this.parseDates&&this.equalSpacing){
                f=this.start;
                this.startTime=this.data[this.start].time;
                this.endTime=this.data[this.end].time;
                this.timeDifference=
                this.endTime-this.startTime;
                d=this.choosePeriod(0);
                e=d.period;
                m=d.count;
                s=AmCharts.getPeriodDuration(e,m);
                s<k&&(e=l.period,m=l.count,s=k);
                a=e;
                "WW"==a&&(a="DD");
                this.stepWidth=this.getStepWidth(g);
                h=Math.ceil(this.timeDifference/s)+1;
                l=AmCharts.resetDateToMin(new Date(this.startTime-s),e,m,r).getTime();
                this.cellWidth=this.getStepWidth(g);
                g=Math.round(l/s);
                d=-1;
                g/2==Math.round(g/2)&&(d=-2,l-=s);
                g=this.start;
                g/2==Math.round(g/2)&&g--;
                0>g&&(g=0);
                p=this.end+2;
                p>=this.data.length&&(p=this.data.length);
                r=!1;
                for(this.end-this.start>this.gridCount&&(r=!0);g<p;g++)if(q=this.data[g].time,this.checkPeriodChange(e,m,q,l)){
                    k=this.getCoordinate(g-this.start);
                    n=!1;
                    this.nextPeriod[a]&&(n=this.checkPeriodChange(this.nextPeriod[a],1,q,l));
                    u=!1;
                    n?(l=this.dateFormatsObject[this.nextPeriod[a]],u=!0):l=this.dateFormatsObject[a];
                    l=AmCharts.formatDate(new Date(q),l);
                    if(g==d&&!i||g==h&&!j)l=" ";
                    r?r=!1:(t||(u=!1),k=new this.axisItemRenderer(this,k,l,void 0,void 0,void 0,void 0,u),k.graphics(),this.pushAxisItem(k));
                    l=q
                    }
                }
            }else if(this.cellWidth=this.getStepWidth(g),g<h&&(h=g),f+=this.start,this.stepWidth=this.getStepWidth(g),0<h){
    t=Math.floor(g/h);
    g=f;
    g/2==Math.round(g/2)&&g--;
    0>g&&(g=0);
    for(h=0;g<=this.end+2;g+=t){
        l=0<=g&&g<this.data.length?this.data[g].category:"";
        k=this.getCoordinate(g-f);
        p=0;
        "start"==this.gridPosition&&(k-=this.cellWidth/2,p=this.cellWidth/2);
        if(g==d&&!i||g==this.end&&!j)l=void 0;
        Math.round(h/e)!=h/e&&(l=void 0);
        h++;
        r=this.cellWidth;
        m&&(r=NaN);
        k=new this.axisItemRenderer(this,k,l,!0,r,p,
            void 0,!1,p);
        this.pushAxisItem(k)
        }
    }
    for(g=0;g<this.data.length;g++)if(i=this.data[g])j=this.parseDates&&!this.equalSpacing?Math.round((i.time-this.startTime)*this.stepWidth+this.cellWidth/2):this.getCoordinate(g-f),i.x[this.id]=j
    }
    i=this.guides.length;
for(g=0;g<i;g++)j=this.guides[g],h=t=d=NaN,j.toCategory&&(h=b.getCategoryIndexByValue(j.toCategory),isNaN(h)||(d=this.getCoordinate(h-f),k=new this.axisItemRenderer(this,d,"",!0,NaN,NaN,j),this.pushAxisItem(k))),j.category&&(h=b.getCategoryIndexByValue(j.category),
    isNaN(h)||(t=this.getCoordinate(h-f),h=(d-t)/2,k=new this.axisItemRenderer(this,t,j.label,!0,NaN,h,j),this.pushAxisItem(k))),j.toDate&&(this.equalSpacing?(h=b.getClosestIndex(this.data,"time",j.toDate.getTime(),!1,0,this.data.length-1),isNaN(h)||(d=this.getCoordinate(h-f))):d=(j.toDate.getTime()-this.startTime)*this.stepWidth,k=new this.axisItemRenderer(this,d,"",!0,NaN,NaN,j),this.pushAxisItem(k)),j.date&&(this.equalSpacing?(h=b.getClosestIndex(this.data,"time",j.date.getTime(),!1,0,this.data.length-
    1),isNaN(h)||(t=this.getCoordinate(h-f))):t=(j.date.getTime()-this.startTime)*this.stepWidth,h=(d-t)/2,k="H"==this.orientation?new this.axisItemRenderer(this,t,j.label,!1,2*h,NaN,j):new this.axisItemRenderer(this,t,j.label,!1,NaN,h,j),this.pushAxisItem(k)),d=new this.guideFillRenderer(this,t,d,j),t=d.graphics(),this.pushAxisItem(d),j.graphics=t,t.index=g,j.balloonText&&this.addEventListeners(t,j);
this.axisCreated=!0;
b=this.x;
f=this.y;
this.set.translate(b,f);
this.labelsSet.translate(b,f);
this.positionTitle();
(b=this.axisLine.set)&&b.toFront()
},
choosePeriod:function(a){
    var b=AmCharts.getPeriodDuration(this.periods[a].period,this.periods[a].count),b=Math.ceil(this.timeDifference/b),d=this.periods;
    return b<=this.gridCount?d[a]:a+1<d.length?this.choosePeriod(a+1):d[a]
    },
getStepWidth:function(a){
    var b;
    this.startOnAxis?(b=this.axisWidth/(a-1),1==a&&(b=this.axisWidth)):b=this.axisWidth/a;
    return b
    },
getCoordinate:function(a){
    a*=this.stepWidth;
    this.startOnAxis||(a+=this.stepWidth/2);
    return Math.round(a)
    },
timeZoom:function(a,
    b){
    this.startTime=a;
    this.endTime=b+this.minDuration()
    },
minDuration:function(){
    var a=AmCharts.extractPeriod(this.minPeriod);
    return AmCharts.getPeriodDuration(a.period,a.count)
    },
checkPeriodChange:function(a,b,d,e){
    var e=new Date(e),f=this.firstDayOfWeek,d=AmCharts.resetDateToMin(new Date(d),a,b,f).getTime(),a=AmCharts.resetDateToMin(e,a,b,f).getTime();
    return d!=a?!0:!1
    },
generateDFObject:function(){
    this.dateFormatsObject={};
    
    for(var a=0;a<this.dateFormats.length;a++){
        var b=this.dateFormats[a];
        this.dateFormatsObject[b.period]=
        b.format
        }
    },
xToIndex:function(a){
    var b=this.data,d=this.chart,e=d.rotate,f=this.stepWidth;
    this.parseDates&&!this.equalSpacing?(a=this.startTime+Math.round(a/f)-this.minDuration()/2,d=d.getClosestIndex(b,"time",a,!1,this.start,this.end+1)):(this.startOnAxis||(a-=f/2),d=this.start+Math.round(a/f));
    var d=AmCharts.fitToBounds(d,0,b.length-1),g;
    b[d]&&(g=b[d].x[this.id]);
    e?g>this.height+1&&d--:g>this.width+1&&d--;
    0>g&&d++;
    return d=AmCharts.fitToBounds(d,0,b.length-1)
    },
dateToCoordinate:function(a){
    return this.parseDates&&
    !this.equalSpacing?(a.getTime()-this.startTime)*this.stepWidth:this.parseDates&&this.equalSpacing?(a=this.chart.getClosestIndex(this.data,"time",a.getTime(),!1,0,this.data.length-1),this.getCoordinate(a-this.start)):NaN
    },
categoryToCoordinate:function(a){
    return this.chart?(a=this.chart.getCategoryIndexByValue(a),this.getCoordinate(a-this.start)):NaN
    },
coordinateToDate:function(a){
    return this.equalSpacing?(a=this.xToIndex(a),new Date(this.data[a].time)):new Date(this.startTime+a/this.stepWidth)
    }
});
AmCharts.RecAxis=AmCharts.Class({
    construct:function(a){
        var b=a.chart,d=a.axisThickness,e=a.axisColor,f=a.axisAlpha,g=a.offset,h=a.dx,i=a.dy,j=a.viX,k=a.viY,l=a.viH,m=a.viW,s=b.container;
        "H"==a.orientation?(e=AmCharts.line(s,[0,m],[0,0],e,f,d),this.axisWidth=a.width,"bottom"==a.position?(a=d/2+g+l+k-1,d=j):(a=-d/2-g+k+i,d=h+j)):(this.axisWidth=a.height,"right"==a.position?(e=AmCharts.line(s,[0,0,-h],[0,l,l-i],e,f,d),a=k+i,d=d/2+g+h+m+j-1):(e=AmCharts.line(s,[0,0],[0,l],e,f,d),a=k,d=-d/2-g+j));
        e.translate(d,
            a);
        b.axesSet.push(e);
        this.set=e
        }
    });
AmCharts.RecItem=AmCharts.Class({
    construct:function(a,b,d,e,f,g,h,i,j){
        b=Math.round(b);
        void 0==d&&(d="");
        j||(j=0);
        void 0==e&&(e=!0);
        var k=a.chart.fontFamily,l=a.fontSize;
        void 0==l&&(l=a.chart.fontSize);
        var m=a.color;
        void 0==m&&(m=a.chart.color);
        var s=a.chart.container,p=s.set();
        this.set=p;
        var q=a.axisThickness,n=a.axisColor,r=a.axisAlpha,t=a.tickLength,u=a.gridAlpha,w=a.gridThickness,y=a.gridColor,z=a.dashLength,v=a.fillColor,x=a.fillAlpha,A=a.labelsEnabled,F=a.labelRotation,Y=a.counter,N=a.inside,
        P=a.dx,H=a.dy,V=a.orientation,O=a.position,T=a.previousCoord,ea=a.viH,ba=a.viW,ca=a.offset,ka,U;
        h?(A=!0,isNaN(h.tickLength)||(t=h.tickLength),void 0!=h.lineColor&&(y=h.lineColor),isNaN(h.lineAlpha)||(u=h.lineAlpha),isNaN(h.dashLength)||(z=h.dashLength),isNaN(h.lineThickness)||(w=h.lineThickness),!0==h.inside&&(N=!0),isNaN(h.labelRotation)||(F=h.labelRotation)):""==d&&(t=0);
        U="start";
        f&&(U="middle");
        var Q=F*Math.PI/180,Z,G=0,E=0,B=0,fa=Z=0;
        "V"==V&&(F=0);
        if(A)var W=AmCharts.text(s,d,m,k,l,U,i),fa=W.getBBox().width;
        if("H"==V){
            if(0<=b&&b<=ba+1&&(0<t&&(0<r&&b+j<=ba+1)&&(ka=AmCharts.line(s,[b+j,b+j],[0,t],n,r,w),p.push(ka)),0<u&&(U=AmCharts.line(s,[b,b+P,b+P],[ea,ea+H,H],y,u,w,z),p.push(U))),E=0,G=b,h&&90==F&&(G-=l),!1==e?(U="start",E="bottom"==O?N?E+t:E-t:N?E-t:E+t,G+=3,f&&(G+=f/2,U="middle"),0<F&&(U="middle")):U="middle",1==Y&&(0<x&&!h&&T<ba)&&(e=AmCharts.fitToBounds(b,0,ba),T=AmCharts.fitToBounds(T,0,ba),Z=e-T,0<Z&&(fill=AmCharts.rect(s,Z,a.height,v,x),fill.translate(e-Z+P,H),p.push(fill))),"bottom"==O?(E+=
                ea+l/2+ca,N?0<F?(E=ea-fa/2*Math.sin(Q)-t-3,G+=fa/2*Math.cos(Q)):E-=t+l+3+3:0<F?(E=ea+fa/2*Math.sin(Q)+t+3,G-=fa/2*Math.cos(Q)):E+=t+q+3+3):(E+=H+l/2-ca,G+=P,N?0<F?(E=fa/2*Math.sin(Q)+t+3,G-=fa/2*Math.cos(Q)):E+=t+3:0<F?(E=-(fa/2)*Math.sin(Q)-t-6,G+=fa/2*Math.cos(Q)):E-=t+l+3+q+3),"bottom"==O?Z=(N?ea-t-1:ea+q-1)+ca:(B=P,Z=(N?H:H-t-q+1)-ca),g&&(G+=g),H=G,0<F&&(H+=fa/2*Math.cos(Q)),W&&(O=0,N&&(O=fa*Math.cos(Q)),H+O>ba+1||0>H))W.remove(),W=null
                }else{
            0<=b&&b<=ea+1&&(0<t&&(0<r&&b+j<=ea+1)&&(ka=AmCharts.line(s,
                [0,t],[b+j,b+j],n,r,w),p.push(ka)),0<u&&(U=AmCharts.line(s,[0,P,ba+P],[b,b+H,b+H],y,u,w,z),p.push(U)));
            U="end";
            if(!0==N&&"left"==O||!1==N&&"right"==O)U="start";
            E=b-l/2;
            1==Y&&(0<x&&!h)&&(e=AmCharts.fitToBounds(b,0,ea),T=AmCharts.fitToBounds(T,0,ea),Q=e-T,fill=AmCharts.polygon(s,[0,a.width,a.width,0],[0,0,Q,Q],v,x),fill.translate(P,e-Q+H),p.push(fill));
            E+=l/2;
            "right"==O?(G+=P+ba+ca,E+=H,N?(G-=t+4,g||(E-=l/2+3)):(G+=t+4+q,E-=2)):N?(G+=t+4-ca,g||(E-=l/2+3),h&&(G+=P,E+=H)):(G+=-t-q-4-2-ca,E-=2);
            ka&&("right"==
                O?(B+=P+ca+ba,Z+=H,B=N?B-q:B+q):(B-=ca,N||(B-=t+q)));
            g&&(E+=g);
            N=-3;
            "right"==O&&(N+=H);
            if(W&&(E>ea+1||E<N))W.remove(),W=null
                }
                ka&&ka.translate(B,Z);
        !1==a.visible&&(ka&&ka.remove(),W&&(W.remove(),W=null));
        W&&(W.attr({
            "text-anchor":U
        }),W.translate(G,E),0!=F&&W.rotate(-F),a.allLabels.push(W)," "!=d&&(this.label=W));
        a.counter=0==Y?1:0;
        a.previousCoord=b;
        0==this.set.node.childNodes.length&&this.set.remove()
        },
    graphics:function(){
        return this.set
        },
    getLabel:function(){
        return this.label
        }
    });
AmCharts.RecFill=AmCharts.Class({
    construct:function(a,b,d,e){
        var f=a.dx,g=a.dy,h=a.orientation,i=0;
        if(d<b)var j=b,b=d,d=j;
        var k=e.fillAlpha;
        isNaN(k)&&(k=0);
        j=a.chart.container;
        e=e.fillColor;
        "V"==h?(b=AmCharts.fitToBounds(b,0,a.viH),d=AmCharts.fitToBounds(d,0,a.viH)):(b=AmCharts.fitToBounds(b,0,a.viW),d=AmCharts.fitToBounds(d,0,a.viW));
        d-=b;
        isNaN(d)&&(d=4,i=2,k=0);
        0>d&&"object"==typeof e&&(e=e.join(",").split(",").reverse());
        "V"==h?(a=AmCharts.rect(j,a.width,d,e,k),a.translate(f,b-i+g)):(a=AmCharts.rect(j,
            d,a.height,e,k),a.translate(b-i+f,g));
        this.set=j.set([a])
        },
    graphics:function(){
        return this.set
        },
    getLabel:function(){}
});
AmCharts.RadAxis=AmCharts.Class({
    construct:function(a){
        var b=a.chart,d=a.axisThickness,e=a.axisColor,f=a.axisAlpha,g=a.x,h=a.y;
        this.set=b.container.set();
        b.axesSet.push(this.set);
        var i=a.axisTitleOffset,j=a.radarCategoriesEnabled,k=a.chart.fontFamily,l=a.fontSize;
        void 0==l&&(l=a.chart.fontSize);
        var m=a.color;
        void 0==m&&(m=a.chart.color);
        if(b){
            this.axisWidth=a.height;
            for(var a=b.chartData,s=a.length,p=0;p<s;p++){
                var q=180-360/s*p,n=g+this.axisWidth*Math.sin(q/180*Math.PI),r=h+this.axisWidth*Math.cos(q/
                    180*Math.PI),n=AmCharts.line(b.container,[g,n],[h,r],e,f,d);
                this.set.push(n);
                if(j){
                    var t="start",n=g+(this.axisWidth+i)*Math.sin(q/180*Math.PI),r=h+(this.axisWidth+i)*Math.cos(q/180*Math.PI);
                    if(180==q||0==q)t="middle",n-=5;
                    0>q&&(t="end",n-=10);
                    180==q&&(r-=5);
                    0==q&&(r+=5);
                    q=AmCharts.text(b.container,a[p].category,m,k,l,t);
                    q.translate(n+5,r);
                    this.set.push(q);
                    q.getBBox()
                    }
                }
            }
    }
});
AmCharts.RadItem=AmCharts.Class({
    construct:function(a,b,d,e,f,g,h){
        void 0==d&&(d="");
        var i=a.chart.fontFamily,j=a.fontSize;
        void 0==j&&(j=a.chart.fontSize);
        var k=a.color;
        void 0==k&&(k=a.chart.color);
        var l=a.chart.container;
        this.set=e=l.set();
        var m=a.axisColor,s=a.axisAlpha,p=a.tickLength,q=a.gridAlpha,n=a.gridThickness,r=a.gridColor,t=a.dashLength,u=a.fillColor,w=a.fillAlpha,y=a.labelsEnabled,f=a.counter,z=a.inside,v=a.gridType,b=b-a.height,x,g=a.x,A=a.y;
        h?(y=!0,isNaN(h.tickLength)||(p=h.tickLength),
            void 0!=h.lineColor&&(r=h.lineColor),isNaN(h.lineAlpha)||(q=h.lineAlpha),isNaN(h.dashLength)||(t=h.dashLength),isNaN(h.lineThickness)||(n=h.lineThickness),!0==h.inside&&(z=!0)):d||(q/=3,p/=2);
        var F="end",Y=-1;
        z&&(F="start",Y=1);
        if(y){
            var N=AmCharts.text(l,d,k,i,j,F);
            N.translate(g+(p+3)*Y,b);
            e.push(N);
            this.label=N;
            x=AmCharts.line(l,[g,g+p*Y],[b,b],m,s,n);
            e.push(x)
            }
            b=a.y-b;
        if("polygons"==v){
            for(var P=[],H=[],V=a.data.length,d=0;d<V;d++)i=180-360/V*d,P.push(b*Math.sin(i/180*Math.PI)),H.push(b*Math.cos(i/
                180*Math.PI));
            P.push(P[0]);
            H.push(H[0]);
            d=AmCharts.line(l,P,H,r,q,n,t)
            }else d=AmCharts.circle(l,b,"#FFFFFF",0,n,r,q);
        d.translate(g,A);
        e.push(d);
        if(1==f&&0<w&&!h){
            h=a.previousCoord;
            if("polygons"==v){
                for(d=V;0<=d;d--)i=180-360/V*d,P.push(h*Math.sin(i/180*Math.PI)),H.push(h*Math.cos(i/180*Math.PI));
                P=AmCharts.polygon(l,P,H,u,w)
                }else P=AmCharts.wedge(l,0,0,0,-360,b,b,h,0,{
                fill:u,
                "fill-opacity":w,
                stroke:0,
                "stroke-opacity":0,
                "stroke-width":0
            });
            e.push(P);
            P.translate(g,A)
            }!1==a.visible&&(x&&x.hide(),N&&N.hide());
        a.counter=0==f?1:0;
        a.previousCoord=b
        },
    graphics:function(){
        return this.set
        },
    getLabel:function(){
        return this.label
        }
    });
AmCharts.RadarFill=AmCharts.Class({
    construct:function(a,b,d,e){
        var f=Math.max(b,d),b=d=Math.min(b,d),d=a.chart.container,g=e.fillAlpha,h=e.fillColor,f=Math.abs(f)-a.y,b=Math.abs(b)-a.y,i=-e.angle,e=-e.toAngle;
        isNaN(i)&&(i=0);
        isNaN(e)&&(e=-360);
        this.set=d.set();
        void 0==h&&(h="#000000");
        isNaN(g)&&(g=0);
        if("polygons"==a.gridType){
            for(var e=[],j=[],k=a.data.length,l=0;l<k;l++)i=180-360/k*l,e.push(f*Math.sin(i/180*Math.PI)),j.push(f*Math.cos(i/180*Math.PI));
            e.push(e[0]);
            j.push(j[0]);
            for(l=k;0<=l;l--)i=
                180-360/k*l,e.push(b*Math.sin(i/180*Math.PI)),j.push(b*Math.cos(i/180*Math.PI));
            this.fill=AmCharts.polygon(d,e,j,h,g)
            }else this.fill=AmCharts.wedge(d,0,0,i,e-i,f,f,b,0,{
            fill:h,
            "fill-opacity":g,
            stroke:0,
            "stroke-opacity":0,
            "stroke-width":0
        });
        this.set.push(this.fill);
        this.fill.translate(a.x,a.y)
        },
    graphics:function(){
        return this.set
        },
    getLabel:function(){}
});
AmCharts.AmGraph=AmCharts.Class({
    construct:function(){
        this.createEvents("rollOverGraphItem","rollOutGraphItem","clickGraphItem","doubleClickGraphItem");
        this.type="line";
        this.stackable=!0;
        this.columnCount=1;
        this.columnIndex=0;
        this.centerCustomBullets=this.showBalloon=!0;
        this.maxBulletSize=50;
        this.minBulletSize=0;
        this.balloonText="[[value]]";
        this.hidden=this.scrollbar=this.animationPlayed=!1;
        this.columnWidth=0.8;
        this.pointPosition="middle";
        this.depthCount=1;
        this.includeInMinMax=!0;
        this.negativeBase=
        0;
        this.visibleInLegend=!0;
        this.showAllValueLabels=!1;
        this.showBalloonAt="close";
        this.lineThickness=1;
        this.dashLength=0;
        this.connect=!0;
        this.lineAlpha=1;
        this.bullet="none";
        this.bulletBorderThickness=2;
        this.bulletAlpha=this.bulletBorderAlpha=1;
        this.bulletSize=8;
        this.hideBulletsCount=this.bulletOffset=0;
        this.labelPosition="top";
        this.cornerRadiusTop=0;
        this.cursorBulletAlpha=1;
        this.gradientOrientation="vertical";
        this.dy=this.dx=0;
        this.periodValue="";
        this.y=this.x=0
        },
    draw:function(){
        var a=this.chart,b=
        a.container;
        this.container=b;
        this.destroy();
        var d=b.set(),e=b.set();
        this.behindColumns?(a.graphsBehindSet.push(d),a.bulletBehindSet.push(e)):(a.graphsSet.push(d),a.bulletSet.push(e));
        this.bulletSet=e;
        if(!this.scrollbar){
            var f=a.marginLeftReal,a=a.marginTopReal;
            d.translate(f,a);
            e.translate(f,a)
            }
            if("column"==this.type)var g=b.set();
        AmCharts.remove(this.columnsSet);
        d.push(g);
        this.set=d;
        this.columnsSet=g;
        this.columnsArray=[];
        this.ownColumns=[];
        this.allBullets=[];
        this.animationArray=[];
        AmCharts.ifArray(this.data)&&
        (b=!1,"xy"==this.chartType?this.xAxis.axisCreated&&this.yAxis.axisCreated&&(b=!0):this.valueAxis.axisCreated&&(b=!0),!this.hidden&&b&&this.createGraph())
        },
    createGraph:function(){
        var a=this.chart;
        "inside"==this.labelPosition&&(this.labelPosition="bottom");
        this.startAlpha=a.startAlpha;
        this.seqAn=a.sequencedAnimation;
        this.baseCoord=this.valueAxis.baseCoord;
        this.fillColors||(this.fillColors=this.lineColor);
        void 0==this.fillAlphas&&(this.fillAlphas=0);
        void 0==this.bulletColor&&(this.bulletColor=this.lineColor,
            this.bulletColorNegative=this.negativeLineColor);
        void 0==this.bulletAlpha&&(this.bulletAlpha=this.lineAlpha);
        this.bulletBorderColor||(this.bulletBorderAlpha=0);
        if(!isNaN(this.valueAxis.min)&&!isNaN(this.valueAxis.max)){
            switch(this.chartType){
                case "serial":
                    this.createSerialGraph();
                    break;
                case "radar":
                    this.createRadarGraph();
                    break;
                case "xy":
                    this.createXYGraph(),this.positiveClip(this.set)
                    }
                    this.animationPlayed=!0
            }
        },
createXYGraph:function(){
    var a=[],b=[],d=this.xAxis,e=this.yAxis;
    this.pmh=e.viH+1;
    this.pmw=
    d.viW+1;
    this.pmy=this.pmx=0;
    for(var f=this.start;f<=this.end;f++){
        var g=this.data[f].axes[d.id].graphs[this.id],h=g.values,i=h.x,j=h.y,h=d.getCoordinate(i),k=e.getCoordinate(j);
        if(!isNaN(i)&&!isNaN(j)&&(a.push(h),b.push(k),(i=this.createBullet(g,h,k,f))||(i=0),j=this.labelText))g=this.createLabel(g,h,k,j),this.positionLabel(h,k,g,this.labelPosition,i)
            }
            this.drawLineGraph(a,b);
    this.launchAnimation()
    },
createRadarGraph:function(){
    for(var a=this.valueAxis.stackType,b=[],d=[],e,f,g=this.start;g<=this.end;g++){
        var h=
        this.data[g].axes[this.valueAxis.id].graphs[this.id],i;
        i="none"==a||"3d"==a?h.values.value:h.values.close;
        if(isNaN(i))this.drawLineGraph(b,d),b=[],d=[];
        else{
            var j=this.y-(this.valueAxis.getCoordinate(i)-this.height),k=180-360/(this.end-this.start+1)*g;
            i=j*Math.sin(k/180*Math.PI);
            j*=Math.cos(k/180*Math.PI);
            b.push(i);
            d.push(j);
            (k=this.createBullet(h,i,j,g))||(k=0);
            var l=this.labelText;
            l&&(h=this.createLabel(h,i,j,l),this.positionLabel(i,j,h,this.labelPosition,k));
            isNaN(e)&&(e=i);
            isNaN(f)&&(f=j)
            }
        }
    b.push(e);
    d.push(f);
    this.drawLineGraph(b,d);
    this.launchAnimation()
    },
positionLabel:function(a,b,d,e,f){
    var g=d.getBBox();
    switch(e){
        case "left":
            a-=(g.width+f)/2+2;
            break;
        case "top":
            b-=(f+g.height)/2+1;
            break;
        case "right":
            a+=(g.width+f)/2+2;
            break;
        case "bottom":
            b+=(f+g.height)/2+1
            }
            d.translate(a,b)
    },
createSerialGraph:function(){
    var a=this.id,b=this.index,d=this.data,e=this.chart.container,f=this.valueAxis,g=this.type,h=this.columnWidth,i=this.width,j=this.height,k=this.y,l=this.rotate,m=this.columnCount,s=AmCharts.toCoordinate(this.cornerRadiusTop,
        h/2),p=this.connect,q=[],n=[],r,t,u=this.chart.graphs.length,w,y=this.dx/this.depthCount,z=this.dy/this.depthCount,v=f.stackType,x=this.labelPosition,A=this.start,F=this.end,Y=this.scrollbar,N=this.categoryAxis,P=this.baseCoord,H=this.negativeBase,V=this.columnIndex,O=this.lineThickness,T=this.lineAlpha,ea=this.lineColor,ba=this.dashLength,ca=this.set;
    "above"==x&&(x="top");
    "below"==x&&(x="bottom");
    var ka=x,U=270;
    "horizontal"==this.gradientOrientation&&(U=0);
    this.gradientRotation=U;
    var Q=this.chart.columnSpacing,
    Z=N.cellWidth,G=(Z*h-m)/m;
    Q>G&&(Q=G);
    var E,B,fa,W=j+1,Ua=i+1,Ma=0,Va=0,Wa,Xa,Na,Oa,Ab=this.fillColors,Da=this.negativeFillColors,xa=this.negativeLineColor,Ea=this.fillAlphas,Fa=this.negativeFillAlphas;
    "object"==typeof Ea&&(Ea=Ea[0]);
    "object"==typeof Fa&&(Fa=Fa[0]);
    var Pa=f.getCoordinate(f.min);
    f.logarithmic&&(Pa=f.getCoordinate(f.minReal));
    this.minCoord=Pa;
    this.resetBullet&&(this.bullet="none");
    if(!Y&&("line"==g||"smoothedLine"==g||"step"==g))if(1==d.length&&("step"!=g&&"none"==this.bullet)&&(this.bullet=
        "round",this.resetBullet=!0),Da||void 0!=xa){
        var ya=H;
        ya>f.max&&(ya=f.max);
        ya<f.min&&(ya=f.min);
        f.logarithmic&&(ya=f.minReal);
        var sa=f.getCoordinate(ya),mb=f.getCoordinate(f.max);
        l?(W=j,Ua=Math.abs(mb-sa),Wa=j,Xa=Math.abs(Pa-sa),Oa=Va=0,f.reversed?(Ma=0,Na=sa):(Ma=sa,Na=0)):(Ua=i,W=Math.abs(mb-sa),Xa=i,Wa=Math.abs(Pa-sa),Na=Ma=0,f.reversed?(Oa=k,Va=sa):Oa=sa+1)
        }
        var ta=Math.round;
    this.pmx=ta(Ma);
    this.pmy=ta(Va);
    this.pmh=ta(W);
    this.pmw=ta(Ua);
    this.nmx=ta(Na);
    this.nmy=ta(Oa);
    this.nmh=ta(Wa);
    this.nmw=
    ta(Xa);
    h="column"==g?(Z*h-Q*(m-1))/m:Z*h;
    1>h&&(h=1);
    var L;
    if("line"==g||"step"==g||"smoothedLine"==g){
        if(0<A)for(L=A-1;-1<L;L--)if(E=d[L],B=E.axes[f.id].graphs[a],fa=B.values.value){
            A=L;
            break
        }
        if(F<d.length-1)for(L=F+1;L<d.length;L++)if(E=d[L],B=E.axes[f.id].graphs[a],fa=B.values.value){
            F=L;
            break
        }
        }
        F<d.length-1&&F++;
var ga=[],ha=[],Ga=!1;
if("line"==g||"step"==g||"smoothedLine"==g)if(this.stackable&&"regular"==v||"100%"==v||this.fillToGraph)Ga=!0;
    for(L=A;L<=F;L++){
    E=d[L];
    B=E.axes[f.id].graphs[a];
    B.index=
    L;
    var na=NaN,D=NaN,C=NaN,R=NaN,M=NaN,Qa=NaN,za=NaN,Ra=NaN,Aa=NaN,X=NaN,$=NaN,oa=NaN,pa=NaN,S=NaN,ja=void 0,ua=Ab,Ha=Ea,la=ea;
    void 0!=B.color&&(ua=B.color);
    B.fillColors&&(ua=B.fillColors);
    isNaN(B.alpha)||(Ha=B.alpha);
    var qa=B.values;
    f.recalculateToPercents&&(qa=B.percents);
    if(qa){
        S=!this.stackable||"none"==v||"3d"==v?qa.value:qa.close;
        if("candlestick"==g||"ohlc"==g)var S=qa.close,Ya=qa.low,za=f.getCoordinate(Ya),Za=qa.high,Aa=f.getCoordinate(Za);
        var ia=qa.open,C=f.getCoordinate(S);
        isNaN(ia)||(M=f.getCoordinate(ia));
        if(!Y)switch(this.showBalloonAt){
            case "close":
                B.y=C;
                break;
            case "open":
                B.y=M;
                break;
            case "high":
                B.y=Aa;
                break;
            case "low":
                B.y=za
                }
                var na=E.x[N.id],va=Math.floor(Z/2),Ia=va;
        "start"==this.pointPosition&&(na-=Z/2,va=0,Ia=Z);
        Y||(B.x=na);
        -1E5>na&&(na=-1E5);
        na>i+1E5&&(na=i+1E5);
        l?(D=C,R=M,M=C=na,isNaN(ia)&&!this.fillToGraph&&(R=P),Qa=za,Ra=Aa):(R=D=na,isNaN(ia)&&!this.fillToGraph&&(M=P));
        switch(g){
            case "line":
                isNaN(S)?p||(this.drawLineGraph(q,n,ga,ha),q=[],n=[],ga=[],ha=[]):(B.isNegative=S<H?!0:!1,q.push(D),
                n.push(C),X=D,$=C,oa=D,pa=C,Ga&&(!isNaN(M)&&!isNaN(R))&&(ga.push(R),ha.push(M)));
            break;
            case "smoothedLine":
                isNaN(S)?p||(this.drawSmoothedGraph(q,n,ga,ha),q=[],n=[],ga=[],ha=[]):(B.isNegative=S<H?!0:!1,q.push(D),n.push(C),X=D,$=C,oa=D,pa=C,Ga&&(!isNaN(M)&&!isNaN(R))&&(ga.push(R),ha.push(M)));
                break;
            case "step":
                isNaN(S)?p||(t=NaN,this.drawLineGraph(q,n,ga,ha),q=[],n=[],ga=[],ha=[]):(B.isNegative=S<H?!0:!1,l?(isNaN(r)||(q.push(r),n.push(C-va)),n.push(C-va),q.push(D),n.push(C+Ia),q.push(D),Ga&&(!isNaN(M)&&
                !isNaN(R))&&(ga.push(R),ha.push(M-va),ga.push(R),ha.push(M+Ia))):(isNaN(t)||(n.push(t),q.push(D-va)),q.push(D-va),n.push(C),q.push(D+Ia),n.push(C),Ga&&(!isNaN(M)&&!isNaN(R))&&(ga.push(R-va),ha.push(M),ga.push(R+Ia),ha.push(M))),r=D,t=C,X=D,$=C,oa=D,pa=C);
                break;
            case "column":
                var ma=la;
                void 0!=B.lineColor&&(ma=B.lineColor);
                if(!isNaN(S)){
                S<H?(B.isNegative=!0,Da&&(ua=Da),void 0!=xa&&(la=xa)):B.isNegative=!1;
                var nb=f.min,ob=f.max;
                if(!(S<nb&&(ia<nb||void 0==ia)||S>ob&&ia>ob))if(l){
                    if("3d"==v)var J=C-0.5*
                        (h+Q)+Q/2+z*V,K=R+y*V;else J=C-(m/2-V)*(h+Q)+Q/2,K=R;
                    var I=h,X=D,$=J+h/2,oa=D,pa=J+h/2;
                    J+I>j&&(I=j-J);
                    0>J&&(I+=J,J=0);
                    var aa=D-R,Bb=K,K=AmCharts.fitToBounds(K,0,i),aa=aa+(Bb-K),aa=AmCharts.fitToBounds(aa,-K,i-K+y*V);
                    if(J<j&&0<I&&(ja=new AmCharts.Cuboid(e,aa,I,y,z,ua,Ha,O,ma,T,U,s,l),"bottom"!=x))if(x=f.reversed?"left":"right",0>S)x=f.reversed?"right":"left";
                        else if("regular"==v||"100%"==v)X+=this.dx
                        }else{
                    "3d"==v?(K=D-0.5*(h+Q)+Q/2+y*V,J=M+z*V):(K=D-(m/2-V)*(h+Q)+Q/2,J=M);
                    I=h;
                    X=K+h/2;
                    $=C;
                    oa=K+h/2;
                    pa=C;
                    K+I>i+V*y&&(I=i-K+V*y);
                    0>K&&(I+=K,K=0);
                    var aa=C-M,Cb=J,J=AmCharts.fitToBounds(J,this.dy,j),aa=aa+(Cb-J),aa=AmCharts.fitToBounds(aa,-J+z*V,j-J);
                    if(K<i+V*y&&0<I)if(ja=new AmCharts.Cuboid(e,I,aa,y,z,ua,Ha,O,ma,this.lineAlpha,U,s,l),0>S&&"middle"!=x)x="bottom";
                        else if(x=ka,"regular"==v||"100%"==v)$+=this.dy
                        }
                        if(ja){
                    var ra=ja.set;
                    ra.translate(K,J);
                    this.columnsSet.push(ra);
                    B.url&&ra.setAttr("cursor","pointer");
                    if(!Y){
                        "none"==v&&(w=l?(this.end+1-L)*u-b:u*L+b);
                        "3d"==v&&(l?(w=(u-b)*(this.end+1-L),X+=y*
                            this.columnIndex,oa+=y*this.columnIndex,B.y+=y*this.columnIndex):(w=(u-b)*(L+1),X+=3,$+=z*this.columnIndex+7,pa+=z*this.columnIndex,B.y+=z*this.columnIndex));
                        if("regular"==v||"100%"==v)x="middle",w=l?0<qa.value?(this.end+1-L)*u+b:(this.end+1-L)*u-b:0<qa.value?u*L+b:u*L-b;
                        this.columnsArray.push({
                            column:ja,
                            depth:w
                        });
                        B.x=l?J+I/2:K+I/2;
                        this.ownColumns.push(ja);
                        this.animateColumns(ja,L,D,R,C,M);
                        this.addListeners(ra,B)
                        }
                        B.columnSprite=ra
                    }
                }
            break;
        case "candlestick":
            if(!isNaN(ia)&&!isNaN(Za)&&!isNaN(Ya)&&!isNaN(S)){
            var Sa,
            $a;
            S<ia&&(B.isNegative=!0,Da&&(ua=Da),Fa&&(Ha=Fa),void 0!=xa&&(la=xa));
            ma=la;
            void 0!=B.lineColor&&(ma=B.lineColor);
            if(l){
                if(J=C-h/2,K=R,I=h,J+I>j&&(I=j-J),0>J&&(I+=J,J=0),J<j&&0<I){
                    var ab,bb;
                    S>ia?(ab=[D,Ra],bb=[R,Qa]):(ab=[R,Ra],bb=[D,Qa]);
                    C<j&&0<C&&(Sa=AmCharts.line(e,ab,[C,C],ma,T,O),$a=AmCharts.line(e,bb,[C,C],ma,T,O));
                    aa=D-R;
                    ja=new AmCharts.Cuboid(e,aa,I,y,z,ua,Ea,O,ma,T,U,s,l)
                    }
                }else if(K=D-h/2,J=M+O/2,I=h,K+I>i&&(I=i-K),0>K&&(I+=K,K=0),aa=C-M,K<i&&0<I){
            var ja=new AmCharts.Cuboid(e,I,aa,y,z,ua,
                Ha,O,ma,T,U,s,l),cb,db;
            S>ia?(cb=[C,Aa],db=[M,za]):(cb=[M,Aa],db=[C,za]);
            D<i&&0<D&&(Sa=AmCharts.line(e,[D,D],cb,ma,T,O),$a=AmCharts.line(e,[D,D],db,ma,T,O))
            }
            ja&&(ra=ja.set,ca.push(ra),ra.translate(K,J),B.url&&ra.setAttr("cursor","pointer"),Sa&&(ca.push(Sa),ca.push($a)),X=D,$=C,oa=D,pa=C,Y||(B.x=l?J+I/2:K+I/2,this.animateColumns(ja,L,D,R,C,M),this.addListeners(ra,B)))
            }
            break;
    case "ohlc":
        if(!isNaN(ia)&&!isNaN(Za)&&!isNaN(Ya)&&!isNaN(S)){
        S<ia&&(B.isNegative=!0,void 0!=xa&&(la=xa));
        var eb,fb,gb;
        if(l){
            var hb=
            C-h/2,hb=AmCharts.fitToBounds(hb,0,j),pb=AmCharts.fitToBounds(C,0,j),ib=C+h/2,ib=AmCharts.fitToBounds(ib,0,j);
            fb=AmCharts.line(e,[R,R],[hb,pb],la,T,O,ba);
            0<C&&C<j&&(eb=AmCharts.line(e,[Qa,Ra],[C,C],la,T,O,ba));
            gb=AmCharts.line(e,[D,D],[pb,ib],la,T,O,ba)
            }else{
            var jb=D-h/2,jb=AmCharts.fitToBounds(jb,0,i),qb=AmCharts.fitToBounds(D,0,i),kb=D+h/2,kb=AmCharts.fitToBounds(kb,0,i);
            fb=AmCharts.line(e,[jb,qb],[M,M],la,T,O,ba);
            0<D&&D<i&&(eb=AmCharts.line(e,[D,D],[za,Aa],la,T,O,ba));
            gb=AmCharts.line(e,[qb,kb],
                [C,C],la,T,O,ba)
            }
            ca.push(fb);
        ca.push(eb);
        ca.push(gb);
        X=D;
        $=C;
        oa=D;
        pa=C
        }
    }
    if(!Y&&!isNaN(S)){
    var rb=this.hideBulletsCount;
    if(this.end-this.start<=rb||0==rb){
        var Ba=this.createBullet(B,oa,pa,L);
        Ba||(Ba=0);
        var sb=this.labelText;
        if(sb){
            var da=this.createLabel(B,0,0,sb),wa=0,Ca=0,tb=da.getBBox(),Ta=tb.width,lb=tb.height;
            switch(x){
                case "left":
                    wa=-(Ta/2+Ba/2+3);
                    break;
                case "top":
                    Ca=-(lb/2+Ba/2+3);
                    break;
                case "right":
                    wa=Ba/2+2+Ta/2;
                    break;
                case "bottom":
                    l&&"column"==g?(X=P,0>S?(wa=-6,da.attr({
                    "text-anchor":"end"
                })):
                (wa=6,da.attr({
                    "text-anchor":"start"
                }))):(Ca=Ba/2+lb/2,da.x=-(Ta/2+2));
                    break;
                case "middle":
                    "column"==g&&(l?(wa=-(D-R)/2-y,0>aa&&(wa+=y),Math.abs(D-R)<Ta&&!this.showAllValueLabels&&(da.remove(),da=null)):(Ca=-(C-M)/2,0>aa&&(Ca-=z),Math.abs(C-M)<lb&&!this.showAllValueLabels&&(da.remove(),da=null)))
                    }
                    if(da)if(!isNaN($)&&!isNaN(X))if(X+=wa,$+=Ca,da.translate(X,$),l){
                if(0>$||$>j)da.remove(),da=null
                    }else{
                var ub=0;
                "3d"==v&&(ub=y*V);
                if(0>X||X>i+ub)da.remove(),da=null
                    }else da.remove(),da=null
                }
                if("column"==
            g&&"regular"==v||"100%"==v){
            var vb=f.totalText;
            if(vb){
                var Ja=this.createLabel(B,0,0,vb),wb=Ja.getBBox(),xb=wb.width,yb=wb.height,Ka,La,zb=f.totals[L];
                zb&&zb.remove();
                l?(La=C,Ka=0>S?D-xb/2-2:D+xb/2+3):(Ka=D,La=0>S?C+yb/2:C-yb/2-3);
                Ja.translate(Ka,La);
                f.totals[L]=Ja;
                l?(0>La||La>j)&&Ja.remove():(0>Ka||Ka>i)&&Ja.remove()
                }
            }
    }
}
}
}
if("line"==g||"step"==g||"smoothedLine"==g)"smoothedLine"==g?this.drawSmoothedGraph(q,n,ga,ha):this.drawLineGraph(q,n,ga,ha),Y||this.launchAnimation()
    },
animateColumns:function(a,
    b){
    var d=this,e=d.chart.startDuration;
    0<e&&!d.animationPlayed&&(d.seqAn?(a.set.hide(),d.animationArray.push(a),e=setTimeout(function(){
        d.animate.call(d)
        },1E3*e/(d.end-d.start+1)*(b-d.start)),d.timeOuts.push(e)):d.animate(a))
    },
createLabel:function(a,b,d,e){
    var f=this.chart,g=this.color;
    void 0==g&&(g=f.color);
    var h=this.fontSize;
    void 0==h&&(h=f.fontSize);
    a=f.formatString(e,a,this);
    a=AmCharts.cleanFromEmpty(a);
    f=AmCharts.text(this.container,a,g,f.fontFamily,h);
    f.translate(b,d);
    this.bulletSet.push(f);
    this.allBullets.push(f);
    return f
    },
positiveClip:function(a){
    a.clipRect(this.pmx,this.pmy,this.pmw,this.pmh)
    },
negativeClip:function(a){
    a.clipRect(this.nmx,this.nmy,this.nmw,this.nmh)
    },
drawLineGraph:function(a,b,d,e){
    if(1<a.length){
        var f=this.set,g=this.container,h=g.set(),i=g.set();
        f.push(h);
        f.push(i);
        var j=this.lineAlpha,k=this.lineThickness,l=this.dashLength,f=this.fillAlphas,m=this.fillColors,s=this.negativeLineColor,p=this.negativeFillColors,q=this.negativeFillAlphas,n=this.baseCoord,r=AmCharts.line(g,
            a,b,this.lineColor,j,k,l,!1,!0);
        h.push(r);
        void 0!=s&&(j=AmCharts.line(g,a,b,s,j,k,l,!1,!0),i.push(j));
        if(0<f&&(j=a.join(";").split(";"),k=b.join(";").split(";"),"serial"==this.chartType&&(0<d.length?(d.reverse(),e.reverse(),j=a.concat(d),k=b.concat(e)):this.rotate?(k.push(k[k.length-1]),j.push(n),k.push(k[0]),j.push(n),k.push(k[0]),j.push(j[0])):(j.push(j[j.length-1]),k.push(n),j.push(j[0]),k.push(n),j.push(a[0]),k.push(k[0]))),a=AmCharts.polygon(g,j,k,m,f,0,0,0,this.gradientRotation),h.push(a),p||
            void 0!=s))q||(q=f),p||(p=s),g=AmCharts.polygon(g,j,k,p,q,0,0,0,this.gradientRotation),i.push(g);
        this.applyMask(i,h)
        }
    },
applyMask:function(a,b){
    var d=a.length();
    "serial"==this.chartType&&!this.scrollbar&&(this.positiveClip(b),0<d&&this.negativeClip(a))
    },
drawSmoothedGraph:function(a,b,d,e){
    if(1<a.length){
        var f=this.set,g=this.container,h=g.set(),i=g.set();
        f.push(h);
        f.push(i);
        var j=this.lineAlpha,k=this.lineThickness,f=this.dashLength,l=this.fillAlphas,m=this.fillColors,s=this.negativeLineColor,p=this.negativeFillColors,
        q=this.negativeFillAlphas,n=this.baseCoord,r=new AmCharts.Bezier(g,a,b,this.lineColor,j,k,m,0,f);
        h.push(r.path);
        void 0!=s&&(j=new AmCharts.Bezier(g,a,b,s,j,k,m,0,f),i.push(j.path));
        if(0<l&&(k=a.join(";").split(";"),r=b.join(";").split(";"),j="",0<d.length?(d.reverse(),e.reverse(),k=a.concat(d),r=b.concat(e)):(this.rotate?(j+=" L"+n+","+b[b.length-1],j+=" L"+n+","+b[0]):(j+=" L"+a[a.length-1]+","+n,j+=" L"+a[0]+","+n),j+=" L"+a[0]+","+b[0]),d=new AmCharts.Bezier(g,k,r,NaN,0,0,m,l,f,j),h.push(d.path),
            p||void 0!=s))q||(q=l),p||(p=s),a=new AmCharts.Bezier(g,a,b,NaN,0,0,p,q,f,j),i.push(a.path);
        this.applyMask(i,h)
        }
    },
launchAnimation:function(){
    var a=this,b=a.chart.startDuration;
    if(0<b&&!a.animationPlayed){
        var d=a.set,e=a.bulletSet;
        AmCharts.VML||(d.attr({
            opacity:a.startAlpha
            }),e.attr({
            opacity:a.startAlpha
            }));
        d.hide();
        e.hide();
        a.seqAn?(b=setTimeout(function(){
            a.animateGraphs.call(a)
            },1E3*a.index*b),a.timeOuts.push(b)):a.animateGraphs()
        }
    },
animateGraphs:function(){
    var a=this.chart,b=this.set,d=this.bulletSet,
    e=this.x,f=this.y;
    b.show();
    d.show();
    var g=a.startDuration,a=a.startEffect;
    b&&(this.rotate?(b.translate(-1E3,f),d.translate(-1E3,f)):(b.translate(e,-1E3),d.translate(e,-1E3)),b.animate({
        opacity:1,
        translate:e+","+f
        },g,a),d.animate({
        opacity:1,
        translate:e+","+f
        },g,a))
    },
animate:function(a){
    var b=this.chart,d=this.container,e=this.animationArray;
    !a&&0<e.length&&(a=e[0],e.shift());
    d=d[AmCharts.getEffect(b.startEffect)];
    b=b.startDuration;
    a&&(this.rotate?a.animateWidth(b,d):a.animateHeight(b,d),a.set.show())
    },
legendKeyColor:function(){
    var a=this.legendColor,b=this.lineAlpha;
    void 0==a&&(a=this.lineColor,0==b&&(b=this.fillColors)&&(a="object"==typeof b?b[0]:b));
    return a
    },
legendKeyAlpha:function(){
    var a=this.legendAlpha;
    void 0==a&&(a=this.lineAlpha,0==a&&this.fillAlphas&&(a=this.fillAlphas),0==a&&(a=this.bulletAlpha),0==a&&(a=1));
    return a
    },
createBullet:function(a,b,d){
    var e=this.container,f=this.bulletOffset,g=this.bulletSize;
    isNaN(a.bulletSize)||(g=a.bulletSize);
    if(!isNaN(this.maxValue)){
        var h=a.values.value;
        isNaN(h)||(g=h/this.maxValue*this.maxBulletSize)
        }
        g<this.minBulletSize&&(g=this.minBulletSize);
    this.rotate?b+=f:d-=f;
    var i;
    if("none"!=this.bullet||a.bullet){
        var j=this.bulletColor;
        a.isNegative&&void 0!=this.bulletColorNegative&&(j=this.bulletColorNegative);
        void 0!=a.color&&(j=a.color);
        f=this.bullet;
        a.bullet&&(f=a.bullet);
        var h=this.bulletBorderThickness,k=this.bulletBorderColor,l=this.bulletBorderAlpha,m=this.bulletAlpha,s=a.alpha;
        isNaN(s)||(m=s);
        switch(f){
            case "round":
                i=AmCharts.circle(e,g/2,j,m,
                h,k,l);
            break;
            case "square":
                i=AmCharts.polygon(e,[0,g,g,0],[0,0,g,g],j,m,h,k,l);
                b-=g/2;
                d-=g/2;
                break;
            case "triangleUp":
                i=AmCharts.triangle(e,g,0,j,m,h,k,l);
                break;
            case "triangleDown":
                i=AmCharts.triangle(e,g,180,j,m,h,k,l);
                break;
            case "triangleLeft":
                i=AmCharts.triangle(e,g,270,j,m,h,k,l);
                break;
            case "triangleRight":
                i=AmCharts.triangle(e,g,90,j,m,h,k,l);
                break;
            case "bubble":
                i=AmCharts.circle(e,g/2,j,m,h,k,l,!0)
                }
            }
    h=f=0;
if(this.customBullet||a.customBullet)k=this.customBullet,a.customBullet&&(k=a.customBullet),
    k&&(i&&i.remove(),"function"==typeof k?(i=new k,i.chart=this.chart,a.bulletConfig&&(i.availableSpace=d,i.graph=this,a.bulletConfig.minCoord=this.minCoord-d,i.bulletConfig=a.bulletConfig),i.write(e),i=i.set):(this.chart.path&&(k=this.chart.path+k),i=e.image(k,0,0,g,g),this.centerCustomBullets&&(b-=g/2,d-=g/2,f-=g/2,h-=g/2)));
if(i){
    a.url&&i.setAttr("cursor","pointer");
    this.allBullets.push(i);
    if("serial"==this.chartType&&(0>b-f||b-f>this.width||d<-g/2||d-h>this.height))i.remove(),i=null;
    i&&(this.bulletSet.push(i),
        i.translate(b,d),this.addListeners(i,a))
    }
    return g
},
showBullets:function(){
    for(var a=this.allBullets,b=0;b<a.length;b++)a[b].show()
        },
hideBullets:function(){
    for(var a=this.allBullets,b=0;b<a.length;b++)a[b].hide()
        },
addListeners:function(a,b){
    var d=this;
    a.mouseover(function(){
        d.handleRollOver(b)
        }).mouseout(function(){
        d.handleRollOut(b)
        }).click(function(){
        d.handleClick(b)
        }).dblclick(function(){
        d.handleDoubleClick(b)
        })
    },
handleRollOver:function(a){
    if(a){
        var b=this.chart,d={
            type:"rollOverGraphItem",
            item:a,
            index:a.index,
            graph:this,
            target:this,
            chart:this.chart
            };
            
        this.fire("rollOverGraphItem",d);
        b.fire("rollOverGraphItem",d);
        clearTimeout(b.hoverInt);
        d=this.showBalloon;
        b.chartCursor&&"serial"==this.chartType&&(d=!1,!b.chartCursor.valueBalloonsEnabled&&this.showBalloon&&(d=!0));
        d&&(d=b.formatString(this.balloonText,a,a.graph),d=AmCharts.cleanFromEmpty(d),a=b.getBalloonColor(this,a),b.balloon.showBullet=!1,b.balloon.pointerOrientation="V",b.showBalloon(d,a,!0))
        }
    },
handleRollOut:function(a){
    this.chart.hideBalloon();
    a&&(a={
        type:"rollOutGraphItem",
        item:a,
        index:a.index,
        graph:this,
        target:this,
        chart:this.chart
        },this.fire("rollOutGraphItem",a),this.chart.fire("rollOutGraphItem",a))
    },
handleClick:function(a){
    if(a){
        var b={
            type:"clickGraphItem",
            item:a,
            index:a.index,
            graph:this,
            target:this,
            chart:this.chart
            };
            
        this.fire("clickGraphItem",b);
        this.chart.fire("clickGraphItem",b);
        AmCharts.getURL(a.url,this.urlTarget)
        }
    },
handleDoubleClick:function(a){
    a&&(a={
        type:"doubleClickGraphItem",
        item:a,
        index:a.index,
        graph:this,
        target:this,
        chart:this.chart
        },this.fire("doubleClickGraphItem",a),this.chart.fire("doubleClickGraphItem",a))
    },
zoom:function(a,b){
    this.start=a;
    this.end=b;
    this.draw()
    },
changeOpacity:function(a){
    var b=this.set;
    b&&b.setAttr("opacity",a);
    if(b=this.ownColumns)for(var d=0;d<b.length;d++){
        var e=b[d].set;
        e&&e.setAttr("opacity",a)
        }(b=this.bulletSet)&&b.setAttr("opacity",a)
    },
destroy:function(){
    AmCharts.remove(this.set);
    AmCharts.remove(this.bulletSet);
    var a=this.timeOuts;
    if(a)for(var b=0;b<a.length;b++)clearTimeout(a[b]);
    this.timeOuts=[]
    }
});
AmCharts.ChartCursor=AmCharts.Class({
    construct:function(){
        this.createEvents("changed","zoomed","onHideCursor","draw");
        this.enabled=!0;
        this.cursorAlpha=1;
        this.selectionAlpha=0.2;
        this.cursorColor="#CC0000";
        this.categoryBalloonAlpha=1;
        this.color="#FFFFFF";
        this.type="cursor";
        this.zoomed=!1;
        this.zoomable=!0;
        this.pan=!1;
        this.animate=!0;
        this.categoryBalloonDateFormat="MMM DD, YYYY";
        this.categoryBalloonEnabled=this.valueBalloonsEnabled=!0;
        this.rolledOver=!1;
        this.cursorPosition="middle";
        this.bulletsEnabled=
        this.skipZoomDispatch=!1;
        this.bulletSize=8;
        this.selectWithoutZooming=this.oneBalloonOnly=!1
        },
    draw:function(){
        var a=this;
        a.destroy();
        var b=a.chart,d=b.container;
        a.rotate=b.rotate;
        a.container=d;
        d=d.set();
        d.translate(a.x,a.y);
        a.set=d;
        b.cursorSet.push(d);
        d=new AmCharts.AmBalloon;
        d.chart=b;
        a.categoryBalloon=d;
        d.cornerRadius=0;
        d.borderThickness=0;
        d.borderAlpha=0;
        d.showBullet=!1;
        var e=a.categoryBalloonColor;
        void 0==e&&(e=a.cursorColor);
        d.fillColor=e;
        d.fillAlpha=a.categoryBalloonAlpha;
        d.borderColor=e;
        d.color=
        a.color;
        a.rotate&&(d.pointerOrientation="H");
        if(a.valueBalloonsEnabled)for(d=0;d<b.graphs.length;d++)e=new AmCharts.AmBalloon,e.chart=b,AmCharts.copyProperties(b.balloon,e),b.graphs[d].valueBalloon=e;
        "cursor"==a.type?a.createCursor():a.createCrosshair();
        a.interval=setInterval(function(){
            a.detectMovement.call(a)
            },40)
        },
    updateData:function(){
        var a=this.chart.chartData;
        this.data=a;
        AmCharts.ifArray(a)&&(this.firstTime=a[0].time,this.lastTime=a[a.length-1].time)
        },
    createCursor:function(){
        var a=this.chart,
        b=this.cursorAlpha,d=a.categoryAxis,e=d.position,f=d.inside,g=d.axisThickness,h=this.categoryBalloon,i,j,k=a.dx,l=a.dy,m=this.x,s=this.y,p=this.width,q=this.height,a=a.rotate,n=d.tickLength;
        h.pointerWidth=n;
        a?(i=[0,p,p+k],j=[0,0,l]):(i=[k,0,0],j=[l,0,q]);
        this.line=b=AmCharts.line(this.container,i,j,this.cursorColor,b,1);
        this.set.push(b);
        a?(f&&(h.pointerWidth=0),"right"==e?f?h.setBounds(m,s+l,m+p+k,s+q+l):h.setBounds(m+p+k+g,s+l,m+p+1E3,s+q+l):f?h.setBounds(m,s,p+m,q+s):h.setBounds(-1E3,-1E3,m-n-g,
            s+q+15)):(h.maxWidth=p,d.parseDates&&(n=0,h.pointerWidth=0),"top"==e?f?h.setBounds(m+k,s+l,p+k+m,q+s):h.setBounds(m+k,-1E3,p+k+m,s+l-n-g):f?h.setBounds(m,s,p+m,q+s-n):h.setBounds(m,s+q+n+g-1,m+p,s+q+n+g));
        this.hideCursor()
        },
    createCrosshair:function(){
        var a=this.cursorAlpha,b=this.container,d=AmCharts.line(b,[0,0],[0,this.height],this.cursorColor,a,1),a=AmCharts.line(b,[0,this.width],[0,0],this.cursorColor,a,1);
        this.set.push(d);
        this.set.push(a);
        this.vLine=d;
        this.hLine=a;
        this.hideCursor()
        },
    detectMovement:function(){
        var a=
        this.chart;
        if(a.mouseIsOver){
            var b=a.mouseX-this.x,d=a.mouseY-this.y;
            0<b&&b<this.width&&0<d&&d<this.height?(this.drawing?this.rolledOver||a.setMouseCursor("crosshair"):this.pan&&(this.rolledOver||a.setMouseCursor("move")),this.rolledOver=!0,this.setPosition()):this.rolledOver&&(this.handleMouseOut(),this.rolledOver=!1)
            }else this.rolledOver&&(this.handleMouseOut(),this.rolledOver=!1)
            },
    getMousePosition:function(){
        var a,b=this.width,d=this.height;
        a=this.chart;
        this.rotate?(a=a.mouseY-this.y,0>a&&(a=0),
            a>d&&(a=d)):(a=a.mouseX-this.x,0>a&&(a=0),a>b&&(a=b));
        return a
        },
    updateCrosshair:function(){
        var a=this.chart,b=a.mouseX-this.x,d=a.mouseY-this.y,e=this.vLine,f=this.hLine,b=AmCharts.fitToBounds(b,0,this.width),d=AmCharts.fitToBounds(d,0,this.height);
        0<this.cursorAlpha&&(e.show(),f.show(),e.translate(b,0),f.translate(0,d));
        this.zooming&&(a.hideXScrollbar&&(b=NaN),a.hideYScrollbar&&(d=NaN),this.updateSelectionSize(b,d));
        !a.mouseIsOver&&!this.zooming&&this.hideCursor()
        },
    updateSelectionSize:function(a,
        b){
        AmCharts.remove(this.selection);
        var d=this.selectionPosX,e=this.selectionPosY,f=0,g=0,h=this.width,i=this.height;
        isNaN(a)||(d>a&&(f=a,h=d-a),d<a&&(f=d,h=a-d),d==a&&(f=a,h=0));
        isNaN(b)||(e>b&&(g=b,i=e-b),e<b&&(g=e,i=b-e),e==b&&(g=b,i=0));
        0<h&&0<i&&(d=AmCharts.rect(this.container,h,i,this.cursorColor,this.selectionAlpha),d.translate(f+this.x,g+this.y),this.selection=d)
        },
    arrangeBalloons:function(){
        var a=this.valueBalloons,b=this.x,d=this.y,e=this.height+d;
        a.sort(this.compareY);
        for(var f=0;f<a.length;f++){
            var g=
            a[f].balloon;
            g.setBounds(b,d,b+this.width,e);
            g.draw();
            e=g.yPos-3
            }
            this.arrangeBalloons2()
        },
    compareY:function(a,b){
        return a.yy<b.yy?1:-1
        },
    arrangeBalloons2:function(){
        var a=this.valueBalloons;
        a.reverse();
        for(var b,d=this.x,e,f=0;f<a.length;f++){
            var g=a[f].balloon;
            b=g.bottom;
            var h=g.bottom-g.yPos;
            0<f&&b-h<e+3&&(g.setBounds(d,e+3,d+this.width,e+h+3),g.draw());
            g.set&&g.set.show();
            e=g.bottom
            }
        },
showBullets:function(){
    AmCharts.remove(this.allBullets);
    var a=this.container,b=a.set();
    this.set.push(b);
    this.set.show();
    this.allBullets=b;
    for(var b=this.chart.graphs,d=0;d<b.length;d++){
        var e=b[d];
        if(!e.hidden&&e.balloonText){
            var f=this.data[this.index].axes[e.valueAxis.id].graphs[e.id],g=f.y;
            if(!isNaN(g)){
                var h,i;
                h=f.x;
                this.rotate?(i=g,g=h):i=h;
                e=AmCharts.circle(a,this.bulletSize/2,this.chart.getBalloonColor(e,f),e.cursorBulletAlpha);
                e.translate(i,g);
                this.allBullets.push(e)
                }
            }
    }
},
destroy:function(){
    this.clear();
    AmCharts.remove(this.selection);
    this.selection=null;
    var a=this.categoryBalloon;
    a&&a.destroy();
    this.destroyValueBalloons();
    AmCharts.remove(this.set)
    },
clear:function(){
    clearInterval(this.interval)
    },
destroyValueBalloons:function(){
    var a=this.valueBalloons;
    if(a)for(var b=0;b<a.length;b++)a[b].balloon.hide()
        },
zoom:function(a,b,d,e){
    var f=this.chart;
    this.destroyValueBalloons();
    this.zooming=!1;
    var g;
    this.rotate?this.selectionPosY=g=f.mouseY:this.selectionPosX=g=f.mouseX;
    this.start=a;
    this.end=b;
    this.startTime=d;
    this.endTime=e;
    this.zoomed=!0;
    var h=f.categoryAxis,f=this.rotate;
    g=this.width;
    var i=this.height;
    h.parseDates&&!h.equalSpacing?
    (a=e-d+h.minDuration(),a=f?i/a:g/a):a=f?i/(b-a):g/(b-a);
    this.stepWidth=a;
    this.setPosition();
    this.hideCursor()
    },
hideObj:function(a){
    a&&a.hide()
    },
hideCursor:function(a){
    void 0==a&&(a=!0);
    this.hideObj(this.set);
    this.hideObj(this.categoryBalloon);
    this.hideObj(this.line);
    this.hideObj(this.vLine);
    this.hideObj(this.hLine);
    this.hideObj(this.allBullets);
    this.destroyValueBalloons();
    this.selectWithoutZooming||AmCharts.remove(this.selection);
    this.previousIndex=NaN;
    a&&this.fire("onHideCursor",{
        type:"onHideCursor",
        chart:this.chart,
        target:this
    });
    this.drawing||this.chart.setMouseCursor("auto")
    },
setPosition:function(a,b){
    void 0==b&&(b=!0);
    if("cursor"==this.type){
        if(AmCharts.ifArray(this.data)){
            isNaN(a)&&(a=this.getMousePosition());
            if((a!=this.previousMousePosition||!0==this.zoomed||this.oneBalloonOnly)&&!isNaN(a)){
                var d=this.chart.categoryAxis.xToIndex(a);
                if(d!=this.previousIndex||this.zoomed||"mouse"==this.cursorPosition||this.oneBalloonOnly)this.updateCursor(d,b),this.zoomed=!1
                    }
                    this.previousMousePosition=a
            }
        }else this.updateCrosshair()
    },
updateCursor:function(a,b){
    var d=this.chart,e=d.mouseX-this.x,f=d.mouseY-this.y;
    this.drawingNow&&(AmCharts.remove(this.drawingLine),this.drawingLine=AmCharts.line(this.container,[this.x+this.drawStartX,this.x+e],[this.y+this.drawStartY,this.y+f],this.cursorColor,1,1));
    if(this.enabled){
        void 0==b&&(b=!0);
        this.index=a;
        var g=d.categoryAxis,h=d.dx,i=d.dy,j=this.x,k=this.y,l=this.width,m=this.height,s=this.data[a],p=s.x[g.id],q=d.rotate,n=g.inside,r=this.stepWidth,t=this.categoryBalloon,u=this.firstTime,
        w=this.lastTime,y=this.cursorPosition,z=g.position,v=this.zooming,x=this.panning,A=d.graphs,F=g.axisThickness;
        if(d.mouseIsOver||v||x||this.forceShow)if(this.forceShow=!1,x){
            k=this.panClickPos;
            d=this.panClickEndTime;
            v=this.panClickStartTime;
            h=this.panClickEnd;
            j=this.panClickStart;
            e=(q?k-f:k-e)/r;
            if(!g.parseDates||g.equalSpacing)e=Math.round(e);
            0!=e&&(k={
                type:"zoomed",
                target:this
            },k.chart=this.chart,g.parseDates&&!g.equalSpacing?(d+e>w&&(e=w-d),v+e<u&&(e=u-v),k.start=v+e,k.end=d+e,this.fire(k.type,
                k)):h+e>=this.data.length||0>j+e||(k.start=j+e,k.end=h+e,this.fire(k.type,k)))
            }else{
            "start"==y&&(p-=g.cellWidth/2);
            "mouse"==y&&d.mouseIsOver&&(p=q?f-2:e-2);
            if(q){
                if(0>p)if(v)p=0;
                    else{
                    this.hideCursor();
                    return
                }
                if(p>m+1)if(v)p=m+1;
                    else{
                    this.hideCursor();
                    return
                }
                }else{
            if(0>p)if(v)p=0;
                else{
                this.hideCursor();
                return
            }
            if(p>l)if(v)p=l;
                else{
                this.hideCursor();
                return
            }
            }
            0<this.cursorAlpha&&(u=this.line,q?u.translate(0,p+i):u.translate(p,0),u.show());
        this.linePos=q?p+i:p;
        v&&(q?this.updateSelectionSize(NaN,p):this.updateSelectionSize(p,
            NaN));
        u=!0;
        v&&(u=!1);
        this.categoryBalloonEnabled&&u?(q?(n&&("right"==z?t.setBounds(j,k+i,j+l+h,k+p+i):t.setBounds(j,k+i,j+l+h,k+p)),"right"==z?n?t.setPosition(j+l+h,k+p+i):t.setPosition(j+l+h+F,k+p+i):n?t.setPosition(j,k+p):t.setPosition(j-F,k+p)):"top"==z?n?t.setPosition(j+p+h,k+i):t.setPosition(j+p+h,k+i-F+1):n?t.setPosition(j+p,k+m):t.setPosition(j+p,k+m+F-1),g.parseDates?(g=AmCharts.formatDate(s.category,this.categoryBalloonDateFormat),-1!=g.indexOf("fff")&&(g=AmCharts.formatMilliseconds(g,s.category)),
            t.showBalloon(g)):t.showBalloon(s.category)):t.hide();
        A&&this.bulletsEnabled&&this.showBullets();
        this.destroyValueBalloons();
        if(A&&this.valueBalloonsEnabled&&u&&d.balloon.enabled){
            this.valueBalloons=g=[];
            if(this.oneBalloonOnly)for(var i=Infinity,Y,u=0;u<A.length;u++)r=A[u],r.showBalloon&&(!r.hidden&&r.balloonText)&&(t=s.axes[r.valueAxis.id].graphs[r.id],w=t.y,isNaN(w)||(q?Math.abs(e-w)<i&&(i=Math.abs(e-w),Y=r):Math.abs(f-w)<i&&(i=Math.abs(f-w),Y=r)));
            for(u=0;u<A.length;u++)if(r=A[u],!(this.oneBalloonOnly&&
                r!=Y)&&(r.showBalloon&&!r.hidden&&r.balloonText)&&(t=s.axes[r.valueAxis.id].graphs[r.id],w=t.y,!isNaN(w))){
                p=t.x;
                n=!0;
                if(q){
                    if(i=w,0>p||p>m)n=!1
                        }else if(i=p,p=w,0>i||i>l+h)n=!1;
                n&&(n=r.valueBalloon,z=d.getBalloonColor(r,t),n.setBounds(j,k,j+l,k+m),n.pointerOrientation="H",n.changeColor(z),void 0!=r.balloonAlpha&&(n.fillAlpha=r.balloonAlpha),void 0!=r.balloonTextColor&&(n.color=r.balloonTextColor),n.setPosition(i+j,p+k),r=d.formatString(r.balloonText,t,r),""!=r&&n.showBalloon(r),!q&&n.set&&n.set.hide(),
                    g.push({
                        yy:w,
                        balloon:n
                    }))
                }
                q||this.arrangeBalloons()
            }
            b?(k={
            type:"changed"
        },k.index=a,k.target=this,k.chart=this.chart,k.zooming=v,k.position=q?f:e,k.target=this,d.fire("changed",k),this.fire("changed",k),this.skipZoomDispatch=!1):(this.skipZoomDispatch=!0,d.updateLegendValues(a));
        this.previousIndex=a
        }
    }else this.hideCursor()
    },
enableDrawing:function(a){
    this.enabled=!a;
    this.hideCursor();
    this.rolledOver=!1;
    this.drawing=a
    },
isZooming:function(a){
    a&&a!=this.zooming&&this.handleMouseDown("fake");
    !a&&a!=this.zooming&&
    this.handleMouseUp()
    },
handleMouseOut:function(){
    if(this.enabled)if(this.zooming)this.setPosition();
        else{
        this.index=void 0;
        var a={
            type:"changed",
            index:void 0,
            target:this
        };
        
        a.chart=this.chart;
        this.fire("changed",a);
        this.hideCursor()
        }
    },
handleReleaseOutside:function(){
    this.handleMouseUp()
    },
handleMouseUp:function(){
    var a=this.chart;
    if(a){
        var b=a.mouseX-this.x,d=a.mouseY-this.y;
        if(this.drawingNow){
            this.drawingNow=!1;
            AmCharts.remove(this.drawingLine);
            var e=this.drawStartX,f=this.drawStartY;
            if(2<Math.abs(e-
                b)||2<Math.abs(f-d))e={
                type:"draw",
                target:this,
                chart:a,
                initialX:e,
                initialY:f,
                finalX:b,
                finalY:d
            },this.fire(e.type,e)
                }
                if(this.enabled&&0<this.data.length){
            if(this.pan)this.rolledOver=!1;
            else if(this.zoomable&&!this.selectWithoutZooming&&this.zooming){
                e={
                    type:"zoomed",
                    target:this
                };
                
                e.chart=this.chart;
                if("cursor"==this.type)this.rotate?this.selectionPosY=a=d:this.selectionPosX=a=b,2>Math.abs(a-this.initialMouse)&&this.fromIndex==this.index||(this.index<this.fromIndex?(e.end=this.fromIndex,e.start=this.index):
                    (e.end=this.index,e.start=this.fromIndex),a=this.chart.categoryAxis,a.parseDates&&!a.equalSpacing&&(e.start=this.data[e.start].time,e.end=this.data[e.end].time),this.skipZoomDispatch||this.fire(e.type,e));
                else{
                    var g=this.initialMouseX,h=this.initialMouseY;
                    if(!(3>Math.abs(b-g)&&3>Math.abs(d-h))){
                        var f=Math.min(g,b),i=Math.min(h,d),b=Math.abs(g-b),d=Math.abs(h-d);
                        a.hideXScrollbar&&(f=0,b=this.width);
                        a.hideYScrollbar&&(i=0,d=this.height);
                        e.selectionHeight=d;
                        e.selectionWidth=b;
                        e.selectionY=i;
                        e.selectionX=
                        f;
                        this.skipZoomDispatch||this.fire(e.type,e)
                        }
                    }
                AmCharts.remove(this.selection)
            }
            this.panning=this.zooming=this.skipZoomDispatch=!1
        }
    }
},
showCursorAt:function(a){
    var b=this.chart.categoryAxis,a=b.parseDates?b.dateToCoordinate(a):b.categoryToCoordinate(a);
    this.previousMousePosition=NaN;
    this.forceShow=!0;
    this.setPosition(a,!1)
    },
handleMouseDown:function(a){
    if(this.zoomable||this.pan||this.drawing){
        var b=this.rotate,d=this.chart,e=d.mouseX-this.x,f=d.mouseY-this.y;
        if(0<e&&e<this.width&&0<f&&f<this.height||
            "fake"==a)this.setPosition(),this.selectWithoutZooming&&AmCharts.remove(this.selection),this.drawing?(this.drawStartY=f,this.drawStartX=e,this.drawingNow=!0):this.pan?(this.zoomable=!1,d.setMouseCursor("move"),this.panning=!0,this.panClickPos=b?f:e,this.panClickStart=this.start,this.panClickEnd=this.end,this.panClickStartTime=this.startTime,this.panClickEndTime=this.endTime):this.zoomable&&("cursor"==this.type?(this.fromIndex=this.index,b?(this.initialMouse=f,this.selectionPosY=this.linePos):(this.initialMouse=
            e,this.selectionPosX=this.linePos)):(this.initialMouseX=e,this.initialMouseY=f,this.selectionPosX=e,this.selectionPosY=f),this.zooming=!0)
            }
        }
});
AmCharts.SimpleChartScrollbar=AmCharts.Class({
    construct:function(){
        this.createEvents("zoomed");
        this.backgroundColor="#D4D4D4";
        this.backgroundAlpha=1;
        this.selectedBackgroundColor="#EFEFEF";
        this.scrollDuration=this.selectedBackgroundAlpha=1;
        this.resizeEnabled=!0;
        this.hideResizeGrips=!1;
        this.scrollbarHeight=20;
        this.updateOnReleaseOnly=!1;
        9>document.documentMode&&(this.updateOnReleaseOnly=!0);
        this.dragIconWidth=11;
        this.dragIconHeight=18
        },
    draw:function(){
        var a=this;
        a.destroy();
        a.interval=setInterval(function(){
            a.updateScrollbar.call(a)
            },
        40);
        var b=a.chart.container,d=a.rotate,e=a.chart,f=b.set();
        a.set=f;
        e.scrollbarsSet.push(f);
        var g,h;
        d?(g=a.scrollbarHeight,h=e.plotAreaHeight):(h=a.scrollbarHeight,g=e.plotAreaWidth);
        a.width=g;
        if((a.height=h)&&g){
            var i=AmCharts.rect(b,g,h,a.backgroundColor,a.backgroundAlpha);
            a.bg=i;
            f.push(i);
            i=AmCharts.rect(b,g,h,"#000",0.005);
            f.push(i);
            a.invisibleBg=i;
            i.click(function(){
                a.handleBgClick()
                }).mouseover(function(){
                a.handleMouseOver()
                }).mouseout(function(){
                a.handleMouseOut()
                }).touchend(function(){
                a.handleBgClick()
                });
            i=AmCharts.rect(b,g,h,a.selectedBackgroundColor,a.selectedBackgroundAlpha);
            a.selectedBG=i;
            f.push(i);
            g=AmCharts.rect(b,g,h,"#000",0.005);
            a.dragger=g;
            f.push(g);
            g.mousedown(function(b){
                a.handleDragStart(b)
                }).mouseup(function(){
                a.handleDragStop()
                }).mouseover(function(){
                a.handleDraggerOver()
                }).mouseout(function(){
                a.handleMouseOut()
                }).touchstart(function(b){
                a.handleDragStart(b)
                }).touchend(function(){
                a.handleDragStop()
                });
            g=e.pathToImages;
            d?(i=g+"dragIconH.gif",g=a.dragIconWidth,d=a.dragIconHeight):(i=g+
                "dragIcon.gif",d=a.dragIconWidth,g=a.dragIconHeight);
            h=b.image(i,0,0,d,g);
            var i=b.image(i,0,0,d,g),j=10,k=20;
            e.panEventsEnabled&&(j=25,k=a.scrollbarHeight);
            var l=AmCharts.rect(b,j,k,"#000",0.005),m=AmCharts.rect(b,j,k,"#000",0.005);
            m.translate(-(j-d)/2,-(k-g)/2);
            l.translate(-(j-d)/2,-(k-g)/2);
            d=b.set([h,m]);
            b=b.set([i,l]);
            a.iconLeft=d;
            f.push(a.iconLeft);
            a.iconRight=b;
            f.push(b);
            d.mousedown(function(){
                a.leftDragStart()
                }).mouseup(function(){
                a.leftDragStop()
                }).mouseover(function(){
                a.iconRollOver()
                }).mouseout(function(){
                a.iconRollOut()
                }).touchstart(function(){
                a.leftDragStart()
                }).touchend(function(){
                a.leftDragStop()
                });
            b.mousedown(function(){
                a.rightDragStart()
                }).mouseup(function(){
                a.rightDragStop()
                }).mouseover(function(){
                a.iconRollOver()
                }).mouseout(function(){
                a.iconRollOut()
                }).touchstart(function(){
                a.rightDragStart()
                }).touchend(function(){
                a.rightDragStop()
                });
            AmCharts.ifArray(e.chartData)?f.show():f.hide();
            a.hideDragIcons()
            }
            f.translate(a.x,a.y);
        a.clipDragger(!1)
        },
    updateScrollbarSize:function(a,b){
        var d=this.dragger,e,f,g,h;
        this.rotate?(e=0,f=a,g=this.width+1,h=b-a,d.setAttr("height",b-a),d.setAttr("y",f)):(e=a,f=
            0,g=b-a,h=this.height+1,d.setAttr("width",b-a),d.setAttr("x",e));
        this.clipAndUpdate(e,f,g,h)
        },
    updateScrollbar:function(){
        var a,b=!1,d,e,f=this.x,g=this.y,h=this.dragger,i=this.getDBox();
        d=i.x+f;
        e=i.y+g;
        var j=i.width,i=i.height,k=this.rotate,l=this.chart,m=this.width,s=this.height,p=l.mouseX,q=l.mouseY;
        a=this.initialMouse;
        l.mouseIsOver&&(this.dragging&&(l=this.initialCoord,k?(a=l+(q-a),0>a&&(a=0),l=s-i,a>l&&(a=l),h.setAttr("y",a)):(a=l+(p-a),0>a&&(a=0),l=m-j,a>l&&(a=l),h.setAttr("x",a))),this.resizingRight&&
            (k?(a=q-e,a+e>s+g&&(a=s-e+g),0>a?(this.resizingRight=!1,b=this.resizingLeft=!0):(0==a&&(a=0.1),h.setAttr("height",a))):(a=p-d,a+d>m+f&&(a=m-d+f),0>a?(this.resizingRight=!1,b=this.resizingLeft=!0):(0==a&&(a=0.1),h.setAttr("width",a)))),this.resizingLeft&&(k?(d=e,e=q,e<g&&(e=g),e>s+g&&(e=s+g),a=!0==b?d-e:i+d-e,0>a?(this.resizingRight=!0,this.resizingLeft=!1,h.setAttr("y",d+i-g)):(0==a&&(a=0.1),h.setAttr("y",e-g),h.setAttr("height",a))):(e=p,e<f&&(e=f),e>m+f&&(e=m+f),a=!0==b?d-e:j+d-e,0>a?(this.resizingRight=
                !0,this.resizingLeft=!1,h.setAttr("x",d+j-f)):(0==a&&(a=0.1),h.setAttr("x",e-f),h.setAttr("width",a)))),this.clipDragger(!0))
        },
    clipDragger:function(a){
        var b=this.getDBox(),d=b.x,e=b.y,f=b.width,b=b.height,g=!1;
        if(this.rotate){
            if(d=0,f=this.width+1,this.clipY!=e||this.clipH!=b)g=!0
                }else if(e=0,b=this.height+1,this.clipX!=d||this.clipW!=f)g=!0;
        g&&(this.clipAndUpdate(d,e,f,b),a&&(this.updateOnReleaseOnly||this.dispatchScrollbarEvent()))
        },
    maskGraphs:function(){},
    clipAndUpdate:function(a,b,d,e){
        this.clipX=
        a;
        this.clipY=b;
        this.clipW=d;
        this.clipH=e;
        this.selectedBG.clipRect(a,b,d,e);
        this.updateDragIconPositions();
        this.maskGraphs(a,b,d,e)
        },
    dispatchScrollbarEvent:function(){
        if(this.skipEvent)this.skipEvent=!1;
        else{
            var a=this.chart;
            a.hideBalloon();
            var b=this.getDBox(),d=b.x,e=b.y,f=b.width,b=b.height;
            this.rotate?(d=e,f=this.height/b):f=this.width/f;
            a={
                type:"zoomed",
                position:d,
                chart:a,
                target:this,
                multiplier:f
            };
            
            this.fire(a.type,a)
            }
        },
updateDragIconPositions:function(){
    var a=this.getDBox(),b=a.x,d=a.y,e=this.iconLeft,
    f=this.iconRight,g,h,i=this.scrollbarHeight;
    this.rotate?(g=this.dragIconWidth,h=this.dragIconHeight,e.translate((i-h)/2,d-g/2),f.translate((i-h)/2,d+a.height-g/2)):(g=this.dragIconHeight,h=this.dragIconWidth,e.translate(b-h/2,(i-g)/2),f.translate(b+-h/2+a.width,(i-g)/2))
    },
showDragIcons:function(){
    this.resizeEnabled&&(this.iconLeft.show(),this.iconRight.show())
    },
hideDragIcons:function(){
    !this.resizingLeft&&(!this.resizingRight&&!this.dragging)&&(this.hideResizeGrips&&(this.iconLeft.hide(),this.iconRight.hide()),
        this.removeCursors())
    },
removeCursors:function(){
    this.chart.setMouseCursor("auto")
    },
relativeZoom:function(a,b){
    this.dragger.stop();
    this.multiplier=a;
    this.position=b;
    this.updateScrollbarSize(b,this.rotate?b+this.height/a:b+this.width/a)
    },
destroy:function(){
    this.clear();
    AmCharts.remove(this.set)
    },
clear:function(){
    clearInterval(this.interval)
    },
handleDragStart:function(){
    var a=this.chart;
    this.dragger.stop();
    this.removeCursors();
    this.dragging=!0;
    var b=this.getDBox();
    this.rotate?(this.initialCoord=b.y,this.initialMouse=
        a.mouseY):(this.initialCoord=b.x,this.initialMouse=a.mouseX)
    },
handleDragStop:function(){
    this.updateOnReleaseOnly&&(this.updateScrollbar(),this.skipEvent=!1,this.dispatchScrollbarEvent());
    this.dragging=!1;
    this.mouseIsOver&&this.removeCursors();
    this.updateScrollbar()
    },
handleDraggerOver:function(){
    this.handleMouseOver()
    },
leftDragStart:function(){
    this.dragger.stop();
    this.resizingLeft=!0
    },
leftDragStop:function(){
    this.resizingLeft=!1;
    this.mouseIsOver||this.removeCursors();
    this.updateOnRelease()
    },
rightDragStart:function(){
    this.dragger.stop();
    this.resizingRight=!0
    },
rightDragStop:function(){
    this.resizingRight=!1;
    this.mouseIsOver||this.removeCursors();
    this.updateOnRelease()
    },
iconRollOut:function(){
    this.removeCursors()
    },
iconRollOver:function(){
    this.rotate?this.chart.setMouseCursor("n-resize"):this.chart.setMouseCursor("e-resize");
    this.handleMouseOver()
    },
getDBox:function(){
    return this.dragger.getBBox()
    },
handleBgClick:function(){
    if(!this.resizingRight&&!this.resizingLeft){
        this.zooming=!0;
        var a,b,d=this.scrollDuration,e=this.dragger;
        a=this.getDBox();
        var f=a.height,g=a.width;
        b=this.chart;
        var h=this.y,i=this.x,j=this.rotate;
        j?(a="y",b=b.mouseY-f/2-h,b=AmCharts.fitToBounds(b,0,this.height-f)):(a="x",b=b.mouseX-g/2-i,b=AmCharts.fitToBounds(b,0,this.width-g));
        this.updateOnReleaseOnly?(this.skipEvent=!1,e.setAttr(a,b),this.dispatchScrollbarEvent(),this.clipDragger()):(b=Math.round(b),j?e.animate({
            y:b
        },d,">"):e.animate({
            x:b
        },d,">"))
        }
    },
updateOnRelease:function(){
    this.updateOnReleaseOnly&&(this.updateScrollbar(),this.skipEvent=!1,this.dispatchScrollbarEvent())
    },
handleReleaseOutside:function(){
    if(this.set){
        if(this.resizingLeft||this.resizingRight||this.dragging)this.updateOnRelease(),this.removeCursors();
        this.mouseIsOver=this.dragging=this.resizingRight=this.resizingLeft=!1;
        this.hideDragIcons();
        this.updateScrollbar()
        }
    },
handleMouseOver:function(){
    this.mouseIsOver=!0;
    this.showDragIcons()
    },
handleMouseOut:function(){
    this.mouseIsOver=!1;
    this.hideDragIcons()
    }
});
AmCharts.ChartScrollbar=AmCharts.Class({
    inherits:AmCharts.SimpleChartScrollbar,
    construct:function(){
        AmCharts.ChartScrollbar.base.construct.call(this);
        this.graphLineColor="#BBBBBB";
        this.graphLineAlpha=0;
        this.graphFillColor="#BBBBBB";
        this.graphFillAlpha=1;
        this.selectedGraphLineColor="#888888";
        this.selectedGraphLineAlpha=0;
        this.selectedGraphFillColor="#888888";
        this.selectedGraphFillAlpha=1;
        this.gridCount=0;
        this.gridColor="#FFFFFF";
        this.gridAlpha=0.7;
        this.skipEvent=this.autoGridCount=!1;
        this.color="#FFFFFF";
        this.scrollbarCreated=!1
        },
    init:function(){
        var a=this.categoryAxis,b=this.chart;
        a||(this.categoryAxis=a=new AmCharts.CategoryAxis);
        a.chart=b;
        a.id="scrollbar";
        a.dateFormats=b.categoryAxis.dateFormats;
        a.boldPeriodBeginning=b.categoryAxis.boldPeriodBeginning;
        a.axisItemRenderer=AmCharts.RecItem;
        a.axisRenderer=AmCharts.RecAxis;
        a.guideFillRenderer=AmCharts.RecFill;
        a.inside=!0;
        a.fontSize=this.fontSize;
        a.tickLength=0;
        a.axisAlpha=0;
        this.graph&&(a=this.valueAxis,a||(this.valueAxis=a=new AmCharts.ValueAxis,a.visible=
            !1,a.scrollbar=!0,a.axisItemRenderer=AmCharts.RecItem,a.axisRenderer=AmCharts.RecAxis,a.guideFillRenderer=AmCharts.RecFill,a.labelsEnabled=!1,a.chart=b),b=this.unselectedGraph,b||(b=new AmCharts.AmGraph,b.scrollbar=!0,this.unselectedGraph=b,b.negativeBase=this.graph.negativeBase),b=this.selectedGraph,b||(b=new AmCharts.AmGraph,b.scrollbar=!0,this.selectedGraph=b,b.negativeBase=this.graph.negativeBase));
        this.scrollbarCreated=!0
        },
    draw:function(){
        var a=this;
        AmCharts.ChartScrollbar.base.draw.call(a);
        a.scrollbarCreated||a.init();
        var b=a.chart,d=b.chartData,e=a.categoryAxis,f=a.rotate,g=a.x,h=a.y,i=a.width,j=a.height,k=b.categoryAxis,l=a.set;
        e.setOrientation(!f);
        e.parseDates=k.parseDates;
        e.rotate=f;
        e.equalSpacing=k.equalSpacing;
        e.minPeriod=k.minPeriod;
        e.startOnAxis=k.startOnAxis;
        e.viW=i;
        e.viH=j;
        e.width=i;
        e.height=j;
        e.gridCount=a.gridCount;
        e.gridColor=a.gridColor;
        e.gridAlpha=a.gridAlpha;
        e.color=a.color;
        e.autoGridCount=a.autoGridCount;
        e.parseDates&&!e.equalSpacing&&e.timeZoom(d[0].time,d[d.length-
            1].time);
        e.zoom(0,d.length-1);
        if(k=a.graph){
            var m=a.valueAxis,s=k.valueAxis;
            m.id=s.id;
            m.rotate=f;
            m.setOrientation(f);
            m.width=i;
            m.height=j;
            m.viW=i;
            m.viH=j;
            m.dataProvider=d;
            m.reversed=s.reversed;
            m.logarithmic=s.logarithmic;
            m.gridAlpha=0;
            m.axisAlpha=0;
            l.push(m.set);
            f?m.y=h:m.x=g;
            for(var g=Infinity,h=-Infinity,p=0;p<d.length;p++){
                var q=d[p].axes[s.id].graphs[k.id].values,n;
                for(n in q)if("percents"!=n&&"total"!=n){
                    var r=q[n];
                    r<g&&(g=r);
                    r>h&&(h=r)
                    }
                }
                Infinity!=g&&(m.minimum=g);
        -Infinity!=h&&(m.maximum=h+
            0.1*(h-g));
        g==h&&(m.minimum-=1,m.maximum+=1);
        m.zoom(0,d.length-1);
        n=a.unselectedGraph;
        n.id=k.id;
        n.rotate=f;
        n.chart=b;
        n.chartType=b.chartType;
        n.data=d;
        n.valueAxis=m;
        n.chart=k.chart;
        n.categoryAxis=a.categoryAxis;
        n.valueField=k.valueField;
        n.openField=k.openField;
        n.closeField=k.closeField;
        n.highField=k.highField;
        n.lowField=k.lowField;
        n.lineAlpha=a.graphLineAlpha;
        n.lineColor=a.graphLineColor;
        n.fillAlphas=a.graphFillAlpha;
        n.fillColors=a.graphFillColor;
        n.connect=k.connect;
        n.hidden=k.hidden;
        n.width=i;
        n.height=
        j;
        s=a.selectedGraph;
        s.id=k.id;
        s.rotate=f;
        s.chart=b;
        s.chartType=b.chartType;
        s.data=d;
        s.valueAxis=m;
        s.chart=k.chart;
        s.categoryAxis=e;
        s.valueField=k.valueField;
        s.openField=k.openField;
        s.closeField=k.closeField;
        s.highField=k.highField;
        s.lowField=k.lowField;
        s.lineAlpha=a.selectedGraphLineAlpha;
        s.lineColor=a.selectedGraphLineColor;
        s.fillAlphas=a.selectedGraphFillAlpha;
        s.fillColors=a.selectedGraphFillColor;
        s.connect=k.connect;
        s.hidden=k.hidden;
        s.width=i;
        s.height=j;
        b=a.graphType;
        b||(b=k.type);
        n.type=b;
        s.type=
        b;
        d=d.length-1;
        n.zoom(0,d);
        s.zoom(0,d);
        s.set.click(function(){
            a.handleBackgroundClick()
            }).mouseover(function(){
            a.handleMouseOver()
            }).mouseout(function(){
            a.handleMouseOut()
            });
        n.set.click(function(){
            a.handleBackgroundClick()
            }).mouseover(function(){
            a.handleMouseOver()
            }).mouseout(function(){
            a.handleMouseOut()
            });
        l.push(n.set);
        l.push(s.set)
        }
        l.push(e.set);
    l.push(e.labelsSet);
    a.bg.toBack();
    a.invisibleBg.toFront();
    a.dragger.toFront();
    a.iconLeft.toFront();
    a.iconRight.toFront()
    },
timeZoom:function(a,b){
    this.startTime=
    a;
    this.endTime=b;
    this.timeDifference=b-a;
    this.skipEvent=!0;
    this.zoomScrollbar()
    },
zoom:function(a,b){
    this.start=a;
    this.end=b;
    this.skipEvent=!0;
    this.zoomScrollbar()
    },
dispatchScrollbarEvent:function(){
    if(this.skipEvent)this.skipEvent=!1;
    else{
        var a=this.chart.chartData,b,d,e=this.dragger.getBBox();
        b=e.x;
        d=e.y;
        var f=e.width,e=e.height;
        this.rotate?(b=d,d=e):d=f;
        f={
            type:"zoomed",
            target:this
        };
        
        f.chart=this.chart;
        var e=this.categoryAxis,g=this.stepWidth;
        if(e.parseDates&&!e.equalSpacing){
            var a=a[0].time,h=e.minDuration(),
            e=Math.round(b/g)+a,a=this.dragging?e+this.timeDifference:Math.round((b+d)/g)+a-h;
            e>a&&(e=a);
            if(e!=this.startTime||a!=this.endTime)this.startTime=e,this.endTime=a,f.start=e,f.end=a,f.startDate=new Date(e),f.endDate=new Date(a),this.fire(f.type,f)
                }else if(e.startOnAxis||(b+=g/2),d-=this.stepWidth/2,g=e.xToIndex(b),b=e.xToIndex(b+d),g!=this.start||this.end!=b)e.startOnAxis&&(this.resizingRight&&g==b&&b++,this.resizingLeft&&g==b&&(0<g?g--:b=1)),this.start=g,this.end=this.dragging?this.start+this.difference:
            b,f.start=this.start,f.end=this.end,e.parseDates&&(a[this.start]&&(f.startDate=new Date(a[this.start].time)),a[this.end]&&(f.endDate=new Date(a[this.end].time))),this.fire(f.type,f)
            }
        },
zoomScrollbar:function(){
    var a,b;
    b=this.chart.chartData;
    var d=this.categoryAxis,e;
    d.parseDates&&!d.equalSpacing?(e=d.stepWidth,b=b[0].time,a=e*(this.startTime-b),b=e*(this.endTime-b+d.minDuration())):(a=b[this.start].x[d.id],b=b[this.end].x[d.id],e=d.stepWidth,d.startOnAxis||(d=e/2,a-=d,b+=d));
    this.stepWidth=e;
    this.updateScrollbarSize(a,
        b)
    },
maskGraphs:function(a,b,d,e){
    var f=this.selectedGraph;
    f&&f.set.clipRect(a,b,d,e)
    },
handleDragStart:function(){
    AmCharts.ChartScrollbar.base.handleDragStart.call(this);
    this.difference=this.end-this.start;
    this.timeDifference=this.endTime-this.startTime;
    0>this.timeDifference&&(this.timeDifference=0)
    },
handleBackgroundClick:function(){
    AmCharts.ChartScrollbar.base.handleBackgroundClick.call(this);
    this.dragging||(this.difference=this.end-this.start,this.timeDifference=this.endTime-this.startTime,0>this.timeDifference&&
        (this.timeDifference=0))
    }
});
AmCharts.circle=function(a,b,d,e,f,g,h,i){
    if(void 0==f||0==f)f=1;
    void 0==g&&(g="#000000");
    void 0==h&&(h=0);
    e={
        fill:d,
        stroke:g,
        "fill-opacity":e,
        "stroke-width":f,
        "stroke-opacity":h
    };
    
    a=a.circle(0,0,b).attr(e);
    i&&a.gradient("radialGradient",[d,AmCharts.adjustLuminosity(d,-0.6)]);
    return a
    };
    
AmCharts.text=function(a,b,d,e,f,g,h,i){
    g||(g="middle");
    "right"==g&&(g="end");
    d={
        fill:d,
        "font-family":e,
        "font-size":f,
        opacity:i
    };
    !0==h&&(d["font-weight"]="bold");
    d["text-anchor"]=g;
    return a.text(b,d)
    };
AmCharts.polygon=function(a,b,d,e,f,g,h,i,j){
    isNaN(g)&&(g=0);
    isNaN(i)&&(i=f);
    var k=e,l=!1;
    "object"==typeof k&&1<k.length&&(l=!0,k=k[0]);
    void 0==h&&(h=k);
    for(var f={
        fill:k,
        stroke:h,
        "fill-opacity":f,
        "stroke-width":g,
        "stroke-opacity":i
    },g=AmCharts.dx,h=AmCharts.dy,i=Math.round,k="M"+(i(b[0])+g)+","+(i(d[0])+h),m=1;m<b.length;m++)k+=" L"+(i(b[m])+g)+","+(i(d[m])+h);
    a=a.path(k+" Z").attr(f);
    l&&a.gradient("linearGradient",e,j);
    return a
    };
AmCharts.rect=function(a,b,d,e,f,g,h,i,j,k){
    isNaN(g)&&(g=0);
    void 0==j&&(j=0);
    void 0==k&&(k=270);
    isNaN(f)&&(f=0);
    var l=e,m=!1;
    "object"==typeof l&&(l=l[0],m=!0);
    void 0==h&&(h=l);
    void 0==i&&(i=f);
    var b=Math.round(b),d=Math.round(d),s=0,p=0;
    0>b&&(b=Math.abs(b),s=-b);
    0>d&&(d=Math.abs(d),p=-d);
    s+=AmCharts.dx;
    p+=AmCharts.dy;
    f={
        fill:l,
        stroke:h,
        "fill-opacity":f,
        "stroke-opacity":i
    };
    
    a=a.rect(s,p,b,d,j,g).attr(f);
    m&&a.gradient("linearGradient",e,k);
    return a
    };
AmCharts.triangle=function(a,b,d,e,f,g,h,i){
    if(void 0==g||0==g)g=1;
    void 0==h&&(h="#000");
    void 0==i&&(i=0);
    var e={
        fill:e,
        stroke:h,
        "fill-opacity":f,
        "stroke-width":g,
        "stroke-opacity":i
    },b=b/2,j;
    0==d&&(j=" M"+-b+","+b+" L0,"+-b+" L"+b+","+b+" Z");
    180==d&&(j=" M"+-b+","+-b+" L0,"+b+" L"+b+","+-b+" Z");
    90==d&&(j=" M"+-b+","+-b+" L"+b+",0 L"+-b+","+b+" Z");
    270==d&&(j=" M"+-b+",0 L"+b+","+b+" L"+b+","+-b+" Z");
    return a.path(j).attr(e)
    };
AmCharts.line=function(a,b,d,e,f,g,h,i,j){
    g={
        fill:"none",
        "stroke-width":g
    };
    
    void 0!=h&&0<h&&(g["stroke-dasharray"]=h);
    isNaN(f)||(g["stroke-opacity"]=f);
    e&&(g.stroke=e);
    for(var e=Math.round,f=AmCharts.dx,h=AmCharts.dy,i="M"+(e(b[0])+f)+","+(e(d[0])+h),k=1;k<b.length;k++)i+=" L"+(e(b[k])+f)+","+(e(d[k])+h);
    if(AmCharts.VML)return a.path(i,void 0,!0).attr(g);
    j&&(i+=" M0,0 L0,0");
    return a.path(i).attr(g)
    };
AmCharts.wedge=function(a,b,d,e,f,g,h,i,j,k,l){
    var m=Math.round,g=m(g),h=m(h),i=m(i),s=m(h/g*i),p=AmCharts.VML,q=-359.5-g/100;
    -359.95>q&&(q=-359.95);
    f<=q&&(f=q);
    var n=1/180*Math.PI,q=b+Math.cos(e*n)*i,r=d+Math.sin(-e*n)*s,t=b+Math.cos(e*n)*g,u=d+Math.sin(-e*n)*h,w=b+Math.cos((e+f)*n)*g,y=d+Math.sin((-e-f)*n)*h,z=b+Math.cos((e+f)*n)*i,n=d+Math.sin((-e-f)*n)*s,v={
        fill:AmCharts.adjustLuminosity(k.fill,-0.2),
        "stroke-opacity":0
    },x=0;
    180<Math.abs(f)&&(x=1);
    var e=a.set(),A;
    p&&(q=m(10*q),t=m(10*t),w=m(10*
        w),z=m(10*z),r=m(10*r),u=m(10*u),y=m(10*y),n=m(10*n),b=m(10*b),j=m(10*j),d=m(10*d),g*=10,h*=10,i*=10,s*=10,1>Math.abs(f)&&(1>=Math.abs(w-t)&&1>=Math.abs(y-u))&&(A=!0));
    f="";
    if(0<j){
        p?(path=" M"+q+","+(r+j)+" L"+t+","+(u+j),A||(path+=" A"+(b-g)+","+(j+d-h)+","+(b+g)+","+(j+d+h)+","+t+","+(u+j)+","+w+","+(y+j)),path+=" L"+z+","+(n+j),0<i&&(A||(path+=" B"+(b-i)+","+(j+d-s)+","+(b+i)+","+(j+d+s)+","+z+","+(j+n)+","+q+","+(j+r)))):(path=" M"+q+","+(r+j)+" L"+t+","+(u+j),path+=" A"+g+","+h+",0,"+x+",1,"+
            w+","+(y+j)+" L"+z+","+(n+j),0<i&&(path+=" A"+i+","+s+",0,"+x+",0,"+q+","+(r+j)));
        path+=" Z";
        c=a.path(path,void 0,void 0,"1000,1000").attr(v);
        e.push(c);
        var F=a.path(" M"+q+","+r+" L"+q+","+(r+j)+" L"+t+","+(u+j)+" L"+t+","+u+" L"+q+","+r+" Z",void 0,void 0,"1000,1000").attr(v),j=a.path(" M"+w+","+y+" L"+w+","+(y+j)+" L"+z+","+(n+j)+" L"+z+","+n+" L"+w+","+y+" Z",void 0,void 0,"1000,1000").attr(v);
        e.push(F);
        e.push(j)
        }
        p?(A||(f=" A"+m(b-g)+","+m(d-h)+","+m(b+g)+","+m(d+h)+","+m(t)+","+m(u)+","+m(w)+
        ","+m(y)),g=" M"+m(q)+","+m(r)+" L"+m(t)+","+m(u)+f+" L"+m(z)+","+m(n)):g=" M"+q+","+r+" L"+t+","+u+(" A"+g+","+h+",0,"+x+",1,"+w+","+y)+" L"+z+","+n;
    0<i&&(p?A||(g+=" B"+(b-i)+","+(d-s)+","+(b+i)+","+(d+s)+","+z+","+n+","+q+","+r):g+=" A"+i+","+s+",0,"+x+",0,"+q+","+r);
    a=a.path(g+" Z",void 0,void 0,"1000,1000").attr(k);
    if(l){
        b=[];
        for(d=0;d<l.length;d++)b.push(AmCharts.adjustLuminosity(k.fill,l[d]));
        0<b.length&&a.gradient("linearGradient",b)
        }
        e.push(a);
    return e
    };
AmCharts.adjustLuminosity=function(a,b){
    a=String(a).replace(/[^0-9a-f]/gi,"");
    6>a.length&&(a=String(a[0])+String(a[0])+String(a[1])+String(a[1])+String(a[2])+String(a[2]));
    var b=b||0,d="#",e,f;
    for(f=0;3>f;f++)e=parseInt(a.substr(2*f,2),16),e=Math.round(Math.min(Math.max(0,e+e*b),255)).toString(16),d+=("00"+e).substr(e.length);
    return d
    };
    
AmCharts.AmPieChart=AmCharts.Class({
    inherits:AmCharts.AmChart,
    construct:function(){
        this.createEvents("rollOverSlice","rollOutSlice","clickSlice","pullOutSlice","pullInSlice");
        AmCharts.AmPieChart.base.construct.call(this);
        this.colors="#FF0F00 #FF6600 #FF9E01 #FCD202 #F8FF01 #B0DE09 #04D215 #0D8ECF #0D52D1 #2A0CD0 #8A0CCF #CD0D74 #754DEB #DDDDDD #999999 #333333 #000000 #57032A #CA9726 #990000 #4B0C25".split(" ");
        this.pieAlpha=1;
        this.pieBaseColor;
        this.pieBrightnessStep=30;
        this.groupPercent=0;
        this.groupedTitle=
        "Other";
        this.groupedPulled=!1;
        this.groupedAlpha=1;
        this.marginLeft=0;
        this.marginBottom=this.marginTop=10;
        this.marginRight=0;
        this.minRadius=10;
        this.hoverAlpha=1;
        this.depth3D=0;
        this.startAngle=90;
        this.angle=this.innerRadius=0;
        this.outlineColor="#FFFFFF";
        this.outlineAlpha=0;
        this.outlineThickness=1;
        this.startRadius="500%";
        this.startDuration=this.startAlpha=1;
        this.startEffect="bounce";
        this.sequencedAnimation=!1;
        this.pullOutRadius="20%";
        this.pullOutDuration=1;
        this.pullOutEffect="bounce";
        this.pullOnHover=
        this.pullOutOnlyOne=!1;
        this.labelsEnabled=!0;
        this.labelRadius=30;
        this.labelTickColor="#000000";
        this.labelTickAlpha=0.2;
        this.labelText="[[title]]: [[percents]]%";
        this.hideLabelsPercent=0;
        this.balloonText="[[title]]: [[percents]]% ([[value]])\n[[description]]";
        this.dataProvider;
        this.urlTarget="_self";
        this.previousScale=1;
        this.autoMarginOffset=10;
        this.gradientRatio=[]
        },
    initChart:function(){
        AmCharts.AmPieChart.base.initChart.call(this);
        this.dataChanged&&(this.parseData(),this.dispatchDataUpdated=!0,this.dataChanged=
            !1,this.legend&&this.legend.setData(this.chartData));
        this.drawChart()
        },
    handleLegendEvent:function(a){
        var b=a.type;
        if(a=a.dataItem){
            var d=a.hidden;
            switch(b){
                case "clickMarker":
                    d||this.clickSlice(a);
                    break;
                case "clickLabel":
                    d||this.clickSlice(a);
                    break;
                case "rollOverItem":
                    d||this.rollOverSlice(a,!1);
                    break;
                case "rollOutItem":
                    d||this.rollOutSlice(a);
                    break;
                case "hideItem":
                    this.hideSlice(a);
                    break;
                case "showItem":
                    this.showSlice(a)
                    }
                }
    },
invalidateVisibility:function(){
    this.recalculatePercents();
    this.initChart();
    var a=this.legend;
    a&&a.invalidateSize()
    },
drawChart:function(){
    var a=this;
    AmCharts.AmPieChart.base.drawChart.call(a);
    var b=a.chartData;
    if(AmCharts.ifArray(b)){
        if(0<a.realWidth&&0<a.realHeight){
            AmCharts.VML&&(a.startAlpha=1);
            var d=a.startDuration,e=a.container,f=a.updateWidth();
            a.realWidth=f;
            var g=a.updateHeight();
            a.realHeight=g;
            var h=AmCharts.toCoordinate,i=h(a.marginLeft,f),j=h(a.marginRight,f),k=h(a.marginTop,g)+a.getTitleHeight(),l=h(a.marginBottom,g);
            a.chartDataLabels=[];
            a.ticks=[];
            var m,s,p,q=
            AmCharts.toNumber(a.labelRadius),n=a.measureMaxLabel();
            if(!a.labelText||!a.labelsEnabled)q=n=0;
            m=void 0==a.pieX?(f-i-j)/2+i:h(a.pieX,a.realWidth);
            s=void 0==a.pieY?(g-k-l)/2+k:h(a.pieY,g);
            p=h(a.radius,f,g);
            a.pullOutRadiusReal=AmCharts.toCoordinate(a.pullOutRadius,p);
            p||(f=0<=q?f-i-j-2*n:f-i-j,g=g-k-l,p=Math.min(f,g),g<f&&(p/=1-a.angle/90,p>f&&(p=f)),a.pullOutRadiusReal=AmCharts.toCoordinate(a.pullOutRadius,p),p=0<=q?p-1.8*(q+a.pullOutRadiusReal):p-1.8*a.pullOutRadiusReal,p/=2);
            p<a.minRadius&&(p=a.minRadius);
            a.pullOutRadiusReal=h(a.pullOutRadius,p);
            h=h(a.innerRadius,p);
            h>=p&&(h=p-1);
            g=AmCharts.fitToBounds(a.startAngle,0,360);
            0<a.depth3D&&(g=270<=g?270:90);
            k=p-p*a.angle/90;
            for(l=0;l<b.length;l++)if(f=b[l],!0!=f.hidden&&0<f.percents){
                var r=360*-f.percents/100,j=Math.cos((g+r/2)/180*Math.PI),n=Math.sin((-g-r/2)/180*Math.PI)*(k/p),i={
                    fill:f.color,
                    stroke:a.outlineColor,
                    "stroke-width":a.outlineThickness,
                    "stroke-opacity":a.outlineAlpha
                    };
                    
                f.url&&(i.cursor="pointer");
                i=AmCharts.wedge(e,m,s,g,r,p,k,h,a.depth3D,
                    i,a.gradientRatio);
                a.addEventListeners(i,f);
                f.startAngle=g;
                b[l].wedge=i;
                if(0<d){
                    var t=a.startAlpha;
                    a.chartCreated&&(t=f.alpha);
                    i.setAttr("opacity",t)
                    }
                    f.ix=j;
                f.iy=n;
                f.wedge=i;
                f.index=l;
                if(a.labelsEnabled&&a.labelText&&f.percents>=a.hideLabelsPercent){
                    r=g+r/2;
                    0>=r&&(r+=360);
                    var j=m+j*(p+q),t=s+n*(p+q),u,n=0;
                    if(0<=q){
                        var w;
                        90>=r&&0<=r?(w=0,u="start",n=8):360>=r&&270<r?(w=1,u="start",n=8):270>=r&&180<r?(w=2,u="end",n=-8):180>=r&&90<r&&(w=3,u="end",n=-8);
                        f.labelQuarter=w
                        }else u="middle";
                    r=a.formatString(a.labelText,
                        f);
                    r=AmCharts.text(e,r,a.color,a.fontFamily,a.fontSize,u);
                    r.translate(j+1.5*n,t);
                    f.tx=j+1.5*n;
                    f.ty=t;
                    t=setTimeout(function(){
                        a.showLabels.call(a)
                        },1E3*d);
                    a.timeOuts.push(t);
                    0<=a.labelRadius?i.push(r):a.freeLabelsSet.push(r);
                    f.label=r;
                    a.chartDataLabels[l]=r;
                    f.tx=j;
                    f.tx2=j+n
                    }
                    a.graphsSet.push(i);
                (0==f.alpha||0<d&&!a.chartCreated)&&i.hide();
                g-=360*f.percents/100;
                0>=g&&(g+=360)
                }
                0<q&&a.arrangeLabels();
            a.pieXReal=m;
            a.pieYReal=s;
            a.radiusReal=p;
            a.innerRadiusReal=h;
            0<q&&a.drawTicks();
            a=this;
            a.chartCreated?
            a.pullSlices(!0):(t=setTimeout(function(){
                a.pullSlices.call(a)
                },1200*d),a.timeOuts.push(t));
            a.chartCreated||a.startSlices();
            a.setDepths()
            }
        }else a.cleanChart();
    a.chartCreated=!0;
    a.dispDUpd()
    },
setDepths:function(){
    for(var a=this.chartData,b=0;b<a.length;b++){
        var d=a[b],e=d.wedge,d=d.startAngle;
        90>=d&&0<=d||360>=d&&270<d?e.toFront():(270>=d&&180<d||180>=d&&90<d)&&e.toBack()
        }
    },
addEventListeners:function(a,b){
    var d=this;
    a.mouseover(function(){
        d.rollOverSlice(b,!0)
        }).mouseout(function(){
        d.rollOutSlice(b)
        }).click(function(){
        d.clickSlice(b)
        })
    },
formatString:function(a,b){
    a=AmCharts.formatValue(a,b,["value"],this.numberFormatter,"",this.usePrefixes,this.prefixesOfSmallNumbers,this.prefixesOfBigNumbers);
    a=AmCharts.formatValue(a,b,["percents"],this.percentFormatter);
    a=AmCharts.massReplace(a,{
        "[[title]]":b.title,
        "[[description]]":b.description,
        "<br>":"\n"
    });
    a=AmCharts.fixNewLines(a);
    return a=AmCharts.cleanFromEmpty(a)
    },
drawTicks:function(){
    for(var a=this.chartData,b=0;b<a.length;b++)if(this.chartDataLabels[b]){
        var d=a[b],e=d.ty,f=this.radiusReal,
        e=AmCharts.line(this.container,[this.pieXReal+d.ix*f,d.tx,d.tx2],[this.pieYReal+d.iy*f,e,e],this.labelTickColor,this.labelTickAlpha);
        d.wedge.push(e);
        this.ticks[b]=e
        }
    },
arrangeLabels:function(){
    for(var a=this.chartData,b=a.length,d,e=b-1;0<=e;e--)d=a[e],0==d.labelQuarter&&!d.hidden&&this.checkOverlapping(e,d,0,!0,0);
    for(e=0;e<b;e++)d=a[e],1==d.labelQuarter&&!d.hidden&&this.checkOverlapping(e,d,1,!1,0);
    for(e=b-1;0<=e;e--)d=a[e],2==d.labelQuarter&&!d.hidden&&this.checkOverlapping(e,d,2,!0,0);
    for(e=0;e<
        b;e++)d=a[e],3==d.labelQuarter&&!d.hidden&&this.checkOverlapping(e,d,3,!1,0)
        },
checkOverlapping:function(a,b,d,e,f){
    var g,h,i=this.chartData,j=i.length,k=b.label;
    if(k){
        if(!0==e)for(h=a+1;h<j;h++)(g=this.checkOverlappingReal(b,i[h],d))&&(h=j);else for(h=a-1;0<=h;h--)(g=this.checkOverlappingReal(b,i[h],d))&&(h=0);
        !0==g&&100>f&&(g=b.ty+3*b.iy,b.ty=g,k.translate(b.tx2,g),this.checkOverlapping(a,b,d,e,f+1))
        }
    },
checkOverlappingReal:function(a,b,d){
    var e=!1,f=a.label,g=b.label;
    a.labelQuarter==d&&(!a.hidden&&
        !b.hidden&&g)&&(f=f.getBBox(),d={},d.width=f.width,d.height=f.height,d.y=a.ty,d.x=a.tx,a=g.getBBox(),g={},g.width=a.width,g.height=a.height,g.y=b.ty,g.x=b.tx,AmCharts.hitTest(d,g)&&(e=!0));
    return e
    },
startSlices:function(){
    for(var a=this,b=500*(a.startDuration/a.chartData.length),d=0;d<a.chartData.length;d++)if(0<a.startDuration&&a.sequencedAnimation){
        var e=setTimeout(function(){
            a.startSequenced.call(a)
            },b*d);
        a.timeOuts.push(e)
        }else a.startSlice(a.chartData[d])
        },
pullSlices:function(a){
    for(var b=this.chartData,
        d=0;d<b.length;d++){
        var e=b[d];
        e.pulled&&this.pullSlice(e,1,a)
        }
    },
startSequenced:function(){
    for(var a=this.chartData,b=0;b<a.length;b++)if(!a[b].started){
        this.startSlice(this.chartData[b]);
        break
    }
    },
startSlice:function(a){
    a.started=!0;
    var b=a.wedge,d=this.startDuration;
    if(b&&0<d){
        0<a.alpha&&b.show();
        var e=AmCharts.toCoordinate(this.startRadius,this.radiusReal);
        b.translate(Math.round(a.ix*e),Math.round(a.iy*e));
        b.animate({
            opacity:a.alpha,
            translate:"0,0"
        },d,this.startEffect)
        }
    },
showLabels:function(){
    for(var a=
        this.chartData,b=0;b<a.length;b++)if(0<a[b].alpha){
        var d=this.chartDataLabels[b];
        d&&d.show();
        (d=this.ticks[b])&&d.show()
        }
    },
showSlice:function(a){
    isNaN(a)?a.hidden=!1:this.chartData[a].hidden=!1;
    this.hideBalloon();
    this.invalidateVisibility()
    },
hideSlice:function(a){
    isNaN(a)?a.hidden=!0:this.chartData[a].hidden=!0;
    this.hideBalloon();
    this.invalidateVisibility()
    },
rollOverSlice:function(a,b){
    isNaN(a)||(a=this.chartData[a]);
    clearTimeout(this.hoverInt);
    this.pullOnHover&&this.pullSlice(a,1);
    var d=this.innerRadiusReal+
    (this.radiusReal-this.innerRadiusReal)/2;
    a.pulled&&(d+=this.pullOutRadiusReal);
    1>this.hoverAlpha&&a.wedge&&a.wedge.attr({
        opacity:this.hoverAlpha
        });
    var e;
    e=a.ix*d+this.pieXReal;
    var d=a.iy*d+this.pieYReal,f=this.formatString(this.balloonText,a),g=AmCharts.adjustLuminosity(a.color,-0.15);
    this.showBalloon(f,g,b,e,d);
    e={
        type:"rollOverSlice",
        dataItem:a,
        chart:this
    };
    
    this.fire(e.type,e)
    },
rollOutSlice:function(a){
    isNaN(a)||(a=this.chartData[a]);
    a.wedge&&a.wedge.attr({
        opacity:a.alpha
        });
    this.hideBalloon();
    a=

    {
        type:"rollOutSlice",
        dataItem:a,
        chart:this
    };
    
    this.fire(a.type,a)
    },
clickSlice:function(a){
    isNaN(a)||(a=this.chartData[a]);
    this.hideBalloon();
    a.pulled?this.pullSlice(a,0):this.pullSlice(a,1);
    AmCharts.getURL(a.url,this.urlTarget);
    a={
        type:"clickSlice",
        dataItem:a,
        chart:this
    };
    
    this.fire(a.type,a)
    },
pullSlice:function(a,b,d){
    var e=a.ix,f=a.iy,g=this.pullOutDuration;
    !0===d&&(g=0);
    var d=a.wedge,h=this.pullOutRadiusReal;
    d&&d.animate({
        translate:b*e*h+","+b*f*h
        },g,this.pullOutEffect);
    1==b?(a.pulled=!0,this.pullOutOnlyOne&&
        this.pullInAll(a.index),a={
            type:"pullOutSlice",
            dataItem:a,
            chart:this
        }):(a.pulled=!1,a={
        type:"pullInSlice",
        dataItem:a,
        chart:this
    });
    this.fire(a.type,a)
    },
pullInAll:function(a){
    for(var b=this.chartData,d=0;d<this.chartData.length;d++)d!=a&&b[d].pulled&&this.pullSlice(b[d],0)
        },
pullOutAll:function(){
    for(var a=this.chartData,b=0;b<a.length;b++)a[b].pulled||this.pullSlice(a[b],1)
        },
parseData:function(){
    var a=[];
    this.chartData=a;
    var b=this.dataProvider;
    if(void 0!=b){
        for(var d=b.length,e=0,f=0;f<d;f++){
            var g=

            {},h=b[f];
            g.dataContext=h;
            g.value=Number(h[this.valueField]);
            var i=h[this.titleField];
            i||(i="");
            g.title=i;
            g.pulled=AmCharts.toBoolean(h[this.pulledField],!1);
            (i=h[this.descriptionField])||(i="");
            g.description=i;
            g.url=h[this.urlField];
            g.visibleInLegend=AmCharts.toBoolean(h[this.visibleInLegendField],!0);
            i=h[this.alphaField];
            g.alpha=void 0!=i?Number(i):this.pieAlpha;
            h=h[this.colorField];
            void 0!=h&&(g.color=AmCharts.toColor(h));
            e+=g.value;
            g.hidden=!1;
            a[f]=g
            }
            for(f=b=0;f<d;f++)g=a[f],g.percents=100*(g.value/
            e),g.percents<this.groupPercent&&b++;
        1<b&&(this.groupValue=0,this.removeSmallSlices(),a.push({
            title:this.groupedTitle,
            value:this.groupValue,
            percents:100*(this.groupValue/e),
            pulled:this.groupedPulled,
            color:this.groupedColor,
            url:this.groupedUrl,
            description:this.groupedDescription,
            alpha:this.groupedAlpha
            }));
        for(f=0;f<a.length;f++)this.pieBaseColor?h=AmCharts.adjustLuminosity(this.pieBaseColor,f*this.pieBrightnessStep/100):(h=this.colors[f],void 0==h&&(h=AmCharts.randomColor())),void 0==a[f].color&&(a[f].color=
            h);
        this.recalculatePercents()
        }
    },
recalculatePercents:function(){
    for(var a=this.chartData,b=0,d=0;d<a.length;d++){
        var e=a[d];
        !e.hidden&&0<e.value&&(b+=e.value)
        }
        for(d=0;d<a.length;d++)e=this.chartData[d],e.percents=!e.hidden&&0<e.value?100*e.value/b:0
        },
removeSmallSlices:function(){
    for(var a=this.chartData,b=a.length-1;0<=b;b--)a[b].percents<this.groupPercent&&(this.groupValue+=a[b].value,a.splice(b,1))
        },
animateAgain:function(){
    var a=this;
    a.startSlices();
    var b=setTimeout(function(){
        a.pullSlices.call(a)
        },
    1200*a.startDuration);
    a.timeOuts.push(b)
    },
measureMaxLabel:function(){
    for(var a=this.chartData,b=0,d=0;d<a.length;d++){
        var e=this.formatString(this.labelText,a[d]),e=AmCharts.text(this.container,e,this.color,this.fontFamily,this.fontSize),f=e.getBBox().width;
        f>b&&(b=f);
        e.remove()
        }
        return b
    }
});
AmCharts.AmXYChart=AmCharts.Class({
    inherits:AmCharts.AmRectangularChart,
    construct:function(){
        AmCharts.AmXYChart.base.construct.call(this);
        this.createEvents("zoomed");
        this.xAxes;
        this.yAxes;
        this.scrollbarV;
        this.scrollbarH;
        this.maxZoomFactor=20;
        this.chartType="xy";
        this.hideXScrollbar;
        this.hideYScrollbar
        },
    initChart:function(){
        AmCharts.AmXYChart.base.initChart.call(this);
        this.dataChanged&&(this.updateData(),this.dataChanged=!1,this.dispatchDataUpdated=!0);
        this.updateScrollbar=!0;
        this.drawChart();
        this.autoMargins&&
        !this.marginsUpdated&&(this.marginsUpdated=!0,this.measureMargins());
        var a=this.marginLeftReal,b=this.marginTopReal,d=this.plotAreaWidth,e=this.plotAreaHeight;
        this.graphsSet.clipRect(a,b,d,e);
        this.bulletSet.clipRect(a,b,d,e);
        this.trendLinesSet.clipRect(a,b,d,e)
        },
    createValueAxes:function(){
        var a=[],b=[];
        this.xAxes=a;
        this.yAxes=b;
        for(var d=this.valueAxes,e=0;e<d.length;e++){
            var f=d[e],g=f.position;
            if("top"==g||"bottom"==g)f.rotate=!0;
            f.setOrientation(f.rotate);
            g=f.orientation;
            "V"==g&&b.push(f);
            "H"==
            g&&a.push(f)
            }
            0==b.length&&(f=new AmCharts.ValueAxis,f.rotate=!1,f.setOrientation(!1),d.push(f),b.push(f));
        0==a.length&&(f=new AmCharts.ValueAxis,f.rotate=!0,f.setOrientation(!0),d.push(f),a.push(f));
        for(e=0;e<d.length;e++)this.processValueAxis(d[e],e);
        a=this.graphs;
        for(e=0;e<a.length;e++)this.processGraph(a[e],e)
            },
    drawChart:function(){
        AmCharts.AmXYChart.base.drawChart.call(this);
        AmCharts.ifArray(this.chartData)?(this.chartScrollbar&&this.updateScrollbars(),this.zoomChart()):this.cleanChart();
        if(this.hideXScrollbar){
            var a=
            this.scrollbarH;
            a&&(this.removeListener(a,"zoomed",this.handleHSBZoom),a.destroy());
            this.scrollbarH=null
            }
            if(this.hideYScrollbar){
            if(a=this.scrollbarV)this.removeListener(a,"zoomed",this.handleVSBZoom),a.destroy();
            this.scrollbarV=null
            }
            this.dispDUpd();
        this.chartCreated=!0;
        this.zoomScrollbars()
        },
    cleanChart:function(){
        AmCharts.callMethod("destroy",[this.valueAxes,this.graphs,this.scrollbarV,this.scrollbarH,this.chartCursor])
        },
    zoomChart:function(){
        this.toggleZoomOutButton();
        this.zoomObjects(this.valueAxes);
        this.zoomObjects(this.graphs);
        this.zoomTrendLines();
        this.dispatchAxisZoom()
        },
    toggleZoomOutButton:function(){
        1==this.heightMultiplier&&1==this.widthMultiplier?this.showZB(!1):this.showZB(!0)
        },
    dispatchAxisZoom:function(){
        for(var a=this.valueAxes,b=0;b<a.length;b++){
            var d=a[b];
            if(!isNaN(d.min)&&!isNaN(d.max)){
                var e,f;
                "V"==d.orientation?(e=d.coordinateToValue(-this.verticalPosition),f=d.coordinateToValue(-this.verticalPosition+this.plotAreaHeight)):(e=d.coordinateToValue(-this.horizontalPosition),f=d.coordinateToValue(-this.horizontalPosition+
                    this.plotAreaWidth));
                if(!isNaN(e)&&!isNaN(f)){
                    if(e>f){
                        var g=f;
                        f=e;
                        e=g
                        }
                        d.dispatchZoomEvent(e,f)
                    }
                }
        }
    },
zoomObjects:function(a){
    for(var b=a.length,d=0;d<b;d++){
        var e=a[d];
        this.updateObjectSize(e);
        e.zoom(0,this.chartData.length-1)
        }
    },
updateData:function(){
    this.parseData();
    for(var a=this.chartData,b=a.length-1,d=this.graphs,e=this.dataProvider,f=0,g=0;g<d.length;g++){
        var h=d[g];
        h.data=a;
        h.zoom(0,b);
        if(h=h.valueField)for(var i=0;i<e.length;i++){
            var j=e[i][h];
            j>f&&(f=j)
            }
        }
        for(g=0;g<d.length;g++)h=d[g],h.maxValue=
    f;
if(a=this.chartCursor)a.updateData(),a.type="crosshair",a.valueBalloonsEnabled=!1
    },
zoomOut:function(){
    this.verticalPosition=this.horizontalPosition=0;
    this.heightMultiplier=this.widthMultiplier=1;
    this.zoomChart();
    this.zoomScrollbars()
    },
processValueAxis:function(a){
    a.chart=this;
    a.minMaxField="H"==a.orientation?"x":"y";
    a.minTemp=NaN;
    a.maxTemp=NaN;
    this.listenTo(a,"axisSelfZoomed",this.handleAxisSelfZoom)
    },
processGraph:function(a){
    a.xAxis||(a.xAxis=this.xAxes[0]);
    a.yAxis||(a.yAxis=this.yAxes[0])
    },
parseData:function(){
    AmCharts.AmXYChart.base.parseData.call(this);
    this.chartData=[];
    for(var a=this.dataProvider,b=this.valueAxes,d=this.graphs,e=0;e<a.length;e++){
        for(var f={
            axes:{},
            x:{},
            y:{}
        },g=a[e],h=0;h<b.length;h++){
            var i=b[h].id;
            f.axes[i]={};
            
            f.axes[i].graphs={};
            
            for(var j=0;j<d.length;j++){
                var k=d[j],l=k.id;
                if(k.xAxis.id==i||k.yAxis.id==i){
                    var m={};
                    
                    m.serialDataItem=f;
                    m.index=e;
                    var s={},p=Number(g[k.valueField]);
                    isNaN(p)||(s.value=p);
                    p=Number(g[k.xField]);
                    isNaN(p)||(s.x=p);
                    p=Number(g[k.yField]);
                    isNaN(p)||(s.y=p);
                    m.values=s;
                    this.processFields(k,m,g);
                    m.serialDataItem=
                    f;
                    m.graph=k;
                    f.axes[i].graphs[l]=m
                    }
                }
            }
        this.chartData[e]=f
}
},
formatString:function(a,b){
    var d=b.graph.numberFormatter;
    d||(d=this.numberFormatter);
    a=AmCharts.formatValue(a,b.values,["value","x","y"],d);
    -1!=a.indexOf("[[")&&(a=AmCharts.formatDataContextValue(a,b.dataContext));
    return a=AmCharts.AmSerialChart.base.formatString.call(this,a,b)
    },
addChartScrollbar:function(a){
    AmCharts.callMethod("destroy",[this.chartScrollbar,this.scrollbarH,this.scrollbarV]);
    if(a){
        this.chartScrollbar=a;
        this.scrollbarHeight=
        a.scrollbarHeight;
        var b="backgroundColor backgroundAlpha selectedBackgroundColor selectedBackgroundAlpha scrollDuration resizeEnabled hideResizeGrips scrollbarHeight updateOnReleaseOnly".split(" ");
        if(!this.hideYScrollbar){
            var d=new AmCharts.SimpleChartScrollbar;
            d.skipEvent=!0;
            d.chart=this;
            this.listenTo(d,"zoomed",this.handleVSBZoom);
            AmCharts.copyProperties(a,d,b);
            d.rotate=!0;
            this.scrollbarV=d
            }
            this.hideXScrollbar||(d=new AmCharts.SimpleChartScrollbar,d.skipEvent=!0,d.chart=this,this.listenTo(d,"zoomed",
            this.handleHSBZoom),AmCharts.copyProperties(a,d,b),d.rotate=!1,this.scrollbarH=d)
        }
    },
updateTrendLines:function(){
    for(var a=this.trendLines,b=0;b<a.length;b++){
        var d=a[b];
        d.chart=this;
        d.valueAxis||(d.valueAxis=this.yAxes[0]);
        d.valueAxisX||(d.valueAxisX=this.xAxes[0])
        }
    },
updateMargins:function(){
    AmCharts.AmXYChart.base.updateMargins.call(this);
    var a=this.scrollbarV;
    a&&(this.getScrollbarPosition(a,!0,this.yAxes[0].position),this.adjustMargins(a,!0));
    if(a=this.scrollbarH)this.getScrollbarPosition(a,!1,
        this.xAxes[0].position),this.adjustMargins(a,!1)
        },
updateScrollbars:function(){
    var a=this.scrollbarV;
    a&&(this.updateChartScrollbar(a,!0),a.draw());
    if(a=this.scrollbarH)this.updateChartScrollbar(a,!1),a.draw()
        },
zoomScrollbars:function(){
    var a=this.scrollbarH;
    a&&a.relativeZoom(this.widthMultiplier,-this.horizontalPosition/this.widthMultiplier);
    (a=this.scrollbarV)&&a.relativeZoom(this.heightMultiplier,-this.verticalPosition/this.heightMultiplier)
    },
fitMultiplier:function(a){
    a>this.maxZoomFactor&&(a=this.maxZoomFactor);
    return a
    },
handleHSBZoom:function(a){
    var b=this.fitMultiplier(a.multiplier),a=-a.position*b,d=-(this.plotAreaWidth*b-this.plotAreaWidth);
    a<d&&(a=d);
    this.widthMultiplier=b;
    this.horizontalPosition=a;
    this.zoomChart()
    },
handleVSBZoom:function(a){
    var b=this.fitMultiplier(a.multiplier),a=-a.position*b,d=-(this.plotAreaHeight*b-this.plotAreaHeight);
    a<d&&(a=d);
    this.heightMultiplier=b;
    this.verticalPosition=a;
    this.zoomChart()
    },
handleCursorZoom:function(a){
    var b=this.widthMultiplier*this.plotAreaWidth/a.selectionWidth,
    d=this.heightMultiplier*this.plotAreaHeight/a.selectionHeight,b=this.fitMultiplier(b),d=this.fitMultiplier(d);
    this.horizontalPosition=(this.horizontalPosition-a.selectionX)*b/this.widthMultiplier;
    this.verticalPosition=(this.verticalPosition-a.selectionY)*d/this.heightMultiplier;
    this.widthMultiplier=b;
    this.heightMultiplier=d;
    this.zoomChart();
    this.zoomScrollbars()
    },
handleAxisSelfZoom:function(a){
    if("H"==a.valueAxis.orientation){
        var b=this.fitMultiplier(a.multiplier),a=-a.position/this.widthMultiplier*
        b,d=-(this.plotAreaWidth*b-this.plotAreaWidth);
        a<d&&(a=d);
        this.horizontalPosition=a;
        this.widthMultiplier=b
        }else b=this.fitMultiplier(a.multiplier),a=-a.position/this.heightMultiplier*b,d=-(this.plotAreaHeight*b-this.plotAreaHeight),a<d&&(a=d),this.verticalPosition=a,this.heightMultiplier=b;
    this.zoomChart();
    this.zoomScrollbars()
    },
removeChartScrollbar:function(){
    AmCharts.callMethod("destroy",[this.scrollbarH,this.scrollbarV]);
    this.scrollbarV=this.scrollbarH=null
    },
handleReleaseOutside:function(a){
    AmCharts.AmXYChart.base.handleReleaseOutside.call(this,
        a);
    AmCharts.callMethod("handleReleaseOutside",[this.scrollbarH,this.scrollbarV])
    }
});
AmCharts.AmStockChart=AmCharts.Class({
    construct:function(){
        this.version="2.8.2";
        this.createEvents("zoomed","rollOverStockEvent","rollOutStockEvent","clickStockEvent","panelRemoved","dataUpdated");
        this.colors="#FF6600 #FCD202 #B0DE09 #0D8ECF #2A0CD0 #CD0D74 #CC0000 #00CC00 #0000CC #DDDDDD #999999 #333333 #990000".split(" ");
        this.firstDayOfWeek=1;
        this.glueToTheEnd=!1;
        this.dataSetCounter=-1;
        this.zoomOutOnDataSetChange=!1;
        this.panels=[];
        this.dataSets=[];
        this.chartCursors=[];
        this.comparedDataSets=[];
        this.categoryAxesSettings=
        new AmCharts.CategoryAxesSettings;
        this.valueAxesSettings=new AmCharts.ValueAxesSettings;
        this.panelsSettings=new AmCharts.PanelsSettings;
        this.chartScrollbarSettings=new AmCharts.ChartScrollbarSettings;
        this.chartCursorSettings=new AmCharts.ChartCursorSettings;
        this.stockEventsSettings=new AmCharts.StockEventsSettings;
        this.legendSettings=new AmCharts.LegendSettings;
        this.balloon=new AmCharts.AmBalloon;
        this.previousEndDate=new Date(0);
        this.previousStartDate=new Date(0);
        this.dataSetCount=this.graphCount=
        0
        },
    write:function(a){
        a="object"!=typeof a?document.getElementById(a):a;
        a.innerHTML="";
        this.div=a;
        this.measure();
        this.createLayout();
        this.updateDataSets();
        this.addDataSetSelector();
        this.addPeriodSelector();
        this.addPanels();
        this.addChartScrollbar();
        this.updatePanels();
        this.updateData();
        this.skipDefault||this.setDefaultPeriod()
        },
    setDefaultPeriod:function(a){
        var b=this.periodSelector;
        b&&(this.animationPlayed=!1,b.setDefaultPeriod(a))
        },
    updateDataSets:function(){
        var a=this.dataSets;
        !this.mainDataSet&&AmCharts.ifArray(a)&&
        (this.mainDataSet=this.dataSets[0]);
        for(var b=0;b<a.length;b++){
            var d=a[b];
            d.id||(this.dataSetCount++,d.id="ds"+this.dataSetCount);
            void 0==d.color&&(d.color=this.colors.length-1>b?this.colors[b]:AmCharts.randomColor())
            }
        },
updateEvents:function(){
    var a=this.mainDataSet;
    AmCharts.ifArray(a.stockEvents)&&AmCharts.parseEvents(a,this.panels,this.stockEventsSettings,this.firstDayOfWeek,this)
    },
updateData:function(){
    var a=this.mainDataSet;
    if(a){
        var b=this.categoryAxesSettings;
        -1==AmCharts.getItemIndex(b.minPeriod,
            b.groupToPeriods)&&b.groupToPeriods.unshift(b.minPeriod);
        var d=a.dataProvider;
        if(AmCharts.ifArray(d)){
            var e=a.categoryField;
            this.firstDate=new Date(d[0][e]);
            this.lastDate=new Date(d[d.length-1][e]);
            this.periodSelector&&this.periodSelector.setRanges(this.firstDate,this.lastDate);
            a.dataParsed||(AmCharts.parseStockData(a,b.minPeriod,b.groupToPeriods,this.firstDayOfWeek),a.dataParsed=!0);
            this.updateComparingData();
            this.updateEvents()
            }else this.lastDate=this.firstDate=void 0;
        this.glueToTheEnd&&(this.startDate&&
            this.endDate&&this.lastDate)&&(AmCharts.getPeriodDuration(b.minPeriod),this.startDate=new Date(this.startDate.getTime()+(this.lastDate.getTime()-this.endDate.getTime())),this.endDate=this.lastDate,this.updateScrollbar=!0);
        this.updatePanelsWithNewData()
        }
        a={
        type:"dataUpdated",
        chart:this
    };
    
    this.fire(a.type,a)
    },
updateComparingData:function(){
    for(var a=this.comparedDataSets,b=this.categoryAxesSettings,d=0;d<a.length;d++){
        var e=a[d];
        e.dataParsed||(AmCharts.parseStockData(e,b.minPeriod,b.groupToPeriods,this.firstDayOfWeek),
            e.dataParsed=!0)
        }
    },
createLayout:function(){
    var a=this.div,b,d,e=this.periodSelector;
    e&&(b=e.position);
    if(e=this.dataSetSelector)d=e.position;
    if("left"==b||"left"==d)e=document.createElement("div"),e.style.cssFloat="left",e.style.styleFloat="left",e.style.width="0px",e.style.position="absolute",a.appendChild(e),this.leftContainer=e;
    if("right"==b||"right"==d)b=document.createElement("div"),b.style.cssFloat="right",b.style.styleFloat="right",b.style.width="0px",a.appendChild(b),this.rightContainer=b;
    b=document.createElement("div");
    a.appendChild(b);
    this.centerContainer=b;
    a=document.createElement("div");
    b.appendChild(a);
    this.panelsContainer=a
    },
addPanels:function(){
    var a=this.chartScrollbarSettings,b=this.divRealHeight,d=this.panelsSettings.panelSpacing;
    a.enabled&&(b-=a.height);
    if((a=this.periodSelector)&&!a.vertical)a=a.offsetHeight,b-=a+d;
    if((a=this.dataSetSelector)&&!a.vertical)a=a.offsetHeight,b-=a+d;
    a=this.panels;
    this.panelsContainer.style.height=b+"px";
    this.chartCursors=[];
    for(var e=0,f=0;f<
        a.length;f++){
        var g=a[f],h=g.percentHeight;
        isNaN(h)&&(h=100/a.length,g.percentHeight=h);
        e+=h
        }
        for(f=0;f<a.length;f++)g=a[f],g.percentHeight=100*(g.percentHeight/e);
    this.panelsHeight=b-d*(a.length-1);
    for(f=0;f<a.length;f++)this.addStockPanel(a[f],f);
    this.panelsAdded=!0
    },
addStockPanel:function(a,b){
    var d=this.panelsSettings,e=document.createElement("div");
    0<b&&!this.panels[b-1].showCategoryAxis&&(e.style.marginTop=d.panelSpacing+"px");
    a.panelBox=e;
    a.stockChart=this;
    a.id||(a.id="stockPanel"+b);
    a.pathToImages=
    this.pathToImages;
    e.style.height=Math.round(a.percentHeight*this.panelsHeight/100)+"px";
    e.style.width="100%";
    this.panelsContainer.appendChild(e);
    0<d.backgroundAlpha&&(e.style.backgroundColor=d.backgroundColor);
    if(e=a.stockLegend)e.container=void 0,e.title=a.title,e.marginLeft=d.marginLeft,e.marginRight=d.marginRight,e.verticalGap=3,e.position="top",AmCharts.copyProperties(this.legendSettings,e),a.addLegend(e);
    a.zoomOutText="";
    a.removeChartCursor();
    this.addCursor(a)
    },
enableCursors:function(a){
    for(var b=
        this.chartCursors,d=0;d<b.length;d++)b[d].enabled=a
    },
updatePanels:function(){
    for(var a=this.panels,b=0;b<a.length;b++)this.updatePanel(a[b]);
    this.mainDataSet&&this.updateGraphs();
    this.currentPeriod=void 0
    },
updatePanel:function(a){
    a.seriesIdField="amCategoryIdField";
    a.dataProvider=[];
    a.chartData=[];
    a.graphs=[];
    var b=a.categoryAxis,d=this.categoryAxesSettings;
    AmCharts.copyProperties(this.panelsSettings,a);
    AmCharts.copyProperties(d,b);
    b.parseDates=!0;
    a.zoomOutOnDataUpdate=!1;
    a.showCategoryAxis?"top"==
    b.position?a.marginTop=d.axisHeight:a.marginBottom=d.axisHeight:(a.categoryAxis.labelsEnabled=!1,a.chartCursor&&(a.chartCursor.categoryBalloonEnabled=!1));
    var d=a.valueAxes,e=d.length,f;
    0==e&&(f=new AmCharts.ValueAxis,a.addValueAxis(f));
    b=new AmCharts.AmBalloon;
    AmCharts.copyProperties(this.balloon,b);
    a.balloon=b;
    d=a.valueAxes;
    e=d.length;
    for(b=0;b<e;b++)f=d[b],AmCharts.copyProperties(this.valueAxesSettings,f);
    a.listenersAdded=!1;
    a.write(a.panelBox)
    },
zoom:function(a,b){
    this.zoomChart(a,b)
    },
zoomOut:function(){
    this.zoomChart(this.firstDate,
        this.lastDate)
    },
updatePanelsWithNewData:function(){
    var a=this.mainDataSet;
    if(a){
        var b=this.panels;
        this.currentPeriod=void 0;
        for(var d=0;d<b.length;d++){
            var e=b[d];
            e.categoryField=a.categoryField;
            0==a.dataProvider.length&&(e.dataProvider=[])
            }
            if(b=this.scrollbarChart){
            d=this.categoryAxesSettings;
            e=d.minPeriod;
            b.categoryField=a.categoryField;
            b.dataProvider=0<a.dataProvider.length?a.agregatedDataProviders[e]:[];
            var f=b.categoryAxis;
            f.minPeriod=e;
            f.firstDayOfWeek=this.firstDayOfWeek;
            f.equalSpacing=d.equalSpacing;
            b.validateData()
            }
            0<a.dataProvider.length&&this.zoomChart(this.startDate,this.endDate)
        }
        this.panelDataInvalidated=!1
    },
addChartScrollbar:function(){
    var a=this.chartScrollbarSettings,b=this.scrollbarChart;
    b&&(b.clear(),b.destroy());
    if(a.enabled){
        var d=this.panelsSettings,e=this.categoryAxesSettings,b=new AmCharts.AmSerialChart;
        b.pathToImages=this.pathToImages;
        b.autoMargins=!1;
        this.scrollbarChart=b;
        b.id="scrollbarChart";
        b.scrollbarOnly=!0;
        b.zoomOutText="";
        b.panEventsEnabled=this.panelsSettings.panEventsEnabled;
        b.marginLeft=d.marginLeft;
        b.marginRight=d.marginRight;
        b.marginTop=0;
        b.marginBottom=0;
        var d=e.dateFormats,f=b.categoryAxis;
        f.boldPeriodBeginning=e.boldPeriodBeginning;
        d&&(f.dateFormats=e.dateFormats);
        f.labelsEnabled=!1;
        f.parseDates=!0;
        if(e=a.graph){
            var g=new AmCharts.AmGraph;
            g.valueField=e.valueField;
            g.periodValue=e.periodValue;
            g.type=e.type;
            g.connect=e.connect;
            b.addGraph(g)
            }
            e=new AmCharts.ChartScrollbar;
        b.addChartScrollbar(e);
        AmCharts.copyProperties(a,e);
        e.scrollbarHeight=a.height;
        e.graph=g;
        this.removeListener(e,
            "zoomed",this.handleScrollbarZoom);
        this.listenTo(e,"zoomed",this.handleScrollbarZoom);
        g=document.createElement("div");
        g.style.height=a.height+"px";
        a=this.periodSelectorContainer;
        (e=this.periodSelector)?"bottom"==e.position?this.centerContainer.insertBefore(g,a):this.centerContainer.appendChild(g):this.centerContainer.appendChild(g);
        b.write(g)
        }
    },
handleScrollbarZoom:function(a){
    if(this.skipScrollbarEvent)this.skipScrollbarEvent=!1;
    else{
        var b=a.endDate,d={};
        
        d.startDate=a.startDate;
        d.endDate=b;
        this.updateScrollbar=
        !1;
        this.handleZoom(d)
        }
    },
addPeriodSelector:function(){
    var a=this.periodSelector;
    if(a){
        var b=this.categoryAxesSettings.minPeriod;
        a.minDuration=AmCharts.getPeriodDuration(b);
        a.minPeriod=b;
        a.chart=this;
        if(b=this.dataSetSelector)var d=b.position,e=this.dssContainer;
        var b=this.panelsSettings.panelSpacing,f=document.createElement("div");
        this.periodSelectorContainer=f;
        var g=this.leftContainer,h=this.rightContainer,i=this.centerContainer,j=this.panelsContainer,k=a.width+2*b+"px";
        switch(a.position){
            case "left":
                g.style.width=
                a.width+"px";
                g.appendChild(f);
                i.style.paddingLeft=k;
                break;
            case "right":
                i.style.marginRight=k;
                h.appendChild(f);
                h.style.width=a.width+"px";
                break;
            case "top":
                j.style.clear="both";
                "top"==d?i.insertAfter(f,e):i.insertBefore(f,j);
                f.style.paddingBottom=b+"px";
                break;
            case "bottom":
                f.style.marginTop=b+"px","bottom"==d?i.insertBefore(f,e):i.appendChild(f)
                }
                this.removeListener(a,"changed",this.handlePeriodSelectorZoom);
        this.listenTo(a,"changed",this.handlePeriodSelectorZoom);
        a.write(f)
        }
    },
addDataSetSelector:function(){
    var a=
    this.dataSetSelector;
    if(a){
        a.chart=this;
        a.dataProvider=this.dataSets;
        var b=a.position,d=this.panelsSettings.panelSpacing,e=document.createElement("div");
        this.dssContainer=e;
        var f=this.leftContainer,g=this.rightContainer,h=this.centerContainer,i=this.panelsContainer,d=a.width+2*d+"px";
        switch(b){
            case "left":
                f.style.width=a.width+"px";
                f.appendChild(e);
                h.style.paddingLeft=d;
                break;
            case "right":
                h.style.marginRight=d;
                g.appendChild(e);
                g.style.width=a.width+"px";
                break;
            case "top":
                i.style.clear="both";
                h.insertBefore(e,
                i);
            break;
            case "bottom":
                h.appendChild(e)
                }
                a.write(e)
        }
    },
handlePeriodSelectorZoom:function(a){
    var b=this.scrollbarChart;
    b&&(b.updateScrollbar=!0);
    a.predefinedPeriod?(this.predefinedStart=a.startDate,this.predefinedEnd=a.endDate):this.predefinedEnd=this.predefinedStart=null;
    this.zoomChart(a.startDate,a.endDate)
    },
addCursor:function(a){
    var b=this.chartCursorSettings;
    if(b.enabled){
        var d=new AmCharts.ChartCursor;
        AmCharts.copyProperties(b,d);
        a.removeChartCursor();
        a.addChartCursor(d);
        this.removeListener(d,"changed",
            this.handleCursorChange);
        this.removeListener(d,"onHideCursor",this.hideChartCursor);
        this.removeListener(d,"zoomed",this.handleCursorZoom);
        this.listenTo(d,"changed",this.handleCursorChange);
        this.listenTo(d,"onHideCursor",this.hideChartCursor);
        this.listenTo(d,"zoomed",this.handleCursorZoom);
        this.chartCursors.push(d)
        }
    },
hideChartCursor:function(){
    for(var a=this.chartCursors,b=0;b<a.length;b++){
        var d=a[b];
        d.hideCursor(!1);
        (d=d.chart)&&d.updateLegendValues()
        }
    },
handleCursorZoom:function(a){
    var b=this.scrollbarChart;
    b&&(b.updateScrollbar=!0);
    var b={},d;
    if(this.categoryAxesSettings.equalSpacing){
        var e=this.mainDataSet.categoryField,f=this.mainDataSet.agregatedDataProviders[this.currentPeriod];
        d=new Date(f[a.start][e]);
        a=new Date(f[a.end][e])
        }else d=new Date(a.start),a=new Date(a.end);
    b.startDate=d;
    b.endDate=a;
    this.handleZoom(b)
    },
handleZoom:function(a){
    this.zoomChart(a.startDate,a.endDate)
    },
zoomChart:function(a,b){
    var d=this,e=d.firstDate,f=d.lastDate,g=d.currentPeriod,h=d.categoryAxesSettings,i=h.minPeriod,j=
    d.panelsSettings,k=d.periodSelector,l=d.panels,m=d.comparedGraphs,s=d.scrollbarChart;
    if(e&&f){
        a||(a=e);
        b||(b=f);
        if(g){
            var p=AmCharts.extractPeriod(g);
            a.getTime()==b.getTime()&&p!=i&&(b=AmCharts.changeDate(b,p.period,p.count))
            }
            a.getTime()<e.getTime()&&(a=e);
        a.getTime()>f.getTime()&&(a=f);
        b.getTime()<e.getTime()&&(b=e);
        b.getTime()>f.getTime()&&(b=f);
        h=AmCharts.getItemIndex(i,h.groupToPeriods);
        f=g;
        g=d.choosePeriod(h,a,b);
        d.currentPeriod=g;
        h=AmCharts.extractPeriod(g);
        AmCharts.getPeriodDuration(h.period,
            h.count);
        i=AmCharts.getPeriodDuration(i);
        b.getTime()-a.getTime()<i&&(a=new Date(b.getTime()-i));
        i=d.firstDayOfWeek;
        p=new Date(a);
        p.getTime()==e.getTime()&&(p=AmCharts.resetDateToMin(a,h.period,h.count,i));
        for(e=0;e<l.length;e++){
            var q=l[e];
            if(g!=f){
                for(var n=0;n<m.length;n++){
                    var r=m[n].graph;
                    r.dataProvider=r.dataSet.agregatedDataProviders[g]
                    }
                    n=q.categoryAxis;
                n.firstDayOfWeek=i;
                n.minPeriod=g;
                q.dataProvider=d.mainDataSet.agregatedDataProviders[g];
                if(n=q.chartCursor)n.categoryBalloonDateFormat=d.chartCursorSettings.categoryBalloonDateFormat(h.period),
                    q.showCategoryAxis||(n.categoryBalloonEnabled=!1);
                q.startTime=p.getTime();
                q.endTime=b.getTime();
                q.validateData(!0)
                }
                n=!1;
            q.chartCursor&&q.chartCursor.panning&&(n=!0);
            n||(q.startTime=void 0,q.endTime=void 0,q.zoomToDates(p,b));
            0<j.startDuration&&d.animationPlayed?q.startDuration=0:0<j.startDuration&&(q.animateAgain(),q.validateNow(),d.animationPlayed=!0)
            }
            j=AmCharts.extractPeriod(g);
        j=AmCharts.changeDate(new Date(b),j.period,j.count);
        s&&d.updateScrollbar&&(s.zoomToDates(a,j),d.skipScrollbarEvent=!0,
            setTimeout(function(){
                d.resetSkip.call(d)
                },100));
        d.updateScrollbar=!0;
        d.startDate=a;
        d.endDate=b;
        k&&k.zoom(a,b);
        if(a.getTime()!=d.previousStartDate.getTime()||b.getTime()!=d.previousEndDate.getTime())k={
            type:"zoomed"
        },k.startDate=a,k.endDate=b,k.chart=d,k.period=g,d.fire(k.type,k),d.previousStartDate=new Date(a),d.previousEndDate=new Date(b)
            }
            d.animationPlayed=!0
    },
resetSkip:function(){
    this.skipScrollbarEvent=!1
    },
updateGraphs:function(){
    this.getSelections();
    if(0<this.dataSets.length){
        var a=this.panels;
        this.comparedGraphs=[];
        for(var b=0;b<a.length;b++){
            for(var d=a[b],e=d.valueAxes,f=0;f<e.length;f++)e[f].recalculateToPercents="always"==d.recalculateToPercents?!0:!1;
            var e=this.mainDataSet,f=this.comparedDataSets,g=d.stockGraphs;
            d.graphs=[];
            for(var h=0;h<g.length;h++){
                var i=g[h];
                if(!i.title||i.resetTitleOnDataSetChange)i.title=e.title,i.resetTitleOnDataSetChange=!0;
                i.useDataSetColors&&(i.lineColor=e.color,i.fillColors=void 0,i.bulletColor=void 0);
                d.addGraph(i);
                var j=!1;
                "always"==d.recalculateToPercents&&
                (j=!0);
                var k=d.stockLegend,l,m;
                k&&(l=k.valueTextComparing,m=k.valueTextRegular);
                if(i.comparable){
                    var s=f.length;
                    0<s&&"whenComparing"==d.recalculateToPercents&&(i.valueAxis.recalculateToPercents=!0);
                    k&&i.valueAxis&&!0==i.valueAxis.recalculateToPercents&&(j=!0);
                    for(var p=0;p<s;p++){
                        var q=f[p],n=i.comparedGraphs[q.id];
                        n||(n=new AmCharts.AmGraph,n.id="comparedGraph"+p+"_"+q.id);
                        n.periodValue=i.periodValue;
                        n.dataSet=q;
                        i.comparedGraphs[q.id]=n;
                        n.seriesIdField="amCategoryIdField";
                        n.connect=i.connect;
                        var r=
                        i.compareField;
                        r||(r=i.valueField);
                        for(var t=!1,u=q.fieldMappings,w=0;w<u.length;w++)u[w].toField==r&&(t=!0);
                        if(t){
                            n.valueField=r;
                            n.title=q.title;
                            n.lineColor=q.color;
                            i.compareGraphType&&(n.type=i.compareGraphType);
                            r=i.compareGraphLineThickness;
                            isNaN(r)||(n.lineThickness=r);
                            r=i.compareGraphDashLength;
                            isNaN(r)||(n.dashLength=r);
                            r=i.compareGraphLineAlpha;
                            isNaN(r)||(n.lineAlpha=r);
                            r=i.compareGraphCornerRadiusTop;
                            isNaN(r)||(n.cornerRadiusTop=r);
                            r=i.compareGraphCornerRadiusBottom;
                            isNaN(r)||(n.cornerRadiusBottom=
                                r);
                            r=i.compareGraphBalloonColor;
                            isNaN(r)||(n.balloonColor=r);
                            if(r=i.compareGraphFillColors)n.fillColors=r;
                            if(r=i.compareGraphNegativeFillColors)n.negativeFillColors=r;
                            if(r=i.compareGraphFillAlphas)n.fillAlphas=r;
                            if(r=i.compareGraphNegativeFillAlphas)n.fillAlphas=r;
                            if(r=i.compareGraphNegativeFillAlphas)n.negativeFillAlphas=r;
                            if(r=i.compareGraphBullet)n.bullet=r;
                            if(r=i.compareGraphNumberFormatter)n.numberFormatter=r;
                            if(r=i.compareGraphBalloonText)n.balloonText=r;
                            r=i.compareGraphBulletSize;
                            isNaN(r)||
                            (n.bulletSize=r);
                            r=i.compareGraphBulletAlpha;
                            isNaN(r)||(n.bulletAlpha=r);
                            n.visibleInLegend=i.compareGraphVisibleInLegend;
                            n.valueAxis=i.valueAxis;
                            k&&(j&&l?n.legendValueText=l:m&&(n.legendValueText=m));
                            d.addGraph(n);
                            this.comparedGraphs.push({
                                graph:n,
                                dataSet:q
                            })
                            }
                        }
                    }
                k&&(j&&l?i.legendValueText=l:m&&(i.legendValueText=m))
            }
        }
    }
},
choosePeriod:function(a,b,d){
    var e=this.categoryAxesSettings,f=e.groupToPeriods,g=f[a],f=f[a+1],h=AmCharts.extractPeriod(g),h=AmCharts.getPeriodDuration(h.period,h.count),i=b.getTime(),
    j=d.getTime(),e=e.maxSeries;
    return(j-i)/h>e&&0<e&&f?this.choosePeriod(a+1,b,d):g
    },
handleCursorChange:function(a){
    for(var b=a.target,d=a.position,a=a.zooming,e=this.chartCursors,f=0;f<e.length;f++){
        var g=e[f];
        g!=b&&d&&(g.isZooming(a),g.previousMousePosition=NaN,g.forceShow=!0,g.setPosition(d,!1))
        }
    },
getSelections:function(){
    for(var a=[],b=this.dataSets,d=0;d<b.length;d++){
        var e=b[d];
        e.compared&&a.push(e)
        }
        this.comparedDataSets=a;
    b=this.panels;
    for(d=0;d<b.length;d++)e=b[d],"never"!=e.recalculateToPercents&&
        0<a.length?e.hideDrawingIcons(!0):e.drawingIconsEnabled&&e.hideDrawingIcons(!1)
        },
addPanel:function(a){
    this.panels.push(a)
    },
addPanelAt:function(a,b){
    this.panels.splice(b,0,a)
    },
removePanel:function(a){
    for(var b=this.panels,d=b.length-1;0<=d;d--)if(b[d]==a){
        var e={
            type:"panelRemoved",
            panel:a,
            chart:this
        };
        
        this.fire(e.type,e);
        b.splice(d,1);
        a.destroy();
        a.clear()
        }
    },
validateData:function(){
    this.resetDataParsed();
    this.updateDataSets();
    this.mainDataSet.compared=!1;
    this.updateGraphs();
    this.updateData();
    var a=
    this.dataSetSelector;
    a&&a.write(a.div)
    },
resetDataParsed:function(){
    for(var a=this.dataSets,b=0;b<a.length;b++)a[b].dataParsed=!1
        },
validateNow:function(){
    this.skipDefault=!0;
    this.clear();
    this.write(this.div)
    },
hideStockEvents:function(){
    this.showHideEvents(!1)
    },
showStockEvents:function(){
    this.showHideEvents(!0)
    },
showHideEvents:function(a){
    for(var b=this.panels,d=0;d<b.length;d++)for(var e=b[d].graphs,f=0;f<e.length;f++){
        var g=e[f];
        !0==a?g.showBullets():g.hideBullets()
        }
    },
measure:function(){
    var a=this.div,
    b=a.offsetWidth,d=a.offsetHeight;
    a.clientHeight&&(b=a.clientWidth,d=a.clientHeight);
    this.divRealWidth=b;
    this.divRealHeight=d
    },
clear:function(){
    for(var a=this.panels,b=0;b<a.length;b++)a[b].clear(!0);
    (a=this.scrollbarChart)&&a.clear();
    this.div.innerHTML=""
    }
});
AmCharts.StockEvent=AmCharts.Class({
    construct:function(){}
});
AmCharts.DataSet=AmCharts.Class({
    construct:function(){
        this.fieldMappings=[];
        this.dataProvider=[];
        this.agregatedDataProviders=[];
        this.stockEvents=[];
        this.compared=!1;
        this.showInCompare=this.showInSelect=!0
        }
    });
AmCharts.PeriodSelector=AmCharts.Class({
    construct:function(){
        this.createEvents("changed");
        this.inputFieldsEnabled=!0;
        this.position="bottom";
        this.width=180;
        this.fromText="From: ";
        this.toText="to: ";
        this.periodsText="Zoom: ";
        this.periods=[];
        this.inputFieldWidth=100;
        this.dateFormat="DD-MM-YYYY";
        this.hideOutOfScopePeriods=!0
        },
    zoom:function(a,b){
        this.inputFieldsEnabled&&(this.startDateField.value=AmCharts.formatDate(a,this.dateFormat),this.endDateField.value=AmCharts.formatDate(b,this.dateFormat));
        this.markButtonAsSelected()
        },
    write:function(a){
        var b=this;
        a.className="amChartsPeriodSelector";
        b.div=a;
        a.innerHTML="";
        var d=b.position,d="top"==d||"bottom"==d?!1:!0;
        b.vertical=d;
        var e=0,f=0;
        if(b.inputFieldsEnabled){
            var g=document.createElement("div");
            a.appendChild(g);
            var h=document.createTextNode(b.fromText);
            g.appendChild(h);
            d?AmCharts.addBr(g):(g.style.styleFloat="left",g.style.display="inline");
            var i=document.createElement("input");
            i.className="amChartsInputField";
            i.style.textAlign="center";
            AmCharts.isNN&&i.addEventListener("keypress",
                function(a){
                    b.handleCalendarChange.call(b,a)
                    },!0);
            AmCharts.isIE&&i.attachEvent("onkeypress",function(a){
                b.handleCalendarChange.call(b,a)
                });
            g.appendChild(i);
            b.startDateField=i;
            if(d)h=b.width-6+"px",AmCharts.addBr(g);
            else{
                var h=b.inputFieldWidth+"px",j=document.createTextNode(" ");
                g.appendChild(j)
                }
                i.style.width=h;
            i=document.createTextNode(b.toText);
            g.appendChild(i);
            d&&AmCharts.addBr(g);
            i=document.createElement("input");
            i.className="amChartsInputField";
            i.style.textAlign="center";
            AmCharts.isNN&&i.addEventListener("keypress",
                function(a){
                    b.handleCalendarChange.call(b,a)
                    },!0);
            AmCharts.isIE&&i.attachEvent("onkeypress",function(a){
                b.handleCalendarChange.call(b,a)
                });
            g.appendChild(i);
            b.endDateField=i;
            d?AmCharts.addBr(g):e=i.offsetHeight+2;
            h&&(i.style.width=h)
            }
            g=b.periods;
        if(AmCharts.ifArray(g)){
            h=document.createElement("div");
            d||(h.style.cssFloat="right",h.style.styleFloat="right",h.style.display="inline");
            a.appendChild(h);
            d&&AmCharts.addBr(h);
            a=document.createTextNode(b.periodsText);
            h.appendChild(a);
            b.periodContainer=h;
            for(a=
                0;a<g.length;a++){
                var i=g[a],k=document.createElement("input");
                k.type="button";
                k.value=i.label;
                k.period=i.period;
                k.count=i.count;
                k.periodObj=i;
                k.className="amChartsButton";
                d&&(k.style.width=b.width-1+"px");
                h.appendChild(k);
                AmCharts.isNN&&k.addEventListener("click",function(a){
                    b.handlePeriodChange.call(b,a)
                    },!0);
                AmCharts.isIE&&k.attachEvent("onclick",function(a){
                    b.handlePeriodChange.call(b,a)
                    });
                i.button=k
                }
                d||(f=k.offsetHeight);
            b.offsetHeight=Math.max(e,f)
            }
        },
getPeriodDates:function(){
    for(var a=this.periods,
        b=0;b<a.length;b++)this.selectPeriodButton(a[b],!0)
        },
handleCalendarChange:function(a){
    if(13==a.keyCode){
        var b=this.dateFormat,a=AmCharts.stringToDate(this.startDateField.value,b),b=AmCharts.stringToDate(this.endDateField.value,b);
        try{
            this.startDateField.blur(),this.endDateField.blur()
            }catch(d){}
        if(a&&b){
            var e={
                type:"changed"
            };
            
            e.startDate=a;
            e.endDate=b;
            e.chart=this.chart;
            this.fire(e.type,e)
            }
        }
},
handlePeriodChange:function(a){
    this.selectPeriodButton((a.srcElement?a.srcElement:a.target).periodObj)
    },
setRanges:function(a,
    b){
    this.firstDate=a;
    this.lastDate=b;
    this.getPeriodDates()
    },
selectPeriodButton:function(a,b){
    var d=a.button,e=d.count,f=d.period,g,h,i=this.firstDate,j=this.lastDate;
    if(i&&j){
        if("MAX"==f)g=i,h=j;
        else if("YTD"==f)g=new Date,g.setMonth(0,1),g.setHours(0,0,0,0),0==e&&g.setDate(g.getDate()-1),h=this.lastDate;
        else{
            var k=AmCharts.getPeriodDuration(f,e);
            this.selectFromStart?(g=i,h=new Date(i.getTime()+k)):(g=new Date(j.getTime()-k),h=j)
            }
            a.startTime=g.getTime();
        if(this.hideOutOfScopePeriods&&b&&a.startTime<
            i.getTime())try{
            this.periodContainer.removeChild(d)
            }catch(l){}
            g.getTime()>j.getTime()&&(k=AmCharts.getPeriodDuration("DD",1),g=new Date(j.getTime()-k));
        g.getTime()<i.getTime()&&(g=i);
        "YTD"==f&&(a.startTime=g.getTime());
        a.endTime=h.getTime();
        b||(this.skipMark=!0,this.unselectButtons(),d.className="amChartsButtonSelected",d={
            type:"changed"
        },d.startDate=g,d.endDate=h,d.predefinedPeriod=f,d.chart=this.chart,d.count=e,this.fire(d.type,d))
        }
    },
markButtonAsSelected:function(){
    if(!this.skipMark){
        var a=this.chart,
        b=this.periods,d=a.startDate.getTime(),a=a.endDate.getTime();
        this.unselectButtons();
        for(var e=b.length-1;0<=e;e--){
            var f=b[e],g=f.button;
            f.startTime&&f.endTime&&(d==f.startTime&&a==f.endTime)&&(this.unselectButtons(),g.className="amChartsButtonSelected")
            }
        }
        this.skipMark=!1
},
unselectButtons:function(){
    for(var a=this.periods,b=a.length-1;0<=b;b--)a[b].button.className="amChartsButton"
        },
setDefaultPeriod:function(){
    for(var a=this.periods,b=0;b<a.length;b++){
        var d=a[b];
        d.selected&&this.selectPeriodButton(d)
        }
    }
});
AmCharts.StockGraph=AmCharts.Class({
    inherits:AmCharts.AmGraph,
    construct:function(){
        AmCharts.StockGraph.base.construct.call(this);
        this.useDataSetColors=!0;
        this.periodValue="Close";
        this.compareGraphType="line";
        this.compareGraphVisibleInLegend=!0;
        this.comparedGraphs={};
        
        this.comparable=this.resetTitleOnDataSetChange=!1;
        this.comparedGraphs={}
    }
});
AmCharts.StockPanel=AmCharts.Class({
    inherits:AmCharts.AmSerialChart,
    construct:function(){
        AmCharts.StockPanel.base.construct.call(this);
        this.showCategoryAxis=!0;
        this.recalculateToPercents="whenComparing";
        this.panelHeaderPaddingBottom=this.panelHeaderPaddingLeft=this.panelHeaderPaddingRight=this.panelHeaderPaddingTop=0;
        this.trendLineAlpha=1;
        this.trendLineColor="#00CC00";
        this.trendLineColorHover="#CC0000";
        this.trendLineThickness=2;
        this.trendLineDashLength=0;
        this.stockGraphs=[];
        this.drawingIconsEnabled=
        !1;
        this.iconSize=18;
        this.autoMargins=this.allowTurningOff=this.eraseAll=this.erasingEnabled=this.drawingEnabled=!1
        },
    initChart:function(a){
        AmCharts.StockPanel.base.initChart.call(this,a);
        this.drawingIconsEnabled&&this.createDrawIcons();
        if(a=this.chartCursor)this.removeListener(a,"draw",this.handleDraw),this.listenTo(a,"draw",this.handleDraw)
            },
    addStockGraph:function(a){
        this.stockGraphs.push(a);
        return a
        },
    removeStockGraph:function(a){
        for(var b=this.stockGraphs,d=b.length-1;0<=d;d--)b[d]==a&&b.splice(d,
            1)
        },
    createDrawIcons:function(){
        var a=this,b=a.iconSize,d=a.container,e=a.pathToImages,f=a.realWidth-2*b-1-a.marginRight,g=AmCharts.rect(d,b,b,"#000",0.005),h=AmCharts.rect(d,b,b,"#000",0.005);
        h.translate(b+1,0);
        var i=d.image(e+"pencilIcon.gif",0,0,b,b);
        a.pencilButton=i;
        h.setAttr("cursor","pointer");
        g.setAttr("cursor","pointer");
        g.mouseup(function(){
            a.handlePencilClick()
            });
        var j=d.image(e+"pencilIconH.gif",0,0,b,b);
        a.pencilButtonPushed=j;
        a.drawingEnabled||j.hide();
        var k=d.image(e+"eraserIcon.gif",
            b+1,0,b,b);
        a.eraserButton=k;
        h.mouseup(function(){
            a.handleEraserClick()
            });
        g.touchend&&(g.touchend(function(){
            a.handlePencilClick()
            }),h.touchend(function(){
            a.handleEraserClick()
            }));
        b=d.image(e+"eraserIconH.gif",b+1,0,b,b);
        a.eraserButtonPushed=b;
        a.erasingEnabled||b.hide();
        d=d.set([i,j,k,b,g,h]);
        d.translate(f,1);
        this.hideIcons&&d.hide()
        },
    handlePencilClick:function(){
        var a=!this.drawingEnabled;
        this.disableDrawing(!a);
        this.erasingEnabled=!1;
        this.eraserButtonPushed.hide();
        a?this.pencilButtonPushed.show():
        (this.pencilButtonPushed.hide(),this.setMouseCursor("auto"))
        },
    disableDrawing:function(a){
        this.drawingEnabled=!a;
        var b=this.chartCursor;
        this.stockChart.enableCursors(a);
        b&&b.enableDrawing(!a)
        },
    handleEraserClick:function(){
        this.disableDrawing(!0);
        this.pencilButtonPushed.hide();
        if(this.eraseAll){
            for(var a=this.trendLines,b=a.length-1;0<=b;b--){
                var d=a[b];
                d.isProtected||this.removeTrendLine(d)
                }
                this.validateNow()
            }else(this.erasingEnabled=a=!this.erasingEnabled)?(this.eraserButtonPushed.show(),this.setTrendColorHover(this.trendLineColorHover),
            this.setMouseCursor("auto")):(this.eraserButtonPushed.hide(),this.setTrendColorHover())
            },
    setTrendColorHover:function(a){
        for(var b=this.trendLines,d=b.length-1;0<=d;d--){
            var e=b[d];
            e.isProtected||(e.rollOverColor=a)
            }
        },
handleDraw:function(a){
    var b=this.drawOnAxis;
    b||(b=this.valueAxes[0]);
    var d=this.categoryAxis,e=a.initialX,f=a.finalX,g=a.initialY,a=a.finalY,h=new AmCharts.TrendLine;
    h.initialDate=d.coordinateToDate(e);
    h.finalDate=d.coordinateToDate(f);
    h.initialValue=b.coordinateToValue(g);
    h.finalValue=
    b.coordinateToValue(a);
    h.lineAlpha=this.trendLineAlpha;
    h.lineColor=this.trendLineColor;
    h.lineThickness=this.trendLineThickness;
    h.dashLength=this.trendLineDashLength;
    h.valueAxis=b;
    h.categoryAxis=d;
    this.addTrendLine(h);
    this.listenTo(h,"click",this.handleTrendClick);
    this.validateNow()
    },
hideDrawingIcons:function(a){
    (this.hideIcons=a)&&this.disableDrawing(a)
    },
handleTrendClick:function(a){
    this.erasingEnabled&&(a=a.trendLine,!this.eraseAll&&!a.isProtected&&this.removeTrendLine(a),this.validateNow())
    }
});
AmCharts.CategoryAxesSettings=AmCharts.Class({
    construct:function(){
        this.minPeriod="DD";
        this.equalSpacing=!1;
        this.axisHeight=28;
        this.tickLength=this.axisAlpha=0;
        this.gridCount=10;
        this.maxSeries=150;
        this.groupToPeriods="ss 10ss 30ss mm 10mm 30mm hh DD WW MM YYYY".split(" ");
        this.autoGridCount=!0
        }
    });
AmCharts.ChartCursorSettings=AmCharts.Class({
    construct:function(){
        this.enabled=!0;
        this.bulletsEnabled=this.valueBalloonsEnabled=!1;
        this.categoryBalloonDateFormats=[{
            period:"YYYY",
            format:"YYYY"
        },{
            period:"MM",
            format:"MMM, YYYY"
        },{
            period:"WW",
            format:"MMM DD, YYYY"
        },{
            period:"DD",
            format:"MMM DD, YYYY"
        },{
            period:"hh",
            format:"JJ:NN"
        },{
            period:"mm",
            format:"JJ:NN"
        },{
            period:"ss",
            format:"JJ:NN:SS"
        },{
            period:"fff",
            format:"JJ:NN:SS"
        }]
        },
    categoryBalloonDateFormat:function(a){
        for(var b=this.categoryBalloonDateFormats,
            d,e=0;e<b.length;e++)b[e].period==a&&(d=b[e].format);
        return d
        }
    });
AmCharts.ChartScrollbarSettings=AmCharts.Class({
    construct:function(){
        this.height=40;
        this.enabled=!0;
        this.color="#FFFFFF";
        this.updateOnReleaseOnly=this.autoGridCount=!0;
        this.hideResizeGrips=!1
        }
    });
AmCharts.LegendSettings=AmCharts.Class({
    construct:function(){
        this.marginBottom=this.marginTop=0;
        this.usePositiveNegativeOnPercentsOnly=!0;
        this.positiveValueColor="#00CC00";
        this.negativeValueColor="#CC0000";
        this.autoMargins=this.equalWidths=this.textClickEnabled=!1
        }
    });
AmCharts.PanelsSettings=AmCharts.Class({
    construct:function(){
        this.marginBottom=this.marginTop=this.marginRight=this.marginLeft=0;
        this.backgroundColor="#FFFFFF";
        this.backgroundAlpha=0;
        this.panelSpacing=8;
        this.panEventsEnabled=!1
        }
    });
AmCharts.StockEventsSettings=AmCharts.Class({
    construct:function(){
        this.type="sign";
        this.backgroundAlpha=1;
        this.backgroundColor="#DADADA";
        this.borderAlpha=1;
        this.borderColor="#888888";
        this.rollOverColor="#CC0000"
        }
    });
AmCharts.ValueAxesSettings=AmCharts.Class({
    construct:function(){
        this.tickLength=0;
        this.showFirstLabel=this.autoGridCount=this.inside=!0;
        this.showLastLabel=!1;
        this.axisAlpha=0
        }
    });
AmCharts.getItemIndex=function(a,b){
    for(var d=-1,e=0;e<b.length;e++)a==b[e]&&(d=e);
    return d
    };
    
AmCharts.addBr=function(a){
    a.appendChild(document.createElement("br"))
    };
AmCharts.stringToDate=function(a,b){
    var d={},e=[{
        pattern:"YYYY",
        period:"year"
    },{
        pattern:"YY",
        period:"year"
    },{
        pattern:"MM",
        period:"month"
    },{
        pattern:"M",
        period:"month"
    },{
        pattern:"DD",
        period:"date"
    },{
        pattern:"D",
        period:"date"
    },{
        pattern:"JJ",
        period:"hours"
    },{
        pattern:"J",
        period:"hours"
    },{
        pattern:"HH",
        period:"hours"
    },{
        pattern:"H",
        period:"hours"
    },{
        pattern:"KK",
        period:"hours"
    },{
        pattern:"K",
        period:"hours"
    },{
        pattern:"LL",
        period:"hours"
    },{
        pattern:"L",
        period:"hours"
    },{
        pattern:"NN",
        period:"minutes"
    },{
        pattern:"N",
        period:"minutes"
    },{
        pattern:"SS",
        period:"seconds"
    },{
        pattern:"S",
        period:"seconds"
    },{
        pattern:"QQQ",
        period:"milliseconds"
    },{
        pattern:"QQ",
        period:"milliseconds"
    },{
        pattern:"Q",
        period:"milliseconds"
    }],f=!0,g=b.indexOf("AA");
    -1!=g&&(a.substr(g,2),"pm"==a.toLowerCase&&(f=!1));
    for(var g=b,h=0;h<e.length;h++){
        var i=e[h].pattern,j=e[h].period;
        d[j]=0;
        "date"==j&&1==d[j]
        }
        for(h=0;h<e.length;h++)if(i=e[h].pattern,j=e[h].period,-1!=b.indexOf(i)){
        var k=AmCharts.getFromDateString(i,a,g),b=b.replace(i,"");
        if("KK"==i||
            "K"==i||"LL"==i||"L"==i)f||(k+=12);
        d[j]=k
        }
        return new Date(d.year,d.month,d.date,d.hours,d.minutes,d.seconds,d.milliseconds)
    };
    
AmCharts.getFromDateString=function(a,b,d){
    d=d.indexOf(a);
    b=b.substr(d,a.length);
    "0"==b.charAt(0)&&(b=b.substr(1,b.length-1));
    b=Number(b);
    isNaN(b)&&(b=0);
    -1!=a.indexOf("M")&&b--;
    return b
    };
AmCharts.changeDate=function(a,b,d,e,f){
    var g=-1;
    void 0==e&&(e=!0);
    void 0==f&&(f=!1);
    !0==e&&(g=1);
    switch(b){
        case "YYYY":
            a.setFullYear(a.getFullYear()+d*g);
            !e&&!f&&a.setDate(a.getDate()+1);
            break;
        case "MM":
            a.setMonth(a.getMonth()+d*g);
            !e&&!f&&a.setDate(a.getDate()+1);
            break;
        case "DD":
            a.setDate(a.getDate()+d*g);
            break;
        case "WW":
            a.setDate(a.getDate()+7*d*g+1);
            break;
        case "hh":
            a.setHours(a.getHours()+d*g);
            break;
        case "mm":
            a.setMinutes(a.getMinutes()+d*g);
            break;
        case "ss":
            a.setSeconds(a.getSeconds()+d*g);
            break;
        case "fff":
            a.setMilliseconds(a.getMilliseconds()+d*g)
            }
            return a
    };
AmCharts.parseStockData=function(a,b,d,e){
    var f={},g=a.dataProvider,h=a.categoryField;
    if(h){
        var b=AmCharts.getItemIndex(b,d),i=d.length,j,k=g.length,l,m={};
        
        for(j=b;j<i;j++)l=d[j],f[l]=[];
        var s={},p=a.fieldMappings,q=p.length;
        for(j=0;j<k;j++){
            var n=g[j],r=new Date(n[h]),t=r.getTime(),u={};
            
            for(l=0;l<q;l++)u[p[l].toField]=n[p[l].fromField];
            for(var w=b;w<i;w++){
                l=d[w];
                var y=AmCharts.extractPeriod(l),z=y.period,y=y.count;
                if(w==b||t>=m[l]||!m[l]){
                    s[l]={};
                    
                    s[l][h]=new Date(r);
                    s[l].amCategoryIdField=AmCharts.resetDateToMin(r,
                        z,y,e);
                    for(var v=0;v<q;v++){
                        var x=p[v].toField;
                        AmCharts.agregateDataObject(s[l],x,u[x])
                        }
                        f[l].push(s[l]);
                    w>b&&(v=new Date(r),v=AmCharts.changeDate(v,z,y,!0),v=AmCharts.resetDateToMin(v,z,y,e),m[l]=v.getTime());
                    if(w==b)for(var A in n)s[l][A]=n[A]
                        }else for(z=0;z<q;z++)y=p[z].toField,AmCharts.agregateDataObject(s[l],y,u[y])
                    }
                }
        }
    a.agregatedDataProviders=f
};
AmCharts.agregateDataObject=function(a,b,d){
    isNaN(d)||(isNaN(a[b+"Open"])&&(a[b+"Open"]=d),a[b+"Sum"]=isNaN(a[b+"Sum"])?d:a[b+"Sum"]+d,isNaN(a[b+"Low"])?a[b+"Low"]=d:d<a[b+"Low"]&&(a[b+"Low"]=d),isNaN(a[b+"High"])?a[b+"High"]=d:d>a[b+"High"]&&(a[b+"High"]=d),isNaN(d)||(a[b+"Close"]=d),isNaN(a[b+"Count"])&&(a[b+"Count"]=0),a[b+"Count"]++,a[b+"Average"]=a[b+"Sum"]/a[b+"Count"])
    };
AmCharts.parseEvents=function(a,b,d,e,f){
    var g=a.stockEvents,h=a.agregatedDataProviders,i=b.length,j,k,l,m,s,p,q;
    for(j=0;j<i;j++){
        p=b[j];
        s=p.graphs;
        l=s.length;
        for(k=0;k<l;k++)m=s[k],m.customBulletField="amCustomBullet"+m.id+"_"+p.id,m.bulletConfigField="amCustomBulletConfig"+m.id+"_"+p.id
            }
            for(var n in h)for(var r=h[n],t=AmCharts.extractPeriod(n),u=r.length,w=0;w<u;w++){
        var y=r[w];
        j=y[a.categoryField];
        var z=j.getTime();
        k=t.period;
        l=t.count;
        var v="fff"==k?j.getTime()+1:AmCharts.resetDateToMin(AmCharts.changeDate(new Date(j),
            t.period,t.count),k,l,e).getTime();
        for(j=0;j<i;j++){
            p=b[j];
            s=p.graphs;
            l=s.length;
            for(k=0;k<l;k++){
                m=s[k];
                var x={};
                
                x.eventDispatcher=f;
                x.eventObjects=[];
                x.letters=[];
                x.descriptions=[];
                x.shapes=[];
                x.backgroundColors=[];
                x.backgroundAlphas=[];
                x.borderColors=[];
                x.borderAlphas=[];
                x.colors=[];
                x.rollOverColors=[];
                x.showOnAxis=[];
                for(q=0;q<g.length;q++){
                    var A=g[q],F=A.date.getTime();
                    m==A.graph&&(F>=z&&F<v)&&(x.eventObjects.push(A),x.letters.push(A.text),x.descriptions.push(A.description),A.type?x.shapes.push(A.type):
                        x.shapes.push(d.type),void 0!=A.backgroundColor?x.backgroundColors.push(A.backgroundColor):x.backgroundColors.push(d.backgroundColor),isNaN(A.backgroundAlpha)?x.backgroundAlphas.push(d.backgroundAlpha):x.backgroundAlphas.push(A.backgroundAlpha),isNaN(A.borderAlpha)?x.borderAlphas.push(d.borderAlpha):x.borderAlphas.push(A.borderAlpha),void 0!=A.borderColor?x.borderColors.push(A.borderColor):x.borderColors.push(d.borderColor),void 0!=A.rollOverColor?x.rollOverColors.push(A.rollOverColor):x.rollOverColors.push(d.rollOverColor),
                        x.colors.push(A.color),!A.panel&&A.graph&&(A.panel=A.graph.chart),x.showOnAxis.push(A.showOnAxis),x.date=new Date(A.date))
                    }
                    0<x.shapes.length&&(q="amCustomBullet"+m.id+"_"+p.id,m="amCustomBulletConfig"+m.id+"_"+p.id,y[q]=AmCharts.StackedBullet,y[m]=x)
                }
            }
        }
    };
    
AmCharts.StockLegend=AmCharts.Class({
    inherits:AmCharts.AmLegend,
    construct:function(){
        AmCharts.StockLegend.base.construct.call(this);
        this.valueTextComparing="[[percents.value]]%";
        this.valueTextRegular="[[value]]"
        },
    drawLegend:function(){
        var a=this;
        AmCharts.StockLegend.base.drawLegend.call(a);
        var b=a.chart;
        if(b.allowTurningOff){
            var d=a.container,e=d.image(b.pathToImages+"xIcon.gif",b.realWidth-17,3,17,17),b=d.image(b.pathToImages+"xIconH.gif",b.realWidth-17,3,17,17);
            b.hide();
            a.xButtonHover=b;
            e.mouseup(function(){
                a.handleXClick()
                }).mouseover(function(){
                a.handleXOver()
                });
            b.mouseup(function(){
                a.handleXClick()
                }).mouseout(function(){
                a.handleXOut()
                })
            }
        },
handleXOver:function(){
    this.xButtonHover.show()
    },
handleXOut:function(){
    this.xButtonHover.hide()
    },
handleXClick:function(){
    var a=this.chart,b=a.stockChart;
    b.removePanel(a);
    b.validateNow()
    }
});
AmCharts.DataSetSelector=AmCharts.Class({
    construct:function(){
        this.createEvents("dataSetSelected","dataSetCompared","dataSetUncompared");
        this.position="left";
        this.selectText="Select:";
        this.comboBoxSelectText="Select...";
        this.compareText="Compare to:";
        this.width=180;
        this.dataProvider=[];
        this.listHeight=150;
        this.listCheckBoxSize=14;
        this.rollOverBackgroundColor="#b2e1ff";
        this.selectedBackgroundColor="#7fceff"
        },
    write:function(a){
        var b=this;
        a.className="amChartsDataSetSelector";
        b.div=a;
        a.innerHTML="";
        var d=b.position,e;
        e="top"==d||"bottom"==d?!1:!0;
        b.vertical=e;
        var f;
        e&&(f=b.width+"px");
        d=b.dataProvider;
        if(1<b.countDataSets("showInSelect")){
            var g=document.createTextNode(b.selectText);
            a.appendChild(g);
            e&&AmCharts.addBr(a);
            var h=document.createElement("select");
            f&&(h.style.width=f);
            b.selectCB=h;
            a.appendChild(h);
            AmCharts.isNN&&h.addEventListener("change",function(a){
                b.handleDataSetChange.call(b,a)
                },!0);
            AmCharts.isIE&&h.attachEvent("onchange",function(a){
                b.handleDataSetChange.call(b,a)
                });
            for(g=0;g<
                d.length;g++){
                var i=d[g];
                if(!0==i.showInSelect){
                    var j=document.createElement("option");
                    j.text=i.title;
                    j.value=g;
                    i==b.chart.mainDataSet&&(j.selected=!0);
                    try{
                        h.add(j,null)
                        }catch(k){
                        h.add(j)
                        }
                    }
            }
            b.offsetHeight=h.offsetHeight
    }
    if(0<b.countDataSets("showInCompare")&&1<d.length)if(e?(AmCharts.addBr(a),AmCharts.addBr(a)):(g=document.createTextNode(" "),a.appendChild(g)),g=document.createTextNode(b.compareText),a.appendChild(g),j=b.listCheckBoxSize,e){
    AmCharts.addBr(a);
    f=document.createElement("div");
    a.appendChild(f);
    f.className="amChartsCompareList";
    f.style.overflow="auto";
    f.style.overflowX="hidden";
    f.style.width=b.width-2+"px";
    f.style.maxHeight=b.listHeight+"px";
    for(g=0;g<d.length;g++)i=d[g],!0==i.showInCompare&&i!=b.chart.mainDataSet&&(e=document.createElement("div"),e.style.padding="4px",e.style.position="relative",e.name="amCBContainer",e.dataSet=i,e.style.height=j+"px",i.compared&&(e.style.backgroundColor=b.selectedBackgroundColor),f.appendChild(e),h=document.createElement("div"),h.style.width=j+"px",h.style.height=
        j+"px",h.style.position="absolute",h.style.backgroundColor=i.color,e.appendChild(h),h=document.createElement("div"),h.style.width="100%",h.style.position="absolute",h.style.left=j+10+"px",e.appendChild(h),i=document.createTextNode(i.title),h.style.whiteSpace="nowrap",h.style.cursor="default",h.appendChild(i),AmCharts.isNN&&(e.addEventListener("mouseover",function(a){
            b.handleRollOver.call(b,a)
            },!0),e.addEventListener("mouseout",function(a){
            b.handleRollOut.call(b,a)
            },!0),e.addEventListener("click",
            function(a){
                b.handleClick.call(b,a)
                },!0)),AmCharts.isIE&&(e.attachEvent("onmouseout",function(a){
            b.handleRollOut.call(b,a)
            }),e.attachEvent("onmouseover",function(a){
            b.handleRollOver.call(b,a)
            }),e.attachEvent("onclick",function(a){
            b.handleClick.call(b,a)
            })));
    AmCharts.addBr(a);
    AmCharts.addBr(a)
    }else{
    e=document.createElement("select");
    b.compareCB=e;
    f&&(e.style.width=f);
    a.appendChild(e);
    AmCharts.isNN&&e.addEventListener("change",function(a){
        b.handleCBSelect.call(b,a)
        },!0);
    AmCharts.isIE&&e.attachEvent("onchange",
        function(a){
            b.handleCBSelect.call(b,a)
            });
    j=document.createElement("option");
    j.text=b.comboBoxSelectText;
    try{
        e.add(j,null)
        }catch(l){
        e.add(j)
        }
        for(g=0;g<d.length;g++)if(i=d[g],!0==i.showInCompare&&i!=b.chart.mainDataSet){
        j=document.createElement("option");
        j.text=i.title;
        j.value=g;
        i.compared&&(j.selected=!0);
        try{
            e.add(j,null)
            }catch(m){
            e.add(j)
            }
        }
    b.offsetHeight=e.offsetHeight
}
},
handleDataSetChange:function(){
    var a=this.selectCB,a=this.dataProvider[a.options[a.selectedIndex].value],b=this.chart;
    b.mainDataSet=
    a;
    b.zoomOutOnDataSetChange&&(b.startDate=void 0,b.endDate=void 0);
    b.validateData();
    a={
        type:"dataSetSelected",
        dataSet:a,
        chart:this.chart
        };
        
    this.fire(a.type,a)
    },
handleRollOver:function(a){
    a=this.getRealDiv(a);
    a.dataSet.compared||(a.style.backgroundColor=this.rollOverBackgroundColor)
    },
handleRollOut:function(a){
    a=this.getRealDiv(a);
    a.dataSet.compared||(a.style.removeProperty&&a.style.removeProperty("background-color"),a.style.removeAttribute&&a.style.removeAttribute("backgroundColor"))
    },
handleCBSelect:function(a){
    for(var b=
        this.compareCB,d=this.dataProvider,e=0;e<d.length;e++){
        var f=d[e];
        f.compared&&(a={
            type:"dataSetUncompared",
            dataSet:f
        });
        f.compared=!1
        }
        d=b.selectedIndex;
    0<d&&(f=this.dataProvider[b.options[d].value],f.compared||(a={
        type:"dataSetCompared",
        dataSet:f
    }),f.compared=!0);
    b=this.chart;
    b.validateData();
    a.chart=b;
    this.fire(a.type,a)
    },
handleClick:function(a){
    a=this.getRealDiv(a).dataSet;
    !0==a.compared?(a.compared=!1,a={
        type:"dataSetUncompared",
        dataSet:a
    }):(a.compared=!0,a={
        type:"dataSetCompared",
        dataSet:a
    });
    var b=
    this.chart;
    b.validateData();
    a.chart=b;
    this.fire(a.type,a)
    },
getRealDiv:function(a){
    a||(a=window.event);
    a=a.currentTarget?a.currentTarget:a.srcElement;
    "amCBContainer"==a.parentNode.name&&(a=a.parentNode);
    return a
    },
countDataSets:function(a){
    for(var b=this.dataProvider,d=0,e=0;e<b.length;e++)!0==b[e][a]&&d++;
    return d
    }
});
AmCharts.StackedBullet=AmCharts.Class({
    construct:function(){
        this.fontSize=11;
        this.stackDown=!1;
        this.mastHeight=8;
        this.shapes=[];
        this.backgroundColors=[];
        this.backgroundAlphas=[];
        this.borderAlphas=[];
        this.borderColors=[];
        this.colors=[];
        this.rollOverColors=[];
        this.showOnAxiss=[];
        this.textColor="#000000";
        this.nextY=0;
        this.size=16
        },
    parseConfig:function(){
        var a=this.bulletConfig;
        this.eventObjects=a.eventObjects;
        this.letters=a.letters;
        this.shapes=a.shapes;
        this.backgroundColors=a.backgroundColors;
        this.backgroundAlphas=
        a.backgroundAlphas;
        this.borderColors=a.borderColors;
        this.borderAlphas=a.borderAlphas;
        this.colors=a.colors;
        this.rollOverColors=a.rollOverColors;
        this.date=a.date;
        this.showOnAxiss=a.showOnAxis;
        this.axisCoordinate=a.minCoord
        },
    write:function(a){
        this.parseConfig();
        this.container=a;
        this.bullets=[];
        if(this.graph){
            var b=this.graph.fontSize;
            b&&(this.fontSize=b)
            }
            b=this.letters.length;
        (this.mastHeight+2*(this.fontSize/2+2))*b>this.availableSpace&&(this.stackDown=!0);
        this.set=a.set();
        for(var d=a=0;d<b;d++)this.shape=
            this.shapes[d],this.backgroundColor=this.backgroundColors[d],this.backgroundAlpha=this.backgroundAlphas[d],this.borderAlpha=this.borderAlphas[d],this.borderColor=this.borderColors[d],this.rollOverColor=this.rollOverColors[d],this.showOnAxis=this.showOnAxiss[d],this.color=this.colors[d],this.addLetter(this.letters[d],a,d),this.showOnAxis||a++
    },
    addLetter:function(a,b,d){
        var e=this.container,b=e.set(),f=-1,g=this.stackDown;
        this.showOnAxis&&(this.stackDown=this.graph.valueAxis.reversed?!0:!1);
        this.stackDown&&
        (f=1);
        var h=0,i=0,j=0,k,j=this.fontSize,l=this.mastHeight,m=this.shape,s=this.textColor;
        void 0!=this.color&&(s=this.color);
        void 0==a&&(a="");
        a=AmCharts.text(e,a,s,this.chart.fontFamily,this.fontSize);
        e=a.getBBox();
        this.labelWidth=s=e.width;
        this.labelHeight=e.height;
        e=0;
        switch(m){
            case "sign":
                k=this.drawSign(b);
                h=l+4+j/2;
                e=l+j+4;
                1==f&&(h-=4);
                break;
            case "flag":
                k=this.drawFlag(b);
                i=s/2+3;
                h=l+4+j/2;
                e=l+j+4;
                1==f&&(h-=4);
                break;
            case "pin":
                k=this.drawPin(b);
                h=6+j/2;
                e=j+8;
                break;
            case "triangleUp":
                k=this.drawTriangleUp(b);
                h=-j-1;
                e=j+4;
                f=-1;
                break;
            case "triangleDown":
                k=this.drawTriangleDown(b);
                h=j+1;
                e=j+4;
                f=-1;
                break;
            case "triangleLeft":
                k=this.drawTriangleLeft(b);
                i=j;
                e=j+4;
                f=-1;
                break;
            case "triangleRight":
                k=this.drawTriangleRight(b);
                i=-j;
                f=-1;
                e=j+4;
                break;
            case "arrowUp":
                k=this.drawArrowUp(b);
                a.hide();
                break;
            case "arrowDown":
                k=this.drawArrowDown(b);
                a.hide();
                e=j+4;
                break;
            case "text":
                f=-1;
                k=this.drawTextBackground(b,a);
                h=this.labelHeight+3;
                e=j+10;
                break;
            case "round":
                k=this.drawCircle(b)
                }
                this.bullets[d]=k;
        this.showOnAxis?(k=isNaN(this.nextAxisY)?
            this.axisCoordinate:this.nextY,j=h*f,this.nextAxisY=k+f*e):(k=this.nextY,j=h*f);
        a.translate(i,j);
        b.push(a);
        b.translate(0,k);
        this.addEventListeners(b,d);
        this.nextY=k+f*e;
        this.stackDown=g
        },
    addEventListeners:function(a,b){
        var d=this;
        a.click(function(){
            d.handleClick(b)
            }).mouseover(function(){
            d.handleMouseOver(b)
            }).touchend(function(){
            d.handleMouseOver(b,!0)
            }).mouseout(function(){
            d.handleMouseOut(b)
            })
        },
    drawPin:function(a){
        var b=-1;
        this.stackDown&&(b=1);
        var d=this.fontSize+4;
        return this.drawRealPolygon(a,
            [0,d/2,d/2,-d/2,-d/2,0],[0,b*d/4,b*(d+d/4),b*(d+d/4),b*d/4,0])
        },
    drawSign:function(a){
        var b=-1;
        this.stackDown&&(b=1);
        var d=this.mastHeight*b,e=this.fontSize/2+2,f=AmCharts.line(this.container,[0,0],[0,d],this.borderColor,this.borderAlpha,1),g=AmCharts.circle(this.container,e,this.backgroundColor,this.backgroundAlpha,1,this.borderColor,this.borderAlpha);
        g.translate(0,d+e*b);
        a.push(f);
        a.push(g);
        this.set.push(a);
        return g
        },
    drawFlag:function(a){
        var b=-1;
        this.stackDown&&(b=1);
        var d=this.fontSize+4,e=this.labelWidth+
        6,f=this.mastHeight,b=1==b?b*f:b*f-d,f=AmCharts.line(this.container,[0,0],[0,b],this.borderColor,this.borderAlpha,1),d=AmCharts.polygon(this.container,[0,e,e,0],[0,0,d,d],this.backgroundColor,this.backgroundAlpha,1,this.borderColor,this.borderAlpha);
        d.translate(0,b);
        a.push(f);
        a.push(d);
        this.set.push(a);
        return d
        },
    drawTriangleUp:function(a){
        var b=this.fontSize+7;
        return this.drawRealPolygon(a,[0,b/2,-b/2,0],[0,b,b,0])
        },
    drawArrowUp:function(a){
        var b=this.size,d=b/2,e=b/4;
        return this.drawRealPolygon(a,
            [0,d,e,e,-e,-e,-d,0],[0,d,d,b,b,d,d,0])
        },
    drawArrowDown:function(a){
        var b=this.size,d=b/2,e=b/4;
        return this.drawRealPolygon(a,[0,d,e,e,-e,-e,-d,0],[0,-d,-d,-b,-b,-d,-d,0])
        },
    drawTriangleDown:function(a){
        var b=this.fontSize+7;
        return this.drawRealPolygon(a,[0,b/2,-b/2,0],[0,-b,-b,0])
        },
    drawTriangleLeft:function(a){
        var b=this.fontSize+7;
        return this.drawRealPolygon(a,[0,b,b,0],[0,-b/2,b/2])
        },
    drawTriangleRight:function(a){
        var b=this.fontSize+7;
        return this.drawRealPolygon(a,[0,-b,-b,0],[0,-b/2,b/2,0])
        },
    drawRealPolygon:function(a,
        b,d){
        b=AmCharts.polygon(this.container,b,d,this.backgroundColor,this.backgroundAlpha,1,this.borderColor,this.borderAlpha);
        a.push(b);
        this.set.push(a);
        return b
        },
    drawCircle:function(a){
        shape=AmCharts.circle(this.container,this.fontSize/2,this.backgroundColor,this.backgroundAlpha,1,this.borderColor,this.borderAlpha);
        a.push(shape);
        this.set.push(a);
        return shape
        },
    drawTextBackground:function(a,b){
        var d=b.getBBox(),e=-d.width/2-5,f=d.width/2+5,d=-d.height-12;
        return this.drawRealPolygon(a,[e,-5,0,5,f,f,e,e],
            [-5,-5,0,-5,-5,d,d,-5])
        },
    handleMouseOver:function(a,b){
        b||this.bullets[a].attr({
            fill:this.rollOverColors[a]
            });
        var d=this.eventObjects[a],e={
            type:"rollOverStockEvent",
            eventObject:d,
            graph:this.graph,
            date:this.date
            },f=this.bulletConfig.eventDispatcher;
        e.chart=f;
        f.fire(e.type,e);
        d.url&&this.bullets[a].setAttr("cursor","pointer");
        this.chart.showBalloon(d.description,"#CC0000",!0)
        },
    handleClick:function(a){
        var a=this.eventObjects[a],b={
            type:"clickStockEvent",
            eventObject:a,
            graph:this.graph,
            date:this.date
            },
        d=this.bulletConfig.eventDispatcher;
        b.chart=d;
        d.fire(b.type,b);
        b=a.urlTarget;
        b||(b=d.stockEventsSettings.urlTarget);
        AmCharts.getURL(a.url,b)
        },
    handleMouseOut:function(a){
        this.bullets[a].attr({
            fill:this.backgroundColors[a]
            });
        var a={
            type:"rollOutStockEvent",
            eventObject:this.eventObjects[a],
            graph:this.graph,
            date:this.date
            },b=this.bulletConfig.eventDispatcher;
        a.chart=b;
        b.fire(a.type,a)
        }
    });
AmCharts.AmDraw=AmCharts.Class({
    construct:function(a,b,d){
        AmCharts.SVG_NS="http://www.w3.org/2000/svg";
        AmCharts.SVG_XLINK="http://www.w3.org/1999/xlink";
        AmCharts.hasSVG=!!document.createElementNS&&!!document.createElementNS(AmCharts.SVG_NS,"svg").createSVGRect;
        1>b&&(b=10);
        1>d&&(d=10);
        this.div=a;
        this.width=b;
        this.height=d;
        this.rBin=document.createElement("div");
        if(AmCharts.hasSVG){
            AmCharts.SVG=!0;
            var e=this.createSvgElement("svg");
            e.style.position="absolute";
            e.style.width=b+"px";
            e.style.height=d+"px";
            e.setAttribute("version","1.1");
            a.appendChild(e);
            this.container=e;
            this.R=new AmCharts.SVGRenderer(this)
            }else AmCharts.isIE&&AmCharts.VMLRenderer&&(AmCharts.VML=!0,AmCharts.vmlStyleSheet||(document.namespaces.add("amvml","urn:schemas-microsoft-com:vml"),b=document.createStyleSheet(),b.addRule(".amvml","behavior:url(#default#VML); display:inline-block; antialias:true"),AmCharts.vmlStyleSheet=b),this.container=a,this.R=new AmCharts.VMLRenderer(this),this.R.disableSelection(a))
            },
    createSvgElement:function(a){
        return document.createElementNS(AmCharts.SVG_NS,
            a)
        },
    circle:function(a,b,d,e){
        var f=new AmCharts.AmDObject("circle",this);
        f.attr({
            r:d,
            cx:a,
            cy:b
        });
        this.addToContainer(f.node,e);
        return f
        },
    setSize:function(a,b){
        0<a&&0<b&&(this.container.style.width=a+"px",this.container.style.height=b+"px")
        },
    rect:function(a,b,d,e,f,g,h){
        var i=new AmCharts.AmDObject("rect",this);
        AmCharts.VML&&(f=100*f/Math.min(d,e),d+=2*g,e+=2*g,i.bw=g,i.node.style.marginLeft=-g,i.node.style.marginTop=-g);
        1>d&&(d=1);
        1>e&&(e=1);
        i.attr({
            x:a,
            y:b,
            width:d,
            height:e,
            rx:f,
            ry:f,
            "stroke-width":g
        });
        this.addToContainer(i.node,h);
        return i
        },
    image:function(a,b,d,e,f,g){
        var h=new AmCharts.AmDObject("image",this);
        h.attr({
            x:b,
            y:d,
            width:e,
            height:f
        });
        this.R.path(h,a);
        this.addToContainer(h.node,g);
        return h
        },
    addToContainer:function(a,b){
        b||(b=this.container);
        b.appendChild(a)
        },
    text:function(a,b,d){
        return this.R.text(a,b,d)
        },
    path:function(a,b,d,e){
        var f=new AmCharts.AmDObject("path",this);
        e||(e="100,100");
        f.attr({
            cs:e
        });
        d?f.attr({
            dd:a
        }):f.attr({
            d:a
        });
        this.addToContainer(f.node,b);
        return f
        },
    set:function(a){
        return this.R.set(a)
        },
    remove:function(a){
        if(a){
            var b=this.rBin;
            b.appendChild(a);
            b.innerHTML=""
            }
        },
bounce:function(a,b,d,e,f){
    return(b/=f)<1/2.75?e*7.5625*b*b+d:b<2/2.75?e*(7.5625*(b-=1.5/2.75)*b+0.75)+d:b<2.5/2.75?e*(7.5625*(b-=2.25/2.75)*b+0.9375)+d:e*(7.5625*(b-=2.625/2.75)*b+0.984375)+d
    },
easeInSine:function(a,b,d,e,f){
    return-e*Math.cos(b/f*(Math.PI/2))+e+d
    },
easeOutSine:function(a,b,d,e,f){
    return e*Math.sin(b/f*(Math.PI/2))+d
    },
easeOutElastic:function(a,b,d,e,f){
    var a=1.70158,g=0,h=e;
    if(0==b)return d;
    if(1==(b/=f))return d+
        e;
    g||(g=0.3*f);
    h<Math.abs(e)?(h=e,a=g/4):a=g/(2*Math.PI)*Math.asin(e/h);
    return h*Math.pow(2,-10*b)*Math.sin((b*f-a)*2*Math.PI/g)+e+d
    },
renderFix:function(){
    var a=this.container,b=a.style,d;
    try{
        d=a.getScreenCTM()||a.createSVGMatrix()
        }catch(e){
        d=a.createSVGMatrix()
        }
        a=1-d.e%1;
    d=1-d.f%1;
    0.5<a&&(a-=1);
    0.5<d&&(d-=1);
    a&&(b.left=a+"px");
    d&&(b.top=d+"px")
    }
});
AmCharts.AmDObject=AmCharts.Class({
    construct:function(a,b){
        this.D=b;
        this.R=b.R;
        this.node=this.R.create(this,a);
        this.children=[];
        this.y=this.x=0;
        this.scale=1
        },
    attr:function(a){
        this.R.attr(this,a);
        return this
        },
    getAttr:function(a){
        return this.node.getAttribute(a)
        },
    setAttr:function(a,b){
        this.R.setAttr(this,a,b);
        return this
        },
    clipRect:function(a,b,d,e){
        this.R.clipRect(this,a,b,d,e)
        },
    translate:function(a,b,d){
        this.R.move(this,Math.round(a),Math.round(b),d);
        this.x=a;
        this.y=b;
        this.scale=d;
        this.angle&&this.rotate(this.angle)
        },
    rotate:function(a){
        this.R.rotate(this,a);
        this.angle=a
        },
    animate:function(a,b,d){
        for(var e in a){
            var f=e,g=a[e],d=AmCharts.getEffect(d);
            this.R.animate(this,f,g,b,d)
            }
        },
push:function(a){
    if(a){
        var b=this.node;
        b.appendChild(a.node);
        var d=a.clipPath;
        d&&b.appendChild(d);
        (d=a.grad)&&b.appendChild(d);
        this.children.push(a)
        }
    },
text:function(a){
    this.R.setText(this,a)
    },
remove:function(){
    this.R.remove(this)
    },
clear:function(){
    var a=this.node;
    if(a.hasChildNodes())for(;1<=a.childNodes.length;)a.removeChild(a.firstChild)
        },
hide:function(){
    this.setAttr("visibility","hidden")
    },
show:function(){
    this.setAttr("visibility","visible")
    },
getBBox:function(){
    return this.R.getBBox(this)
    },
toFront:function(){
    var a=this.node;
    if(a){
        var b=a.parentNode;
        b&&b.appendChild(a)
        }
    },
toBack:function(){
    var a=this.node;
    if(a){
        var b=a.parentNode;
        if(b){
            var d=b.firstChild;
            d&&b.insertBefore(a,d)
            }
        }
},
mouseover:function(a){
    this.R.addListener(this,"mouseover",a);
    return this
    },
mouseout:function(a){
    this.R.addListener(this,"mouseout",a);
    return this
    },
click:function(a){
    this.R.addListener(this,
        "click",a);
    return this
    },
dblclick:function(a){
    this.R.addListener(this,"dblclick",a);
    return this
    },
mousedown:function(a){
    this.R.addListener(this,"mousedown",a);
    return this
    },
mouseup:function(a){
    this.R.addListener(this,"mouseup",a);
    return this
    },
touchstart:function(a){
    this.R.addListener(this,"touchstart",a);
    return this
    },
touchend:function(a){
    this.R.addListener(this,"touchend",a);
    return this
    },
stop:function(){
    var a=this.animationX;
    a&&AmCharts.removeFromArray(this.R.animations,a);
    (a=this.animationY)&&AmCharts.removeFromArray(this.R.animations,
        a)
    },
length:function(){
    return this.node.childNodes.length
    },
gradient:function(a,b,d){
    this.R.gradient(this,a,b,d)
    }
});
AmCharts.VMLRenderer=AmCharts.Class({
    construct:function(a){
        this.D=a;
        this.cNames={
            circle:"oval",
            rect:"roundrect",
            path:"shape"
        };
        
        this.styleMap={
            x:"left",
            y:"top",
            width:"width",
            height:"height",
            "font-family":"fontFamily",
            "font-size":"fontSize",
            visibility:"visibility"
        };
        
        this.animations=[]
        },
    create:function(a,b){
        var d;
        if("group"==b)d=document.createElement("div"),a.type="div";
        else if("text"==b)d=document.createElement("div"),a.type="text";
        else if("image"==b)d=document.createElement("img"),a.type="image";
        else{
            a.type=
            "shape";
            a.shapeType=this.cNames[b];
            d=document.createElement("amvml:"+this.cNames[b]);
            var e=document.createElement("amvml:stroke");
            d.appendChild(e);
            a.stroke=e;
            var f=document.createElement("amvml:fill");
            d.appendChild(f);
            a.fill=f;
            f.className="amvml";
            e.className="amvml";
            d.className="amvml"
            }
            d.style.position="absolute";
        d.style.top=0;
        d.style.left=0;
        return d
        },
    path:function(a,b){
        a.node.setAttribute("src",b)
        },
    setAttr:function(a,b,d){
        if(void 0!==d){
            if(8===document.documentMode)var e=!0;
            var f=a.node,g=a.type,
            h=f.style;
            "r"==b&&(h.width=2*d,h.height=2*d);
            if("roundrect"==a.shapeType&&("width"==b||"height"==b))d-=1;
            "cursor"==b&&(h.cursor=d);
            "cx"==b&&(h.left=d-AmCharts.removePx(h.width)/2);
            "cy"==b&&(h.top=d-AmCharts.removePx(h.height)/2);
            var i=this.styleMap[b];
            void 0!=i&&(h[i]=d);
            "text"==g&&("text-anchor"==b&&(a.anchor=d,i=f.clientWidth,"end"==d&&(h.marginLeft=-i+"px"),"middle"==d&&(h.marginLeft=-(i/2)+"px"),"start"==d&&(h.marginLeft="0px")),"fill"==b&&(h.color=d),"font-weight"==b&&(h.fontWeight=d));
            h=a.children;
            for(i=0;i<h.length;i++)h[i].setAttr(b,d);
            if("shape"==g){
                "cs"==b&&(f.style.width="100px",f.style.height="100px",f.setAttribute("coordsize",d));
                "d"==b&&f.setAttribute("path",this.svgPathToVml(d));
                "dd"==b&&f.setAttribute("path",d);
                g=a.stroke;
                a=a.fill;
                "stroke"==b&&(e?g.color=d:g.setAttribute("color",d));
                "stroke-width"==b&&(e?g.weight=d:g.setAttribute("weight",d));
                "stroke-opacity"==b&&(e?g.opacity=d:g.setAttribute("opacity",d));
                "stroke-dasharray"==b&&(h="solid",0<d&&3>d&&(h="dot"),3<=d&&6>=d&&(h="dash"),
                    6<d&&(h="longdash"),e?g.dashstyle=h:g.setAttribute("dashstyle",h));
                if("fill-opacity"==b||"opacity"==b)0==d?e?a.on=!1:a.setAttribute("on",!1):e?a.opacity=d:a.setAttribute("opacity",d);
                "fill"==b&&(e?a.color=d:a.setAttribute("color",d));
                "rx"==b&&(e?f.arcSize=d+"%":f.setAttribute("arcsize",d+"%"))
                }
            }
    },
attr:function(a,b){
    for(var d in b)this.setAttr(a,d,b[d])
        },
text:function(a,b,d){
    var e=new AmCharts.AmDObject("text",this.D),f=e.node;
    f.style.whiteSpace="pre";
    a=document.createTextNode(a);
    f.appendChild(a);
    this.D.addToContainer(f,d);
    this.attr(e,b);
    return e
    },
getBBox:function(a){
    return this.getBox(a.node)
    },
getBox:function(a){
    var b=a.offsetLeft,d=a.offsetTop,e=a.offsetWidth,f=a.offsetHeight,g;
    if(a.hasChildNodes()){
        for(var h,i,j=0;j<a.childNodes.length;j++){
            g=this.getBox(a.childNodes[j]);
            var k=g.x;
            isNaN(k)||(isNaN(h)?h=k:k<h&&(h=k));
            var l=g.y;
            isNaN(l)||(isNaN(i)?i=l:l<i&&(i=l));
            k=g.width+k;
            isNaN(k)||(e=Math.max(e,k));
            g=g.height+l;
            isNaN(g)||(f=Math.max(f,g))
            }
            0>h&&(b+=h);
        0>i&&(d+=i)
        }
        return{
        x:b,
        y:d,
        width:e,
        height:f
    }
},
setText:function(a,b){
    var d=a.node;
    d&&(d.removeChild(d.firstChild),d.appendChild(document.createTextNode(b)));
    this.setAttr(a,"text-anchor",a.anchor)
    },
addListener:function(a,b,d){
    a.node["on"+b]=d
    },
move:function(a,b,d){
    var e=a.node,f=e.style;
    "text"==a.type&&(d-=AmCharts.removePx(f.fontSize)/2-1);
    "oval"==a.shapeType&&(b-=AmCharts.removePx(f.width)/2,d-=AmCharts.removePx(f.height)/2);
    a=a.bw;
    isNaN(a)||(b-=a,d-=a);
    e.style.left=b+"px";
    e.style.top=d+"px"
    },
svgPathToVml:function(a){
    for(var b=a.split(" "),
        a="",d,e=Math.round,f=0;f<b.length;f++){
        var g=b[f],h=g.substring(0,1),g=g.substring(1),i=g.split(","),j=e(i[0])+","+e(i[1]);
        "M"==h&&(a+=" m "+j);
        "L"==h&&(a+=" l "+j);
        "Z"==h&&(a+=" x e");
        if("Q"==h){
            var k=d.length,l=d[k-1],m=i[0],s=i[1],j=i[2],p=i[3];
            d=e(d[k-2]/3+2/3*m);
            l=e(l/3+2/3*s);
            m=e(2/3*m+j/3);
            s=e(2/3*s+p/3);
            a+=" c "+d+","+l+","+m+","+s+","+j+","+p
            }
            "A"==h&&(a+=" wa "+g);
        "B"==h&&(a+=" at "+g);
        d=i
        }
        return a
    },
animate:function(a,b,d,e,f){
    var g=this,h=a.node;
    if("translate"==b){
        var i=d.split(","),b=
        i[1],d=h.offsetTop,h={
            obj:a,
            frame:0,
            attribute:"left",
            from:h.offsetLeft,
            to:i[0],
            time:e,
            effect:f
        };
        
        g.animations.push(h);
        e={
            obj:a,
            frame:0,
            attribute:"top",
            from:d,
            to:b,
            time:e,
            effect:f
        };
        
        g.animations.push(e);
        a.animationX=h;
        a.animationY=e
        }
        g.interval||(g.interval=setInterval(function(){
        g.updateAnimations.call(g)
        },AmCharts.updateRate))
    },
updateAnimations:function(){
    for(var a=this.animations.length-1;0<=a;a--){
        var b=this.animations[a],d=1E3*b.time/AmCharts.updateRate,e=b.frame+1,f=b.obj,g=b.attribute;
        if(e<=d){
            b.frame++;
            var h=Number(b.from),i=Number(b.to)-h,b=this.D[b.effect](0,e,h,i,d);
            0==i?this.animations.splice(a,1):f.node.style[g]=b
            }else f.node.style[g]=Number(b.to),this.animations.splice(a,1)
            }
        },
clipRect:function(a,b,d,e,f){
    a.node.style.clip="rect("+d+"px "+(b+e)+"px "+(d+f)+"px "+b+"px)"
    },
rotate:function(a,b){
    var d=a.node,e=d.style,f=this.getBGColor(d.parentNode);
    e.backgroundColor=f;
    e.paddingLeft=1;
    var f=b*Math.PI/180,g=Math.cos(f),h=Math.sin(f),i=AmCharts.removePx(e.left),j=AmCharts.removePx(e.top),k=d.offsetWidth,
    d=d.offsetHeight,l=b/Math.abs(b);
    e.left=i+k/2-k/2*Math.cos(f)-l*d/2*Math.sin(f)+3;
    e.top=j-l*k/2*Math.sin(f)+l*d/2*Math.sin(f);
    e.cssText=e.cssText+"; filter:progid:DXImageTransform.Microsoft.Matrix(M11='"+g+"', M12='"+-h+"', M21='"+h+"', M22='"+g+"', sizingmethod='auto expand');"
    },
getBGColor:function(a){
    var b="#FFFFFF";
    if(a.style){
        var d=a.style.backgroundColor;
        ""!=d?b=d:a.parentNode&&(b=this.getBGColor(a.parentNode))
        }
        return b
    },
set:function(a){
    var b=new AmCharts.AmDObject("group",this.D);
    this.D.container.appendChild(b.node);
    if(a)for(var d=0;d<a.length;d++)b.push(a[d]);
    return b
    },
gradient:function(a,b,d,e){
    var f="";
    "radialGradient"==b&&(b="gradientradial",d.reverse());
    "linearGradient"==b&&(b="gradient");
    for(var g=0;g<d.length;g++){
        var h=Math.round(100*g/(d.length-1)),f=f+(h+"% "+d[g]);
        g<d.length-1&&(f+=",")
        }
        a=a.fill;
    90==e?e=0:270==e?e=180:180==e?e=90:0==e&&(e=270);
    8===document.documentMode?(a.type=b,a.angle=e):(a.setAttribute("type",b),a.setAttribute("angle",e));
    f&&(a.colors.value=f)
    },
remove:function(a){
    a.clipPath&&this.D.remove(a.clipPath);
    this.D.remove(a.node)
    },
disableSelection:function(a){
    void 0!=typeof a.onselectstart&&(a.onselectstart=function(){
        return!1
        });
    a.style.cursor="default"
    }
});
AmCharts.SVGRenderer=AmCharts.Class({
    construct:function(a){
        this.D=a;
        this.animations=[]
        },
    create:function(a,b){
        return document.createElementNS(AmCharts.SVG_NS,b)
        },
    attr:function(a,b){
        for(var d in b)this.setAttr(a,d,b[d])
            },
    setAttr:function(a,b,d){
        void 0!==d&&a.node.setAttribute(b,d)
        },
    animate:function(a,b,d,e,f){
        var g=this,h=a.node;
        "translate"==b?(h=(h=h.getAttribute("transform"))?String(h).substring(10,h.length-1):"0,0",h=h.split(", ").join(" "),h=h.split(" ").join(","),0==h&&(h="0,0")):h=h.getAttribute(b);
        b={
            obj:a,
            frame:0,
            attribute:b,
            from:h,
            to:d,
            time:e,
            effect:f
        };
        
        g.animations.push(b);
        a.animationX=b;
        g.interval||(g.interval=setInterval(function(){
            g.updateAnimations.call(g)
            },AmCharts.updateRate))
        },
    updateAnimations:function(){
        for(var a=this.animations.length-1;0<=a;a--){
            var b=this.animations[a],d=1E3*b.time/AmCharts.updateRate,e=b.frame+1,f=b.obj,g=b.attribute;
            if(e<=d){
                b.frame++;
                if("translate"==g)var h=b.from.split(","),g=Number(h[0]),h=Number(h[1]),i=b.to.split(","),j=Number(i[0]),i=Number(i[1]),j=0==
                    j-g?j:Math.round(this.D[b.effect](0,e,g,j-g,d)),b=0==i-h?i:Math.round(this.D[b.effect](0,e,h,i-h,d)),g="transform",b="translate("+j+","+b+")";else h=Number(b.from),j=Number(b.to),j-=h,b=this.D[b.effect](0,e,h,j,d),0==j&&this.animations.splice(a,1);
                this.setAttr(f,g,b)
                }else"translate"==g?(i=b.to.split(","),j=Number(i[0]),i=Number(i[1]),f.translate(j,i)):(j=Number(b.to),this.setAttr(f,g,j)),this.animations.splice(a,1)
                }
            },
getBBox:function(a){
    if(a=a.node)try{
        return a.getBBox()
        }catch(b){}
        return{
        width:0,
        height:0,
        x:0,
        y:0
    }
},
path:function(a,b){
    a.node.setAttributeNS(AmCharts.SVG_XLINK,"xlink:href",b)
    },
clipRect:function(a,b,d,e,f){
    var g=a.node,h=a.clipPath;
    h&&this.D.remove(h);
    var i=g.parentNode;
    i&&(g=document.createElementNS(AmCharts.SVG_NS,"clipPath"),h=AmCharts.getUniqueId(),g.setAttribute("id",h),this.D.rect(b,d,e,f,0,0,g),i.appendChild(g),b="#",AmCharts.baseHref&&!AmCharts.isIE&&(b=window.location.href+b),this.setAttr(a,"clip-path","url("+b+h+")"),this.clipPathC++,a.clipPath=g)
    },
text:function(a,b,
    d){
    for(var e=new AmCharts.AmDObject("text",this.D),a=String(a).split("\n"),f=b["font-size"],g=0;g<a.length;g++){
        var h=this.create(null,"tspan");
        h.appendChild(document.createTextNode(a[g]));
        h.setAttribute("y",(f+2)*g+f/2+0);
        h.setAttribute("x",0);
        e.node.appendChild(h)
        }
        e.node.setAttribute("y",f/2+0);
    this.attr(e,b);
    this.D.addToContainer(e.node,d);
    return e
    },
setText:function(a,b){
    var d=a.node;
    d&&(d.removeChild(d.firstChild),d.appendChild(document.createTextNode(b)))
    },
move:function(a,b,d,e){
    b="translate("+
    b+","+d+")";
    e&&(b=b+" scale("+e+")");
    this.setAttr(a,"transform",b)
    },
rotate:function(a,b){
    var d=a.node.getAttribute("transform"),e="rotate("+b+")";
    d&&(e=d+" "+e);
    this.setAttr(a,"transform",e)
    },
set:function(a){
    var b=new AmCharts.AmDObject("g",this.D);
    this.D.container.appendChild(b.node);
    if(a)for(var d=0;d<a.length;d++)b.push(a[d]);
    return b
    },
addListener:function(a,b,d){
    a.node["on"+b]=d
    },
gradient:function(a,b,d,e){
    var f=a.node,g=a.grad;
    g&&this.D.remove(g);
    b=document.createElementNS(AmCharts.SVG_NS,b);
    g=AmCharts.getUniqueId();
    b.setAttribute("id",g);
    if(!isNaN(e)){
        var h=0,i=0,j=0,k=0;
        90==e?j=100:270==e?k=100:180==e?h=100:0==e&&(i=100);
        b.setAttribute("x1",h+"%");
        b.setAttribute("x2",i+"%");
        b.setAttribute("y1",j+"%");
        b.setAttribute("y2",k+"%")
        }
        for(e=0;e<d.length;e++)h=document.createElementNS(AmCharts.SVG_NS,"stop"),i=100*e/(d.length-1),0==e&&(i=0),h.setAttribute("offset",i+"%"),h.setAttribute("stop-color",d[e]),b.appendChild(h);
    f.parentNode.appendChild(b);
    d="#";
    AmCharts.baseHref&&!AmCharts.isIE&&(d=
        window.location.href+d);
    f.setAttribute("fill","url("+d+g+")");
    a.grad=b
    },
remove:function(a){
    a.clipPath&&this.D.remove(a.clipPath);
    a.grad&&this.D.remove(a.grad);
    this.D.remove(a.node)
    }
});
AmCharts.AmDSet=AmCharts.Class({
    construct:function(){
        this.create("g")
        },
    attr:function(a){
        this.R.attr(this.node,a)
        },
    move:function(a,b){
        this.R.move(this.node,a,b)
        }
    });