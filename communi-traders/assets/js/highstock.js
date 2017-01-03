/*
 Highstock JS v1.2.4 (2012-10-08)

 (c) 2009-2012 Torstein Hønsi

 License: www.highcharts.com/license
*/
(function(){
    function u(a,b){
        var c;
        a||(a={});
        for(c in b)a[c]=b[c];return a
        }
        function ja(){
        for(var a=0,b=arguments,c=b.length,d={};
            a<c;a++)d[b[a++]]=b[a];
        return d
        }
        function F(a,b){
        return parseInt(a,b||10)
        }
        function qa(a){
        return typeof a==="string"
        }
        function ga(a){
        return typeof a==="object"
        }
        function Wa(a){
        return Object.prototype.toString.call(a)==="[object Array]"
        }
        function za(a){
        return typeof a==="number"
        }
        function ra(a){
        return M.log(a)/M.LN10
        }
        function ka(a){
        return M.pow(10,a)
        }
        function Ma(a,b){
        for(var c=
            a.length;c--;)if(a[c]===b){
            a.splice(c,1);
            break
        }
        }
        function v(a){
    return a!==r&&a!==null
    }
    function G(a,b,c){
    var d,e;
    if(qa(b))v(c)?a.setAttribute(b,c):a&&a.getAttribute&&(e=a.getAttribute(b));
    else if(v(b)&&ga(b))for(d in b)a.setAttribute(d,b[d]);return e
    }
    function la(a){
    return Wa(a)?a:[a]
    }
    function p(){
    var a=arguments,b,c,d=a.length;
    for(b=0;b<d;b++)if(c=a[b],typeof c!=="undefined"&&c!==null)return c
        }
        function L(a,b){
    if(Na&&b&&b.opacity!==r)b.filter="alpha(opacity="+b.opacity*100+")";
    u(a.style,b)
    }
    function U(a,
    b,c,d,e){
    a=E.createElement(a);
    b&&u(a,b);
    e&&L(a,{
        padding:0,
        border:$,
        margin:0
    });
    c&&L(a,c);
    d&&d.appendChild(a);
    return a
    }
    function aa(a,b){
    var c=function(){};
    
    c.prototype=new a;
    u(c.prototype,b);
    return c
    }
    function Oa(a,b,c,d){
    var e=P.lang,f=a;
    b===-1?(b=(a||0).toString(),a=b.indexOf(".")>-1?b.split(".")[1].length:0):a=isNaN(b=V(b))?2:b;
    var b=a,c=c===void 0?e.decimalPoint:c,d=d===void 0?e.thousandsSep:d,e=f<0?"-":"",a=String(F(f=V(+f||0).toFixed(b))),g=a.length>3?a.length%3:0;
    return e+(g?a.substr(0,g)+d:"")+
    a.substr(g).replace(/(\d{3})(?=\d)/g,"$1"+d)+(b?c+V(f-a).toFixed(b).slice(2):"")
    }
    function Aa(a,b){
    return Array((b||2)+1-String(a).length).join(0)+a
    }
    function rb(a,b,c){
    var d=a[b];
    a[b]=function(){
        var a=Array.prototype.slice.call(arguments);
        a.unshift(d);
        return c.apply(this,a)
        }
    }
function sb(a,b,c,d){
    var e,c=p(c,1);
    e=a/c;
    b||(b=[1,2,2.5,5,10],d&&d.allowDecimals===!1&&(c===1?b=[1,2,5,10]:c<=0.1&&(b=[1/c])));
    for(d=0;d<b.length;d++)if(a=b[d],e<=(b[d]+(b[d+1]||b[d]))/2)break;a*=c;
    return a
    }
    function Gb(a,b){
    var c=
    b||[[cb,[1,2,5,10,20,25,50,100,200,500]],[Xa,[1,2,5,10,15,30]],[Pa,[1,2,5,10,15,30]],[sa,[1,2,3,4,6,8,12]],[fa,[1,2]],[Ba,[1,2]],[Ca,[1,2,3,4,6]],[na,null]],d=c[c.length-1],e=C[d[0]],f=d[1],g;
    for(g=0;g<c.length;g++)if(d=c[g],e=C[d[0]],f=d[1],c[g+1]&&a<=(e*f[f.length-1]+C[c[g+1][0]])/2)break;e===C[na]&&a<5*e&&(f=[1,2,5]);
    e===C[na]&&a<5*e&&(f=[1,2,5]);
    c=sb(a/e,f);
    return{
        unitRange:e,
        count:c,
        unitName:d[0]
        }
    }
function db(a,b,c,d){
    var e=[],f={},g=P.global.useUTC,h,i=new Date(b),b=a.unitRange,j=a.count;
    b>=
    C[Xa]&&(i.setMilliseconds(0),i.setSeconds(b>=C[Pa]?0:j*Y(i.getSeconds()/j)));
    if(b>=C[Pa])i[Hb](b>=C[sa]?0:j*Y(i[tb]()/j));
    if(b>=C[sa])i[Ib](b>=C[fa]?0:j*Y(i[ub]()/j));
    if(b>=C[fa])i[vb](b>=C[Ca]?1:j*Y(i[Da]()/j));
    b>=C[Ca]&&(i[Jb](b>=C[na]?0:j*Y(i[eb]()/j)),h=i[fb]());
    b>=C[na]&&(h-=h%j,i[Kb](h));
    if(b===C[Ba])i[vb](i[Da]()-i[wb]()+p(d,1));
    d=1;
    h=i[fb]();
    for(var k=i.getTime(),l=i[eb](),m=i[Da](),i=g?0:(864E5+i.getTimezoneOffset()*6E4)%864E5;k<c;)e.push(k),b===C[na]?k=gb(h+d*j,0):b===C[Ca]?k=gb(h,l+d*j):
        !g&&(b===C[fa]||b===C[Ba])?k=gb(h,l,m+d*j*(b===C[fa]?1:7)):(k+=b*j,b<=C[sa]&&k%C[fa]===i&&(f[k]=fa)),d++;
    e.push(k);
    e.info=u(a,{
        higherRanks:f,
        totalRange:b*j
        });
    return e
    }
    function Lb(){
    this.symbol=this.color=0
    }
    function Mb(a,b){
    var c=a.length,d,e;
    for(e=0;e<c;e++)a[e].ss_i=e;
    a.sort(function(a,c){
        d=b(a,c);
        return d===0?a.ss_i-c.ss_i:d
        });
    for(e=0;e<c;e++)delete a[e].ss_i
        }
        function Qa(a){
    for(var b=a.length,c=a[0];b--;)a[b]<c&&(c=a[b]);
    return c
    }
    function Ea(a){
    for(var b=a.length,c=a[0];b--;)a[b]>c&&(c=a[b]);
    return c
    }
function ta(a,b){
    for(var c in a)a[c]&&a[c]!==b&&a[c].destroy&&a[c].destroy(),delete a[c]
    }
    function Ra(a){
    hb||(hb=U(oa));
    a&&hb.appendChild(a);
    hb.innerHTML=""
    }
    function ib(a,b){
    var c="Highcharts error #"+a+": www.highcharts.com/errors/"+a;
    if(b)throw c;else S.console&&console.log(c)
        }
        function ma(a){
    return parseFloat(a.toPrecision(14))
    }
    function Fa(a,b){
    Ya=p(a,b.animation)
    }
    function Nb(){
    var a=P.global.useUTC,b=a?"getUTC":"get",c=a?"setUTC":"set";
    gb=a?Date.UTC:function(a,b,c,g,h,i){
        return(new Date(a,b,p(c,
            1),p(g,0),p(h,0),p(i,0))).getTime()
        };
        
    tb=b+"Minutes";
    ub=b+"Hours";
    wb=b+"Day";
    Da=b+"Date";
    eb=b+"Month";
    fb=b+"FullYear";
    Hb=c+"Minutes";
    Ib=c+"Hours";
    vb=c+"Date";
    Jb=c+"Month";
    Kb=c+"FullYear"
    }
    function Ga(){}
function Za(a,b,c){
    this.axis=a;
    this.pos=b;
    this.type=c||"";
    this.isNew=!0;
    c||this.addLabel()
    }
    function xb(a,b){
    this.axis=a;
    if(b)this.options=b,this.id=b.id;
    return this
    }
    function Ob(a,b,c,d,e,f){
    var g=a.chart.inverted;
    this.axis=a;
    this.isNegative=c;
    this.options=b;
    this.x=d;
    this.stack=e;
    this.percent=f==="percent";
    this.alignOptions={
        align:b.align||(g?c?"left":"right":"center"),
        verticalAlign:b.verticalAlign||(g?"middle":c?"bottom":"top"),
        y:p(b.y,g?4:c?14:-6),
        x:p(b.x,g?c?-6:6:0)
        };
        
    this.textAlign=b.textAlign||(g?c?"right":"left":"center")
    }
    function Sa(){
    this.init.apply(this,arguments)
    }
    function yb(a,b){
    var c=b.borderWidth,d=b.style,e=F(d.padding);
    this.chart=a;
    this.options=b;
    this.crosshairs=[];
    this.now={
        x:0,
        y:0
    };
    
    this.isHidden=!0;
    this.label=a.renderer.label("",0,0,b.shape,null,null,b.useHTML,null,"tooltip").attr({
        padding:e,
        fill:b.backgroundColor,
        "stroke-width":c,
        r:b.borderRadius,
        zIndex:8
    }).css(d).css({
        padding:0
    }).hide().add();
    ca||this.label.shadow(b.shadow);
    this.shared=b.shared
    }
    function zb(a,b){
    var c=ca?"":b.chart.zoomType;
    this.zoomX=/x/.test(c);
    this.zoomY=/y/.test(c);
    this.options=b;
    this.chart=a;
    this.init(a,b.tooltip)
    }
    function Ab(a){
    this.init(a)
    }
    function $a(a,b){
    var c,d=a.series;
    a.series=null;
    c=w(P,a);
    c.series=a.series=d;
    var d=c.chart,e=d.margin,e=ga(e)?e:[e,e,e,e];
    this.optionsMarginTop=p(d.marginTop,e[0]);
    this.optionsMarginRight=
    p(d.marginRight,e[1]);
    this.optionsMarginBottom=p(d.marginBottom,e[2]);
    this.optionsMarginLeft=p(d.marginLeft,e[3]);
    this.runChartClick=(e=d.events)&&!!e.click;
    this.callback=b;
    this.isResizing=0;
    this.options=c;
    this.axes=[];
    this.series=[];
    this.hasCartesianSeries=d.showAxes;
    this.init(e)
    }
    function Pb(a){
    var b=a.options,c=b.navigator,d=c.enabled,b=b.scrollbar,e=b.enabled,f=d?c.height:0,g=e?b.height:0,h=c.baseSeries;
    this.baseSeries=a.series[h]||typeof h==="string"&&a.get(h)||a.series[0];
    this.handles=[];
    this.scrollbarButtons=
    [];
    this.elementsToDestroy=[];
    this.chart=a;
    this.height=f;
    this.scrollbarHeight=g;
    this.scrollbarEnabled=e;
    this.navigatorEnabled=d;
    this.navigatorOptions=c;
    this.scrollbarOptions=b;
    this.outlineHeight=f+g;
    this.init()
    }
    function Qb(a){
    this.chart=a;
    this.buttons=[];
    this.boxSpanElements={};
    
    this.init([{
        type:"month",
        count:1,
        text:"1m"
    },{
        type:"month",
        count:3,
        text:"3m"
    },{
        type:"month",
        count:6,
        text:"6m"
    },{
        type:"ytd",
        text:"YTD"
    },{
        type:"year",
        count:1,
        text:"1y"
    },{
        type:"all",
        text:"All"
    }])
    }
    var r,E=document,S=window,M=Math,
t=M.round,Y=M.floor,Ha=M.ceil,x=M.max,K=M.min,V=M.abs,da=M.cos,ha=M.sin,Ia=M.PI,jb=Ia*2/360,Ta=navigator.userAgent,Rb=S.opera,Na=/msie/i.test(Ta)&&!Rb,ab=E.documentMode===8,Bb=/AppleWebKit/.test(Ta),kb=/Firefox/.test(Ta),ua="http://www.w3.org/2000/svg",ia=!!E.createElementNS&&!!E.createElementNS(ua,"svg").createSVGRect,$b=kb&&parseInt(Ta.split("Firefox/")[1],10)<4,ca=!ia&&!Na&&!!E.createElement("canvas").getContext,Ua,ba=E.documentElement.ontouchstart!==r,Sb={},Cb=0,hb,P,va,Ya,Db,C,lb=function(){},
oa="div",$="none",Eb="rgba(192,192,192,"+(ia?1.0E-6:0.0020)+")",cb="millisecond",Xa="second",Pa="minute",sa="hour",fa="day",Ba="week",Ca="month",na="year",gb,tb,ub,wb,Da,eb,fb,Hb,Ib,vb,Jb,Kb,R={};

S.Highcharts={};

va=function(a,b,c){
    if(!v(b)||isNaN(b))return"Invalid date";
    var a=p(a,"%Y-%m-%d %H:%M:%S"),d=new Date(b),e,f=d[ub](),g=d[wb](),h=d[Da](),i=d[eb](),j=d[fb](),k=P.lang,l=k.weekdays,b={
        a:l[g].substr(0,3),
        A:l[g],
        d:Aa(h),
        e:h,
        b:k.shortMonths[i],
        B:k.months[i],
        m:Aa(i+1),
        y:j.toString().substr(2,2),
        Y:j,
        H:Aa(f),
        I:Aa(f%12||12),
        l:f%12||12,
        M:Aa(d[tb]()),
        p:f<12?"AM":"PM",
        P:f<12?"am":"pm",
        S:Aa(d.getSeconds()),
        L:Aa(t(b%1E3),3)
        };
        
    for(e in b)a=a.replace("%"+e,b[e]);return c?a.substr(0,1).toUpperCase()+a.substr(1):a
    };
    
Lb.prototype={
    wrapColor:function(a){
        if(this.color>=a)this.color=0
            },
    wrapSymbol:function(a){
        if(this.symbol>=a)this.symbol=0
            }
        };

C=ja(cb,1,Xa,1E3,Pa,6E4,sa,36E5,fa,864E5,Ba,6048E5,Ca,2592E6,na,31556952E3);
Db={
    init:function(a,b,c){
        var b=b||"",d=a.shift,e=b.indexOf("C")>-1,f=e?7:3,g,b=b.split(" "),
        c=[].concat(c),h,i,j=function(a){
            for(g=a.length;g--;)a[g]==="M"&&a.splice(g+1,0,a[g+1],a[g+2],a[g+1],a[g+2])
                };
                
        e&&(j(b),j(c));
        a.isArea&&(h=b.splice(b.length-6,6),i=c.splice(c.length-6,6));
        if(d<=c.length/f)for(;d--;)c=[].concat(c).splice(0,f).concat(c);
        a.shift=0;
        if(b.length)for(a=c.length;b.length<a;)d=[].concat(b).splice(b.length-f,f),e&&(d[f-6]=d[f-2],d[f-5]=d[f-1]),b=b.concat(d);
        h&&(b=b.concat(h),c=c.concat(i));
        return[b,c]
        },
    step:function(a,b,c,d){
        var e=[],f=a.length;
        if(c===1)e=d;
        else if(f===b.length&&
            c<1)for(;f--;)d=parseFloat(a[f]),e[f]=isNaN(d)?a[f]:c*parseFloat(b[f]-d)+d;else e=b;
        return e
        }
    };
(function(a){
    S.HighchartsAdapter=S.HighchartsAdapter||a&&{
        init:function(b){
            var c=a.fx,d=c.step,e,f=a.Tween,g=f&&f.propHooks;
            a.extend(a.easing,{
                easeOutQuad:function(a,b,c,d,e){
                    return-d*(b/=e)*(b-2)+c
                    }
                });
        a.each(["cur","_default","width","height"],function(a,b){
            var e=d,k,l;
            b==="cur"?e=c.prototype:b==="_default"&&f&&(e=g[b],b="set");
            (k=e[b])&&(e[b]=function(c){
                c=a?c:this;
                l=c.elem;
                return l.attr?l.attr(c.prop,
                    b==="cur"?r:c.now):k.apply(this,arguments)
                })
            });
        e=function(a){
            var c=a.elem,d;
            if(!a.started)d=b.init(c,c.d,c.toD),a.start=d[0],a.end=d[1],a.started=!0;
            c.attr("d",b.step(a.start,a.end,a.pos,c.toD))
            };
            
        f?g.d={
            set:e
        }:d.d=e;
        this.each=Array.prototype.forEach?function(a,b){
            return Array.prototype.forEach.call(a,b)
            }:function(a,b){
            for(var c=0,d=a.length;c<d;c++)if(b.call(a[c],a[c],c,a)===!1)return c
                }
            },
getScript:a.getScript,
inArray:a.inArray,
adapterRun:function(b,c){
    return a(b)[c]()
    },
grep:a.grep,
map:function(a,
    c){
    for(var d=[],e=0,f=a.length;e<f;e++)d[e]=c.call(a[e],a[e],e,a);
    return d
    },
merge:function(){
    var b=arguments;
    return a.extend(!0,null,b[0],b[1],b[2],b[3])
    },
offset:function(b){
    return a(b).offset()
    },
addEvent:function(b,c,d){
    a(b).bind(c,d)
    },
removeEvent:function(b,c,d){
    var e=E.removeEventListener?"removeEventListener":"detachEvent";
    E[e]&&!b[e]&&(b[e]=function(){});
    a(b).unbind(c,d)
    },
fireEvent:function(b,c,d,e){
    var f=a.Event(c),g="detached"+c,h;
    !Na&&d&&(delete d.layerX,delete d.layerY);
    u(f,d);
    b[c]&&(b[g]=
        b[c],b[c]=null);
    a.each(["preventDefault","stopPropagation"],function(a,b){
        var c=f[b];
        f[b]=function(){
            try{
                c.call(f)
                }catch(a){
                b==="preventDefault"&&(h=!0)
                }
            }
    });
a(b).trigger(f);
b[g]&&(b[c]=b[g],b[g]=null);
e&&!f.isDefaultPrevented()&&!h&&e(f)
},
washMouseEvent:function(a){
    var c=a.originalEvent||a;
    if(c.pageX===r)c.pageX=a.pageX,c.pageY=a.pageY;
    return c
    },
animate:function(b,c,d){
    var e=a(b);
    if(c.d)b.toD=c.d,c.d=1;
    e.stop();
    e.animate(c,d)
    },
stop:function(b){
    a(b).stop()
    }
}
})(S.jQuery);
var N=S.HighchartsAdapter,H=
N||{};

N&&N.init.call(N,Db);
var mb=H.adapterRun,ac=H.getScript,bc=H.inArray,n=H.each,Tb=H.grep,cc=H.offset,Ja=H.map,w=H.merge,D=H.addEvent,O=H.removeEvent,J=H.fireEvent,Ub=H.washMouseEvent,Fb=H.animate,nb=H.stop,H={
    enabled:!0,
    align:"center",
    x:0,
    y:15,
    style:{
        color:"#666",
        fontSize:"11px",
        lineHeight:"14px"
    }
};

P={
    colors:"#4572A7,#AA4643,#89A54E,#80699B,#3D96AE,#DB843D,#92A8CD,#A47D7C,#B5CA92".split(","),
    symbols:["circle","diamond","square","triangle","triangle-down"],
    lang:{
        loading:"Loading...",
        months:"January,February,March,April,May,June,July,August,September,October,November,December".split(","),
        shortMonths:"Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec".split(","),
        weekdays:"Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday".split(","),
        decimalPoint:".",
        numericSymbols:"k,M,G,T,P,E".split(","),
        resetZoom:"Reset zoom",
        resetZoomTitle:"Reset zoom level 1:1",
        thousandsSep:","
    },
    global:{
        useUTC:!0,
        canvasToolsURL:"http://code.highcharts.com/stock/1.2.4/modules/canvas-tools.js",
        VMLRadialGradientURL:"http://code.highcharts.com/stock/1.2.4/gfx/vml-radial-gradient.png"
    },
    chart:{
        borderColor:"#4572A7",
        borderRadius:5,
        defaultSeriesType:"line",
        ignoreHiddenSeries:!0,
        spacingTop:10,
        spacingRight:10,
        spacingBottom:15,
        spacingLeft:10,
        style:{
            fontFamily:'"Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif',
            fontSize:"12px"
        },
        backgroundColor:"#FFFFFF",
        plotBorderColor:"#C0C0C0",
        resetZoomButton:{
            theme:{
                zIndex:20
            },
            position:{
                align:"right",
                x:-10,
                y:10
            }
        }
    },
title:{
    text:"Chart title",
    align:"center",
    y:15,
    style:{
        color:"#3E576F",
        fontSize:"16px"
    }
},
subtitle:{
    text:"",
    align:"center",
    y:30,
    style:{
        color:"#6D869F"
    }
},
plotOptions:{
    line:{
        allowPointSelect:!1,
        showCheckbox:!1,
        animation:{
            duration:1E3
        },
        events:{},
        lineWidth:2,
        shadow:!0,
        marker:{
            enabled:!0,
            lineWidth:0,
            radius:4,
            lineColor:"#FFFFFF",
            states:{
                hover:{
                    enabled:!0
                    },
                select:{
                    fillColor:"#FFFFFF",
                    lineColor:"#000000",
                    lineWidth:2
                }
            }
        },
point:{
    events:{}
},
dataLabels:w(H,{
    enabled:!1,
    formatter:function(){
        return this.y
        },
    verticalAlign:"bottom",
    y:0
}),
cropThreshold:300,
pointRange:0,
showInLegend:!0,
states:{
    hover:{
        marker:{}
},
select:{
    marker:{}
}
},
stickyTracking:!0
}
},
labels:{
    style:{
        position:"absolute",
        color:"#3E576F"
    }
},
legend:{
    enabled:!0,
    align:"center",
    layout:"horizontal",
    labelFormatter:function(){
        return this.name
        },
    borderWidth:1,
    borderColor:"#909090",
    borderRadius:5,
    navigation:{
        activeColor:"#3E576F",
        inactiveColor:"#CCC"
    },
    shadow:!1,
    itemStyle:{
        cursor:"pointer",
        color:"#3E576F",
        fontSize:"12px"
    },
    itemHoverStyle:{
        color:"#000"
    },
    itemHiddenStyle:{
        color:"#CCC"
    },
    itemCheckboxStyle:{
        position:"absolute",
        width:"13px",
        height:"13px"
    },
    symbolWidth:16,
    symbolPadding:5,
    verticalAlign:"bottom",
    x:0,
    y:0
},
loading:{
    labelStyle:{
        fontWeight:"bold",
        position:"relative",
        top:"1em"
    },
    style:{
        position:"absolute",
        backgroundColor:"white",
        opacity:0.5,
        textAlign:"center"
    }
},
tooltip:{
    enabled:!0,
    backgroundColor:"rgba(255, 255, 255, .85)",
    borderWidth:2,
    borderRadius:5,
    dateTimeLabelFormats:{
        millisecond:"%A, %b %e, %H:%M:%S.%L",
        second:"%A, %b %e, %H:%M:%S",
        minute:"%A, %b %e, %H:%M",
        hour:"%A, %b %e, %H:%M",
        day:"%A, %b %e, %Y",
        week:"Week from %A, %b %e, %Y",
        month:"%B %Y",
        year:"%Y"
    },
    headerFormat:'<span style="font-size: 10px">{point.key}</span><br/>',
    pointFormat:'<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
    shadow:!0,
    shared:ca,
    snap:ba?25:10,
    style:{
        color:"#333333",
        fontSize:"12px",
        padding:"5px",
        whiteSpace:"nowrap"
    }
},
credits:{
    enabled:!0,
    text:"Highcharts.com",
    href:"http://www.highcharts.com",
    position:{
        align:"right",
        x:-10,
        verticalAlign:"bottom",
        y:-5
    },
    style:{
        cursor:"pointer",
        color:"#909090",
        fontSize:"10px"
    }
}
};

var Q=P.plotOptions,N=Q.line;
Nb();
var wa=function(a){
    var b=[],c;
    (function(a){
        (c=/rgba\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]?(?:\.[0-9]+)?)\s*\)/.exec(a))?b=[F(c[1]),F(c[2]),
        F(c[3]),parseFloat(c[4],10)]:(c=/#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(a))&&(b=[F(c[1],16),F(c[2],16),F(c[3],16),1])
        })(a);
    return{
        get:function(c){
            return b&&!isNaN(b[0])?c==="rgb"?"rgb("+b[0]+","+b[1]+","+b[2]+")":c==="a"?b[3]:"rgba("+b.join(",")+")":a
            },
        brighten:function(a){
            if(za(a)&&a!==0){
                var c;
                for(c=0;c<3;c++)b[c]+=F(a*255),b[c]<0&&(b[c]=0),b[c]>255&&(b[c]=255)
                    }
                    return this
            },
        setOpacity:function(a){
            b[3]=a;
            return this
            }
        }
};

Ga.prototype={
    init:function(a,b){
        this.element=b==="span"?U(b):
        E.createElementNS(ua,b);
        this.renderer=a;
        this.attrSetters={}
    },
animate:function(a,b,c){
    b=p(b,Ya,!0);
    nb(this);
    if(b){
        b=w(b);
        if(c)b.complete=c;
        Fb(this,a,b)
        }else this.attr(a),c&&c()
        },
attr:function(a,b){
    var c,d,e,f,g=this.element,h=g.nodeName.toLowerCase(),i=this.renderer,j,k=this.attrSetters,l=this.shadows,m,o,s=this;
    qa(a)&&v(b)&&(c=a,a={},a[c]=b);
    if(qa(a))c=a,h==="circle"?c={
        x:"cx",
        y:"cy"
    }
    [c]||c:c==="strokeWidth"&&(c="stroke-width"),s=G(g,c)||this[c]||0,c!=="d"&&c!=="visibility"&&(s=parseFloat(s));else for(c in a)if(j=
        !1,d=a[c],e=k[c]&&k[c].call(this,d,c),e!==!1){
        e!==r&&(d=e);
        if(c==="d")d&&d.join&&(d=d.join(" ")),/(NaN| {2}|^$)/.test(d)&&(d="M 0 0");
        else if(c==="x"&&h==="text"){
            for(e=0;e<g.childNodes.length;e++)f=g.childNodes[e],G(f,"x")===G(g,"x")&&G(f,"x",d);
            this.rotation&&G(g,"transform","rotate("+this.rotation+" "+d+" "+F(a.y||G(g,"y"))+")")
            }else if(c==="fill")d=i.color(d,g,c);
        else if(h==="circle"&&(c==="x"||c==="y"))c={
            x:"cx",
            y:"cy"
        }
        [c]||c;
        else if(h==="rect"&&c==="r")G(g,{
            rx:d,
            ry:d
        }),j=!0;
        else if(c==="translateX"||
            c==="translateY"||c==="rotation"||c==="verticalAlign")j=o=!0;
        else if(c==="stroke")d=i.color(d,g,c);
        else if(c==="dashstyle")if(c="stroke-dasharray",d=d&&d.toLowerCase(),d==="solid")d=$;
            else{
            if(d){
                d=d.replace("shortdashdotdot","3,1,1,1,1,1,").replace("shortdashdot","3,1,1,1").replace("shortdot","1,1,").replace("shortdash","3,1,").replace("longdash","8,3,").replace(/dot/g,"1,3,").replace("dash","4,3,").replace(/,$/,"").split(",");
                for(e=d.length;e--;)d[e]=F(d[e])*a["stroke-width"];
                d=d.join(",")
                }
            }else if(c===
        "isTracker")this[c]=d;
        else if(c==="width")d=F(d);
        else if(c==="align")c="text-anchor",d={
        left:"start",
        center:"middle",
        right:"end"
    }
    [d];
    else if(c==="title")e=g.getElementsByTagName("title")[0],e||(e=E.createElementNS(ua,"title"),g.appendChild(e)),e.textContent=d;
        c==="strokeWidth"&&(c="stroke-width");
        Bb&&c==="stroke-width"&&d===0&&(d=1.0E-6);
        this.symbolName&&/^(x|y|width|height|r|start|end|innerR|anchorX|anchorY)/.test(c)&&(m||(this.symbolAttr(a),m=!0),j=!0);
        if(l&&/^(width|height|visibility|x|y|d|transform)$/.test(c))for(e=
        l.length;e--;)G(l[e],c,c==="height"?x(d-(l[e].cutHeight||0),0):d);
        if((c==="width"||c==="height")&&h==="rect"&&d<0)d=0;
        this[c]=d;
        o&&this.updateTransform();
        c==="text"?(d!==this.textStr&&delete this.bBox,this.textStr=d,this.added&&i.buildText(this)):j||G(g,c,d)
        }
        return s
},
symbolAttr:function(a){
    var b=this;
    n("x,y,r,start,end,width,height,innerR,anchorX,anchorY".split(","),function(c){
        b[c]=p(a[c],b[c])
        });
    b.attr({
        d:b.renderer.symbols[b.symbolName](b.x,b.y,b.width,b.height,b)
        })
    },
clip:function(a){
    return this.attr("clip-path",
        a?"url("+this.renderer.url+"#"+a.id+")":$)
    },
crisp:function(a,b,c,d,e){
    var f,g={},h={},i,a=a||this.strokeWidth||this.attr&&this.attr("stroke-width")||0;
    i=t(a)%2/2;
    h.x=Y(b||this.x||0)+i;
    h.y=Y(c||this.y||0)+i;
    h.width=Y((d||this.width||0)-2*i);
    h.height=Y((e||this.height||0)-2*i);
    h.strokeWidth=a;
    for(f in h)this[f]!==h[f]&&(this[f]=g[f]=h[f]);return g
    },
css:function(a){
    var b=this.element,b=a&&a.width&&b.nodeName.toLowerCase()==="text",c,d="",e=function(a,b){
        return"-"+b.toLowerCase()
        };
        
    if(a&&a.color)a.fill=
        a.color;
    this.styles=a=u(this.styles,a);
    ca&&b&&delete a.width;
    if(Na&&!ia)b&&delete a.width,L(this.element,a);
    else{
        for(c in a)d+=c.replace(/([A-Z])/g,e)+":"+a[c]+";";this.attr({
            style:d
        })
        }
        b&&this.added&&this.renderer.buildText(this);
    return this
    },
on:function(a,b){
    var c=b;
    ba&&a==="click"&&(a="touchstart",c=function(a){
        a.preventDefault();
        b()
        });
    this.element["on"+a]=c;
    return this
    },
setRadialReference:function(a){
    this.element.radialReference=a;
    return this
    },
translate:function(a,b){
    return this.attr({
        translateX:a,
        translateY:b
    })
    },
invert:function(){
    this.inverted=!0;
    this.updateTransform();
    return this
    },
htmlCss:function(a){
    var b=this.element;
    if(b=a&&b.tagName==="SPAN"&&a.width)delete a.width,this.textWidth=b,this.updateTransform();
    this.styles=u(this.styles,a);
    L(this.element,a);
    return this
    },
htmlGetBBox:function(){
    var a=this.element,b=this.bBox;
    if(!b){
        if(a.nodeName==="text")a.style.position="absolute";
        b=this.bBox={
            x:a.offsetLeft,
            y:a.offsetTop,
            width:a.offsetWidth,
            height:a.offsetHeight
            }
        }
    return b
},
htmlUpdateTransform:function(){
    if(this.added){
        var a=
        this.renderer,b=this.element,c=this.translateX||0,d=this.translateY||0,e=this.x||0,f=this.y||0,g=this.textAlign||"left",h={
            left:0,
            center:0.5,
            right:1
        }
        [g],i=g&&g!=="left",j=this.shadows;
        if(c||d)L(b,{
            marginLeft:c,
            marginTop:d
        }),j&&n(j,function(a){
            L(a,{
                marginLeft:c+1,
                marginTop:d+1
                })
            });
        this.inverted&&n(b.childNodes,function(c){
            a.invertChild(c,b)
            });
        if(b.tagName==="SPAN"){
            var k,l,j=this.rotation,m,o=0,s=1,o=0,y;
            m=F(this.textWidth);
            var q=this.xCorr||0,bb=this.yCorr||0,X=[j,g,b.innerHTML,this.textWidth].join(",");
            k={};
            
            if(X!==this.cTT){
                if(v(j))a.isSVG?(q=Na?"-ms-transform":Bb?"-webkit-transform":kb?"MozTransform":Rb?"-o-transform":"",k[q]=k.transform="rotate("+j+"deg)"):(o=j*jb,s=da(o),o=ha(o),k.filter=j?["progid:DXImageTransform.Microsoft.Matrix(M11=",s,", M12=",-o,", M21=",o,", M22=",s,", sizingMethod='auto expand')"].join(""):$),L(b,k);
                k=p(this.elemWidth,b.offsetWidth);
                l=p(this.elemHeight,b.offsetHeight);
                k>m&&/[ \-]/.test(b.innerText)&&(L(b,{
                    width:m+"px",
                    display:"block",
                    whiteSpace:"normal"
                }),k=m);
                m=a.fontMetrics(b.style.fontSize).b;
                q=s<0&&-k;
                bb=o<0&&-l;
                y=s*o<0;
                q+=o*m*(y?1-h:h);
                bb-=s*m*(j?y?h:1-h:1);
                i&&(q-=k*h*(s<0?-1:1),j&&(bb-=l*h*(o<0?-1:1)),L(b,{
                    textAlign:g
                }));
                this.xCorr=q;
                this.yCorr=bb
                }
                L(b,{
                left:e+q+"px",
                top:f+bb+"px"
                });
            this.cTT=X
            }
        }else this.alignOnAdd=!0
    },
updateTransform:function(){
    var a=this.translateX||0,b=this.translateY||0,c=this.inverted,d=this.rotation,e=[];
    c&&(a+=this.attr("width"),b+=this.attr("height"));
    (a||b)&&e.push("translate("+a+","+b+")");
    c?e.push("rotate(90) scale(-1,1)"):d&&e.push("rotate("+d+" "+(this.x||
        0)+" "+(this.y||0)+")");
    e.length&&G(this.element,"transform",e.join(" "))
    },
toFront:function(){
    var a=this.element;
    a.parentNode.appendChild(a);
    return this
    },
align:function(a,b,c){
    a?(this.alignOptions=a,this.alignByTranslate=b,c||this.renderer.alignedObjects.push(this)):(a=this.alignOptions,b=this.alignByTranslate);
    var c=p(c,this.renderer),d=a.align,e=a.verticalAlign,f=(c.x||0)+(a.x||0),g=(c.y||0)+(a.y||0),h={};
    
    if(d==="right"||d==="center")f+=(c.width-(a.width||0))/{
        right:1,
        center:2
    }
    [d];
    h[b?"translateX":
    "x"]=t(f);
    if(e==="bottom"||e==="middle")g+=(c.height-(a.height||0))/({
        bottom:1,
        middle:2
    }
    [e]||1);
    h[b?"translateY":"y"]=t(g);
    this[this.placed?"animate":"attr"](h);
    this.placed=!0;
    this.alignAttr=h;
    return this
    },
getBBox:function(){
    var a=this.bBox,b=this.renderer,c,d=this.rotation,e=this.element,f=this.styles,g=d*jb;
    if(!a){
        if(e.namespaceURI===ua||b.forExport){
            try{
                a=e.getBBox?u({},e.getBBox()):{
                    width:e.offsetWidth,
                    height:e.offsetHeight
                    }
                }catch(h){}
        if(!a||a.width<0)a={
            width:0,
            height:0
        }
        }else a=this.htmlGetBBox();
if(b.isSVG&&(b=a.width,c=a.height,d))a.width=V(c*ha(g))+V(b*da(g)),a.height=V(c*da(g))+V(b*ha(g));
if(Na&&f&&f.fontSize==="11px"&&c===22.700000762939453)a.height=14;
this.bBox=a
}
return a
},
show:function(){
    return this.attr({
        visibility:"visible"
    })
    },
hide:function(){
    return this.attr({
        visibility:"hidden"
    })
    },
add:function(a){
    var b=this.renderer,c=a||b,d=c.element||b.box,e=d.childNodes,f=this.element,g=G(f,"zIndex"),h;
    if(a)this.parentGroup=a;
    this.parentInverted=a&&a.inverted;
    this.textStr!==void 0&&b.buildText(this);
    if(g)c.handleZ=!0,g=F(g);
    if(c.handleZ)for(c=0;c<e.length;c++)if(a=e[c],b=G(a,"zIndex"),a!==f&&(F(b)>g||!v(g)&&v(b))){
        d.insertBefore(f,a);
        h=!0;
        break
    }
    h||d.appendChild(f);
    this.added=!0;
    J(this,"add");
    return this
    },
safeRemoveChild:function(a){
    var b=a.parentNode;
    b&&b.removeChild(a)
    },
destroy:function(){
    var a=this,b=a.element||{},c=a.shadows,d,e;
    b.onclick=b.onmouseout=b.onmouseover=b.onmousemove=null;
    nb(a);
    if(a.clipPath)a.clipPath=a.clipPath.destroy();
    if(a.stops){
        for(e=0;e<a.stops.length;e++)a.stops[e]=a.stops[e].destroy();
        a.stops=null
        }
        a.safeRemoveChild(b);
    c&&n(c,function(b){
        a.safeRemoveChild(b)
        });
    Ma(a.renderer.alignedObjects,a);
    for(d in a)delete a[d];return null
    },
empty:function(){
    for(var a=this.element,b=a.childNodes,c=b.length;c--;)a.removeChild(b[c])
        },
shadow:function(a,b,c){
    var d=[],e,f,g=this.element,h,i,j,k;
    if(a){
        i=p(a.width,3);
        j=(a.opacity||0.15)/i;
        k=this.parentInverted?"(-1,-1)":"("+p(a.offsetX,1)+", "+p(a.offsetY,1)+")";
        for(e=1;e<=i;e++){
            f=g.cloneNode(0);
            h=i*2+1-2*e;
            G(f,{
                isShadow:"true",
                stroke:a.color||"black",
                "stroke-opacity":j*e,
                "stroke-width":h,
                transform:"translate"+k,
                fill:$
            });
            if(c)G(f,"height",x(G(f,"height")-h,0)),f.cutHeight=h;
            b?b.element.appendChild(f):g.parentNode.insertBefore(f,g);
            d.push(f)
            }
            this.shadows=d
        }
        return this
    }
};

var pa=function(){
    this.init.apply(this,arguments)
    };
    
pa.prototype={
    Element:Ga,
    init:function(a,b,c,d){
        var e=location,f;
        f=this.createElement("svg").attr({
            xmlns:ua,
            version:"1.1"
        });
        a.appendChild(f.element);
        this.isSVG=!0;
        this.box=f.element;
        this.boxWrapper=f;
        this.alignedObjects=[];
        this.url=
        (kb||Bb)&&E.getElementsByTagName("base").length?e.href.replace(/#.*?$/,"").replace(/([\('\)])/g,"\\$1").replace(/ /g,"%20"):"";
        this.defs=this.createElement("defs").add();
        this.forExport=d;
        this.gradients={};
        
        this.setSize(b,c,!1);
        var g;
        if(kb&&a.getBoundingClientRect)this.subPixelFix=b=function(){
            L(a,{
                left:0,
                top:0
            });
            g=a.getBoundingClientRect();
            L(a,{
                left:Ha(g.left)-g.left+"px",
                top:Ha(g.top)-g.top+"px"
                })
            },b(),D(S,"resize",b)
            },
    isHidden:function(){
        return!this.boxWrapper.getBBox().width
        },
    destroy:function(){
        var a=
        this.defs;
        this.box=null;
        this.boxWrapper=this.boxWrapper.destroy();
        ta(this.gradients||{});
        this.gradients=null;
        if(a)this.defs=a.destroy();
        this.subPixelFix&&O(S,"resize",this.subPixelFix);
        return this.alignedObjects=null
        },
    createElement:function(a){
        var b=new this.Element;
        b.init(this,a);
        return b
        },
    draw:function(){},
    buildText:function(a){
        for(var b=a.element,c=p(a.textStr,"").toString().replace(/<(b|strong)>/g,'<span style="font-weight:bold">').replace(/<(i|em)>/g,'<span style="font-style:italic">').replace(/<a/g,
            "<span").replace(/<\/(b|strong|i|em|a)>/g,"</span>").split(/<br.*?>/g),d=b.childNodes,e=/style="([^"]+)"/,f=/href="([^"]+)"/,g=G(b,"x"),h=a.styles,i=h&&h.width&&F(h.width),j=h&&h.lineHeight,k,h=d.length,l=[];h--;)b.removeChild(d[h]);
        i&&!a.added&&this.box.appendChild(b);
        c[c.length-1]===""&&c.pop();
        n(c,function(c,d){
            var h,y=0,q,c=c.replace(/<span/g,"|||<span").replace(/<\/span>/g,"</span>|||");
            h=c.split("|||");
            n(h,function(c){
                if(c!==""||h.length===1){
                    var m={},n=E.createElementNS(ua,"tspan"),p;
                    e.test(c)&&
                    (p=c.match(e)[1].replace(/(;| |^)color([ :])/,"$1fill$2"),G(n,"style",p));
                    f.test(c)&&(G(n,"onclick",'location.href="'+c.match(f)[1]+'"'),L(n,{
                        cursor:"pointer"
                    }));
                    c=(c.replace(/<(.|\n)*?>/g,"")||" ").replace(/&lt;/g,"<").replace(/&gt;/g,">");
                    n.appendChild(E.createTextNode(c));
                    y?m.dx=3:m.x=g;
                    if(!y){
                        if(d){
                            !ia&&a.renderer.forExport&&L(n,{
                                display:"block"
                            });
                            q=S.getComputedStyle&&F(S.getComputedStyle(k,null).getPropertyValue("line-height"));
                            if(!q||isNaN(q)){
                                var A;
                                if(!(A=j))if(!(A=k.offsetHeight))l[d]=b.getBBox?
                                    b.getBBox().height:a.renderer.fontMetrics(b.style.fontSize).h,A=t(l[d]-(l[d-1]||0))||18;
                                q=A
                                }
                                G(n,"dy",q)
                            }
                            k=n
                        }
                        G(n,m);
                    b.appendChild(n);
                    y++;
                    if(i)for(var c=c.replace(/([^\^])-/g,"$1- ").split(" "),B=[];c.length||B.length;)delete a.bBox,A=a.getBBox().width,m=A>i,!m||c.length===1?(c=B,B=[],c.length&&(n=E.createElementNS(ua,"tspan"),G(n,{
                        dy:j||16,
                        x:g
                    }),p&&G(n,"style",p),b.appendChild(n),A>i&&(i=A))):(n.removeChild(n.firstChild),B.unshift(c.pop())),c.length&&n.appendChild(E.createTextNode(c.join(" ").replace(/- /g,
                        "-")))
                    }
                    })
        })
    },
button:function(a,b,c,d,e,f,g){
    var h=this.label(a,b,c),i=0,j,k,l,m,o,a={
        x1:0,
        y1:0,
        x2:0,
        y2:1
    },e=w(ja("stroke-width",1,"stroke","#999","fill",ja("linearGradient",a,"stops",[[0,"#FFF"],[1,"#DDD"]]),"r",3,"padding",3,"style",ja("color","black")),e);
    l=e.style;
    delete e.style;
    f=w(e,ja("stroke","#68A","fill",ja("linearGradient",a,"stops",[[0,"#FFF"],[1,"#ACF"]])),f);
    m=f.style;
    delete f.style;
    g=w(e,ja("stroke","#68A","fill",ja("linearGradient",a,"stops",[[0,"#9BD"],[1,"#CDF"]])),g);
    o=g.style;
    delete g.style;
    D(h.element,"mouseenter",function(){
        h.attr(f).css(m)
        });
    D(h.element,"mouseleave",function(){
        j=[e,f,g][i];
        k=[l,m,o][i];
        h.attr(j).css(k)
        });
    h.setState=function(a){
        (i=a)?a===2&&h.attr(g).css(o):h.attr(e).css(l)
        };
        
    return h.on("click",function(){
        d.call(h)
        }).attr(e).css(u({
        cursor:"default"
    },l))
    },
crispLine:function(a,b){
    a[1]===a[4]&&(a[1]=a[4]=t(a[1])-b%2/2);
    a[2]===a[5]&&(a[2]=a[5]=t(a[2])+b%2/2);
    return a
    },
path:function(a){
    var b={
        fill:$
    };
    
    Wa(a)?b.d=a:ga(a)&&u(b,a);
    return this.createElement("path").attr(b)
    },
circle:function(a,b,c){
    a=ga(a)?a:{
        x:a,
        y:b,
        r:c
    };
    
    return this.createElement("circle").attr(a)
    },
arc:function(a,b,c,d,e,f){
    if(ga(a))b=a.y,c=a.r,d=a.innerR,e=a.start,f=a.end,a=a.x;
    return this.symbol("arc",a||0,b||0,c||0,c||0,{
        innerR:d||0,
        start:e||0,
        end:f||0
        })
    },
rect:function(a,b,c,d,e,f){
    e=ga(a)?a.r:e;
    e=this.createElement("rect").attr({
        rx:e,
        ry:e,
        fill:$
    });
    return e.attr(ga(a)?a:e.crisp(f,a,b,x(c,0),x(d,0)))
    },
setSize:function(a,b,c){
    var d=this.alignedObjects,e=d.length;
    this.width=a;
    this.height=b;
    for(this.boxWrapper[p(c,
        !0)?"animate":"attr"]({
        width:a,
        height:b
    });e--;)d[e].align()
        },
g:function(a){
    var b=this.createElement("g");
    return v(a)?b.attr({
        "class":"highcharts-"+a
        }):b
    },
image:function(a,b,c,d,e){
    var f={
        preserveAspectRatio:$
    };
    
    arguments.length>1&&u(f,{
        x:b,
        y:c,
        width:d,
        height:e
    });
    f=this.createElement("image").attr(f);
    f.element.setAttributeNS?f.element.setAttributeNS("http://www.w3.org/1999/xlink","href",a):f.element.setAttribute("hc-svg-href",a);
    return f
    },
symbol:function(a,b,c,d,e,f){
    var g,h=this.symbols[a],h=h&&h(t(b),
        t(c),d,e,f),i=/^url\((.*?)\)$/,j,k;
    h?(g=this.path(h),u(g,{
        symbolName:a,
        x:b,
        y:c,
        width:d,
        height:e
    }),f&&u(g,f)):i.test(a)&&(k=function(a,b){
        a.attr({
            width:b[0],
            height:b[1]
            });
        a.alignByTranslate||a.translate(-t(b[0]/2),-t(b[1]/2))
        },j=a.match(i)[1],a=Sb[j],g=this.image(j).attr({
        x:b,
        y:c
    }),a?k(g,a):(g.attr({
        width:0,
        height:0
    }),U("img",{
        onload:function(){
            k(g,Sb[j]=[this.width,this.height])
            },
        src:j
    })));
    return g
    },
symbols:{
    circle:function(a,b,c,d){
        var e=0.166*c;
        return["M",a+c/2,b,"C",a+c+e,b,a+c+e,b+d,a+c/2,b+d,
        "C",a-e,b+d,a-e,b,a+c/2,b,"Z"]
        },
    square:function(a,b,c,d){
        return["M",a,b,"L",a+c,b,a+c,b+d,a,b+d,"Z"]
        },
    triangle:function(a,b,c,d){
        return["M",a+c/2,b,"L",a+c,b+d,a,b+d,"Z"]
        },
    "triangle-down":function(a,b,c,d){
        return["M",a,b,"L",a+c,b,a+c/2,b+d,"Z"]
        },
    diamond:function(a,b,c,d){
        return["M",a+c/2,b,"L",a+c,b+d/2,a+c/2,b+d,a,b+d/2,"Z"]
        },
    arc:function(a,b,c,d,e){
        var f=e.start,c=e.r||c||d,g=e.end-1.0E-6,d=e.innerR,h=e.open,i=da(f),j=ha(f),k=da(g),g=ha(g),e=e.end-f<Ia?0:1;
        return["M",a+c*i,b+c*j,"A",c,c,0,e,1,
        a+c*k,b+c*g,h?"M":"L",a+d*k,b+d*g,"A",d,d,0,e,0,a+d*i,b+d*j,h?"":"Z"]
        }
    },
clipRect:function(a,b,c,d){
    var e="highcharts-"+Cb++,f=this.createElement("clipPath").attr({
        id:e
    }).add(this.defs),a=this.rect(a,b,c,d,0).add(f);
    a.id=e;
    a.clipPath=f;
    return a
    },
color:function(a,b,c){
    var d=this,e,f=/^rgba/,g;
    a&&a.linearGradient?g="linearGradient":a&&a.radialGradient&&(g="radialGradient");
    if(g){
        var c=a[g],h=d.gradients,i,j,k,b=b.radialReference;
        if(!c.id||!h[c.id])Wa(c)&&(a[g]=c={
            x1:c[0],
            y1:c[1],
            x2:c[2],
            y2:c[3],
            gradientUnits:"userSpaceOnUse"
        }),
        g==="radialGradient"&&b&&!v(c.gradientUnits)&&u(c,{
            cx:b[0]-b[2]/2+c.cx*b[2],
            cy:b[1]-b[2]/2+c.cy*b[2],
            r:c.r*b[2],
            gradientUnits:"userSpaceOnUse"
        }),c.id="highcharts-"+Cb++,h[c.id]=i=d.createElement(g).attr(c).add(d.defs),i.stops=[],n(a.stops,function(a){
            f.test(a[1])?(e=wa(a[1]),j=e.get("rgb"),k=e.get("a")):(j=a[1],k=1);
            a=d.createElement("stop").attr({
                offset:a[0],
                "stop-color":j,
                "stop-opacity":k
            }).add(i);
            i.stops.push(a)
            });
        return"url("+d.url+"#"+c.id+")"
        }else return f.test(a)?(e=wa(a),G(b,c+"-opacity",
        e.get("a")),e.get("rgb")):(b.removeAttribute(c+"-opacity"),a)
        },
text:function(a,b,c,d){
    var e=P.chart.style,f=ca||!ia&&this.forExport;
    if(d&&!this.forExport)return this.html(a,b,c);
    b=t(p(b,0));
    c=t(p(c,0));
    a=this.createElement("text").attr({
        x:b,
        y:c,
        text:a
    }).css({
        fontFamily:e.fontFamily,
        fontSize:e.fontSize
        });
    f&&a.css({
        position:"absolute"
    });
    a.x=b;
    a.y=c;
    return a
    },
html:function(a,b,c){
    var d=P.chart.style,e=this.createElement("span"),f=e.attrSetters,g=e.element,h=e.renderer;
    f.text=function(a){
        a!==g.innerHTML&&
        delete this.bBox;
        g.innerHTML=a;
        return!1
        };
        
    f.x=f.y=f.align=function(a,b){
        b==="align"&&(b="textAlign");
        e[b]=a;
        e.htmlUpdateTransform();
        return!1
        };
        
    e.attr({
        text:a,
        x:t(b),
        y:t(c)
        }).css({
        position:"absolute",
        whiteSpace:"nowrap",
        fontFamily:d.fontFamily,
        fontSize:d.fontSize
        });
    e.css=e.htmlCss;
    if(h.isSVG)e.add=function(a){
        var b,c=h.box.parentNode,d=[];
        if(a){
            if(b=a.div,!b){
                for(;a;)d.push(a),a=a.parentGroup;
                n(d.reverse(),function(a){
                    var d;
                    b=a.div=a.div||U(oa,{
                        className:G(a.element,"class")
                        },{
                        position:"absolute",
                        left:(a.translateX||
                            0)+"px",
                        top:(a.translateY||0)+"px"
                        },b||c);
                    d=b.style;
                    u(a.attrSetters,{
                        translateX:function(a){
                            d.left=a+"px"
                            },
                        translateY:function(a){
                            d.top=a+"px"
                            },
                        visibility:function(a,b){
                            d[b]=a
                            }
                        })
                })
            }
        }else b=c;
    b.appendChild(g);
    e.added=!0;
    e.alignOnAdd&&e.htmlUpdateTransform();
    return e
    };
    
return e
},
fontMetrics:function(a){
    var a=F(a||11),a=a<24?a+4:t(a*1.2),b=t(a*0.8);
    return{
        h:a,
        b:b
    }
},
label:function(a,b,c,d,e,f,g,h,i){
    function j(){
        var a=o.styles,a=a&&a.textAlign,b=X*(1-p),c;
        c=h?0:x;
        if(v(I)&&(a==="center"||a==="right"))b+=

        {
            center:0.5,
            right:1
        }
        [a]*(I-q.width);
        (b!==s.x||c!==s.y)&&s.attr({
            x:b,
            y:c
        });
        s.x=b;
        s.y=c
        }
        function k(a,b){
        y?y.attr(a,b):Va[a]=b
        }
        function l(){
        s.add(o);
        o.attr({
            text:a,
            x:b,
            y:c
        });
        v(e)&&o.attr({
            anchorX:e,
            anchorY:f
        })
        }
        var m=this,o=m.g(i),s=m.text("",0,0,g).attr({
        zIndex:1
    }),y,q,p=0,X=3,I,z,A,B,Z=0,Va={},x,g=o.attrSetters;
    D(o,"add",l);
    g.width=function(a){
        I=a;
        return!1
        };
        
    g.height=function(a){
        z=a;
        return!1
        };
        
    g.padding=function(a){
        v(a)&&a!==X&&(X=a,j());
        return!1
        };
        
    g.align=function(a){
        p={
            left:0,
            center:0.5,
            right:1
        }
        [a];
        return!1
        };
        
    g.text=function(a,b){
        s.attr(b,a);
        var c;
        c=s.element.style;
        q=(I===void 0||z===void 0||o.styles.textAlign)&&s.getBBox();
        o.width=(I||q.width||0)+2*X;
        o.height=(z||q.height||0)+2*X;
        x=X+m.fontMetrics(c&&c.fontSize).b;
        if(!y)c=h?-x:0,o.box=y=d?m.symbol(d,-p*X,c,o.width,o.height):m.rect(-p*X,c,o.width,o.height,0,Va["stroke-width"]),y.add(o);
        y.attr(w({
            width:o.width,
            height:o.height
            },Va));
        Va=null;
        j();
        return!1
        };
        
    g["stroke-width"]=function(a,b){
        Z=a%2/2;
        k(b,a);
        return!1
        };
        
    g.stroke=g.fill=g.r=function(a,b){
        k(b,
            a);
        return!1
        };
        
    g.anchorX=function(a,b){
        e=a;
        k(b,a+Z-A);
        return!1
        };
        
    g.anchorY=function(a,b){
        f=a;
        k(b,a-B);
        return!1
        };
        
    g.x=function(a){
        o.x=a;
        a-=p*((I||q.width)+X);
        A=t(a);
        o.attr("translateX",A);
        return!1
        };
        
    g.y=function(a){
        B=o.y=t(a);
        o.attr("translateY",a);
        return!1
        };
        
    var dc=o.css;
    return u(o,{
        css:function(a){
            if(a){
                var b={},a=w({},a);
                n("fontSize,fontWeight,fontFamily,color,lineHeight,width".split(","),function(c){
                    a[c]!==r&&(b[c]=a[c],delete a[c])
                    });
                s.css(b)
                }
                return dc.call(o,a)
            },
        getBBox:function(){
            return y.getBBox()
            },
        shadow:function(a){
            y.shadow(a);
            return o
            },
        destroy:function(){
            O(o,"add",l);
            O(o.element,"mouseenter");
            O(o.element,"mouseleave");
            s&&(s=s.destroy());
            y&&(y=y.destroy());
            Ga.prototype.destroy.call(o)
            }
        })
}
};

Ua=pa;
var Ka;
if(!ia&&!ca){
    var ea={
        init:function(a,b){
            var c=["<",b,' filled="f" stroked="f"'],d=["position: ","absolute",";"];
            (b==="shape"||b===oa)&&d.push("left:0;top:0;width:1px;height:1px;");
            ab&&d.push("visibility: ",b===oa?"hidden":"visible");
            c.push(' style="',d.join(""),'"/>');
            if(b)c=b===oa||b==="span"||
                b==="img"?c.join(""):a.prepVML(c),this.element=U(c);
            this.renderer=a;
            this.attrSetters={}
        },
    add:function(a){
        var b=this.renderer,c=this.element,d=b.box,d=a?a.element||a:d;
        a&&a.inverted&&b.invertChild(c,d);
        d.appendChild(c);
        this.added=!0;
        this.alignOnAdd&&!this.deferUpdateTransform&&this.updateTransform();
        J(this,"add");
        return this
        },
    updateTransform:Ga.prototype.htmlUpdateTransform,
    attr:function(a,b){
        var c,d,e,f=this.element||{},g=f.style,h=f.nodeName,i=this.renderer,j=this.symbolName,k,l=this.shadows,m,o=
        this.attrSetters,s=this;
        qa(a)&&v(b)&&(c=a,a={},a[c]=b);
        if(qa(a))c=a,s=c==="strokeWidth"||c==="stroke-width"?this.strokeweight:this[c];else for(c in a)if(d=a[c],m=!1,e=o[c]&&o[c].call(this,d,c),e!==!1&&d!==null){
            e!==r&&(d=e);
            if(j&&/^(x|y|r|start|end|width|height|innerR|anchorX|anchorY)/.test(c))k||(this.symbolAttr(a),k=!0),m=!0;
            else if(c==="d"){
                d=d||[];
                this.d=d.join(" ");
                e=d.length;
                for(m=[];e--;)m[e]=za(d[e])?t(d[e]*10)-5:d[e]==="Z"?"x":d[e];
                d=m.join(" ")||"x";
                f.path=d;
                if(l)for(e=l.length;e--;)l[e].path=
                    l[e].cutOff?this.cutOffPath(d,l[e].cutOff):d;
                m=!0
                }else if(c==="visibility"){
                if(l)for(e=l.length;e--;)l[e].style[c]=d;
                h==="DIV"&&(d=d==="hidden"?"-999em":0,c="top");
                g[c]=d;
                m=!0
                }else if(c==="zIndex")d&&(g[c]=d),m=!0;
            else if(c==="width"||c==="height")d=x(0,d),this[c]=d,this.updateClipping?(this[c]=d,this.updateClipping()):g[c]=d,m=!0;
            else if(c==="x"||c==="y")this[c]=d,g[{
                x:"left",
                y:"top"
            }
            [c]]=d;
            else if(c==="class")f.className=d;
            else if(c==="stroke")d=i.color(d,f,c),c="strokecolor";
            else if(c==="stroke-width"||
                c==="strokeWidth")f.stroked=d?!0:!1,c="strokeweight",this[c]=d,za(d)&&(d+="px");
            else if(c==="dashstyle")(f.getElementsByTagName("stroke")[0]||U(i.prepVML(["<stroke/>"]),null,null,f))[c]=d||"solid",this.dashstyle=d,m=!0;
            else if(c==="fill")h==="SPAN"?g.color=d:(f.filled=d!==$?!0:!1,d=i.color(d,f,c,this),c="fillcolor");
            else if(h==="shape"&&c==="rotation")this[c]=d,f.style.left=-t(ha(d*jb)+1)+"px",f.style.top=t(da(d*jb))+"px";
            else if(c==="translateX"||c==="translateY"||c==="rotation")this[c]=d,this.updateTransform(),
                m=!0;
            else if(c==="text")this.bBox=null,f.innerHTML=d,m=!0;
            m||(ab?f[c]=d:G(f,c,d))
            }
            return s
        },
    clip:function(a){
        var b=this,c,d=b.element,e=d.parentNode;
        a?(c=a.members,c.push(b),b.destroyClip=function(){
            Ma(c,b)
            },e&&e.className==="highcharts-tracker"&&!ab&&L(d,{
            visibility:"hidden"
        }),a=a.getCSS(b)):(b.destroyClip&&b.destroyClip(),a={
            clip:ab?"inherit":"rect(auto)"
            });
        return b.css(a)
        },
    css:Ga.prototype.htmlCss,
    safeRemoveChild:function(a){
        a.parentNode&&Ra(a)
        },
    destroy:function(){
        this.destroyClip&&this.destroyClip();
        return Ga.prototype.destroy.apply(this)
        },
    empty:function(){
        for(var a=this.element.childNodes,b=a.length,c;b--;)c=a[b],c.parentNode.removeChild(c)
            },
    on:function(a,b){
        this.element["on"+a]=function(){
            var a=S.event;
            a.target=a.srcElement;
            b(a)
            };
            
        return this
        },
    cutOffPath:function(a,b){
        var c,a=a.split(/[ ,]/);
        c=a.length;
        if(c===9||c===11)a[c-4]=a[c-2]=F(a[c-2])-10*b;
        return a.join(" ")
        },
    shadow:function(a,b,c){
        var d=[],e,f=this.element,g=this.renderer,h,i=f.style,j,k=f.path,l,m,o,s;
        k&&typeof k.value!=="string"&&
        (k="x");
        m=k;
        if(a){
            o=p(a.width,3);
            s=(a.opacity||0.15)/o;
            for(e=1;e<=3;e++){
                l=o*2+1-2*e;
                c&&(m=this.cutOffPath(k.value,l+0.5));
                j=['<shape isShadow="true" strokeweight="',l,'" filled="false" path="',m,'" coordsize="10 10" style="',f.style.cssText,'" />'];
                h=U(g.prepVML(j),null,{
                    left:F(i.left)+p(a.offsetX,1),
                    top:F(i.top)+p(a.offsetY,1)
                    });
                if(c)h.cutOff=l+1;
                j=['<stroke color="',a.color||"black",'" opacity="',s*e,'"/>'];
                U(g.prepVML(j),null,null,h);
                b?b.element.appendChild(h):f.parentNode.insertBefore(h,f);
                d.push(h)
                }
                this.shadows=
            d
            }
            return this
        }
    },ea=aa(Ga,ea),ea={
    Element:ea,
    isIE8:Ta.indexOf("MSIE 8.0")>-1,
    init:function(a,b,c){
        var d,e;
        this.alignedObjects=[];
        d=this.createElement(oa);
        e=d.element;
        e.style.position="relative";
        a.appendChild(d.element);
        this.box=e;
        this.boxWrapper=d;
        this.setSize(b,c,!1);
        if(!E.namespaces.hcv)E.namespaces.add("hcv","urn:schemas-microsoft-com:vml"),E.createStyleSheet().cssText="hcv\\:fill, hcv\\:path, hcv\\:shape, hcv\\:stroke{ behavior:url(#default#VML); display: inline-block; } "
            },
    isHidden:function(){
        return!this.box.offsetWidth
        },
    clipRect:function(a,b,c,d){
        var e=this.createElement(),f=ga(a);
        return u(e,{
            members:[],
            left:f?a.x:a,
            top:f?a.y:b,
            width:f?a.width:c,
            height:f?a.height:d,
            getCSS:function(a){
                var b=a.inverted,c=this.top,d=this.left,e=d+this.width,f=c+this.height,c={
                    clip:"rect("+t(b?d:c)+"px,"+t(b?f:e)+"px,"+t(b?e:f)+"px,"+t(b?c:d)+"px)"
                    };
                !b&&ab&&a.element.nodeName!=="IMG"&&u(c,{
                    width:e+"px",
                    height:f+"px"
                    });
                return c
                },
            updateClipping:function(){
                n(e.members,function(a){
                    a.css(e.getCSS(a))
                    })
                }
            })
    },
color:function(a,b,c,d){
    var e=this,
    f,g=/^rgba/,h,i,j=$;
    a&&a.linearGradient?i="gradient":a&&a.radialGradient&&(i="pattern");
    if(i){
        var k,l,m=a.linearGradient||a.radialGradient,o,s,y,q,p,X="",a=a.stops,I,z=[],A=function(){
            h=['<fill colors="'+z.join(",")+'" opacity="',y,'" o:opacity2="',s,'" type="',i,'" ',X,'focus="100%" method="any" />'];
            U(e.prepVML(h),null,null,b)
            };
            
        o=a[0];
        I=a[a.length-1];
        o[0]>0&&a.unshift([0,o[1]]);
        I[0]<1&&a.push([1,I[1]]);
        n(a,function(a,b){
            g.test(a[1])?(f=wa(a[1]),k=f.get("rgb"),l=f.get("a")):(k=a[1],l=1);
            z.push(a[0]*
                100+"% "+k);
            b?(y=l,q=k):(s=l,p=k)
            });
        if(c==="fill")if(i==="gradient")c=m.x1||m[0]||0,a=m.y1||m[1]||0,o=m.x2||m[2]||0,m=m.y2||m[3]||0,X='angle="'+(90-M.atan((m-a)/(o-c))*180/Ia)+'"',A();
            else{
            var j=m.r,B=j*2,Z=j*2,r=m.cx,v=m.cy,t=b.radialReference,x,j=function(){
                t&&(x=d.getBBox(),r+=(t[0]-x.x)/x.width-0.5,v+=(t[1]-x.y)/x.height-0.5,B*=t[2]/x.width,Z*=t[2]/x.height);
                X='src="'+P.global.VMLRadialGradientURL+'" size="'+B+","+Z+'" origin="0.5,0.5" position="'+r+","+v+'" color2="'+p+'" ';
                A()
                };
                
            d.added?j():
            D(d,"add",j);
            j=q
            }else j=k
            }else if(g.test(a)&&b.tagName!=="IMG")f=wa(a),h=["<",c,' opacity="',f.get("a"),'"/>'],U(this.prepVML(h),null,null,b),j=f.get("rgb");
    else{
        j=b.getElementsByTagName(c);
        if(j.length)j[0].opacity=1;
        j=a
        }
        return j
    },
prepVML:function(a){
    var b=this.isIE8,a=a.join("");
    b?(a=a.replace("/>",' xmlns="urn:schemas-microsoft-com:vml" />'),a=a.indexOf('style="')===-1?a.replace("/>",' style="display:inline-block;behavior:url(#default#VML);" />'):a.replace('style="','style="display:inline-block;behavior:url(#default#VML);')):
    a=a.replace("<","<hcv:");
    return a
    },
text:pa.prototype.html,
path:function(a){
    var b={
        coordsize:"10 10"
    };
    
    Wa(a)?b.d=a:ga(a)&&u(b,a);
    return this.createElement("shape").attr(b)
    },
circle:function(a,b,c){
    return this.symbol("circle").attr({
        x:a-c,
        y:b-c,
        width:2*c,
        height:2*c
        })
    },
g:function(a){
    var b;
    a&&(b={
        className:"highcharts-"+a,
        "class":"highcharts-"+a
        });
    return this.createElement(oa).attr(b)
    },
image:function(a,b,c,d,e){
    var f=this.createElement("img").attr({
        src:a
    });
    arguments.length>1&&f.attr({
        x:b,
        y:c,
        width:d,
        height:e
    });
    return f
    },
rect:function(a,b,c,d,e,f){
    if(ga(a))b=a.y,c=a.width,d=a.height,f=a.strokeWidth,a=a.x;
    var g=this.symbol("rect");
    g.r=e;
    return g.attr(g.crisp(f,a,b,x(c,0),x(d,0)))
    },
invertChild:function(a,b){
    var c=b.style;
    L(a,{
        flip:"x",
        left:F(c.width)-1,
        top:F(c.height)-1,
        rotation:-90
    })
    },
symbols:{
    arc:function(a,b,c,d,e){
        var f=e.start,g=e.end,h=e.r||c||d,c=da(f),d=ha(f),i=da(g),j=ha(g),k=e.innerR,l=0.08/h,m=k&&0.1/k||0;
        if(g-f===0)return["x"];else 2*Ia-g+f<l?i=-l:g-f<m&&(i=da(f+m));
        f=["wa",a-h,b-h,a+h,b+h,a+h*
        c,b+h*d,a+h*i,b+h*j];
        e.open&&!k&&f.push("e","M",a,b);
        f.push("at",a-k,b-k,a+k,b+k,a+k*i,b+k*j,a+k*c,b+k*d,"x","e");
        return f
        },
    circle:function(a,b,c,d){
        return["wa",a,b,a+c,b+d,a+c,b+d/2,a+c,b+d/2,"e"]
        },
    rect:function(a,b,c,d,e){
        var f=a+c,g=b+d,h;
        !v(e)||!e.r?f=pa.prototype.symbols.square.apply(0,arguments):(h=K(e.r,c,d),f=["M",a+h,b,"L",f-h,b,"wa",f-2*h,b,f,b+2*h,f-h,b,f,b+h,"L",f,g-h,"wa",f-2*h,g-2*h,f,g,f,g-h,f-h,g,"L",a+h,g,"wa",a,g-2*h,a+2*h,g,a+h,g,a,g-h,"L",a,b+h,"wa",a,b,a+2*h,b+2*h,a,b+h,a+h,b,
            "x","e"]);
        return f
        }
    }
};

Ka=function(){
    this.init.apply(this,arguments)
    };
    
Ka.prototype=w(pa.prototype,ea);
Ua=Ka
}
var ob,Vb;
if(ca)ob=function(){
    ua="http://www.w3.org/1999/xhtml"
    },ob.prototype.symbols={},Vb=function(){
    function a(){
        var a=b.length,d;
        for(d=0;d<a;d++)b[d]();
        b=[]
        }
        var b=[];
    return{
        push:function(c,d){
            b.length===0&&ac(d,a);
            b.push(c)
            }
        }
}();
Ua=Ka||ob||pa;
Za.prototype={
    addLabel:function(){
        var a=this.axis,b=a.options,c=a.chart,d=a.horiz,e=a.categories,f=this.pos,g=b.labels,h=a.tickPositions,d=e&&d&&e.length&&
        !g.step&&!g.staggerLines&&!g.rotation&&c.plotWidth/h.length||!d&&c.plotWidth/2,i=f===h[0],j=f===h[h.length-1],k=e&&v(e[f])?e[f]:f,e=this.label,h=h.info,l;
        a.isDatetimeAxis&&h&&(l=b.dateTimeLabelFormats[h.higherRanks[f]||h.unitName]);
        this.isFirst=i;
        this.isLast=j;
        b=a.labelFormatter.call({
            axis:a,
            chart:c,
            isFirst:i,
            isLast:j,
            dateTimeLabelFormat:l,
            value:a.isLog?ma(ka(k)):k
            });
        f=d&&{
            width:x(1,t(d-2*(g.padding||10)))+"px"
            };
            
        f=u(f,g.style);
        if(v(e))e&&e.attr({
            text:b
        }).css(f);
        else{
            d={
                align:g.align
                };
                
            if(za(g.rotation))d.rotation=
                g.rotation;
            this.label=v(b)&&g.enabled?c.renderer.text(b,0,0,g.useHTML).attr(d).css(f).add(a.labelGroup):null
            }
        },
getLabelSize:function(){
    var a=this.label,b=this.axis;
    return a?(this.labelBBox=a.getBBox())[b.horiz?"height":"width"]:0
    },
getLabelSides:function(){
    var a=this.axis.options.labels,b=this.labelBBox.width,a=b*{
        left:0,
        center:0.5,
        right:1
    }
    [a.align]-a.x;
    return[-a,b-a]
    },
handleOverflow:function(a,b){
    var c=!0,d=this.axis,e=d.chart,f=this.isFirst,g=this.isLast,h=b.x,i=d.reversed,j=d.tickPositions;
    if(f||
        g){
        var k=this.getLabelSides(),l=k[0],k=k[1],e=e.plotLeft,m=e+d.len,j=(d=d.ticks[j[a+(f?1:-1)]])&&d.label.xy&&d.label.xy.x+d.getLabelSides()[f?0:1];
        f&&!i||g&&i?h+l<e&&(h=e-l,d&&h+k>j&&(c=!1)):h+k>m&&(h=m-k,d&&h+l<j&&(c=!1));
        b.x=h
        }
        return c
    },
getPosition:function(a,b,c,d){
    var e=this.axis,f=e.chart,g=d&&f.oldChartHeight||f.chartHeight;
    return{
        x:a?e.translate(b+c,null,null,d)+e.transB:e.left+e.offset+(e.opposite?(d&&f.oldChartWidth||f.chartWidth)-e.right-e.left:0),
        y:a?g-e.bottom+e.offset-(e.opposite?e.height:
            0):g-e.translate(b+c,null,null,d)-e.transB
        }
    },
getLabelPosition:function(a,b,c,d,e,f,g,h){
    var i=this.axis,j=i.transA,k=i.reversed,i=i.staggerLines,a=a+e.x-(f&&d?f*j*(k?-1:1):0),b=b+e.y-(f&&!d?f*j*(k?1:-1):0);
    v(e.y)||(b+=F(c.styles.lineHeight)*0.9-c.getBBox().height/2);
    i&&(b+=g/(h||1)%i*16);
    return{
        x:a,
        y:b
    }
},
getMarkPath:function(a,b,c,d,e,f){
    return f.crispLine(["M",a,b,"L",a+(e?0:-c),b+(e?c:0)],d)
    },
render:function(a,b){
    var c=this.axis,d=c.options,e=c.chart.renderer,f=c.horiz,g=this.type,h=this.label,
    i=this.pos,j=d.labels,k=this.gridLine,l=g?g+"Grid":"grid",m=g?g+"Tick":"tick",o=d[l+"LineWidth"],s=d[l+"LineColor"],y=d[l+"LineDashStyle"],q=d[m+"Length"],l=d[m+"Width"]||0,n=d[m+"Color"],X=d[m+"Position"],m=this.mark,I=j.step,z=!0,A=c.tickmarkOffset,B=this.getPosition(f,i,A,b),Z=B.x,B=B.y,v=c.staggerLines;
    if(o){
        i=c.getPlotLinePath(i+A,o,b);
        if(k===r){
            k={
                stroke:s,
                "stroke-width":o
            };
            
            if(y)k.dashstyle=y;
            if(!g)k.zIndex=1;
            this.gridLine=k=o?e.path(i).attr(k).add(c.gridGroup):null
            }
            if(!b&&k&&i)k[this.isNew?
            "attr":"animate"]({
                d:i
            })
            }
            if(l&&q)X==="inside"&&(q=-q),c.opposite&&(q=-q),g=this.getMarkPath(Z,B,q,l,f,e),m?m.animate({
        d:g
    }):this.mark=e.path(g).attr({
        stroke:n,
        "stroke-width":l
    }).add(c.axisGroup);
    if(h&&!isNaN(Z))h.xy=B=this.getLabelPosition(Z,B,h,f,j,A,a,I),this.isFirst&&!p(d.showFirstLabel,1)||this.isLast&&!p(d.showLastLabel,1)?z=!1:!v&&f&&j.overflow==="justify"&&!this.handleOverflow(a,B)&&(z=!1),I&&a%I&&(z=!1),z?(h[this.isNew?"attr":"animate"](B),h.show(),this.isNew=!1):h.hide()
        },
destroy:function(){
    ta(this,
        this.axis)
    }
};

xb.prototype={
    render:function(){
        var a=this,b=a.axis,c=b.horiz,d=(b.pointRange||0)/2,e=a.options,f=e.label,g=a.label,h=e.width,i=e.to,j=e.from,k=v(j)&&v(i),l=e.value,m=e.dashStyle,o=a.svgElem,s=[],y,q=e.color,n=e.zIndex,r=e.events,I=b.chart.renderer;
        b.isLog&&(j=ra(j),i=ra(i),l=ra(l));
        if(h){
            if(s=b.getPlotLinePath(l,h),d={
                stroke:q,
                "stroke-width":h
            },m)d.dashstyle=m
                }else if(k){
            if(j=x(j,b.min-d),i=K(i,b.max+d),s=b.getPlotBandPath(j,i,e),d={
                fill:q
            },e.borderWidth)d.stroke=e.borderColor,d["stroke-width"]=
                e.borderWidth
                }else return;
        if(v(n))d.zIndex=n;
        if(o)s?o.animate({
            d:s
        },null,o.onGetPath):(o.hide(),o.onGetPath=function(){
            o.show()
            });
        else if(s&&s.length&&(a.svgElem=o=I.path(s).attr(d).add(),r))for(y in e=function(b){
            o.on(b,function(c){
                r[b].apply(a,[c])
                })
            },r)e(y);if(f&&v(f.text)&&s&&s.length&&b.width>0&&b.height>0){
            f=w({
                align:c&&k&&"center",
                x:c?!k&&4:10,
                verticalAlign:!c&&k&&"middle",
                y:c?k?16:10:k?6:-4,
                rotation:c&&!k&&90
                },f);
            if(!g)a.label=g=I.text(f.text,0,0).attr({
                align:f.textAlign||f.align,
                rotation:f.rotation,
                zIndex:n
            }).css(f.style).add();
            b=[s[1],s[4],p(s[6],s[1])];
            s=[s[2],s[5],p(s[7],s[2])];
            c=Qa(b);
            k=Qa(s);
            g.align(f,!1,{
                x:c,
                y:k,
                width:Ea(b)-c,
                height:Ea(s)-k
                });
            g.show()
            }else g&&g.hide();
        return a
        },
    destroy:function(){
        Ma(this.axis.plotLinesAndBands,this);
        ta(this,this.axis)
        }
    };

Ob.prototype={
    destroy:function(){
        ta(this,this.axis)
        },
    setTotal:function(a){
        this.cum=this.total=a
        },
    render:function(a){
        var b=this.options.formatter.call(this);
        this.label?this.label.attr({
            text:b,
            visibility:"hidden"
        }):this.label=this.axis.chart.renderer.text(b,
            0,0).css(this.options.style).attr({
            align:this.textAlign,
            rotation:this.options.rotation,
            visibility:"hidden"
        }).add(a)
        },
    setOffset:function(a,b){
        var c=this.axis,d=c.chart,e=d.inverted,f=this.isNegative,g=c.translate(this.percent?100:this.total,0,0,0,1),c=c.translate(0),c=V(g-c),h=d.xAxis[0].translate(this.x)+a,i=d.plotHeight,f={
            x:e?f?g:g-c:h,
            y:e?i-h-b:f?i-g-c:i-g,
            width:e?c:b,
            height:e?b:c
            };
            
        if(e=this.label)e.align(this.alignOptions,null,f),f=e.alignAttr,e.attr({
            visibility:this.options.crop===!1||d.isInsidePlot(f.x,
                f.y)?ia?"inherit":"visible":"hidden"
            })
        }
        };

Sa.prototype={
    defaultOptions:{
        dateTimeLabelFormats:{
            millisecond:"%H:%M:%S.%L",
            second:"%H:%M:%S",
            minute:"%H:%M",
            hour:"%H:%M",
            day:"%e. %b",
            week:"%e. %b",
            month:"%b '%y",
            year:"%Y"
        },
        endOnTick:!1,
        gridLineColor:"#C0C0C0",
        labels:H,
        lineColor:"#C0D0E0",
        lineWidth:1,
        minPadding:0.01,
        maxPadding:0.01,
        minorGridLineColor:"#E0E0E0",
        minorGridLineWidth:1,
        minorTickColor:"#A0A0A0",
        minorTickLength:2,
        minorTickPosition:"outside",
        startOfWeek:1,
        startOnTick:!1,
        tickColor:"#C0D0E0",
        tickLength:5,
        tickmarkPlacement:"between",
        tickPixelInterval:100,
        tickPosition:"outside",
        tickWidth:1,
        title:{
            align:"middle",
            style:{
                color:"#6D869F",
                fontWeight:"bold"
            }
        },
    type:"linear"
},
defaultYAxisOptions:{
    endOnTick:!0,
    gridLineWidth:1,
    tickPixelInterval:72,
    showLastLabel:!0,
    labels:{
        align:"right",
        x:-8,
        y:3
    },
    lineWidth:0,
    maxPadding:0.05,
    minPadding:0.05,
    startOnTick:!0,
    tickWidth:0,
    title:{
        rotation:270,
        text:"Y-values"
    },
    stackLabels:{
        enabled:!1,
        formatter:function(){
            return this.total
            },
        style:H.style
        }
    },
defaultLeftAxisOptions:{
    labels:{
        align:"right",
        x:-8,
        y:null
    },
    title:{
        rotation:270
    }
},
defaultRightAxisOptions:{
    labels:{
        align:"left",
        x:8,
        y:null
    },
    title:{
        rotation:90
    }
},
defaultBottomAxisOptions:{
    labels:{
        align:"center",
        x:0,
        y:14
    },
    title:{
        rotation:0
    }
},
defaultTopAxisOptions:{
    labels:{
        align:"center",
        x:0,
        y:-5
    },
    title:{
        rotation:0
    }
},
init:function(a,b){
    var c=b.isX;
    this.horiz=a.inverted?!c:c;
    this.xOrY=(this.isXAxis=c)?"x":"y";
    this.opposite=b.opposite;
    this.side=this.horiz?this.opposite?0:2:this.opposite?1:3;
    this.setOptions(b);
    var d=this.options,e=d.type,f=e==="datetime";
    this.labelFormatter=d.labels.formatter||this.defaultLabelFormatter;
    this.staggerLines=this.horiz&&d.labels.staggerLines;
    this.userOptions=b;
    this.minPixelPadding=0;
    this.chart=a;
    this.reversed=d.reversed;
    this.categories=d.categories;
    this.isLog=e==="logarithmic";
    this.isLinked=v(d.linkedTo);
    this.isDatetimeAxis=f;
    this.tickmarkOffset=d.categories&&d.tickmarkPlacement==="between"?0.5:0;
    this.ticks={};
    
    this.minorTicks={};
    
    this.plotLinesAndBands=[];
    this.alternateBands={};
    
    this.len=0;
    this.minRange=this.userMinRange=
    d.minRange||d.maxZoom;
    this.range=d.range;
    this.offset=d.offset||0;
    this.stacks={};
    
    this.min=this.max=null;
    var g,d=this.options.events;
    a.axes.push(this);
    a[c?"xAxis":"yAxis"].push(this);
    this.series=[];
    if(a.inverted&&c&&this.reversed===r)this.reversed=!0;
    this.removePlotLine=this.removePlotBand=this.removePlotBandOrLine;
    this.addPlotLine=this.addPlotBand=this.addPlotBandOrLine;
    for(g in d)D(this,g,d[g]);if(this.isLog)this.val2lin=ra,this.lin2val=ka
        },
setOptions:function(a){
    this.options=w(this.defaultOptions,
        this.isXAxis?{}:this.defaultYAxisOptions,[this.defaultTopAxisOptions,this.defaultRightAxisOptions,this.defaultBottomAxisOptions,this.defaultLeftAxisOptions][this.side],w(P[this.isXAxis?"xAxis":"yAxis"],a))
    },
defaultLabelFormatter:function(){
    var a=this.axis,b=this.value,c=this.dateTimeLabelFormat,d=P.lang.numericSymbols,e=d&&d.length,f,g=a.isLog?b:a.tickInterval;
    if(a.categories)f=b;
    else if(c)f=va(c,b);
    else if(e&&g>=1E3)for(;e--&&f===r;)a=Math.pow(1E3,e+1),g>=a&&d[e]!==null&&(f=Oa(b/a,-1)+d[e]);
    f===
    r&&(f=b>=1E3?Oa(b,0):Oa(b,-1));
    return f
    },
getSeriesExtremes:function(){
    var a=this,b=a.chart,c=a.stacks,d=[],e=[],f;
    a.hasVisibleSeries=!1;
    a.dataMin=a.dataMax=null;
    n(a.series,function(g){
        if(g.visible||!b.options.chart.ignoreHiddenSeries){
            var h=g.options,i,j,k,l,m,o,s,y,q,n=h.threshold,t,I=[],z=0;
            a.hasVisibleSeries=!0;
            if(a.isLog&&n<=0)n=h.threshold=null;
            if(a.isXAxis){
                if(h=g.xData,h.length)a.dataMin=K(p(a.dataMin,h[0]),Qa(h)),a.dataMax=x(p(a.dataMax,h[0]),Ea(h))
                    }else{
                var A,B,Z,Va=g.cropped,w=g.xAxis.getExtremes(),
                u=!!g.modifyValue;
                i=h.stacking;
                a.usePercentage=i==="percent";
                if(i)m=h.stack,l=g.type+p(m,""),o="-"+l,g.stackKey=l,j=d[l]||[],d[l]=j,k=e[o]||[],e[o]=k;
                if(a.usePercentage)a.dataMin=0,a.dataMax=99;
                h=g.processedXData;
                s=g.processedYData;
                t=s.length;
                for(f=0;f<t;f++)if(y=h[f],q=s[f],i&&(B=(A=q<n)?k:j,Z=A?o:l,q=B[y]=v(B[y])?ma(B[y]+q):q,c[Z]||(c[Z]={}),c[Z][y]||(c[Z][y]=new Ob(a,a.options.stackLabels,A,y,m,i)),c[Z][y].setTotal(q)),q!==null&&q!==r&&(u&&(q=g.modifyValue(q)),Va||(h[f+1]||y)>=w.min&&(h[f-1]||
                    y)<=w.max))if(y=q.length)for(;y--;)q[y]!==null&&(I[z++]=q[y]);else I[z++]=q;if(!a.usePercentage&&I.length)a.dataMin=K(p(a.dataMin,I[0]),Qa(I)),a.dataMax=x(p(a.dataMax,I[0]),Ea(I));
                if(v(n))if(a.dataMin>=n)a.dataMin=n,a.ignoreMinPadding=!0;
                    else if(a.dataMax<n)a.dataMax=n,a.ignoreMaxPadding=!0
                    }
                }
    })
},
translate:function(a,b,c,d,e,f){
    var g=this.len,h=1,i=0,j=d?this.oldTransA:this.transA,d=d?this.oldMin:this.min,e=this.options.ordinal||this.isLog&&e;
    if(!j)j=this.transA;
    c&&(h*=-1,i=g);
    this.reversed&&(h*=-1,
        i-=h*g);
    b?(this.reversed&&(a=g-a),a=a/j+d,e&&(a=this.lin2val(a))):(e&&(a=this.val2lin(a)),a=h*(a-d)*j+i+h*this.minPixelPadding+(f?j*this.pointRange/2:0));
    return a
    },
getPlotLinePath:function(a,b,c){
    var d=this.chart,e=this.left,f=this.top,g,h,i,a=this.translate(a,null,null,c),j=c&&d.oldChartHeight||d.chartHeight,k=c&&d.oldChartWidth||d.chartWidth,l;
    g=this.transB;
    c=h=t(a+g);
    g=i=t(j-a-g);
    if(isNaN(a))l=!0;
    else if(this.horiz){
        if(g=f,i=j-this.bottom,c<e||c>e+this.width)l=!0
            }else if(c=e,h=k-this.right,g<f||
        g>f+this.height)l=!0;
    return l?null:d.renderer.crispLine(["M",c,g,"L",h,i],b||0)
    },
getPlotBandPath:function(a,b){
    var c=this.getPlotLinePath(b),d=this.getPlotLinePath(a);
    d&&c?d.push(c[4],c[5],c[1],c[2]):d=null;
    return d
    },
getLinearTickPositions:function(a,b,c){
    for(var d,b=ma(Y(b/a)*a),c=ma(Ha(c/a)*a),e=[];b<=c;){
        e.push(b);
        b=ma(b+a);
        if(b===d)break;
        d=b
        }
        return e
    },
getLogTickPositions:function(a,b,c,d){
    var e=this.options,f=this.len,g=[];
    if(!d)this._minorAutoInterval=null;
    if(a>=0.5)a=t(a),g=this.getLinearTickPositions(a,
        b,c);
    else if(a>=0.08)for(var f=Y(b),h,i,j,k,l,e=a>0.3?[1,2,4]:a>0.15?[1,2,4,6,8]:[1,2,3,4,5,6,7,8,9];f<c+1&&!l;f++){
        i=e.length;
        for(h=0;h<i&&!l;h++)j=ra(ka(f)*e[h]),j>b&&g.push(k),k>c&&(l=!0),k=j
            }else if(b=ka(b),c=ka(c),a=e[d?"minorTickInterval":"tickInterval"],a=p(a==="auto"?null:a,this._minorAutoInterval,(c-b)*(e.tickPixelInterval/(d?5:1))/((d?f/this.tickPositions.length:f)||1)),a=sb(a,null,M.pow(10,Y(M.log(a)/M.LN10))),g=Ja(this.getLinearTickPositions(a,b,c),ra),!d)this._minorAutoInterval=a/5;
    if(!d)this.tickInterval=
        a;
    return g
    },
getMinorTickPositions:function(){
    var a=this.tickPositions,b=this.minorTickInterval,c=[],d,e;
    if(this.isLog){
        e=a.length;
        for(d=1;d<e;d++)c=c.concat(this.getLogTickPositions(b,a[d-1],a[d],!0))
            }else for(a=this.min+(a[0]-this.min)%b;a<=this.max;a+=b)c.push(a);
    return c
    },
adjustForMinRange:function(){
    var a=this.options,b=this.min,c=this.max,d,e=this.dataMax-this.dataMin>=this.minRange,f,g,h,i,j;
    if(this.isXAxis&&this.minRange===r&&!this.isLog)v(a.min)||v(a.max)?this.minRange=null:(n(this.series,
        function(a){
            i=a.xData;
            for(g=j=a.xIncrement?1:i.length-1;g>0;g--)if(h=i[g]-i[g-1],f===r||h<f)f=h
                }),this.minRange=K(f*5,this.dataMax-this.dataMin));
    if(c-b<this.minRange){
        var k=this.minRange;
        d=(k-c+b)/2;
        d=[b-d,p(a.min,b-d)];
        if(e)d[2]=this.dataMin;
        b=Ea(d);
        c=[b+k,p(a.max,b+k)];
        if(e)c[2]=this.dataMax;
        c=Qa(c);
        c-b<k&&(d[0]=c-k,d[1]=p(a.min,c-k),b=Ea(d))
        }
        this.min=b;
    this.max=c
    },
setAxisTranslation:function(){
    var a=this.max-this.min,b=0,c,d=0,e=0,f=this.linkedParent,g=this.transA;
    if(this.isXAxis)f?(d=f.minPointOffset,
        e=f.pointRangePadding):n(this.series,function(a){
        var f=a.pointRange,g=a.options.pointPlacement,k=a.closestPointRange;
        b=x(b,f);
        d=x(d,g?0:f/2);
        e=x(e,g==="on"?0:f);
        !a.noSharedTooltip&&v(k)&&(c=v(c)?K(c,k):k)
        }),this.minPointOffset=d,this.pointRangePadding=e,this.pointRange=b,this.closestPointRange=c;
    this.oldTransA=g;
    this.translationSlope=this.transA=g=this.len/(a+e||1);
    this.transB=this.horiz?this.left:this.bottom;
    this.minPixelPadding=g*d
    },
setTickPositions:function(a){
    var b=this,c=b.chart,d=b.options,
    e=b.isLog,f=b.isDatetimeAxis,g=b.isXAxis,h=b.isLinked,i=b.options.tickPositioner,j=d.maxPadding,k=d.minPadding,l=d.tickInterval,m=d.minTickInterval,o=d.tickPixelInterval,s=b.categories;
    h?(b.linkedParent=c[g?"xAxis":"yAxis"][d.linkedTo],c=b.linkedParent.getExtremes(),b.min=p(c.min,c.dataMin),b.max=p(c.max,c.dataMax),d.type!==b.linkedParent.options.type&&ib(11,1)):(b.min=p(b.userMin,d.min,b.dataMin),b.max=p(b.userMax,d.max,b.dataMax));
    if(e)!a&&K(b.min,p(b.dataMin,b.min))<=0&&ib(10,1),b.min=ma(ra(b.min)),
        b.max=ma(ra(b.max));
    if(b.range&&(b.userMin=b.min=x(b.min,b.max-b.range),b.userMax=b.max,a))b.range=null;
    b.adjustForMinRange();
    if(!s&&!b.usePercentage&&!h&&v(b.min)&&v(b.max)){
        c=b.max-b.min||1;
        if(!v(d.min)&&!v(b.userMin)&&k&&(b.dataMin<0||!b.ignoreMinPadding))b.min-=c*k;
        if(!v(d.max)&&!v(b.userMax)&&j&&(b.dataMax>0||!b.ignoreMaxPadding))b.max+=c*j
            }
            b.tickInterval=b.min===b.max||b.min===void 0||b.max===void 0?1:h&&!l&&o===b.linkedParent.options.tickPixelInterval?b.linkedParent.tickInterval:p(l,s?1:(b.max-
        b.min)*o/(b.len||1));
    g&&!a&&n(b.series,function(a){
        a.processData(b.min!==b.oldMin||b.max!==b.oldMax)
        });
    b.setAxisTranslation(a);
    b.beforeSetTickPositions&&b.beforeSetTickPositions();
    if(b.postProcessTickInterval)b.tickInterval=b.postProcessTickInterval(b.tickInterval);
    if(!l&&b.tickInterval<m)b.tickInterval=m;
    if(!f&&!e&&(a=M.pow(10,Y(M.log(b.tickInterval)/M.LN10)),!l))b.tickInterval=sb(b.tickInterval,null,a,d);
    b.minorTickInterval=d.minorTickInterval==="auto"&&b.tickInterval?b.tickInterval/5:d.minorTickInterval;
    b.tickPositions=i=d.tickPositions||i&&i.apply(b,[b.min,b.max]);
    if(!i)i=f?(b.getNonLinearTimeTicks||db)(Gb(b.tickInterval,d.units),b.min,b.max,d.startOfWeek,b.ordinalPositions,b.closestPointRange,!0):e?b.getLogTickPositions(b.tickInterval,b.min,b.max):b.getLinearTickPositions(b.tickInterval,b.min,b.max),b.tickPositions=i;
    if(!h)e=i[0],f=i[i.length-1],h=b.minPointOffset||0,d.startOnTick?b.min=e:b.min-h>e&&i.shift(),d.endOnTick?b.max=f:b.max+h<f&&i.pop()
        },
setMaxTicks:function(){
    var a=this.chart,b=a.maxTicks,
    c=this.tickPositions,d=this.xOrY;
    b||(b={
        x:0,
        y:0
    });
    if(!this.isLinked&&!this.isDatetimeAxis&&c.length>b[d]&&this.options.alignTicks!==!1)b[d]=c.length;
    a.maxTicks=b
    },
adjustTickAmount:function(){
    var a=this.xOrY,b=this.tickPositions,c=this.chart.maxTicks;
    if(c&&c[a]&&!this.isDatetimeAxis&&!this.categories&&!this.isLinked&&this.options.alignTicks!==!1){
        var d=this.tickAmount,e=b.length;
        this.tickAmount=a=c[a];
        if(e<a){
            for(;b.length<a;)b.push(ma(b[b.length-1]+this.tickInterval));
            this.transA*=(e-1)/(a-1);
            this.max=
            b[b.length-1]
            }
            if(v(d)&&a!==d)this.isDirty=!0
            }
        },
setScale:function(){
    var a=this.stacks,b,c,d,e;
    this.oldMin=this.min;
    this.oldMax=this.max;
    this.oldAxisLength=this.len;
    this.setAxisSize();
    e=this.len!==this.oldAxisLength;
    n(this.series,function(a){
        if(a.isDirtyData||a.isDirty||a.xAxis.isDirty)d=!0
            });
    if(e||d||this.isLinked||this.userMin!==this.oldUserMin||this.userMax!==this.oldUserMax)if(this.getSeriesExtremes(),this.setTickPositions(),this.oldUserMin=this.userMin,this.oldUserMax=this.userMax,!this.isDirty)this.isDirty=
        e||this.min!==this.oldMin||this.max!==this.oldMax;
    if(!this.isXAxis)for(b in a)for(c in a[b])a[b][c].cum=a[b][c].total;this.setMaxTicks()
    },
setExtremes:function(a,b,c,d,e){
    var f=this,g=f.chart,c=p(c,!0),e=u(e,{
        min:a,
        max:b
    });
    J(f,"setExtremes",e,function(){
        f.userMin=a;
        f.userMax=b;
        f.isDirtyExtremes=!0;
        c&&g.redraw(d)
        })
    },
zoom:function(a,b){
    this.setExtremes(a,b,!1,r,{
        trigger:"zoom"
    });
    return!0
    },
setAxisSize:function(){
    var a=this.chart,b=this.options,c=b.offsetLeft||0,d=b.offsetRight||0;
    this.left=p(b.left,a.plotLeft+
        c);
    this.top=p(b.top,a.plotTop);
    this.width=p(b.width,a.plotWidth-c+d);
    this.height=p(b.height,a.plotHeight);
    this.bottom=a.chartHeight-this.height-this.top;
    this.right=a.chartWidth-this.width-this.left;
    this.len=x(this.horiz?this.width:this.height,0)
    },
getExtremes:function(){
    var a=this.isLog;
    return{
        min:a?ma(ka(this.min)):this.min,
        max:a?ma(ka(this.max)):this.max,
        dataMin:this.dataMin,
        dataMax:this.dataMax,
        userMin:this.userMin,
        userMax:this.userMax
        }
    },
getThreshold:function(a){
    var b=this.isLog,c=b?ka(this.min):
    this.min,b=b?ka(this.max):this.max;
    c>a||a===null?a=c:b<a&&(a=b);
    return this.translate(a,0,1,0,1)
    },
addPlotBandOrLine:function(a){
    a=(new xb(this,a)).render();
    this.plotLinesAndBands.push(a);
    return a
    },
getOffset:function(){
    var a=this,b=a.chart,c=b.renderer,d=a.options,e=a.tickPositions,f=a.ticks,g=a.horiz,h=a.side,i,j=0,k,l=0,m=d.title,o=d.labels,s=0,y=b.axisOffset,q=[-1,1,1,-1][h],r;
    a.hasData=b=a.hasVisibleSeries||v(a.min)&&v(a.max)&&!!e;
    a.showAxis=i=b||p(d.showEmpty,!0);
    if(!a.axisGroup)a.gridGroup=c.g("grid").attr({
        zIndex:d.gridZIndex||
        1
        }).add(),a.axisGroup=c.g("axis").attr({
        zIndex:d.zIndex||2
        }).add(),a.labelGroup=c.g("axis-labels").attr({
        zIndex:o.zIndex||7
        }).add();
    if(b||a.isLinked)n(e,function(b){
        f[b]?f[b].addLabel():f[b]=new Za(a,b)
        }),n(e,function(a){
        if(h===0||h===2||{
            1:"left",
            3:"right"
        }
        [h]===o.align)s=x(f[a].getLabelSize(),s)
            }),a.staggerLines&&(s+=(a.staggerLines-1)*16);else for(r in f)f[r].destroy(),delete f[r];if(m&&m.text){
        if(!a.axisTitle)a.axisTitle=c.text(m.text,0,0,m.useHTML).attr({
            zIndex:7,
            rotation:m.rotation||0,
            align:m.textAlign||

            {
                low:"left",
                middle:"center",
                high:"right"
            }
            [m.align]
            }).css(m.style).add(a.axisGroup),a.axisTitle.isNew=!0;
        if(i)j=a.axisTitle.getBBox()[g?"height":"width"],l=p(m.margin,g?5:10),k=m.offset;
        a.axisTitle[i?"show":"hide"]()
        }
        a.offset=q*p(d.offset,y[h]);
    a.axisTitleMargin=p(k,s+l+(h!==2&&s&&q*d.labels[g?"y":"x"]));
    y[h]=x(y[h],a.axisTitleMargin+j+q*a.offset)
    },
getLinePath:function(a){
    var b=this.chart,c=this.opposite,d=this.offset,e=this.horiz,f=this.left+(c?this.width:0)+d;
    this.lineTop=c=b.chartHeight-this.bottom-
    (c?this.height:0)+d;
    return b.renderer.crispLine(["M",e?this.left:f,e?c:this.top,"L",e?b.chartWidth-this.right:f,e?c:b.chartHeight-this.bottom],a)
    },
getTitlePosition:function(){
    var a=this.horiz,b=this.left,c=this.top,d=this.len,e=this.options.title,f=a?b:c,g=this.opposite,h=this.offset,i=F(e.style.fontSize||12),d={
        low:f+(a?0:d),
        middle:f+d/2,
        high:f+(a?d:0)
        }
        [e.align],b=(a?c+this.height:b)+(a?1:-1)*(g?-1:1)*this.axisTitleMargin+(this.side===2?i:0);
    return{
        x:a?d:b+(g?this.width:0)+h+(e.x||0),
        y:a?b-(g?this.height:
            0)+h:d+(e.y||0)
        }
    },
render:function(){
    var a=this,b=a.chart,c=b.renderer,d=a.options,e=a.isLog,f=a.isLinked,g=a.tickPositions,h=a.axisTitle,i=a.stacks,j=a.ticks,k=a.minorTicks,l=a.alternateBands,m=d.stackLabels,o=d.alternateGridColor,s=a.tickmarkOffset,y=d.lineWidth,q,p=b.hasRendered&&v(a.oldMin)&&!isNaN(a.oldMin),t=a.showAxis,I,z;
    if(a.hasData||f)if(a.minorTickInterval&&!a.categories&&n(a.getMinorTickPositions(),function(b){
        k[b]||(k[b]=new Za(a,b,"minor"));
        p&&k[b].isNew&&k[b].render(null,!0);
        k[b].isActive=
        !0;
        k[b].render()
        }),n(g.slice(1).concat([g[0]]),function(b,c){
        c=c===g.length-1?0:c+1;
        if(!f||b>=a.min&&b<=a.max)j[b]||(j[b]=new Za(a,b)),p&&j[b].isNew&&j[b].render(c,!0),j[b].isActive=!0,j[b].render(c)
            }),o&&n(g,function(b,c){
        if(c%2===0&&b<a.max)l[b]||(l[b]=new xb(a)),I=b+s,z=g[c+1]!==r?g[c+1]+s:a.max,l[b].options={
            from:e?ka(I):I,
            to:e?ka(z):z,
            color:o
        },l[b].render(),l[b].isActive=!0
            }),!a._addedPlotLB)n((d.plotLines||[]).concat(d.plotBands||[]),function(b){
        a.addPlotBandOrLine(b)
        }),a._addedPlotLB=!0;
    n([j,
        k,l],function(a){
            for(var b in a)a[b].isActive?a[b].isActive=!1:(a[b].destroy(),delete a[b])
                });
    if(y)q=a.getLinePath(y),a.axisLine?a.axisLine.animate({
        d:q
    }):a.axisLine=c.path(q).attr({
        stroke:d.lineColor,
        "stroke-width":y,
        zIndex:7
    }).add(a.axisGroup),a.axisLine[t?"show":"hide"]();
    if(h&&t)h[h.isNew?"attr":"animate"](a.getTitlePosition()),h.isNew=!1;
    if(m&&m.enabled){
        var A,B,d=a.stackTotalGroup;
        if(!d)a.stackTotalGroup=d=c.g("stack-labels").attr({
            visibility:"visible",
            zIndex:6
        }).add();
        d.translate(b.plotLeft,
            b.plotTop);
        for(A in i)for(B in b=i[A],b)b[B].render(d)
            }
            a.isDirty=!1
    },
removePlotBandOrLine:function(a){
    for(var b=this.plotLinesAndBands,c=b.length;c--;)b[c].id===a&&b[c].destroy()
        },
setTitle:function(a,b){
    var c=this.chart,d=this.options,e=this.axisTitle;
    d.title=w(d.title,a);
    this.axisTitle=e&&e.destroy();
    this.isDirty=!0;
    p(b,!0)&&c.redraw()
    },
redraw:function(){
    var a=this.chart;
    a.tracker.resetTracker&&a.tracker.resetTracker(!0);
    this.render();
    n(this.plotLinesAndBands,function(a){
        a.render()
        });
    n(this.series,
        function(a){
            a.isDirty=!0
            })
    },
setCategories:function(a,b){
    var c=this.chart;
    this.categories=this.userOptions.categories=a;
    n(this.series,function(a){
        a.translate();
        a.setTooltipPoints(!0)
        });
    this.isDirty=!0;
    p(b,!0)&&c.redraw()
    },
destroy:function(){
    var a=this,b=a.stacks,c;
    O(a);
    for(c in b)ta(b[c]),b[c]=null;n([a.ticks,a.minorTicks,a.alternateBands,a.plotLinesAndBands],function(a){
        ta(a)
        });
    n("stackTotalGroup,axisLine,axisGroup,gridGroup,labelGroup,axisTitle".split(","),function(b){
        a[b]&&(a[b]=a[b].destroy())
        })
    }
};
yb.prototype={
    destroy:function(){
        n(this.crosshairs,function(a){
            a&&a.destroy()
            });
        if(this.label)this.label=this.label.destroy()
            },
    move:function(a,b,c,d){
        var e=this,f=e.now,g=e.options.animation!==!1&&!e.isHidden;
        u(f,{
            x:g?(2*f.x+a)/3:a,
            y:g?(f.y+b)/2:b,
            anchorX:g?(2*f.anchorX+c)/3:c,
            anchorY:g?(f.anchorY+d)/2:d
            });
        e.label.attr(f);
        if(g&&(V(a-f.x)>1||V(b-f.y)>1))clearTimeout(this.tooltipTimeout),this.tooltipTimeout=setTimeout(function(){
            e&&e.move(a,b,c,d)
            },32)
        },
    hide:function(){
        if(!this.isHidden){
            var a=this.chart.hoverPoints;
            this.label.hide();
            a&&n(a,function(a){
                a.setState()
                });
            this.chart.hoverPoints=null;
            this.isHidden=!0
            }
        },
hideCrosshairs:function(){
    n(this.crosshairs,function(a){
        a&&a.hide()
        })
    },
getAnchor:function(a,b){
    var c,d=this.chart,e=d.inverted,f=0,g=0,h,a=la(a);
    c=a[0].tooltipPos;
    c||(n(a,function(a){
        h=a.series.yAxis;
        f+=a.plotX;
        g+=(a.plotLow?(a.plotLow+a.plotHigh)/2:a.plotY)+(!e&&h?h.top-d.plotTop:0)
        }),f/=a.length,g/=a.length,c=[e?d.plotWidth-g:f,this.shared&&!e&&a.length>1&&b?b.chartY-d.plotTop:e?d.plotHeight-f:g]);
    return Ja(c,t)
    },
getPosition:function(a,b,c){
    var d=this.chart,e=d.plotLeft,f=d.plotTop,g=d.plotWidth,h=d.plotHeight,i=p(this.options.distance,12),j=c.plotX,c=c.plotY,d=j+e+(d.inverted?i:-a-i),k=c-b+f+15,l;
    d<7&&(d=e+x(j,0)+i);
    d+a>e+g&&(d-=d+a-(e+g),k=c-b+f-i,l=!0);
    k<f+5&&(k=f+5,l&&c>=k&&c<=k+b&&(k=c+f+i));
    k+b>f+h&&(k=x(f,f+h-b-i));
    return{
        x:d,
        y:k
    }
},
refresh:function(a,b){
    function c(){
        var a=this.points||la(this),b=a[0].series,c;
        c=[b.tooltipHeaderFormatter(a[0].key)];
        n(a,function(a){
            b=a.series;
            c.push(b.tooltipFormatter&&
                b.tooltipFormatter(a)||a.point.tooltipFormatter(b.tooltipOptions.pointFormat))
            });
        c.push(f.footerFormat||"");
        return c.join("")
        }
        var d=this.chart,e=this.label,f=this.options,g,h,i,j={},k,l=[];
    k=f.formatter||c;
    var j=d.hoverPoints,m,o=f.crosshairs;
    i=this.shared;
    h=this.getAnchor(a,b);
    g=h[0];
    h=h[1];
    i&&(!a.series||!a.series.noSharedTooltip)?(d.hoverPoints=a,j&&n(j,function(a){
        a.setState()
        }),n(a,function(a){
        a.setState("hover");
        l.push(a.getLabelConfig())
        }),j={
        x:a[0].category,
        y:a[0].y
        },j.points=l,a=a[0]):j=
    a.getLabelConfig();
    k=k.call(j);
    j=a.series;
    i=i||!j.isCartesian||j.tooltipOutsidePlot||d.isInsidePlot(g,h);
    k===!1||!i?this.hide():(this.isHidden&&e.show(),e.attr({
        text:k
    }),m=f.borderColor||a.color||j.color||"#606060",e.attr({
        stroke:m
    }),e=(f.positioner||this.getPosition).call(this,e.width,e.height,{
        plotX:g,
        plotY:h
    }),this.move(t(e.x),t(e.y),g+d.plotLeft,h+d.plotTop),this.isHidden=!1);
    if(o){
        o=la(o);
        for(e=o.length;e--;)if(i=a.series[e?"yAxis":"xAxis"],o[e]&&i)if(i=i.getPlotLinePath(e?p(a.stackY,a.y):a.x,
            1),this.crosshairs[e])this.crosshairs[e].attr({
            d:i,
            visibility:"visible"
        });
        else{
            j={
                "stroke-width":o[e].width||1,
                stroke:o[e].color||"#C0C0C0",
                zIndex:o[e].zIndex||2
                };
                
            if(o[e].dashStyle)j.dashstyle=o[e].dashStyle;
            this.crosshairs[e]=d.renderer.path(i).attr(j).add()
            }
        }
        J(d,"tooltipRefresh",{
    text:k,
    x:g+d.plotLeft,
    y:h+d.plotTop,
    borderColor:m
})
}
};

zb.prototype={
    normalizeMouseEvent:function(a){
        var b,c,d,a=a||S.event;
        if(!a.target)a.target=a.srcElement;
        a=Ub(a);
        d=a.touches?a.touches.item(0):a;
        this.chartPosition=b=
        cc(this.chart.container);
        d.pageX===r?(c=a.x,b=a.y):(c=d.pageX-b.left,b=d.pageY-b.top);
        return u(a,{
            chartX:t(c),
            chartY:t(b)
            })
        },
    getMouseCoordinates:function(a){
        var b={
            xAxis:[],
            yAxis:[]
        },c=this.chart;
        n(c.axes,function(d){
            var e=d.isXAxis;
            b[e?"xAxis":"yAxis"].push({
                axis:d,
                value:d.translate(((c.inverted?!e:e)?a.chartX-c.plotLeft:d.top+d.len-a.chartY)-d.minPixelPadding,!0)
                })
            });
        return b
        },
    getIndex:function(a){
        var b=this.chart;
        return b.inverted?b.plotHeight+b.plotTop-a.chartY:a.chartX-b.plotLeft
        },
    onmousemove:function(a){
        var b=
        this.chart,c=b.series,d=b.tooltip,e,f=b.hoverPoint,g=b.hoverSeries,h,i,j=b.chartWidth,k=this.getIndex(a);
        if(d&&this.options.tooltip.shared&&(!g||!g.noSharedTooltip)){
            e=[];
            h=c.length;
            for(i=0;i<h;i++)if(c[i].visible&&c[i].options.enableMouseTracking!==!1&&!c[i].noSharedTooltip&&c[i].tooltipPoints.length)b=c[i].tooltipPoints[k],b._dist=V(k-b[c[i].xAxis.tooltipPosName||"plotX"]),j=K(j,b._dist),e.push(b);for(h=e.length;h--;)e[h]._dist>j&&e.splice(h,1);
            if(e.length&&e[0].plotX!==this.hoverX)d.refresh(e,
                a),this.hoverX=e[0].plotX
            }
            if(g&&g.tracker&&(b=g.tooltipPoints[k])&&b!==f)b.onMouseOver()
            },
    resetTracker:function(a){
        var b=this.chart,c=b.hoverSeries,d=b.hoverPoint,e=b.tooltip,b=e&&e.shared?b.hoverPoints:d;
        (a=a&&e&&b)&&la(b)[0].plotX===r&&(a=!1);
        if(a)e.refresh(b);
        else{
            if(d)d.onMouseOut();
            if(c)c.onMouseOut();
            e&&(e.hide(),e.hideCrosshairs());
            this.hoverX=null
            }
        },
setDOMEvents:function(){
    function a(){
        if(b.selectionMarker){
            var f={
                xAxis:[],
                yAxis:[]
            },g=b.selectionMarker.getBBox(),h=g.x-c.plotLeft,l=g.y-c.plotTop,
            m;
            e&&(n(c.axes,function(a){
                if(a.options.zoomEnabled!==!1){
                    var b=a.isXAxis,d=c.inverted?!b:b,e=a.translate(d?h:c.plotHeight-l-g.height,!0,0,0,1),d=a.translate((d?h+g.width:c.plotHeight-l)-2*a.minPixelPadding,!0,0,0,1);
                    !isNaN(e)&&!isNaN(d)&&(f[b?"xAxis":"yAxis"].push({
                        axis:a,
                        min:K(e,d),
                        max:x(e,d)
                        }),m=!0)
                    }
                }),m&&J(c,"selection",f,function(a){
                c.zoom(a)
                }));
        b.selectionMarker=b.selectionMarker.destroy()
        }
        if(c)L(d,{
        cursor:"auto"
    }),c.cancelClick=e,c.mouseIsDown=e=!1;
    O(E,ba?"touchend":"mouseup",a)
    }
    var b=this,
c=b.chart,d=c.container,e,f=b.zoomX&&!c.inverted||b.zoomY&&c.inverted,g=b.zoomY&&!c.inverted||b.zoomX&&c.inverted;
b.hideTooltipOnMouseMove=function(a){
    a=Ub(a);
    b.chartPosition&&c.hoverSeries&&c.hoverSeries.isCartesian&&!c.isInsidePlot(a.pageX-b.chartPosition.left-c.plotLeft,a.pageY-b.chartPosition.top-c.plotTop)&&b.resetTracker()
    };
    
b.hideTooltipOnMouseLeave=function(){
    b.resetTracker();
    b.chartPosition=null
    };
    
d.onmousedown=function(d){
    d=b.normalizeMouseEvent(d);
    !ba&&d.preventDefault&&d.preventDefault();
    c.mouseIsDown=!0;
    c.cancelClick=!1;
    c.mouseDownX=b.mouseDownX=d.chartX;
    b.mouseDownY=d.chartY;
    D(E,ba?"touchend":"mouseup",a)
    };
    
var h=function(a){
    if(!a||!(a.touches&&a.touches.length>1)){
        a=b.normalizeMouseEvent(a);
        if(!ba)a.returnValue=!1;
        var d=a.chartX,h=a.chartY,l=!c.isInsidePlot(d-c.plotLeft,h-c.plotTop);
        ba&&a.type==="touchstart"&&(G(a.target,"isTracker")?c.runTrackerClick||a.preventDefault():!c.runChartClick&&!l&&a.preventDefault());
        if(l)d<c.plotLeft?d=c.plotLeft:d>c.plotLeft+c.plotWidth&&(d=c.plotLeft+
            c.plotWidth),h<c.plotTop?h=c.plotTop:h>c.plotTop+c.plotHeight&&(h=c.plotTop+c.plotHeight);
        if(c.mouseIsDown&&a.type!=="touchstart"&&(e=Math.sqrt(Math.pow(b.mouseDownX-d,2)+Math.pow(b.mouseDownY-h,2)),e>10)){
            var m=c.isInsidePlot(b.mouseDownX-c.plotLeft,b.mouseDownY-c.plotTop);
            if(c.hasCartesianSeries&&(b.zoomX||b.zoomY)&&m&&!b.selectionMarker)b.selectionMarker=c.renderer.rect(c.plotLeft,c.plotTop,f?1:c.plotWidth,g?1:c.plotHeight,0).attr({
                fill:b.options.chart.selectionMarkerFill||"rgba(69,114,167,0.25)",
                zIndex:7
            }).add();
            if(b.selectionMarker&&f){
                var o=d-b.mouseDownX;
                b.selectionMarker.attr({
                    width:V(o),
                    x:(o>0?0:o)+b.mouseDownX
                    })
                }
                b.selectionMarker&&g&&(h-=b.mouseDownY,b.selectionMarker.attr({
                height:V(h),
                y:(h>0?0:h)+b.mouseDownY
                }));
            m&&!b.selectionMarker&&b.options.chart.panning&&c.pan(d)
            }
            if(!l)b.onmousemove(a);
        return l||!c.hasCartesianSeries
        }
    };

d.onmousemove=h;
D(d,"mouseleave",b.hideTooltipOnMouseLeave);
D(E,"mousemove",b.hideTooltipOnMouseMove);
d.ontouchstart=function(a){
    if(b.zoomX||b.zoomY)d.onmousedown(a);
    h(a)
    };
    
d.ontouchmove=h;
d.ontouchend=function(){
    e&&b.resetTracker()
    };
    
d.onclick=function(a){
    var d=c.hoverPoint,e,f,a=b.normalizeMouseEvent(a);
    a.cancelBubble=!0;
    if(!c.cancelClick)d&&(G(a.target,"isTracker")||G(a.target.parentNode,"isTracker"))?(e=d.plotX,f=d.plotY,u(d,{
        pageX:b.chartPosition.left+c.plotLeft+(c.inverted?c.plotWidth-f:e),
        pageY:b.chartPosition.top+c.plotTop+(c.inverted?c.plotHeight-e:f)
        }),J(d.series,"click",u(a,{
        point:d
    })),d.firePointEvent("click",a)):(u(a,b.getMouseCoordinates(a)),c.isInsidePlot(a.chartX-
        c.plotLeft,a.chartY-c.plotTop)&&J(c,"click",a))
        }
    },
destroy:function(){
    var a=this.chart,b=a.container;
    if(a.trackerGroup)a.trackerGroup=a.trackerGroup.destroy();
    O(b,"mouseleave",this.hideTooltipOnMouseLeave);
    O(E,"mousemove",this.hideTooltipOnMouseMove);
    b.onclick=b.onmousedown=b.onmousemove=b.ontouchstart=b.ontouchend=b.ontouchmove=null;
    clearInterval(this.tooltipTimeout)
    },
init:function(a,b){
    if(!a.trackerGroup)a.trackerGroup=a.renderer.g("tracker").attr({
        zIndex:9
    }).add();
    if(b.enabled)a.tooltip=new yb(a,
        b);
    this.setDOMEvents()
    }
};

Ab.prototype={
    init:function(a){
        var b=this,c=b.options=a.options.legend;
        if(c.enabled){
            var d=c.itemStyle,e=p(c.padding,8),f=c.itemMarginTop||0;
            b.baseline=F(d.fontSize)+3+f;
            b.itemStyle=d;
            b.itemHiddenStyle=w(d,c.itemHiddenStyle);
            b.itemMarginTop=f;
            b.padding=e;
            b.initialItemX=e;
            b.initialItemY=e-5;
            b.maxItemWidth=0;
            b.chart=a;
            b.itemHeight=0;
            b.lastLineHeight=0;
            b.render();
            D(b.chart,"endResize",function(){
                b.positionCheckboxes()
                })
            }
        },
colorizeItem:function(a,b){
    var c=this.options,d=a.legendItem,
    e=a.legendLine,f=a.legendSymbol,g=this.itemHiddenStyle.color,c=b?c.itemStyle.color:g,h=b?a.color:g,g=a.options&&a.options.marker,i={
        stroke:h,
        fill:h
    },j;
    d&&d.css({
        fill:c
    });
    e&&e.attr({
        stroke:h
    });
    if(f){
        if(g)for(j in g=a.convertAttribs(g),g)d=g[j],d!==r&&(i[j]=d);f.attr(i)
        }
    },
positionItem:function(a){
    var b=this.options,c=b.symbolPadding,b=!b.rtl,d=a._legendItemPos,e=d[0],d=d[1],f=a.checkbox;
    a.legendGroup&&a.legendGroup.translate(b?e:this.legendWidth-e-2*c-4,d);
    if(f)f.x=e,f.y=d
        },
destroyItem:function(a){
    var b=
    a.checkbox;
    n(["legendItem","legendLine","legendSymbol","legendGroup"],function(b){
        a[b]&&a[b].destroy()
        });
    b&&Ra(a.checkbox)
    },
destroy:function(){
    var a=this.group,b=this.box;
    if(b)this.box=b.destroy();
    if(a)this.group=a.destroy()
        },
positionCheckboxes:function(){
    var a=this;
    n(a.allItems,function(b){
        var c=b.checkbox,d=a.group.alignAttr;
        c&&L(c,{
            left:d.translateX+b.legendItemWidth+c.x-20+"px",
            top:d.translateY+c.y+3+"px"
            })
        })
    },
renderItem:function(a){
    var y;
    var b=this,c=b.chart,d=c.renderer,e=b.options,f=e.layout===
    "horizontal",g=e.symbolWidth,h=e.symbolPadding,i=b.itemStyle,j=b.itemHiddenStyle,k=b.padding,l=!e.rtl,m=e.width,o=e.itemMarginBottom||0,s=b.itemMarginTop,n=b.initialItemX,q=a.legendItem,p=a.series||a,r=p.options,t=r.showCheckbox;
    if(!q&&(a.legendGroup=d.g("legend-item").attr({
        zIndex:1
    }).add(b.scrollGroup),p.drawLegendSymbol(b,a),a.legendItem=q=d.text(e.labelFormatter.call(a),l?g+h:-h,b.baseline,e.useHTML).css(w(a.visible?i:j)).attr({
        align:l?"left":"right",
        zIndex:2
    }).add(a.legendGroup),a.legendGroup.on("mouseover",
        function(){
            a.setState("hover");
            q.css(b.options.itemHoverStyle)
            }).on("mouseout",function(){
        q.css(a.visible?i:j);
        a.setState()
        }).on("click",function(b){
        var c=function(){
            a.setVisible()
            },b={
            browserEvent:b
        };
        
        a.firePointEvent?a.firePointEvent("legendItemClick",b,c):J(a,"legendItemClick",b,c)
        }),b.colorizeItem(a,a.visible),r&&t))a.checkbox=U("input",{
        type:"checkbox",
        checked:a.selected,
        defaultChecked:a.selected
        },e.itemCheckboxStyle,c.container),D(a.checkbox,"click",function(b){
        J(a,"checkboxClick",{
            checked:b.target.checked
            },
        function(){
            a.select()
            })
        });
    d=q.getBBox();
    y=a.legendItemWidth=e.itemWidth||g+h+d.width+k+(t?20:0),e=y;
    b.itemHeight=g=d.height;
    if(f&&b.itemX-n+e>(m||c.chartWidth-2*k-n))b.itemX=n,b.itemY+=s+b.lastLineHeight+o,b.lastLineHeight=0;
    b.maxItemWidth=x(b.maxItemWidth,e);
    b.lastItemY=s+b.itemY+o;
    b.lastLineHeight=x(g,b.lastLineHeight);
    a._legendItemPos=[b.itemX,b.itemY];
    f?b.itemX+=e:(b.itemY+=s+g+o,b.lastLineHeight=g);
    b.offsetWidth=m||x(f?b.itemX-n:e,b.offsetWidth)
    },
render:function(){
    var a=this,b=a.chart,c=b.renderer,
    d=a.group,e,f,g,h,i=a.box,j=a.options,k=a.padding,l=j.borderWidth,m=j.backgroundColor;
    a.itemX=a.initialItemX;
    a.itemY=a.initialItemY;
    a.offsetWidth=0;
    a.lastItemY=0;
    if(!d)a.group=d=c.g("legend").attr({
        zIndex:7
    }).add(),a.contentGroup=c.g().attr({
        zIndex:1
    }).add(d),a.scrollGroup=c.g().add(a.contentGroup),a.clipRect=c.clipRect(0,0,9999,b.chartHeight),a.contentGroup.clip(a.clipRect);
    e=[];
    n(b.series,function(a){
        var b=a.options;
        b.showInLegend&&(e=e.concat(a.legendItems||(b.legendType==="point"?a.data:a)))
        });
    Mb(e,function(a,b){
        return(a.options&&a.options.legendIndex||0)-(b.options&&b.options.legendIndex||0)
        });
    j.reversed&&e.reverse();
    a.allItems=e;
    a.display=f=!!e.length;
    n(e,function(b){
        a.renderItem(b)
        });
    g=j.width||a.offsetWidth;
    h=a.lastItemY+a.lastLineHeight;
    h=a.handleOverflow(h);
    if(l||m){
        g+=k;
        h+=k;
        if(i){
            if(g>0&&h>0)i[i.isNew?"attr":"animate"](i.crisp(null,null,null,g,h)),i.isNew=!1
                }else a.box=i=c.rect(0,0,g,h,j.borderRadius,l||0).attr({
            stroke:j.borderColor,
            "stroke-width":l||0,
            fill:m||$
            }).add(d).shadow(j.shadow),
            i.isNew=!0;
        i[f?"show":"hide"]()
        }
        a.legendWidth=g;
    a.legendHeight=h;
    n(e,function(b){
        a.positionItem(b)
        });
    f&&d.align(u({
        width:g,
        height:h
    },j),!0,b.spacingBox);
    b.isResizing||this.positionCheckboxes()
    },
handleOverflow:function(a){
    var b=this,c=this.chart,d=c.renderer,e=this.options,f=e.y,f=c.spacingBox.height+(e.verticalAlign==="top"?-f:f)-this.padding,g=e.maxHeight,h=this.clipRect,i=e.navigation,j=p(i.animation,!0),k=i.arrowSize||12,l=this.nav;
    e.layout==="horizontal"&&(f/=2);
    g&&(f=K(f,g));
    if(a>f){
        this.clipHeight=
        c=f-20;
        this.pageCount=Ha(a/c);
        this.currentPage=p(this.currentPage,1);
        this.fullHeight=a;
        h.attr({
            height:c
        });
        if(!l)this.nav=l=d.g().attr({
            zIndex:1
        }).add(this.group),this.up=d.symbol("triangle",0,0,k,k).on("click",function(){
            b.scroll(-1,j)
            }).add(l),this.pager=d.text("",15,10).css(i.style).add(l),this.down=d.symbol("triangle-down",0,0,k,k).on("click",function(){
            b.scroll(1,j)
            }).add(l);
        b.scroll(0);
        a=f
        }else l&&(h.attr({
        height:c.chartHeight
        }),l.hide(),this.scrollGroup.attr({
        translateY:1
    }));
    return a
    },
scroll:function(a,
    b){
    var c=this.pageCount,d=this.currentPage+a,e=this.clipHeight,f=this.options.navigation,g=f.activeColor,f=f.inactiveColor,h=this.pager,i=this.padding;
    d>c&&(d=c);
    if(d>0)b!==r&&Fa(b,this.chart),this.nav.attr({
        translateX:i,
        translateY:e+7,
        visibility:"visible"
    }),this.up.attr({
        fill:d===1?f:g
        }).css({
        cursor:d===1?"default":"pointer"
        }),h.attr({
        text:d+"/"+this.pageCount
        }),this.down.attr({
        x:18+this.pager.getBBox().width,
        fill:d===c?f:g
        }).css({
        cursor:d===c?"default":"pointer"
        }),this.scrollGroup.animate({
        translateY:-K(e*
            (d-1),this.fullHeight-e+i)+1
        }),h.attr({
        text:d+"/"+c
        }),this.currentPage=d
    }
    };

$a.prototype={
    initSeries:function(a){
        var b=this.options.chart,b=new R[a.type||b.type||b.defaultSeriesType];
        b.init(this,a);
        return b
        },
    addSeries:function(a,b,c){
        var d,e=this;
        a&&(Fa(c,e),b=p(b,!0),J(e,"addSeries",{
            options:a
        },function(){
            d=e.initSeries(a);
            e.isDirtyLegend=!0;
            b&&e.redraw()
            }));
        return d
        },
    isInsidePlot:function(a,b,c){
        var d=c?b:a,a=c?a:b;
        return d>=0&&d<=this.plotWidth&&a>=0&&a<=this.plotHeight
        },
    adjustTickAmounts:function(){
        this.options.chart.alignTicks!==
        !1&&n(this.axes,function(a){
            a.adjustTickAmount()
            });
        this.maxTicks=null
        },
    redraw:function(a){
        var b=this.axes,c=this.series,d=this.tracker,e=this.legend,f=this.isDirtyLegend,g,h=this.isDirtyBox,i=c.length,j=i,k=this.renderer,l=k.isHidden(),m=[];
        Fa(a,this);
        for(l&&this.cloneRenderTo();j--;)if(a=c[j],a.isDirty&&a.options.stacking){
            g=!0;
            break
        }
        if(g)for(j=i;j--;)if(a=c[j],a.options.stacking)a.isDirty=!0;n(c,function(a){
            a.isDirty&&a.options.legendType==="point"&&(f=!0)
            });
        if(f&&e.options.enabled)e.render(),this.isDirtyLegend=
            !1;
        if(this.hasCartesianSeries){
            if(!this.isResizing)this.maxTicks=null,n(b,function(a){
                a.setScale()
                });
            this.adjustTickAmounts();
            this.getMargins();
            n(b,function(a){
                if(a.isDirtyExtremes)a.isDirtyExtremes=!1,m.push(function(){
                    J(a,"afterSetExtremes",a.getExtremes())
                    });
                if(a.isDirty||h||g)a.redraw(),h=!0
                    })
            }
            h&&this.drawChartBox();
        n(c,function(a){
            a.isDirty&&a.visible&&(!a.isCartesian||a.xAxis)&&a.redraw()
            });
        d&&d.resetTracker&&d.resetTracker(!0);
        k.draw();
        J(this,"redraw");
        l&&this.cloneRenderTo(!0);
        n(m,function(a){
            a.call()
            })
        },
    showLoading:function(a){
        var b=this.options,c=this.loadingDiv,d=b.loading;
        if(!c)this.loadingDiv=c=U(oa,{
            className:"highcharts-loading"
        },u(d.style,{
            left:this.plotLeft+"px",
            top:this.plotTop+"px",
            width:this.plotWidth+"px",
            height:this.plotHeight+"px",
            zIndex:10,
            display:$
        }),this.container),this.loadingSpan=U("span",null,d.labelStyle,c);
        this.loadingSpan.innerHTML=a||b.lang.loading;
        if(!this.loadingShown)L(c,{
            opacity:0,
            display:""
        }),Fb(c,{
            opacity:d.style.opacity
            },{
            duration:d.showDuration||0
            }),this.loadingShown=
        !0
        },
    hideLoading:function(){
        var a=this.options,b=this.loadingDiv;
        b&&Fb(b,{
            opacity:0
        },{
            duration:a.loading.hideDuration||100,
            complete:function(){
                L(b,{
                    display:$
                })
                }
            });
    this.loadingShown=!1
    },
get:function(a){
    var b=this.axes,c=this.series,d,e;
    for(d=0;d<b.length;d++)if(b[d].options.id===a)return b[d];for(d=0;d<c.length;d++)if(c[d].options.id===a)return c[d];for(d=0;d<c.length;d++){
        e=c[d].points||[];
        for(b=0;b<e.length;b++)if(e[b].id===a)return e[b]
            }
            return null
    },
getAxes:function(){
    var a=this,b=this.options,c=
    b.xAxis||{},b=b.yAxis||{},c=la(c);
    n(c,function(a,b){
        a.index=b;
        a.isX=!0
        });
    b=la(b);
    n(b,function(a,b){
        a.index=b
        });
    c=c.concat(b);
    n(c,function(b){
        new Sa(a,b)
        });
    a.adjustTickAmounts()
    },
getSelectedPoints:function(){
    var a=[];
    n(this.series,function(b){
        a=a.concat(Tb(b.points,function(a){
            return a.selected
            }))
        });
    return a
    },
getSelectedSeries:function(){
    return Tb(this.series,function(a){
        return a.selected
        })
    },
showResetZoom:function(){
    var a=this,b=P.lang,c=a.options.chart.resetZoomButton,d=c.theme,e=d.states,f=c.relativeTo===
    "chart"?null:"plotBox";
    this.resetZoomButton=a.renderer.button(b.resetZoom,null,null,function(){
        a.zoomOut()
        },d,e&&e.hover).attr({
        align:c.position.align,
        title:b.resetZoomTitle
        }).add().align(c.position,!1,a[f]);
    this.resetZoomButton.alignTo=f
    },
zoomOut:function(){
    var a=this,b=a.resetZoomButton;
    J(a,"selection",{
        resetSelection:!0
        },function(){
        a.zoom()
        });
    if(b)a.resetZoomButton=b.destroy()
        },
zoom:function(a){
    var b=this,c;
    !a||a.resetSelection?n(b.axes,function(a){
        c=a.zoom()
        }):n(a.xAxis.concat(a.yAxis),function(a){
        var e=
        a.axis;
        if(b.tracker[e.isXAxis?"zoomX":"zoomY"])c=e.zoom(a.min,a.max)
            });
    b.resetZoomButton||b.showResetZoom();
    c&&b.redraw(p(b.options.chart.animation,b.pointCount<100))
    },
pan:function(a){
    var b=this.xAxis[0],c=this.mouseDownX,d=b.pointRange/2,e=b.getExtremes(),f=b.translate(c-a,!0)+d,c=b.translate(c+this.plotWidth-a,!0)-d;
    (d=this.hoverPoints)&&n(d,function(a){
        a.setState()
        });
    b.series.length&&f>K(e.dataMin,e.min)&&c<x(e.dataMax,e.max)&&b.setExtremes(f,c,!0,!1,{
        trigger:"pan"
    });
    this.mouseDownX=a;
    L(this.container,

    {
        cursor:"move"
    })
    },
setTitle:function(a,b){
    var c=this,d=c.options,e;
    c.chartTitleOptions=e=w(d.title,a);
    c.chartSubtitleOptions=d=w(d.subtitle,b);
    n([["title",a,e],["subtitle",b,d]],function(a){
        var b=a[0],d=c[b],e=a[1],a=a[2];
        d&&e&&(c[b]=d=d.destroy());
        a&&a.text&&!d&&(c[b]=c.renderer.text(a.text,0,0,a.useHTML).attr({
            align:a.align,
            "class":"highcharts-"+b,
            zIndex:a.zIndex||4
            }).css(a.style).add().align(a,!1,c.spacingBox))
        })
    },
getChartSize:function(){
    var a=this.options.chart,b=this.renderToClone||this.renderTo;
    this.containerWidth=mb(b,"width");
    this.containerHeight=mb(b,"height");
    this.chartWidth=a.width||this.containerWidth||600;
    this.chartHeight=a.height||(this.containerHeight>19?this.containerHeight:300)
    },
cloneRenderTo:function(a){
    var b=this.renderToClone,c=this.container;
    a?b&&(this.renderTo.appendChild(c),Ra(b),delete this.renderToClone):(c&&this.renderTo.removeChild(c),this.renderToClone=b=this.renderTo.cloneNode(0),L(b,{
        position:"absolute",
        top:"-9999px",
        display:"block"
    }),E.body.appendChild(b),c&&b.appendChild(c))
    },
getContainer:function(){
    var a,b=this.options.chart,c,d,e;
    this.renderTo=a=b.renderTo;
    e="highcharts-"+Cb++;
    if(qa(a))this.renderTo=a=E.getElementById(a);
    a||ib(13,!0);
    a.innerHTML="";
    a.offsetWidth||this.cloneRenderTo();
    this.getChartSize();
    c=this.chartWidth;
    d=this.chartHeight;
    this.container=a=U(oa,{
        className:"highcharts-container"+(b.className?" "+b.className:""),
        id:e
    },u({
        position:"relative",
        overflow:"hidden",
        width:c+"px",
        height:d+"px",
        textAlign:"left",
        lineHeight:"normal",
        zIndex:0
    },b.style),this.renderToClone||
    a);
    this.renderer=b.forExport?new pa(a,c,d,!0):new Ua(a,c,d);
    ca&&this.renderer.create(this,a,c,d)
    },
getMargins:function(){
    var a=this.options.chart,b=a.spacingTop,c=a.spacingRight,d=a.spacingBottom,a=a.spacingLeft,e,f=this.legend,g=this.optionsMarginTop,h=this.optionsMarginLeft,i=this.optionsMarginRight,j=this.optionsMarginBottom,k=this.chartTitleOptions,l=this.chartSubtitleOptions,m=this.options.legend,o=p(m.margin,10),s=m.x,y=m.y,q=m.align,r=m.verticalAlign;
    this.resetMargins();
    e=this.axisOffset;
    if((this.title||
        this.subtitle)&&!v(this.optionsMarginTop))if(l=x(this.title&&!k.floating&&!k.verticalAlign&&k.y||0,this.subtitle&&!l.floating&&!l.verticalAlign&&l.y||0))this.plotTop=x(this.plotTop,l+p(k.margin,15)+b);
    if(f.display&&!m.floating)if(q==="right"){
        if(!v(i))this.marginRight=x(this.marginRight,f.legendWidth-s+o+c)
            }else if(q==="left"){
        if(!v(h))this.plotLeft=x(this.plotLeft,f.legendWidth+s+o+a)
            }else if(r==="top"){
        if(!v(g))this.plotTop=x(this.plotTop,f.legendHeight+y+o+b)
            }else if(r==="bottom"&&!v(j))this.marginBottom=
        x(this.marginBottom,f.legendHeight-y+o+d);
    this.extraBottomMargin&&(this.marginBottom+=this.extraBottomMargin);
    this.extraTopMargin&&(this.plotTop+=this.extraTopMargin);
    this.hasCartesianSeries&&n(this.axes,function(a){
        a.getOffset()
        });
    v(h)||(this.plotLeft+=e[3]);
    v(g)||(this.plotTop+=e[0]);
    v(j)||(this.marginBottom+=e[2]);
    v(i)||(this.marginRight+=e[1]);
    this.setChartSize()
    },
initReflow:function(){
    function a(a){
        var g=c.width||mb(d,"width"),h=c.height||mb(d,"height"),a=a?a.target:S;
        if(g&&h&&(a===S||a===E)){
            if(g!==
                b.containerWidth||h!==b.containerHeight)clearTimeout(e),b.reflowTimeout=e=setTimeout(function(){
                b.container&&b.resize(g,h,!1)
                },100);
            b.containerWidth=g;
            b.containerHeight=h
            }
        }
    var b=this,c=b.options.chart,d=b.renderTo,e;
D(S,"resize",a);
D(b,"destroy",function(){
    O(S,"resize",a)
    })
},
resize:function(a,b,c){
    var d=this,e,f,g=d.resetZoomButton,h=d.title,i=d.subtitle,j;
    d.isResizing+=1;
    j=function(){
        d&&J(d,"endResize",null,function(){
            d.isResizing-=1
            })
        };
        
    Fa(c,d);
    d.oldChartHeight=d.chartHeight;
    d.oldChartWidth=d.chartWidth;
    if(v(a))d.chartWidth=e=t(a);
    if(v(b))d.chartHeight=f=t(b);
    L(d.container,{
        width:e+"px",
        height:f+"px"
        });
    d.renderer.setSize(e,f,c);
    d.plotWidth=e-d.plotLeft-d.marginRight;
    d.plotHeight=f-d.plotTop-d.marginBottom;
    d.maxTicks=null;
    n(d.axes,function(a){
        a.isDirty=!0;
        a.setScale()
        });
    n(d.series,function(a){
        a.isDirty=!0
        });
    d.isDirtyLegend=!0;
    d.isDirtyBox=!0;
    d.getMargins();
    a=d.spacingBox;
    h&&h.align(null,null,a);
    i&&i.align(null,null,a);
    g&&g.align&&g.align(null,null,d[g.alignTo]);
    d.redraw(c);
    d.oldChartHeight=null;
    J(d,
        "resize");
    Ya===!1?j():setTimeout(j,Ya&&Ya.duration||500)
    },
setChartSize:function(){
    var a=this.inverted,b=this.chartWidth,c=this.chartHeight,d=this.options.chart,e=d.spacingTop,f=d.spacingRight,g=d.spacingBottom,h=d.spacingLeft,i,j,k,l;
    this.plotLeft=i=t(this.plotLeft);
    this.plotTop=j=t(this.plotTop);
    this.plotWidth=k=t(b-i-this.marginRight);
    this.plotHeight=l=t(c-j-this.marginBottom);
    this.plotSizeX=a?l:k;
    this.plotSizeY=a?k:l;
    this.plotBorderWidth=a=d.plotBorderWidth||0;
    this.spacingBox={
        x:h,
        y:e,
        width:b-
        h-f,
        height:c-e-g
        };
        
    this.plotBox={
        x:i,
        y:j,
        width:k,
        height:l
    };
    
    this.clipBox={
        x:a/2,
        y:a/2,
        width:this.plotSizeX-a,
        height:this.plotSizeY-a
        };
        
    n(this.axes,function(a){
        a.setAxisSize();
        a.setAxisTranslation()
        })
    },
resetMargins:function(){
    var a=this.options.chart,b=a.spacingRight,c=a.spacingBottom,d=a.spacingLeft;
    this.plotTop=p(this.optionsMarginTop,a.spacingTop);
    this.marginRight=p(this.optionsMarginRight,b);
    this.marginBottom=p(this.optionsMarginBottom,c);
    this.plotLeft=p(this.optionsMarginLeft,d);
    this.axisOffset=
    [0,0,0,0]
    },
drawChartBox:function(){
    var a=this.options.chart,b=this.renderer,c=this.chartWidth,d=this.chartHeight,e=this.chartBackground,f=this.plotBackground,g=this.plotBorder,h=this.plotBGImage,i=a.borderWidth||0,j=a.backgroundColor,k=a.plotBackgroundColor,l=a.plotBackgroundImage,m=a.plotBorderWidth||0,o,s=this.plotLeft,n=this.plotTop,q=this.plotWidth,p=this.plotHeight,r=this.plotBox,t=this.clipRect,v=this.clipBox;
    o=i+(a.shadow?8:0);
    if(i||j)if(e)e.animate(e.crisp(null,null,null,c-o,d-o));
        else{
        e=

        {
            fill:j||$
            };
            
        if(i)e.stroke=a.borderColor,e["stroke-width"]=i;
        this.chartBackground=b.rect(o/2,o/2,c-o,d-o,a.borderRadius,i).attr(e).add().shadow(a.shadow)
        }
        if(k)f?f.animate(r):this.plotBackground=b.rect(s,n,q,p,0).attr({
        fill:k
    }).add().shadow(a.plotShadow);
    if(l)h?h.animate(r):this.plotBGImage=b.image(l,s,n,q,p).add();
    t?t.animate({
        width:v.width,
        height:v.height
        }):this.clipRect=b.clipRect(v);
    if(m)g?g.animate(g.crisp(null,s,n,q,p)):this.plotBorder=b.rect(s,n,q,p,0,m).attr({
        stroke:a.plotBorderColor,
        "stroke-width":m,
        zIndex:1
    }).add();
    this.isDirtyBox=!1
    },
propFromSeries:function(){
    var a=this,b=a.options.chart,c,d=a.options.series,e,f;
    n(["inverted","angular","polar"],function(g){
        c=R[b.type||b.defaultSeriesType];
        f=a[g]||b[g]||c&&c.prototype[g];
        for(e=d&&d.length;!f&&e--;)(c=R[d[e].type])&&c.prototype[g]&&(f=!0);
        a[g]=f
        })
    },
render:function(){
    var a=this,b=a.axes,c=a.renderer,d=a.options,e=d.labels,d=d.credits,f;
    a.setTitle();
    a.legend=new Ab(a);
    n(b,function(a){
        a.setScale()
        });
    a.getMargins();
    a.maxTicks=null;
    n(b,function(a){
        a.setTickPositions(!0);
        a.setMaxTicks()
        });
    a.adjustTickAmounts();
    a.getMargins();
    a.drawChartBox();
    a.hasCartesianSeries&&n(b,function(a){
        a.render()
        });
    if(!a.seriesGroup)a.seriesGroup=c.g("series-group").attr({
        zIndex:3
    }).add();
    n(a.series,function(a){
        a.translate();
        a.setTooltipPoints();
        a.render()
        });
    e.items&&n(e.items,function(b){
        var d=u(e.style,b.style),f=F(d.left)+a.plotLeft,j=F(d.top)+a.plotTop+12;
        delete d.left;
        delete d.top;
        c.text(b.html,f,j).attr({
            zIndex:2
        }).css(d).add()
        });
    if(d.enabled&&!a.credits)f=d.href,a.credits=c.text(d.text,
        0,0).on("click",function(){
        if(f)location.href=f
            }).attr({
        align:d.position.align,
        zIndex:8
    }).css(d.style).add().align(d.position);
    a.hasRendered=!0
    },
destroy:function(){
    var a=this,b=a.axes,c=a.series,d=a.container,e,f=d&&d.parentNode;
    J(a,"destroy");
    O(a);
    for(e=b.length;e--;)b[e]=b[e].destroy();
    for(e=c.length;e--;)c[e]=c[e].destroy();
    n("title,subtitle,chartBackground,plotBackground,plotBGImage,plotBorder,seriesGroup,clipRect,credits,tracker,scroller,rangeSelector,legend,resetZoomButton,tooltip,renderer".split(","),
        function(b){
            var c=a[b];
            c&&c.destroy&&(a[b]=c.destroy())
            });
    if(d)d.innerHTML="",O(d),f&&Ra(d);
    for(e in a)delete a[e]
    },
firstRender:function(){
    var a=this,b=a.options,c=a.callback;
    if(!ia&&S==S.top&&E.readyState!=="complete"||ca&&!S.canvg)ca?Vb.push(function(){
        a.firstRender()
        },b.global.canvasToolsURL):E.attachEvent("onreadystatechange",function(){
        E.detachEvent("onreadystatechange",a.firstRender);
        E.readyState==="complete"&&a.firstRender()
        });
    else{
        a.getContainer();
        J(a,"init");
        if(Highcharts.RangeSelector&&
            b.rangeSelector.enabled)a.rangeSelector=new Highcharts.RangeSelector(a);
        a.resetMargins();
        a.setChartSize();
        a.propFromSeries();
        a.getAxes();
        n(b.series||[],function(b){
            a.initSeries(b)
            });
        if(Highcharts.Scroller&&(b.navigator.enabled||b.scrollbar.enabled))a.scroller=new Highcharts.Scroller(a);
        a.tracker=new zb(a,b);
        a.render();
        a.renderer.draw();
        c&&c.apply(a,[a]);
        n(a.callbacks,function(b){
            b.apply(a,[a])
            });
        a.cloneRenderTo(!0);
        J(a,"load")
        }
    },
init:function(a){
    var b=this.options.chart,c;
    b.reflow!==!1&&D(this,"load",
        this.initReflow);
    if(a)for(c in a)D(this,c,a[c]);this.xAxis=[];
    this.yAxis=[];
    this.animation=ca?!1:p(b.animation,!0);
    this.setSize=this.resize;
    this.pointCount=0;
    this.counters=new Lb;
    this.firstRender()
    }
};

$a.prototype.callbacks=[];
var xa=function(){};

xa.prototype={
    init:function(a,b,c){
        var d=a.chart.counters;
        this.series=a;
        this.applyOptions(b,c);
        this.pointAttr={};
        
        if(a.options.colorByPoint)b=a.chart.options.colors,this.color=this.color||b[d.color++],d.wrapColor(b.length);
        a.chart.pointCount++;
        return this
        },
    applyOptions:function(a,b){
        var c=this.series,d=typeof a;
        this.config=a;
        if(d==="number"||a===null)this.y=a;
        else if(typeof a[0]==="number")this.x=a[0],this.y=a[1];
        else if(d==="object"&&typeof a.length!=="number"){
            u(this,a);
            this.options=a;
            if(a.dataLabels)c._hasPointLabels=!0;
            if(a.marker)c._hasPointMarkers=!0
                }else if(typeof a[0]==="string")this.name=a[0],this.y=a[1];
        if(this.x===r)this.x=b===r?c.autoIncrement():b
            },
    destroy:function(){
        var a=this.series.chart,b=a.hoverPoints,c;
        a.pointCount--;
        if(b&&(this.setState(),
            Ma(b,this),!b.length))a.hoverPoints=null;
        if(this===a.hoverPoint)this.onMouseOut();
        if(this.graphic||this.dataLabel)O(this),this.destroyElements();
        this.legendItem&&a.legend.destroyItem(this);
        for(c in this)this[c]=null
            },
    destroyElements:function(){
        for(var a="graphic,tracker,dataLabel,dataLabelUpper,group,connector,shadowGroup".split(","),b,c=6;c--;)b=a[c],this[b]&&(this[b]=this[b].destroy())
            },
    getLabelConfig:function(){
        return{
            x:this.category,
            y:this.y,
            key:this.name||this.category,
            series:this.series,
            point:this,
            percentage:this.percentage,
            total:this.total||this.stackTotal
            }
        },
select:function(a,b){
    var c=this,d=c.series.chart,a=p(a,!c.selected);
    c.firePointEvent(a?"select":"unselect",{
        accumulate:b
    },function(){
        c.selected=a;
        c.setState(a&&"select");
        b||n(d.getSelectedPoints(),function(a){
            if(a.selected&&a!==c)a.selected=!1,a.setState(""),a.firePointEvent("unselect")
                })
        })
    },
onMouseOver:function(){
    var a=this.series,b=a.chart,c=b.tooltip,d=b.hoverPoint;
    if(d&&d!==this)d.onMouseOut();
    this.firePointEvent("mouseOver");
    c&&(!c.shared||
        a.noSharedTooltip)&&c.refresh(this);
    this.setState("hover");
    b.hoverPoint=this
    },
onMouseOut:function(){
    var a=this.series.chart,b=a.hoverPoints;
    if(!b||bc(this,b)===-1)this.firePointEvent("mouseOut"),this.setState(),a.hoverPoint=null
        },
tooltipFormatter:function(a){
    var b=this.series,c=b.tooltipOptions,d=a.match(/\{(series|point)\.[a-zA-Z]+\}/g),e=/[{\.}]/,f,g,h,i,j={
        y:0,
        open:0,
        high:0,
        low:0,
        close:0,
        percentage:1,
        total:1
    };
    
    c.valuePrefix=c.valuePrefix||c.yPrefix;
    c.valueDecimals=c.valueDecimals||c.yDecimals;
    c.valueSuffix=
    c.valueSuffix||c.ySuffix;
    for(i in d)g=d[i],qa(g)&&g!==a&&(h=(" "+g).split(e),f={
        point:this,
        series:b
    }
    [h[1]],h=h[2],f===this&&j.hasOwnProperty(h)?(f=j[h]?h:"value",f=(c[f+"Prefix"]||"")+Oa(this[h],p(c[f+"Decimals"],-1))+(c[f+"Suffix"]||"")):f=f[h],a=a.replace(g,f));return a
    },
update:function(a,b,c){
    var d=this,e=d.series,f=d.graphic,g,h=e.data,i=h.length,j=e.chart,b=p(b,!0);
    d.firePointEvent("update",{
        options:a
    },function(){
        d.applyOptions(a);
        ga(a)&&(e.getAttribs(),f&&f.attr(d.pointAttr[e.state]));
        for(g=
            0;g<i;g++)if(h[g]===d){
            e.xData[g]=d.x;
            e.yData[g]=d.y;
            e.options.data[g]=a;
            break
        }
        e.isDirty=!0;
        e.isDirtyData=!0;
        b&&j.redraw(c)
        })
    },
remove:function(a,b){
    var c=this,d=c.series,e=d.chart,f,g=d.data,h=g.length;
    Fa(b,e);
    a=p(a,!0);
    c.firePointEvent("remove",null,function(){
        for(f=0;f<h;f++)if(g[f]===c){
            g.splice(f,1);
            d.options.data.splice(f,1);
            d.xData.splice(f,1);
            d.yData.splice(f,1);
            break
        }
        c.destroy();
        d.isDirty=!0;
        d.isDirtyData=!0;
        a&&e.redraw()
        })
    },
firePointEvent:function(a,b,c){
    var d=this,e=this.series.options;
    (e.point.events[a]||d.options&&d.options.events&&d.options.events[a])&&this.importEvents();
    a==="click"&&e.allowPointSelect&&(c=function(a){
        d.select(null,a.ctrlKey||a.metaKey||a.shiftKey)
        });
    J(this,a,b,c)
    },
importEvents:function(){
    if(!this.hasImportedEvents){
        var a=w(this.series.options.point,this.options).events,b;
        this.events=a;
        for(b in a)D(this,b,a[b]);this.hasImportedEvents=!0
        }
    },
setState:function(a){
    var b=this.plotX,c=this.plotY,d=this.series,e=d.options.states,f=Q[d.type].marker&&d.options.marker,
    g=f&&!f.enabled,h=f&&f.states[a],i=h&&h.enabled===!1,j=d.stateMarkerGraphic,k=d.chart,l=this.pointAttr,a=a||"";
    if(!(a===this.state||this.selected&&a!=="select"||e[a]&&e[a].enabled===!1||a&&(i||g&&!h.enabled))){
        if(this.graphic)e=f&&this.graphic.symbolName&&l[a].r,this.graphic.attr(w(l[a],e?{
            x:b-e,
            y:c-e,
            width:2*e,
            height:2*e
            }:{}));
        else{
            if(a&&h)e=h.radius,j?j.attr({
                x:b-e,
                y:c-e
                }):d.stateMarkerGraphic=j=k.renderer.symbol(d.symbol,b-e,c-e,2*e,2*e).attr(l[a]).add(d.markerGroup);
            if(j)j[a&&k.isInsidePlot(b,
                c)?"show":"hide"]()
                }
                this.state=a
        }
    }
};

var W=function(){};

W.prototype={
    isCartesian:!0,
    type:"line",
    pointClass:xa,
    sorted:!0,
    pointAttrToOptions:{
        stroke:"lineColor",
        "stroke-width":"lineWidth",
        fill:"fillColor",
        r:"radius"
    },
    init:function(a,b){
        var c,d;
        this.chart=a;
        this.options=b=this.setOptions(b);
        this.bindAxes();
        u(this,{
            name:b.name,
            state:"",
            pointAttr:{},
            visible:b.visible!==!1,
            selected:b.selected===!0
            });
        if(ca)b.animation=!1;
        d=b.events;
        for(c in d)D(this,c,d[c]);if(d&&d.click||b.point&&b.point.events&&b.point.events.click||
            b.allowPointSelect)a.runTrackerClick=!0;
        this.getColor();
        this.getSymbol();
        this.setData(b.data,!1);
        if(this.isCartesian)a.hasCartesianSeries=!0;
        a.series.push(this);
        Mb(a.series,function(a,b){
            return(a.options.index||0)-(b.options.index||0)
            });
        n(a.series,function(a,b){
            a.index=b;
            a.name=a.name||"Series "+(b+1)
            })
        },
    bindAxes:function(){
        var a=this,b=a.options,c=a.chart,d;
        a.isCartesian&&n(["xAxis","yAxis"],function(e){
            n(c[e],function(c){
                d=c.options;
                if(b[e]===d.index||b[e]===r&&d.index===0)c.series.push(a),a[e]=
                    c,c.isDirty=!0
                    })
            })
        },
    autoIncrement:function(){
        var a=this.options,b=this.xIncrement,b=p(b,a.pointStart,0);
        this.pointInterval=p(this.pointInterval,a.pointInterval,1);
        this.xIncrement=b+this.pointInterval;
        return b
        },
    getSegments:function(){
        var a=-1,b=[],c,d=this.points,e=d.length;
        if(e)if(this.options.connectNulls){
            for(c=e;c--;)d[c].y===null&&d.splice(c,1);
            d.length&&(b=[d])
            }else n(d,function(c,g){
            c.y===null?(g>a+1&&b.push(d.slice(a+1,g)),a=g):g===e-1&&b.push(d.slice(a+1,g+1))
            });
        this.segments=b
        },
    setOptions:function(a){
        var b=
        this.chart.options,c=b.plotOptions,d=c[this.type],e=a.data;
        a.data=null;
        c=w(d,c.series,a);
        c.data=a.data=e;
        this.tooltipOptions=w(b.tooltip,c.tooltip);
        d.marker===null&&delete c.marker;
        return c
        },
    getColor:function(){
        var a=this.options,b=this.chart.options.colors,c=this.chart.counters;
        this.color=a.color||!a.colorByPoint&&b[c.color++]||"gray";
        c.wrapColor(b.length)
        },
    getSymbol:function(){
        var a=this.options.marker,b=this.chart,c=b.options.symbols,b=b.counters;
        this.symbol=a.symbol||c[b.symbol++];
        if(/^url/.test(this.symbol))a.radius=
            0;
        b.wrapSymbol(c.length)
        },
    drawLegendSymbol:function(a){
        var b=this.options,c=b.marker,d=a.options.symbolWidth,e=this.chart.renderer,f=this.legendGroup,a=a.baseline,g;
        if(b.lineWidth){
            g={
                "stroke-width":b.lineWidth
                };
                
            if(b.dashStyle)g.dashstyle=b.dashStyle;
            this.legendLine=e.path(["M",0,a-4,"L",d,a-4]).attr(g).add(f)
            }
            if(c&&c.enabled)b=c.radius,this.legendSymbol=e.symbol(this.symbol,d/2-b,a-4-b,2*b,2*b).add(f)
            },
    addPoint:function(a,b,c,d){
        var e=this.data,f=this.graph,g=this.area,h=this.chart,i=this.xData,
        j=this.yData,k=f&&f.shift||0,l=this.options.data,m=this.pointClass.prototype;
        Fa(d,h);
        if(f&&c)f.shift=k+1;
        if(g){
            if(c)g.shift=k+1;
            g.isArea=!0
            }
            b=p(b,!0);
        d={
            series:this
        };
        
        m.applyOptions.apply(d,[a]);
        i.push(d.x);
        j.push(m.toYData?m.toYData.call(d):d.y);
        l.push(a);
        c&&(e[0]&&e[0].remove?e[0].remove(!1):(e.shift(),i.shift(),j.shift(),l.shift()));
        this.getAttribs();
        this.isDirtyData=this.isDirty=!0;
        b&&h.redraw()
        },
    setData:function(a,b){
        var c=this.points,d=this.options,e=this.initialColor,f=this.chart,g=null,h=this.xAxis,
        i,j=this.pointClass.prototype;
        this.xIncrement=null;
        this.pointRange=h&&h.categories?1:d.pointRange;
        if(v(e))f.counters.color=e;
        var e=[],k=[],l=a?a.length:[],m=(i=this.pointArrayMap)&&i.length;
        if(l>(d.turboThreshold||1E3)){
            for(i=0;g===null&&i<l;)g=a[i],i++;
            if(za(g)){
                j=p(d.pointStart,0);
                d=p(d.pointInterval,1);
                for(i=0;i<l;i++)e[i]=j,k[i]=a[i],j+=d;
                this.xIncrement=j
                }else if(Wa(g))if(m)for(i=0;i<l;i++)d=a[i],e[i]=d[0],k[i]=d.slice(1,m+1);else for(i=0;i<l;i++)d=a[i],e[i]=d[0],k[i]=d[1]
                }else for(i=0;i<l;i++)d=

                {
            series:this
        },j.applyOptions.apply(d,[a[i]]),e[i]=d.x,k[i]=j.toYData?j.toYData.call(d):d.y;
        qa(k[0])&&ib(14,!0);
        this.data=[];
        this.options.data=a;
        this.xData=e;
        this.yData=k;
        for(i=c&&c.length||0;i--;)c[i]&&c[i].destroy&&c[i].destroy();
        if(h)h.minRange=h.userMinRange;
        this.isDirty=this.isDirtyData=f.isDirtyBox=!0;
        p(b,!0)&&f.redraw(!1)
        },
    remove:function(a,b){
        var c=this,d=c.chart,a=p(a,!0);
        if(!c.isRemoving)c.isRemoving=!0,J(c,"remove",null,function(){
            c.destroy();
            d.isDirtyLegend=d.isDirtyBox=!0;
            a&&d.redraw(b)
            });
        c.isRemoving=!1
        },
    processData:function(a){
        var b=this.xData,c=this.yData,d=b.length,e=0,f=d,g,h,i=this.xAxis,j=this.options,k=j.cropThreshold,l=this.isCartesian;
        if(l&&!this.isDirty&&!i.isDirty&&!this.yAxis.isDirty&&!a)return!1;
        if(l&&this.sorted&&(!k||d>k||this.forceCrop))if(a=i.getExtremes(),i=a.min,k=a.max,b[d-1]<i||b[0]>k)b=[],c=[];
            else if(b[0]<i||b[d-1]>k){
            for(a=0;a<d;a++)if(b[a]>=i){
                e=x(0,a-1);
                break
            }
            for(;a<d;a++)if(b[a]>k){
                f=a+1;
                break
            }
            b=b.slice(e,f);
            c=c.slice(e,f);
            g=!0
            }
            for(a=b.length-1;a>0;a--)if(d=
            b[a]-b[a-1],d>0&&(h===r||d<h))h=d;this.cropped=g;
        this.cropStart=e;
        this.processedXData=b;
        this.processedYData=c;
        if(j.pointRange===null)this.pointRange=h||1;
        this.closestPointRange=h
        },
    generatePoints:function(){
        var a=this.options.data,b=this.data,c,d=this.processedXData,e=this.processedYData,f=this.pointClass,g=d.length,h=this.cropStart||0,i,j=this.hasGroupedData,k,l=[],m;
        if(!b&&!j)b=[],b.length=a.length,b=this.data=b;
        for(m=0;m<g;m++)i=h+m,j?l[m]=(new f).init(this,[d[m]].concat(la(e[m]))):(b[i]?k=b[i]:
            a[i]!==r&&(b[i]=k=(new f).init(this,a[i],d[m])),l[m]=k);
        if(b&&(g!==(c=b.length)||j))for(m=0;m<c;m++)if(m===h&&!j&&(m+=g),b[m])b[m].destroyElements(),b[m].plotX=r;this.data=b;
        this.points=l
        },
    translate:function(){
        this.processedXData||this.processData();
        this.generatePoints();
        for(var a=this.chart,b=this.options,c=b.stacking,d=this.xAxis,e=d.categories,f=this.yAxis,g=this.points,h=g.length,i=!!this.modifyValue,j,k=f.series,l=k.length,m=b.pointPlacement==="between";l--;)if(k[l].visible){
            k[l]===this&&(j=
                !0);
            break
        }
        for(l=0;l<h;l++){
            var k=g[l],o=k.x,s=k.y,n=k.low,q=f.stacks[(s<b.threshold?"-":"")+this.stackKey];
            k.plotX=d.translate(o,0,0,0,1,m);
            if(c&&this.visible&&q&&q[o])n=q[o],o=n.total,n.cum=n=n.cum-s,s=n+s,j&&(n=p(b.threshold,f.min)),f.isLog&&n<=0&&(n=null),c==="percent"&&(n=o?n*100/o:0,s=o?s*100/o:0),k.percentage=o?k.y*100/o:0,k.total=k.stackTotal=o,k.stackY=s;
            k.yBottom=v(n)?f.translate(n,0,1,0,1):null;
            i&&(s=this.modifyValue(s,k));
            k.plotY=typeof s==="number"?t(f.translate(s,0,1,0,1)*10)/10:r;
            k.clientX=
            a.inverted?a.plotHeight-k.plotX:k.plotX;
            k.category=e&&e[k.x]!==r?e[k.x]:k.x
            }
            this.getSegments()
        },
    setTooltipPoints:function(a){
        var b=[],c,d,e=(c=this.xAxis)?c.tooltipLen||c.len:this.chart.plotSizeX,f=c&&c.tooltipPosName||"plotX",g,h,i=[];
        if(this.options.enableMouseTracking!==!1){
            if(a)this.tooltipPoints=null;
            n(this.segments||this.points,function(a){
                b=b.concat(a)
                });
            c&&c.reversed&&(b=b.reverse());
            a=b.length;
            for(h=0;h<a;h++){
                g=b[h];
                c=b[h-1]?d+1:0;
                for(d=b[h+1]?x(0,Y((g[f]+(b[h+1]?b[h+1][f]:e))/2)):e;c>=
                    0&&c<=d;)i[c++]=g
                }
                this.tooltipPoints=i
            }
        },
tooltipHeaderFormatter:function(a){
    var b=this.tooltipOptions,c=b.xDateFormat,d=this.xAxis,e=d&&d.options.type==="datetime",f;
    if(e&&!c)for(f in C)if(C[f]>=d.closestPointRange){
        c=b.dateTimeLabelFormats[f];
        break
    }
    return b.headerFormat.replace("{point.key}",e&&za(a)?va(c,a):a).replace("{series.name}",this.name).replace("{series.color}",this.color)
    },
onMouseOver:function(){
    var a=this.chart,b=a.hoverSeries;
    if(b&&b!==this)b.onMouseOut();
    this.options.events.mouseOver&&
    J(this,"mouseOver");
    this.setState("hover");
    a.hoverSeries=this
    },
onMouseOut:function(){
    var a=this.options,b=this.chart,c=b.tooltip,d=b.hoverPoint;
    if(d)d.onMouseOut();
    this&&a.events.mouseOut&&J(this,"mouseOut");
    c&&!a.stickyTracking&&!c.shared&&c.hide();
    this.setState();
    b.hoverSeries=null
    },
animate:function(a){
    var b=this,c=b.chart,d=c.renderer,e;
    e=b.options.animation;
    var f=c.clipBox,g=c.inverted,h;
    if(e&&!ga(e))e=Q[b.type].animation;
    h="_sharedClip"+e.duration+e.easing;
    if(a)a=c[h],e=c[h+"m"],a||(c[h]=a=d.clipRect(u(f,

    {
        width:0
    })),c[h+"m"]=e=d.clipRect(-99,g?-c.plotLeft:-c.plotTop,99,g?c.chartWidth:c.chartHeight)),b.group.clip(a),b.markerGroup.clip(e),b.sharedClipKey=h;
    else{
        if(a=c[h])a.animate({
            width:c.plotSizeX
            },e),c[h+"m"].animate({
            width:c.plotSizeX+99
            },e);
        b.animate=null;
        b.animationTimeout=setTimeout(function(){
            b.afterAnimate()
            },e.duration)
        }
    },
afterAnimate:function(){
    var a=this.chart,b=this.sharedClipKey,c=this.group;
    c&&this.options.clip!==!1&&(c.clip(a.clipRect),this.markerGroup.clip());
    setTimeout(function(){
        b&&
        a[b]&&(a[b]=a[b].destroy(),a[b+"m"]=a[b+"m"].destroy())
        },100)
    },
drawPoints:function(){
    var a,b=this.points,c=this.chart,d,e,f,g,h,i,j,k,l=this.options.marker,m,o=this.markerGroup;
    if(l.enabled||this._hasPointMarkers)for(f=b.length;f--;)if(g=b[f],d=g.plotX,e=g.plotY,k=g.graphic,i=g.marker||{},a=l.enabled&&i.enabled===r||i.enabled,m=c.isInsidePlot(d,e,c.inverted),a&&e!==r&&!isNaN(e))if(a=g.pointAttr[g.selected?"select":""],h=a.r,i=p(i.symbol,this.symbol),j=i.indexOf("url")===0,k)k.attr({
        visibility:m?ia?
        "inherit":"visible":"hidden"
        }).animate(u({
        x:d-h,
        y:e-h
        },k.symbolName?{
        width:2*h,
        height:2*h
        }:{}));
    else{
        if(m&&(h>0||j))g.graphic=c.renderer.symbol(i,d-h,e-h,2*h,2*h).attr(a).add(o)
            }else if(k)g.graphic=k.destroy()
        },
convertAttribs:function(a,b,c,d){
    var e=this.pointAttrToOptions,f,g,h={},a=a||{},b=b||{},c=c||{},d=d||{};
    
    for(f in e)g=e[f],h[f]=p(a[g],b[f],c[f],d[f]);return h
    },
getAttribs:function(){
    var a=this,b=Q[a.type].marker?a.options.marker:a.options,c=b.states,d=c.hover,e,f=a.color,g={
        stroke:f,
        fill:f
    },
    h=a.points||[],i=[],j,k=a.pointAttrToOptions,l;
    a.options.marker?(d.radius=d.radius||b.radius+2,d.lineWidth=d.lineWidth||b.lineWidth+1):d.color=d.color||wa(d.color||f).brighten(d.brightness).get();
    i[""]=a.convertAttribs(b,g);
    n(["hover","select"],function(b){
        i[b]=a.convertAttribs(c[b],i[""])
        });
    a.pointAttr=i;
    for(f=h.length;f--;){
        g=h[f];
        if((b=g.options&&g.options.marker||g.options)&&b.enabled===!1)b.radius=0;
        e=a.options.colorByPoint;
        if(g.options)for(l in k)v(b[k[l]])&&(e=!0);if(e){
            b=b||{};
            
            j=[];
            c=b.states||

            {};
            
            e=c.hover=c.hover||{};
            
            if(!a.options.marker)e.color=wa(e.color||g.color).brighten(e.brightness||d.brightness).get();
            j[""]=a.convertAttribs(u({
                color:g.color
                },b),i[""]);
            j.hover=a.convertAttribs(c.hover,i.hover,j[""]);
            j.select=a.convertAttribs(c.select,i.select,j[""])
            }else j=i;
        g.pointAttr=j
        }
    },
destroy:function(){
    var a=this,b=a.chart,c=/AppleWebKit\/533/.test(Ta),d,e,f=a.data||[],g,h,i;
    J(a,"destroy");
    O(a);
    n(["xAxis","yAxis"],function(b){
        if(i=a[b])Ma(i.series,a),i.isDirty=!0
            });
    a.legendItem&&a.chart.legend.destroyItem(a);
    for(e=f.length;e--;)(g=f[e])&&g.destroy&&g.destroy();
    a.points=null;
    clearTimeout(a.animationTimeout);
    n("area,graph,dataLabelsGroup,group,markerGroup,tracker,trackerGroup".split(","),function(b){
        a[b]&&(d=c&&b==="group"?"hide":"destroy",a[b][d]())
        });
    if(b.hoverSeries===a)b.hoverSeries=null;
    Ma(b.series,a);
    for(h in a)delete a[h]
    },
drawDataLabels:function(){
    var a=this,b=a.options.dataLabels,c=a.points,d,e,f,g;
    if(b.enabled||a._hasPointLabels)a.dlProcessOptions&&a.dlProcessOptions(b),g=a.plotGroup("dataLabelsGroup",
        "data-labels",a.visible?"visible":"hidden",6),e=b,n(c,function(c){
        var i,j=c.dataLabel,k,l=!0;
        d=c.options&&c.options.dataLabels;
        i=e.enabled||d&&d.enabled;
        if(j&&!i)c.dataLabel=j.destroy();
        else if(i){
            i=b.rotation;
            b=w(e,d);
            f=b.formatter.call(c.getLabelConfig(),b);
            b.style.color=p(b.color,b.style.color,a.color,"black");
            if(j)j.attr({
                text:f
            }),l=!1;
            else if(v(f)){
                j={
                    fill:b.backgroundColor,
                    stroke:b.borderColor,
                    "stroke-width":b.borderWidth,
                    r:b.borderRadius||0,
                    rotation:i,
                    padding:b.padding,
                    zIndex:1
                };
                
                for(k in j)j[k]===
                    r&&delete j[k];j=c.dataLabel=a.chart.renderer[i?"text":"label"](f,0,-999,null,null,null,b.useHTML).attr(j).css(b.style).add(g).shadow(b.shadow)
                }
                j&&a.alignDataLabel(c,j,b,null,l)
            }
        })
    },
alignDataLabel:function(a,b,c,d,e){
    var f=this.chart,g=f.inverted,h=p(a.plotX,-999),a=p(a.plotY,-999),i=b.getBBox(),d=u({
        x:g?f.plotWidth-a:h,
        y:t(g?f.plotHeight-h:a),
        width:0,
        height:0
    },d);
    u(c,{
        width:i.width,
        height:i.height
        });
    c.rotation?(d={
        align:c.align,
        x:d.x+c.x+d.width/2,
        y:d.y+c.y+d.height/2
        },b[e?"attr":"animate"](d)):
    (b.align(c,null,d),d=b.alignAttr);
    b.attr({
        visibility:c.crop===!1||f.isInsidePlot(d.x,d.y)||f.isInsidePlot(h,a,g)?ia?"inherit":"visible":"hidden"
        })
    },
getSegmentPath:function(a){
    var b=this,c=[];
    n(a,function(d,e){
        b.getPointSpline?c.push.apply(c,b.getPointSpline(a,d,e)):(c.push(e?"L":"M"),e&&b.options.step&&c.push(d.plotX,a[e-1].plotY),c.push(d.plotX,d.plotY))
        });
    return c
    },
getGraphPath:function(){
    var a=this,b=[],c,d=[];
    n(a.segments,function(e){
        c=a.getSegmentPath(e);
        e.length>1?b=b.concat(c):d.push(e[0])
        });
    a.singlePoints=d;
    return a.graphPath=b
    },
drawGraph:function(){
    var a=this.options,b=this.graph,c=this.group,d=a.lineColor||this.color,e=a.lineWidth,f=a.dashStyle,g=this.getGraphPath();
    if(b)nb(b),b.animate({
        d:g
    });
    else if(e){
        b={
            stroke:d,
            "stroke-width":e,
            zIndex:1
        };
        
        if(f)b.dashstyle=f;
        this.graph=this.chart.renderer.path(g).attr(b).add(c).shadow(a.shadow)
        }
    },
invertGroups:function(){
    function a(){
        var a={
            width:b.yAxis.len,
            height:b.xAxis.len
            };
            
        n(["group","trackerGroup","markerGroup"],function(c){
            b[c]&&b[c].attr(a).invert()
            })
        }
    var b=this,c=b.chart;
    D(c,"resize",a);
    D(b,"destroy",function(){
        O(c,"resize",a)
        });
    a();
    b.invertGroups=a
    },
plotGroup:function(a,b,c,d,e){
    var f=this[a],g=this.chart,h=this.xAxis,i=this.yAxis;
    f||(this[a]=f=g.renderer.g(b).attr({
        visibility:c,
        zIndex:d||0.1
        }).add(e));
    f.translate(h?h.left:g.plotLeft,i?i.top:g.plotTop);
    return f
    },
render:function(){
    var a=this.chart,b,c=this.options,d=c.animation&&!!this.animate,e=this.visible?"visible":"hidden",f=c.zIndex,g=this.hasRendered,h=a.seriesGroup;
    b=this.plotGroup("group",
        "series",e,f,h);
    this.markerGroup=this.plotGroup("markerGroup","markers",e,f,h);
    d&&this.animate(!0);
    this.getAttribs();
    b.inverted=a.inverted;
    this.drawGraph&&this.drawGraph();
    this.drawPoints();
    this.drawDataLabels();
    this.options.enableMouseTracking!==!1&&this.drawTracker();
    a.inverted&&this.invertGroups();
    c.clip!==!1&&!this.sharedClipKey&&!g&&(b.clip(a.clipRect),this.trackerGroup&&this.trackerGroup.clip(a.clipRect));
    d?this.animate():g||this.afterAnimate();
    this.isDirty=this.isDirtyData=!1;
    this.hasRendered=
    !0
    },
redraw:function(){
    var a=this.chart,b=this.isDirtyData,c=this.group;
    c&&(a.inverted&&c.attr({
        width:a.plotWidth,
        height:a.plotHeight
        }),c.animate({
        translateX:this.xAxis.left,
        translateY:this.yAxis.top
        }));
    this.translate();
    this.setTooltipPoints(!0);
    this.render();
    b&&J(this,"updatedData")
    },
setState:function(a){
    var b=this.options,c=this.graph,d=b.states,b=b.lineWidth,a=a||"";
    if(this.state!==a)this.state=a,d[a]&&d[a].enabled===!1||(a&&(b=d[a].lineWidth||b+1),c&&!c.dashstyle&&c.attr({
        "stroke-width":b
    },a?0:
    500))
    },
setVisible:function(a,b){
    var c=this.chart,d=this.legendItem,e=this.group,f=this.tracker,g=this.dataLabelsGroup,h=this.markerGroup,i,j=this.points,k=c.options.chart.ignoreHiddenSeries;
    i=this.visible;
    i=(this.visible=a=a===r?!i:a)?"show":"hide";
    if(e)e[i]();
    if(h)h[i]();
    if(f)f[i]();
    else if(j)for(e=j.length;e--;)if(f=j[e],f.tracker)f.tracker[i]();if(g)g[i]();
    d&&c.legend.colorizeItem(this,a);
    this.isDirty=!0;
    this.options.stacking&&n(c.series,function(a){
        if(a.options.stacking&&a.visible)a.isDirty=!0
            });
    if(k)c.isDirtyBox=!0;
    b!==!1&&c.redraw();
    J(this,i)
    },
show:function(){
    this.setVisible(!0)
    },
hide:function(){
    this.setVisible(!1)
    },
select:function(a){
    this.selected=a=a===r?!this.selected:a;
    if(this.checkbox)this.checkbox.checked=a;
    J(this,a?"select":"unselect")
    },
drawTracker:function(){
    var a=this,b=a.options,c=b.trackByArea,d=[].concat(c?a.areaPath:a.graphPath),e=d.length,f=a.chart,g=f.renderer,h=f.options.tooltip.snap,i=a.tracker,j=b.cursor,j=j&&{
        cursor:j
    },k=a.singlePoints,l=this.isCartesian&&this.plotGroup("trackerGroup",
        null,"visible",b.zIndex||1,f.trackerGroup),m;
    if(e&&!c)for(m=e+1;m--;)d[m]==="M"&&d.splice(m+1,0,d[m+1]-h,d[m+2],"L"),(m&&d[m]==="M"||m===e)&&d.splice(m,0,"L",d[m-2]+h,d[m-1]);
    for(m=0;m<k.length;m++)e=k[m],d.push("M",e.plotX-h,e.plotY,"L",e.plotX+h,e.plotY);
    i?i.attr({
        d:d
    }):a.tracker=g.path(d).attr({
        isTracker:!0,
        "stroke-linejoin":"bevel",
        visibility:a.visible?"visible":"hidden",
        stroke:Eb,
        fill:c?Eb:$,
        "stroke-width":b.lineWidth+(c?0:2*h)
        }).on(ba?"touchstart":"mouseover",function(){
        if(f.hoverSeries!==a)a.onMouseOver()
            }).on("mouseout",
        function(){
            if(!b.stickyTracking)a.onMouseOut()
                }).css(j).add(l)
    }
};

H=aa(W);
R.line=H;
Q.area=w(N,{
    threshold:0
});
H=aa(W,{
    type:"area",
    getSegmentPath:function(a){
        var b=W.prototype.getSegmentPath.call(this,a),c=[].concat(b),d,e=this.options;
        b.length===3&&c.push("L",b[1],b[2]);
        if(e.stacking&&!this.closedStacks)for(d=a.length-1;d>=0;d--)d<a.length-1&&e.step&&c.push(a[d+1].plotX,a[d].yBottom),c.push(a[d].plotX,a[d].yBottom);else this.closeSegment(c,a);
        this.areaPath=this.areaPath.concat(c);
        return b
        },
    closeSegment:function(a,
        b){
        var c=this.yAxis.getThreshold(this.options.threshold);
        a.push("L",b[b.length-1].plotX,c,"L",b[0].plotX,c)
        },
    drawGraph:function(){
        this.areaPath=[];
        W.prototype.drawGraph.apply(this);
        var a=this.areaPath,b=this.options,c=this.area;
        c?c.animate({
            d:a
        }):this.area=this.chart.renderer.path(a).attr({
            fill:p(b.fillColor,wa(this.color).setOpacity(b.fillOpacity||0.75).get()),
            zIndex:0
        }).add(this.group)
        },
    drawLegendSymbol:function(a,b){
        b.legendSymbol=this.chart.renderer.rect(0,a.baseline-11,a.options.symbolWidth,
            12,2).attr({
            zIndex:3
        }).add(b.legendGroup)
        }
    });
R.area=H;
Q.spline=w(N);
ea=aa(W,{
    type:"spline",
    getPointSpline:function(a,b,c){
        var d=b.plotX,e=b.plotY,f=a[c-1],g=a[c+1],h,i,j,k;
        if(f&&g){
            a=f.plotY;
            j=g.plotX;
            var g=g.plotY,l;
            h=(1.5*d+f.plotX)/2.5;
            i=(1.5*e+a)/2.5;
            j=(1.5*d+j)/2.5;
            k=(1.5*e+g)/2.5;
            l=(k-i)*(j-d)/(j-h)+e-k;
            i+=l;
            k+=l;
            i>a&&i>e?(i=x(a,e),k=2*e-i):i<a&&i<e&&(i=K(a,e),k=2*e-i);
            k>g&&k>e?(k=x(g,e),i=2*e-k):k<g&&k<e&&(k=K(g,e),i=2*e-k);
            b.rightContX=j;
            b.rightContY=k
            }
            c?(b=["C",f.rightContX||f.plotX,f.rightContY||
            f.plotY,h||d,i||e,d,e],f.rightContX=f.rightContY=null):b=["M",d,e];
        return b
        }
    });
R.spline=ea;
Q.areaspline=w(Q.area);
var La=H.prototype,ea=aa(ea,{
    type:"areaspline",
    closedStacks:!0,
    getSegmentPath:La.getSegmentPath,
    closeSegment:La.closeSegment,
    drawGraph:La.drawGraph
    });
R.areaspline=ea;
Q.column=w(N,{
    borderColor:"#FFFFFF",
    borderWidth:1,
    borderRadius:0,
    groupPadding:0.2,
    marker:null,
    pointPadding:0.1,
    minPointLength:0,
    cropThreshold:50,
    pointRange:null,
    states:{
        hover:{
            brightness:0.1,
            shadow:!1
            },
        select:{
            color:"#C0C0C0",
            borderColor:"#000000",
            shadow:!1
            }
        },
dataLabels:{
    align:null,
    verticalAlign:null,
    y:null
},
threshold:0
});
ea=aa(W,{
    type:"column",
    tooltipOutsidePlot:!0,
    pointAttrToOptions:{
        stroke:"borderColor",
        "stroke-width":"borderWidth",
        fill:"color",
        r:"borderRadius"
    },
    init:function(){
        W.prototype.init.apply(this,arguments);
        var a=this,b=a.chart;
        b.hasRendered&&n(b.series,function(b){
            if(b.type===a.type)b.isDirty=!0
                })
        },
    translate:function(){
        var a=this,b=a.chart,c=a.options,d=c.stacking,e=c.borderWidth,f=0,g=a.xAxis,h=g.reversed,
        i={},j,k;
        W.prototype.translate.apply(a);
        c.grouping===!1?f=1:n(b.series,function(b){
            var c=b.options;
            if(b.type===a.type&&b.visible&&a.options.group===c.group)c.stacking?(j=b.stackKey,i[j]===r&&(i[j]=f++),k=i[j]):c.grouping!==!1&&(k=f++),b.columnIndex=k
                });
        var l=a.points,g=V(g.transA)*(g.ordinalSlope||c.pointRange||g.closestPointRange||1),m=g*c.groupPadding,o=(g-2*m)/f,s=c.pointWidth,y=v(s)?(o-s)/2:o*c.pointPadding,q=p(s,o-2*y),t=Ha(x(q,1+2*e)),u=y+(m+((h?f-a.columnIndex:a.columnIndex)||0)*o-g/2)*(h?
            -1:1),I=a.translatedThreshold=a.yAxis.getThreshold(c.threshold),z=p(c.minPointLength,5);
        n(l,function(c){
            var f=c.plotY,g=p(c.yBottom,I),h=c.plotX+u,i=Ha(K(f,g)),j=Ha(x(f,g)-i),k=a.yAxis.stacks[(c.y<0?"-":"")+a.stackKey];
            d&&a.visible&&k&&k[c.x]&&k[c.x].setOffset(u,t);
            V(j)<z&&z&&(j=z,i=V(i-I)>z?g-z:I-(f<=I?z:0));
            c.barX=h;
            c.pointWidth=q;
            c.shapeType="rect";
            c.shapeArgs=f=b.renderer.Element.prototype.crisp.call(0,e,h,i,t,j);
            e%2&&(f.y-=1,f.height+=1);
            c.trackerArgs=V(j)<3&&w(c.shapeArgs,{
                height:6,
                y:i-3
                })
            })
        },
    getSymbol:lb,
    drawLegendSymbol:H.prototype.drawLegendSymbol,
    drawGraph:lb,
    drawPoints:function(){
        var a=this,b=a.options,c=a.chart.renderer,d;
        n(a.points,function(e){
            var f=e.plotY,g=e.graphic;
            if(f!==r&&!isNaN(f)&&e.y!==null)d=e.shapeArgs,g?(nb(g),g.animate(w(d))):e.graphic=c[e.shapeType](d).attr(e.pointAttr[e.selected?"select":""]).add(a.group).shadow(b.shadow,null,b.stacking&&!b.borderRadius);
            else if(g)e.graphic=g.destroy()
                })
        },
    drawTracker:function(){
        var a=this,b=a.chart,c=b.renderer,d,e,f=+new Date,g=
        a.options,h=g.cursor,i=h&&{
            cursor:h
        },j=a.isCartesian&&a.plotGroup("trackerGroup",null,"visible",g.zIndex||1,b.trackerGroup),k,l,m;
        n(a.points,function(h){
            e=h.tracker;
            d=h.trackerArgs||h.shapeArgs;
            l=h.plotY;
            m=!a.isCartesian||l!==r&&!isNaN(l);
            delete d.strokeWidth;
            if(h.y!==null&&m)e?e.attr(d):h.tracker=c[h.shapeType](d).attr({
                isTracker:f,
                fill:Eb,
                visibility:a.visible?"visible":"hidden"
                }).on(ba?"touchstart":"mouseover",function(c){
                k=c.relatedTarget||c.fromElement;
                if(b.hoverSeries!==a&&G(k,"isTracker")!==
                    f)a.onMouseOver();
                h.onMouseOver()
                }).on("mouseout",function(b){
                if(!g.stickyTracking&&(k=b.relatedTarget||b.toElement,G(k,"isTracker")!==f))a.onMouseOut()
                    }).css(i).add(h.group||j)
                })
        },
    alignDataLabel:function(a,b,c,d,e){
        var f=this.chart,g=f.inverted,h=a.below||a.plotY>(this.translatedThreshold||f.plotSizeY),i=this.options.stacking||c.inside;
        if(a.shapeArgs&&(d=w(a.shapeArgs),g&&(d={
            x:f.plotWidth-d.y-d.height,
            y:f.plotHeight-d.x-d.width,
            width:d.height,
            height:d.width
            }),!i))g?(d.x+=h?0:d.width,d.width=0):
            (d.y+=h?d.height:0,d.height=0);
        c.align=p(c.align,!g||i?"center":h?"right":"left");
        c.verticalAlign=p(c.verticalAlign,g||i?"middle":h?"top":"bottom");
        W.prototype.alignDataLabel.call(this,a,b,c,d,e)
        },
    animate:function(a){
        var b=this,c=b.points,d=b.options;
        if(!a)n(c,function(a){
            var c=a.graphic,a=a.shapeArgs,g=b.yAxis,h=d.threshold;
            c&&(c.attr({
                height:0,
                y:v(h)?g.getThreshold(h):g.translate(g.getExtremes().min,0,1,0,1)
                }),c.animate({
                height:a.height,
                y:a.y
                },d.animation))
            }),b.animate=null
        },
    remove:function(){
        var a=
        this,b=a.chart;
        b.hasRendered&&n(b.series,function(b){
            if(b.type===a.type)b.isDirty=!0
                });
        W.prototype.remove.apply(a,arguments)
        }
    });
R.column=ea;
Q.bar=w(Q.column);
La=aa(ea,{
    type:"bar",
    inverted:!0
    });
R.bar=La;
Q.scatter=w(N,{
    lineWidth:0,
    states:{
        hover:{
            lineWidth:0
        }
    },
tooltip:{
    headerFormat:'<span style="font-size: 10px; color:{series.color}">{series.name}</span><br/>',
    pointFormat:"x: <b>{point.x}</b><br/>y: <b>{point.y}</b><br/>"
}
});
La=aa(W,{
    type:"scatter",
    sorted:!1,
    translate:function(){
        var a=this;
        W.prototype.translate.apply(a);
        n(a.points,function(b){
            b.shapeType="circle";
            b.shapeArgs={
                x:b.plotX,
                y:b.plotY,
                r:a.chart.options.tooltip.snap
                }
            })
    },
drawTracker:function(){
    for(var a=this,b=a.options.cursor,b=b&&{
        cursor:b
    },c=a.points,d=c.length,e;d--;)if(e=c[d].graphic)e.element._i=d;a._hasTracking?a._hasTracking=!0:a.markerGroup.attr({
        isTracker:!0
        }).on(ba?"touchstart":"mouseover",function(b){
        a.onMouseOver();
        if(b.target._i!==r)c[b.target._i].onMouseOver()
            }).on("mouseout",function(){
        if(!a.options.stickyTracking)a.onMouseOut()
            }).css(b)
    }
});
R.scatter=La;
Q.pie=w(N,{
    borderColor:"#FFFFFF",
    borderWidth:1,
    center:["50%","50%"],
    colorByPoint:!0,
    dataLabels:{
        distance:30,
        enabled:!0,
        formatter:function(){
            return this.point.name
            }
        },
legendType:"point",
marker:null,
size:"75%",
showInLegend:!1,
slicedOffset:10,
states:{
    hover:{
        brightness:0.1,
        shadow:!1
        }
    }
});
N={
    type:"pie",
    isCartesian:!1,
    pointClass:aa(xa,{
        init:function(){
            xa.prototype.init.apply(this,arguments);
            var a=this,b;
            u(a,{
                visible:a.visible!==!1,
                name:p(a.name,"Slice")
                });
            b=function(){
                a.slice()
                };
                
            D(a,"select",
                b);
            D(a,"unselect",b);
            return a
            },
        setVisible:function(a){
            var b=this.series,c=b.chart,d=this.tracker,e=this.dataLabel,f=this.connector,g=this.shadowGroup,h;
            h=(this.visible=a=a===r?!this.visible:a)?"show":"hide";
            this.group[h]();
            if(d)d[h]();
            if(e)e[h]();
            if(f)f[h]();
            if(g)g[h]();
            this.legendItem&&c.legend.colorizeItem(this,a);
            if(!b.isDirty&&b.options.ignoreHiddenPoint)b.isDirty=!0,c.redraw()
                },
        slice:function(a,b,c){
            var d=this.series.chart,e=this.slicedTranslation;
            Fa(c,d);
            p(b,!0);
            a=this.sliced=v(a)?a:!this.sliced;
            a={
                translateX:a?e[0]:d.plotLeft,
                translateY:a?e[1]:d.plotTop
                };
                
            this.group.animate(a);
            this.shadowGroup&&this.shadowGroup.animate(a)
            }
        }),
pointAttrToOptions:{
    stroke:"borderColor",
    "stroke-width":"borderWidth",
    fill:"color"
},
getColor:function(){
    this.initialColor=this.chart.counters.color
    },
animate:function(){
    var a=this;
    n(a.points,function(b){
        var c=b.graphic,b=b.shapeArgs,d=-Ia/2;
        c&&(c.attr({
            r:0,
            start:d,
            end:d
        }),c.animate({
            r:b.r,
            start:b.start,
            end:b.end
            },a.options.animation))
        });
    a.animate=null
    },
setData:function(a,
    b){
    W.prototype.setData.call(this,a,!1);
    this.processData();
    this.generatePoints();
    p(b,!0)&&this.chart.redraw()
    },
getCenter:function(){
    var a=this.options,b=this.chart,c=b.plotWidth,d=b.plotHeight,a=a.center.concat([a.size,a.innerSize||0]),e=K(c,d),f;
    return Ja(a,function(a,b){
        return(f=/%$/.test(a))?[c,d,e,e][b]*F(a)/100:a
        })
    },
translate:function(){
    this.generatePoints();
    var a=0,b=-0.25,c=this.options,d=c.slicedOffset,e=d+c.borderWidth,f,g=this.chart,h,i,j,k=this.points,l=2*Ia,m=c.dataLabels.distance,o=c.ignoreHiddenPoint,
    n,p=k.length,q;
    this.center=f=this.getCenter();
    this.getX=function(a,b){
        j=M.asin((a-f[1])/(f[2]/2+m));
        return f[0]+(b?-1:1)*da(j)*(f[2]/2+m)
        };
        
    for(n=0;n<p;n++)q=k[n],a+=o&&!q.visible?0:q.y;
    for(n=0;n<p;n++){
        q=k[n];
        c=a?q.y/a:0;
        h=t(b*l*1E3)/1E3;
        if(!o||q.visible)b+=c;
        i=t(b*l*1E3)/1E3;
        q.shapeType="arc";
        q.shapeArgs={
            x:f[0],
            y:f[1],
            r:f[2]/2,
            innerR:f[3]/2,
            start:h,
            end:i
        };
        
        j=(i+h)/2;
        q.slicedTranslation=Ja([da(j)*d+g.plotLeft,ha(j)*d+g.plotTop],t);
        h=da(j)*f[2]/2;
        i=ha(j)*f[2]/2;
        q.tooltipPos=[f[0]+h*0.7,f[1]+i*0.7];
        q.labelPos=[f[0]+h+da(j)*m,f[1]+i+ha(j)*m,f[0]+h+da(j)*e,f[1]+i+ha(j)*e,f[0]+h,f[1]+i,m<0?"center":j<l/4?"left":"right",j];
        q.percentage=c*100;
        q.total=a
        }
        this.setTooltipPoints()
    },
render:function(){
    this.getAttribs();
    this.drawPoints();
    this.options.enableMouseTracking!==!1&&this.drawTracker();
    this.drawDataLabels();
    this.options.animation&&this.animate&&this.animate();
    this.isDirty=!1
    },
drawPoints:function(){
    var a=this,b=a.chart,c=b.renderer,d,e,f,g=a.options.shadow,h,i;
    n(a.points,function(j){
        e=j.graphic;
        i=j.shapeArgs;
        f=j.group;
        h=j.shadowGroup;
        if(g&&!h)h=j.shadowGroup=c.g("shadow").attr({
            zIndex:4
        }).add();
        if(!f)f=j.group=c.g("point").attr({
            zIndex:5
        }).add();
        d=j.sliced?j.slicedTranslation:[b.plotLeft,b.plotTop];
        f.translate(d[0],d[1]);
        h&&h.translate(d[0],d[1]);
        e?e.animate(i):j.graphic=e=c.arc(i).setRadialReference(a.center).attr(u(j.pointAttr[""],{
            "stroke-linejoin":"round"
        })).add(j.group).shadow(g,h);
        j.visible===!1&&j.setVisible(!1)
        })
    },
drawDataLabels:function(){
    var a=this.data,b,c=this.chart,d=this.options.dataLabels,
    e=p(d.connectorPadding,10),f=p(d.connectorWidth,1),g,h,i=p(d.softConnector,!0),j=d.distance,k=this.center,l=k[2]/2,m=k[1],o=j>0,s=[[],[]],y,q,r,t,v=2,z;
    if(d.enabled||this._hasPointLabels){
        W.prototype.drawDataLabels.apply(this);
        n(a,function(a){
            a.dataLabel&&s[a.labelPos[7]<Ia/2?0:1].push(a)
            });
        s[1].reverse();
        t=function(a,b){
            return b.y-a.y
            };
            
        for(a=s[0][0]&&s[0][0].dataLabel&&(s[0][0].dataLabel.getBBox().height||21);v--;){
            var A=[],B=[],x=s[v],u=x.length,w;
            if(j>0){
                for(z=m-l-j;z<=m+l+j;z+=a)A.push(z);
                r=A.length;
                if(u>r){
                    h=[].concat(x);
                    h.sort(t);
                    for(z=u;z--;)h[z].rank=z;
                    for(z=u;z--;)x[z].rank>=r&&x.splice(z,1);
                    u=x.length
                    }
                    for(z=0;z<u;z++){
                    b=x[z];
                    h=b.labelPos;
                    b=9999;
                    for(q=0;q<r;q++)g=V(A[q]-h[1]),g<b&&(b=g,w=q);
                    if(w<z&&A[z]!==null)w=z;else for(r<u-z+w&&A[z]!==null&&(w=r-u+z);A[w]===null;)w++;
                    B.push({
                        i:w,
                        y:A[w]
                        });
                    A[w]=null
                    }
                    B.sort(t)
                }
                for(z=0;z<u;z++){
                b=x[z];
                h=b.labelPos;
                g=b.dataLabel;
                r=b.visible===!1?"hidden":"visible";
                y=h[1];
                if(j>0){
                    if(q=B.pop(),w=q.i,q=q.y,y>q&&A[w+1]!==null||y<q&&A[w-1]!==null)q=y
                        }else q=y;
                y=d.justify?k[0]+(v?-1:1)*(l+j):this.getX(w===0||w===A.length-1?y:q,v);
                g.attr({
                    visibility:r,
                    align:h[6]
                    })[g.moved?"animate":"attr"]({
                    x:y+d.x+({
                        left:e,
                        right:-e
                        }
                        [h[6]]||0),
                    y:q+d.y-10
                    });
                g.moved=!0;
                if(o&&f)g=b.connector,h=i?["M",y+(h[6]==="left"?5:-5),q,"C",y,q,2*h[2]-h[4],2*h[3]-h[5],h[2],h[3],"L",h[4],h[5]]:["M",y+(h[6]==="left"?5:-5),q,"L",h[2],h[3],"L",h[4],h[5]],g?(g.animate({
                    d:h
                }),g.attr("visibility",r)):b.connector=g=this.chart.renderer.path(h).attr({
                    "stroke-width":f,
                    stroke:d.connectorColor||b.color||
                    "#606060",
                    visibility:r,
                    zIndex:3
                }).translate(c.plotLeft,c.plotTop).add()
                    }
                }
        }
},
alignDataLabel:lb,
drawTracker:ea.prototype.drawTracker,
drawLegendSymbol:H.prototype.drawLegendSymbol,
getSymbol:function(){}
};

N=aa(W,N);
R.pie=N;
var T=W.prototype,ec=T.processData,fc=T.generatePoints,gc=T.destroy,hc=T.tooltipHeaderFormatter,ic={
    approximation:"average",
    groupPixelWidth:2,
    dateTimeLabelFormats:ja(cb,["%A, %b %e, %H:%M:%S.%L","%A, %b %e, %H:%M:%S.%L","-%H:%M:%S.%L"],Xa,["%A, %b %e, %H:%M:%S","%A, %b %e, %H:%M:%S",
        "-%H:%M:%S"],Pa,["%A, %b %e, %H:%M","%A, %b %e, %H:%M","-%H:%M"],sa,["%A, %b %e, %H:%M","%A, %b %e, %H:%M","-%H:%M"],fa,["%A, %b %e, %Y","%A, %b %e","-%A, %b %e, %Y"],Ba,["Week from %A, %b %e, %Y","%A, %b %e","-%A, %b %e, %Y"],Ca,["%B %Y","%B","-%B %Y"],na,["%Y","%Y","-%Y"])
    },Wb={
    line:{},
    spline:{},
    area:{},
    areaspline:{},
    column:{
        approximation:"sum",
        groupPixelWidth:10
    },
    arearange:{
        approximation:"range"
    },
    areasplinerange:{
        approximation:"range"
    },
    columnrange:{
        approximation:"range",
        groupPixelWidth:10
    },
    candlestick:{
        approximation:"ohlc",
        groupPixelWidth:10
    },
    ohlc:{
        approximation:"ohlc",
        groupPixelWidth:5
    }
},Xb=[[cb,[1,2,5,10,20,25,50,100,200,500]],[Xa,[1,2,5,10,15,30]],[Pa,[1,2,5,10,15,30]],[sa,[1,2,3,4,6,8,12]],[fa,[1]],[Ba,[1]],[Ca,[1,3,6]],[na,null]],ya={
    sum:function(a){
        var b=a.length,c;
        if(!b&&a.hasNulls)c=null;
        else if(b)for(c=0;b--;)c+=a[b];
        return c
        },
    average:function(a){
        var b=a.length,a=ya.sum(a);
        typeof a==="number"&&b&&(a/=b);
        return a
        },
    open:function(a){
        return a.length?a[0]:a.hasNulls?null:r
        },
    high:function(a){
        return a.length?Ea(a):
        a.hasNulls?null:r
        },
    low:function(a){
        return a.length?Qa(a):a.hasNulls?null:r
        },
    close:function(a){
        return a.length?a[a.length-1]:a.hasNulls?null:r
        },
    ohlc:function(a,b,c,d){
        a=ya.open(a);
        b=ya.high(b);
        c=ya.low(c);
        d=ya.close(d);
        if(typeof a==="number"||typeof b==="number"||typeof c==="number"||typeof d==="number")return[a,b,c,d]
            },
    range:function(a,b){
        a=ya.low(a);
        b=ya.high(b);
        if(typeof a==="number"||typeof b==="number")return[a,b]
            }
        };

T.groupData=function(a,b,c,d){
    var e=this.data,f=this.options.data,g=[],h=[],i=
    a.length,j,k,l=!!b,m=[[],[],[],[]],d=typeof d==="function"?d:ya[d],o=this.pointArrayMap,n=o&&o.length,p;
    for(p=0;p<=i;p++){
        for(;c[1]!==r&&a[p]>=c[1]||p===i;)if(j=c.shift(),k=d.apply(0,m),k!==r&&(g.push(j),h.push(k)),m[0]=[],m[1]=[],m[2]=[],m[3]=[],p===i)break;if(p===i)break;
        if(o){
            j=this.cropStart+p;
            j=e&&e[j]||this.pointClass.prototype.applyOptions.apply({
                series:this
            },[f[j]]);
            var q;
            for(k=0;k<n;k++)if(q=j[o[k]],typeof q==="number")m[k].push(q);
                else if(q===null)m[k].hasNulls=!0
                }else if(j=l?b[p]:null,
            typeof j==="number")m[0].push(j);
        else if(j===null)m[0].hasNulls=!0
            }
            return[g,h]
    };
    
T.processData=function(){
    var a=this.chart,b=this.options,c=b.dataGrouping,d=c&&p(c.enabled,a.options._stock),e;
    this.forceCrop=d;
    if(ec.apply(this,arguments)!==!1&&d){
        this.destroyGroupedData();
        var d=this.processedXData,f=this.processedYData,g=a.plotSizeX,h=this.xAxis,i=p(h.groupPixelWidth,c.groupPixelWidth),j=d.length,k=a.series,l=this.pointRange;
        if(!h.groupPixelWidth){
            for(a=k.length;a--;)k[a].xAxis===h&&k[a].options.dataGrouping&&
                (i=x(i,k[a].options.dataGrouping.groupPixelWidth));
            h.groupPixelWidth=i
            }
            if(j>g/i||j&&c.forced){
            e=!0;
            this.points=null;
            a=h.getExtremes();
            j=a.min;
            k=a.max;
            a=h.getGroupIntervalFactor&&h.getGroupIntervalFactor(j,k,d)||1;
            g=i*(k-j)/g*a;
            h=(h.getNonLinearTimeTicks||db)(Gb(g,c.units||Xb),j,k,null,d,this.closestPointRange);
            f=T.groupData.apply(this,[d,f,h,c.approximation]);
            d=f[0];
            f=f[1];
            if(c.smoothed){
                a=d.length-1;
                for(d[a]=k;a--&&a>0;)d[a]+=g/2;
                d[0]=j
                }
                this.currentDataGrouping=h.info;
            if(b.pointRange===null)this.pointRange=
                h.info.totalRange;
            this.closestPointRange=h.info.totalRange;
            this.processedXData=d;
            this.processedYData=f
            }else this.currentDataGrouping=null,this.pointRange=l;
        this.hasGroupedData=e
        }
    };

T.destroyGroupedData=function(){
    var a=this.groupedData;
    n(a||[],function(b,c){
        b&&(a[c]=b.destroy?b.destroy():null)
        });
    this.groupedData=null
    };
    
T.generatePoints=function(){
    fc.apply(this);
    this.destroyGroupedData();
    this.groupedData=this.hasGroupedData?this.points:null
    };
    
T.tooltipHeaderFormatter=function(a){
    var b=this.tooltipOptions,
    c=this.options.dataGrouping,d=b.xDateFormat,e,f=this.xAxis,g,h;
    if(f&&f.options.type==="datetime"&&c&&za(a)){
        g=this.currentDataGrouping;
        c=c.dateTimeLabelFormats;
        if(g)f=c[g.unitName],g.count===1?d=f[0]:(d=f[1],e=f[2]);
        else if(!d)for(h in C)if(C[h]>=f.closestPointRange){
            d=c[h][0];
            break
        }
        d=va(d,a);
        e&&(d+=va(e,a+g.totalRange-1));
        a=b.headerFormat.replace("{point.key}",d)
        }else a=hc.apply(this,[a]);
    return a
    };
    
T.destroy=function(){
    for(var a=this.groupedData||[],b=a.length;b--;)a[b]&&a[b].destroy();
    gc.apply(this)
    };
rb(T,"setOptions",function(a,b){
    var c=a.call(this,b),d=this.type,e=this.chart.options.plotOptions;
    if(Wb[d]){
        if(!Q[d].dataGrouping)Q[d].dataGrouping=w(ic,Wb[d]);
        c.dataGrouping=w(Q[d].dataGrouping,e.series&&e.series.dataGrouping,e[d].dataGrouping,b.dataGrouping)
        }
        return c
    });
Q.ohlc=w(Q.column,{
    lineWidth:1,
    tooltip:{
        pointFormat:'<span style="color:{series.color};font-weight:bold">{series.name}</span><br/>Open: {point.open}<br/>High: {point.high}<br/>Low: {point.low}<br/>Close: {point.close}<br/>'
    },
    states:{
        hover:{
            lineWidth:3
        }
    },
threshold:null
});
N=aa(xa,{
    applyOptions:function(a){
        var b=this.series,c=b.pointArrayMap,d=0,e=0,f=c.length;
        if(typeof a==="object"&&typeof a.length!=="number")u(this,a),this.options=a;
        else if(a.length){
            if(a.length>f){
                if(typeof a[0]==="string")this.name=a[0];
                else if(typeof a[0]==="number")this.x=a[0];
                d++
            }
            for(;e<f;)this[c[e++]]=a[d++]
                }
                this.y=this[b.pointValKey];
        if(this.x===r&&b)this.x=b.autoIncrement();
        return this
        },
    tooltipFormatter:function(){
        var a=this.series;
        return['<span style="color:'+a.color+';font-weight:bold">',
        this.name||a.name,"</span><br/>Open: ",this.open,"<br/>High: ",this.high,"<br/>Low: ",this.low,"<br/>Close: ",this.close,"<br/>"].join("")
        },
    toYData:function(){
        return[this.open,this.high,this.low,this.close]
        }
    });
N=aa(R.column,{
    type:"ohlc",
    pointArrayMap:["open","high","low","close"],
    pointValKey:"high",
    pointClass:N,
    pointAttrToOptions:{
        stroke:"color",
        "stroke-width":"lineWidth"
    },
    upColorProp:"stroke",
    getAttribs:function(){
        R.column.prototype.getAttribs.apply(this,arguments);
        var a=this.options,b=a.states,
        a=a.upColor||this.color,c=w(this.pointAttr),d=this.upColorProp;
        c[""][d]=a;
        c.hover[d]=b.hover.upColor||a;
        c.select[d]=b.select.upColor||a;
        n(this.points,function(a){
            if(a.open<a.close)a.pointAttr=c
                })
        },
    translate:function(){
        var a=this.yAxis;
        R.column.prototype.translate.apply(this);
        n(this.points,function(b){
            if(b.open!==null)b.plotOpen=a.translate(b.open,0,1,0,1);
            if(b.close!==null)b.plotClose=a.translate(b.close,0,1,0,1)
                })
        },
    drawPoints:function(){
        var a=this,b=a.chart,c,d,e,f,g,h,i,j;
        n(a.points,function(k){
            if(k.plotY!==
                r)i=k.graphic,c=k.pointAttr[k.selected?"selected":""],f=c["stroke-width"]%2/2,j=t(k.plotX)+f,g=t(k.shapeArgs.width/2),h=["M",j,t(k.yBottom),"L",j,t(k.plotY)],k.open!==null&&(d=t(k.plotOpen)+f,h.push("M",j,d,"L",j-g,d)),k.close!==null&&(e=t(k.plotClose)+f,h.push("M",j,e,"L",j+g,e)),i?i.animate({
                d:h
            }):k.graphic=b.renderer.path(h).attr(c).add(a.group)
                })
        },
    animate:null
});
R.ohlc=N;
Q.candlestick=w(Q.column,{
    lineColor:"black",
    lineWidth:1,
    states:{
        hover:{
            lineWidth:2
        }
    },
tooltip:Q.ohlc.tooltip,
threshold:null,
upColor:"white"
});
N=aa(N,{
    type:"candlestick",
    pointAttrToOptions:{
        fill:"color",
        stroke:"lineColor",
        "stroke-width":"lineWidth"
    },
    upColorProp:"fill",
    drawPoints:function(){
        var a=this,b=a.chart,c,d,e,f,g,h,i,j,k,l;
        n(a.points,function(m){
            j=m.graphic;
            if(m.plotY!==r)c=m.pointAttr[m.selected?"selected":""],h=c["stroke-width"]%2/2,i=t(m.plotX)+h,d=t(m.plotOpen)+h,e=t(m.plotClose)+h,f=M.min(d,e),g=M.max(d,e),l=t(m.shapeArgs.width/2),k=["M",i-l,g,"L",i-l,f,"L",i+l,f,"L",i+l,g,"L",i-l,g,"M",i,g,"L",i,t(m.yBottom),
                "M",i,f,"L",i,t(m.plotY),"Z"],j?j.animate({
                    d:k
                }):m.graphic=b.renderer.path(k).attr(c).add(a.group)
                })
        }
    });
R.candlestick=N;
var pb=pa.prototype.symbols;
Q.flags=w(Q.column,{
    dataGrouping:null,
    fillColor:"white",
    lineWidth:1,
    pointRange:0,
    shape:"flag",
    stackDistance:7,
    states:{
        hover:{
            lineColor:"black",
            fillColor:"#FCFFC5"
        }
    },
style:{
    fontSize:"11px",
    fontWeight:"bold",
    textAlign:"center"
},
threshold:null,
y:-30
});
R.flags=aa(R.column,{
    type:"flags",
    sorted:!1,
    noSharedTooltip:!0,
    takeOrdinalPosition:!1,
    forceCrop:!0,
    init:W.prototype.init,
    pointAttrToOptions:{
        fill:"fillColor",
        stroke:"color",
        "stroke-width":"lineWidth",
        r:"radius"
    },
    translate:function(){
        R.column.prototype.translate.apply(this);
        var a=this.chart,b=this.points,c=b.length-1,d,e,f=this.options.onSeries,f=(d=f&&a.get(f))&&d.options.step,g=d&&d.points,h=g&&g.length,i=this.xAxis,j=i.getExtremes(),k,l,m;
        if(d&&d.visible&&h){
            l=g[h-1].x;
            for(b.sort(function(a,b){
                return a.x-b.x
                });h--&&b[c];)if(d=b[c],k=g[h],k.x<=d.x&&k.plotY!==r){
                if(d.x<=l)d.plotY=k.plotY,k.x<d.x&&!f&&(m=g[h+1])&&m.plotY!==
                    r&&(d.plotY+=(d.x-k.x)/(m.x-k.x)*(m.plotY-k.plotY));
                c--;
                h++;
                if(c<0)break
            }
            }
            n(b,function(c,d){
        if(c.plotY===r)c.x>=j.min&&c.x<=j.max?c.plotY=i.lineTop-a.plotTop:c.shapeArgs={};
            
        if((e=b[d-1])&&e.plotX===c.plotX){
            if(e.stackIndex===r)e.stackIndex=0;
            c.stackIndex=e.stackIndex+1
            }
        })
},
drawPoints:function(){
    var a,b=this.points,c=this.chart.renderer,d,e,f=this.options,g=f.y,h=f.shape,i,j,k,l,m=f.lineWidth%2/2,o;
    for(k=b.length;k--;)if(l=b[k],d=l.plotX+m,j=l.stackIndex,e=l.plotY,e!==r&&(e=l.plotY+g+m-(j!==r&&j*f.stackDistance)),
        i=j?r:l.plotX+m,o=j?r:l.plotY,j=l.graphic,a=l.tracker,e!==r)a=l.pointAttr[l.selected?"select":""],j?j.attr({
        x:d,
        y:e,
        r:a.r,
        anchorX:i,
        anchorY:o
    }):j=l.graphic=c.label(l.options.title||f.title||"A",d,e,h,i,o).css(w(f.style,l.style)).attr(a).attr({
        align:h==="flag"?"left":"center",
        width:f.width,
        height:f.height
        }).add(this.group).shadow(f.shadow),i=j.box,j=i.getBBox(),l.shapeArgs=u(j,{
        x:d-(h==="flag"?0:i.attr("width")/2),
        y:e
    });
    else if(j)l.graphic=j.destroy(),a&&a.attr("y",-9999)
        },
drawTracker:function(){
    R.column.prototype.drawTracker.apply(this);
    n(this.points,function(a){
        a.tracker&&D(a.tracker.element,"mouseover",function(){
            a.graphic.toFront()
            })
        })
    },
tooltipFormatter:function(a){
    return a.point.text
    },
animate:function(){}
});
pb.flag=function(a,b,c,d,e){
    var f=e&&e.anchorX||a,e=e&&e.anchorY||b;
    return["M",f,e,"L",a,b+d,a,b,a+c,b,a+c,b+d,a,b+d,"M",f,e,"Z"]
    };
    
n(["circle","square"],function(a){
    pb[a+"pin"]=function(b,c,d,e,f){
        var g=f&&f.anchorX,f=f&&f.anchorY,b=pb[a](b,c,d,e);
        g&&f&&b.push("M",g,c+e,"L",g,f);
        return b
        }
    });
Ua===Ka&&n(["flag","circlepin",
    "squarepin"],function(a){
        Ka.prototype.symbols[a]=pb[a]
        });
var qb=ba?"touchstart":"mousedown",Yb=ba?"touchmove":"mousemove",Zb=ba?"touchend":"mouseup",N=ja("linearGradient",{
    x1:0,
    y1:0,
    x2:0,
    y2:1
},"stops",[[0,"#FFF"],[1,"#CCC"]]),H=[].concat(Xb);
H[4]=[fa,[1,2,3,4]];
H[5]=[Ba,[1,2,3]];
u(P,{
    navigator:{
        handles:{
            backgroundColor:"#FFF",
            borderColor:"#666"
        },
        height:40,
        margin:10,
        maskFill:"rgba(255, 255, 255, 0.75)",
        outlineColor:"#444",
        outlineWidth:1,
        series:{
            type:"areaspline",
            color:"#4572A7",
            compare:null,
            fillOpacity:0.4,
            dataGrouping:{
                approximation:"average",
                groupPixelWidth:2,
                smoothed:!0,
                units:H
            },
            dataLabels:{
                enabled:!1
                },
            id:"highcharts-navigator-series",
            lineColor:"#4572A7",
            lineWidth:1,
            marker:{
                enabled:!1
                },
            pointRange:0,
            shadow:!1
            },
        xAxis:{
            tickWidth:0,
            lineWidth:0,
            gridLineWidth:1,
            tickPixelInterval:200,
            labels:{
                align:"left",
                x:3,
                y:-4
            }
        },
    yAxis:{
        gridLineWidth:0,
        startOnTick:!1,
        endOnTick:!1,
        minPadding:0.1,
        maxPadding:0.1,
        labels:{
            enabled:!1
            },
        title:{
            text:null
        },
        tickWidth:0
    }
},
scrollbar:{
    height:ba?20:14,
    barBackgroundColor:N,
    barBorderRadius:2,
    barBorderWidth:1,
    barBorderColor:"#666",
    buttonArrowColor:"#666",
    buttonBackgroundColor:N,
    buttonBorderColor:"#666",
    buttonBorderRadius:2,
    buttonBorderWidth:1,
    rifleColor:"#666",
    trackBackgroundColor:ja("linearGradient",{
        x1:0,
        y1:0,
        x2:0,
        y2:1
    },"stops",[[0,"#EEE"],[1,"#FFF"]]),
    trackBorderColor:"#CCC",
    trackBorderWidth:1
}
});
Pb.prototype={
    getAxisTop:function(a){
        return this.navigatorOptions.top||a-this.height-this.scrollbarHeight-this.chart.options.chart.spacingBottom
        },
    drawHandle:function(a,b){
        var c=this.chart.renderer,
        d=this.elementsToDestroy,e=this.handles,f=this.navigatorOptions.handles,f={
            fill:f.backgroundColor,
            stroke:f.borderColor,
            "stroke-width":1
        },g;
        this.rendered||(e[b]=c.g().css({
            cursor:"e-resize"
        }).attr({
            zIndex:4-b
            }).add(),g=c.rect(-4.5,0,9,16,3,1).attr(f).add(e[b]),d.push(g),g=c.path(["M",-1.5,4,"L",-1.5,12,"M",0.5,4,"L",0.5,12]).attr(f).add(e[b]),d.push(g));
        e[b].translate(this.scrollerLeft+this.scrollbarHeight+parseInt(a,10),this.top+this.height/2-8)
        },
    drawScrollbarButton:function(a){
        var b=this.chart.renderer,
        c=this.elementsToDestroy,d=this.scrollbarButtons,e=this.scrollbarHeight,f=this.scrollbarOptions,g;
        this.rendered||(d[a]=b.g().add(this.scrollbarGroup),g=b.rect(-0.5,-0.5,e+1,e+1,f.buttonBorderRadius,f.buttonBorderWidth).attr({
            stroke:f.buttonBorderColor,
            "stroke-width":f.buttonBorderWidth,
            fill:f.buttonBackgroundColor
            }).add(d[a]),c.push(g),g=b.path(["M",e/2+(a?-1:1),e/2-3,"L",e/2+(a?-1:1),e/2+3,e/2+(a?2:-2),e/2]).attr({
            fill:f.buttonArrowColor
            }).add(d[a]),c.push(g));
        a&&d[a].attr({
            translateX:this.scrollerWidth-
            e
            })
        },
    render:function(a,b,c,d){
        var e=this.chart,f=e.renderer,g,h,i,j,k=this.scrollbarGroup,l=this.scrollbar,m=this.xAxis,o=this.scrollbarTrack,n=this.scrollbarHeight,y=this.scrollbarEnabled,q=this.navigatorOptions,r=this.scrollbarOptions,v=this.height,w=this.top,z=this.navigatorEnabled,A=q.outlineWidth,B=A/2,u=this.outlineHeight,D=r.barBorderRadius,G=r.barBorderWidth,C=w+B;
        if(!isNaN(a)){
            this.navigatorLeft=g=p(m.left,e.plotLeft+n);
            this.navigatorWidth=h=p(m.len,e.plotWidth-2*n);
            this.scrollerLeft=i=g-
            n;
            this.scrollerWidth=j=j=h+2*n;
            if(m.getExtremes){
                var E=e.xAxis[0].getExtremes(),e=E.dataMin===null,H=m.getExtremes(),J=K(E.dataMin,H.dataMin),E=x(E.dataMax,H.dataMax);
                !e&&(J!==H.min||E!==H.max)&&m.setExtremes(J,E,!0,!1)
                }
                c=p(c,m.translate(a));
            d=p(d,m.translate(b));
            this.zoomedMin=a=x(F(K(c,d)),0);
            this.zoomedMax=d=K(F(x(c,d)),h);
            this.range=c=d-a;
            if(!this.rendered){
                if(z)this.leftShade=f.rect().attr({
                    fill:q.maskFill,
                    zIndex:3
                }).add(),this.rightShade=f.rect().attr({
                    fill:q.maskFill,
                    zIndex:3
                }).add(),this.outline=
                    f.path().attr({
                        "stroke-width":A,
                        stroke:q.outlineColor,
                        zIndex:3
                    }).add();
                if(y)this.scrollbarGroup=k=f.g().add(),l=r.trackBorderWidth,this.scrollbarTrack=o=f.rect().attr({
                    y:-l%2/2,
                    fill:r.trackBackgroundColor,
                    stroke:r.trackBorderColor,
                    "stroke-width":l,
                    r:r.trackBorderRadius||0,
                    height:n
                }).add(k),this.scrollbar=l=f.rect().attr({
                    y:-G%2/2,
                    height:n,
                    fill:r.barBackgroundColor,
                    stroke:r.barBorderColor,
                    "stroke-width":G,
                    r:D
                }).add(k),this.scrollbarRifles=f.path().attr({
                    stroke:r.rifleColor,
                    "stroke-width":1
                }).add(k)
                    }
                    z&&
            (this.leftShade.attr({
                x:g,
                y:w,
                width:a,
                height:v
            }),this.rightShade.attr({
                x:g+d,
                y:w,
                width:h-d,
                height:v
            }),this.outline.attr({
                d:["M",i,C,"L",g+a+B,C,g+a+B,C+u-n,"M",g+d-B,C+u-n,"L",g+d-B,C,i+j,C]
                }),this.drawHandle(a+B,0),this.drawHandle(d+B,1));
            y&&(this.drawScrollbarButton(0),this.drawScrollbarButton(1),k.translate(i,t(C+v)),o.attr({
                width:j
            }),l.attr({
                x:t(n+a)+G%2/2,
                width:c-G
                }),f=n+a+c/2-0.5,this.scrollbarRifles.attr({
                d:["M",f-3,n/4,"L",f-3,2*n/3,"M",f,n/4,"L",f,2*n/3,"M",f+3,n/4,"L",f+3,2*n/3],
                visibility:c>
                12?"visible":"hidden"
                }));
            this.rendered=!0
            }
        },
addEvents:function(){
    var a=this.chart;
    D(a.container,qb,this.mouseDownHandler);
    D(a.container,Yb,this.mouseMoveHandler);
    D(document,Zb,this.mouseUpHandler)
    },
removeEvents:function(){
    var a=this.chart;
    O(a.container,qb,this.mouseDownHandler);
    O(a.container,Yb,this.mouseMoveHandler);
    O(document,Zb,this.mouseUpHandler);
    this.navigatorEnabled&&O(this.baseSeries,"updatedData",this.updatedDataHandler)
    },
init:function(){
    var a=this,b=a.chart,c,d,e=a.scrollbarHeight,f=a.navigatorOptions,
    g=a.height,h=a.top,i,j,k,l=document.body.style,m,o=a.baseSeries,n;
    a.mouseDownHandler=function(d){
        var d=b.tracker.normalizeMouseEvent(d),e=a.zoomedMin,f=a.zoomedMax,h=a.top,i=a.scrollbarHeight,k=a.scrollerLeft,o=a.scrollerWidth,n=a.navigatorLeft,p=a.navigatorWidth,q=a.range,s=d.chartX,r=d.chartY,d=ba?10:7;
        if(r>h&&r<h+g+i)if((h=!a.scrollbarEnabled||r<h+g)&&M.abs(s-e-n)<d)a.grabbedLeft=!0,a.otherHandlePos=f;
            else if(h&&M.abs(s-f-n)<d)a.grabbedRight=!0,a.otherHandlePos=e;
            else if(s>n+e&&s<n+f){
            a.grabbedCenter=
            s;
            if(b.renderer.isSVG)m=l.cursor,l.cursor="ew-resize";
            j=s-e
            }else s>k&&s<k+o&&(f=h?s-n-q/2:s<n?e-K(10,q):s>k+o-i?e+K(10,q):s<n+e?e-q:f,f<0?f=0:f+q>p&&(f=p-q),f!==e&&b.xAxis[0].setExtremes(c.translate(f,!0),c.translate(f+q,!0),!0,!1,{
            trigger:"navigator"
        }))
        };
        
    a.mouseMoveHandler=function(c){
        var d=a.scrollbarHeight,e=a.navigatorLeft,f=a.navigatorWidth,g=a.scrollerLeft,h=a.scrollerWidth,i=a.range,c=b.tracker.normalizeMouseEvent(c),c=c.chartX;
        c<e?c=e:c>g+h-d&&(c=g+h-d);
        a.grabbedLeft?(k=!0,a.render(0,0,c-
            e,a.otherHandlePos)):a.grabbedRight?(k=!0,a.render(0,0,a.otherHandlePos,c-e)):a.grabbedCenter&&(k=!0,c<j?c=j:c>f+j-i&&(c=f+j-i),a.render(0,0,c-j,c-j+i))
        };
        
    a.mouseUpHandler=function(){
        var d=a.zoomedMin,e=a.zoomedMax;
        k&&b.xAxis[0].setExtremes(c.translate(d,!0),c.translate(e,!0),!0,!1,{
            trigger:"navigator"
        });
        a.grabbedLeft=a.grabbedRight=a.grabbedCenter=k=j=null;
        l.cursor=m||""
        };
        
    a.updatedDataHandler=function(){
        var c=o.xAxis,d=c.getExtremes(),e=d.min,f=d.max,g=d.dataMin,d=d.dataMax,h=f-e,j,k,l,m,p;
        j=i.xData;
        var q=!!c.setExtremes;
        k=f>=j[j.length-1];
        j=e<=g;
        if(!n)i.options.pointStart=o.xData[0],i.setData(o.options.data,!1),p=!0;
        j&&(m=g,l=m+h);
        k&&(l=d,j||(m=x(l-h,i.xData[0])));
        q&&(j||k)?c.setExtremes(m,l,!0,!1,{
            trigger:"updatedData"
        }):(p&&b.redraw(!1),a.render(x(e,g),K(f,d)))
        };
        
    var p=b.xAxis.length,q=b.yAxis.length,r=b.setSize;
    b.extraBottomMargin=a.outlineHeight+f.margin;
    a.top=h=a.getAxisTop(b.chartHeight);
    if(a.navigatorEnabled){
        var t=o?o.options:{},v=t.data,u=f.series;
        n=u.data;
        t.data=u.data=null;
        a.xAxis=
        c=new Sa(b,w({
            ordinal:o&&o.xAxis.options.ordinal
            },f.xAxis,{
            isX:!0,
            type:"datetime",
            index:p,
            height:g,
            top:h,
            offset:0,
            offsetLeft:e,
            offsetRight:-e,
            startOnTick:!1,
            endOnTick:!1,
            minPadding:0,
            maxPadding:0,
            zoomEnabled:!1
            }));
        a.yAxis=d=new Sa(b,w(f.yAxis,{
            alignTicks:!1,
            height:g,
            top:h,
            offset:0,
            index:q,
            zoomEnabled:!1
            }));
        p=w(t,u,{
            threshold:null,
            clip:!1,
            enableMouseTracking:!1,
            group:"nav",
            padXAxis:!1,
            xAxis:p,
            yAxis:q,
            name:"Navigator",
            showInLegend:!1,
            isInternal:!0,
            visible:!0
            });
        t.data=v;
        u.data=n;
        p.data=n||v;
        i=b.initSeries(p);
        f.adaptToUpdatedData!==!1&&D(o,"updatedData",a.updatedDataHandler)
        }else a.xAxis=c={
        translate:function(a,c){
            var d=b.xAxis[0].getExtremes(),f=b.plotWidth-2*e,g=d.dataMin,d=d.dataMax-g;
            return c?a*d/f+g:f*(a-g)/d
            }
        };
    
a.series=i;
b.setSize=function(e,f,g){
    a.top=h=a.getAxisTop(f);
    if(c&&d)c.options.top=d.options.top=h;
    r.call(b,e,f,g)
    };
    
a.addEvents()
},
destroy:function(){
    this.removeEvents();
    n([this.xAxis,this.yAxis,this.leftShade,this.rightShade,this.outline,this.scrollbarTrack,this.scrollbarRifles,this.scrollbarGroup,
        this.scrollbar],function(a){
            a&&a.destroy&&a.destroy()
            });
    this.xAxis=this.yAxis=this.leftShade=this.rightShade=this.outline=this.scrollbarTrack=this.scrollbarRifles=this.scrollbarGroup=this.scrollbar=null;
    n([this.scrollbarButtons,this.handles,this.elementsToDestroy],function(a){
        ta(a)
        })
    }
};

Highcharts.Scroller=Pb;
rb(Sa.prototype,"zoom",function(a,b,c){
    var d=this.chart,e=d.options,f=e.chart.zoomType,g=e.navigator,e=e.rangeSelector,h;
    if(this.isXAxis&&(g&&g.enabled||e&&e.enabled))if(f==="x")d.resetZoomButton=
        "blocked";
    else if(f==="y")h=!1;
        else if(f==="xy")d=this.previousZoom,v(b)?this.previousZoom=[this.min,this.max]:d&&(b=d[0],c=d[1],delete this.previousZoom);
    return h!==r?h:a.call(this,b,c)
    });
u(P,{
    rangeSelector:{
        buttonTheme:{
            width:28,
            height:16,
            padding:1,
            r:0,
            zIndex:7
        }
    }
});
P.lang=w(P.lang,{
    rangeSelectorZoom:"Zoom",
    rangeSelectorFrom:"From:",
    rangeSelectorTo:"To:"
});
Qb.prototype={
    clickButton:function(a,b,c){
        var d=this,e=d.chart,f=d.buttons,g=e.xAxis[0],h=g&&g.getExtremes(),i=e.scroller&&e.scroller.xAxis,j=
        i&&i.getExtremes&&i.getExtremes(),i=j&&j.dataMin,j=j&&j.dataMax,k=h&&h.dataMin,l=h&&h.dataMax,i=(v(k)&&v(i)?K:p)(k,i),j=(v(l)&&v(j)?x:p)(l,j),m,o=g&&K(h.max,j),h=new Date(o),l=b.type,k=b.count,n,r,q={
            millisecond:1,
            second:1E3,
            minute:6E4,
            hour:36E5,
            day:864E5,
            week:6048E5
        };
        
        if(!(i===null||j===null||a===d.selected))q[l]?(n=q[l]*k,m=x(o-n,i)):l==="month"?(h.setMonth(h.getMonth()-k),m=x(h.getTime(),i),n=2592E6*k):l==="ytd"?(h=new Date(0),l=new Date(j),r=l.getFullYear(),h.setFullYear(r),String(r)!==va("%Y",
            h)&&h.setFullYear(r-1),m=r=x(i||0,h.getTime()),l=l.getTime(),o=K(j||l,l)):l==="year"?(h.setFullYear(h.getFullYear()-k),m=x(i,h.getTime()),n=31536E6*k):l==="all"&&g&&(m=i,o=j),f[a]&&f[a].setState(2),g?setTimeout(function(){
            g.setExtremes(m,o,p(c,1),0,{
                trigger:"rangeSelectorButton",
                rangeSelectorButton:b
            });
            d.selected=a
            },1):(e=e.options.xAxis,e[0]=w(e[0],{
            range:n,
            min:r
        }),d.selected=a)
        },
    init:function(a){
        var b=this,c=b.chart,d=c.options.rangeSelector,a=d.buttons||a,e=b.buttons,f=b.leftBox,g=b.rightBox,d=
        d.selected;
        c.extraTopMargin=25;
        b.buttonOptions=a;
        b.mouseDownHandler=function(){
            f&&f.blur();
            g&&g.blur()
            };
            
        D(c.container,qb,b.mouseDownHandler);
        d!==r&&a[d]&&this.clickButton(d,a[d],!1);
        D(c,"load",function(){
            D(c.xAxis[0],"afterSetExtremes",function(){
                e[b.selected]&&!c.renderer.forExport&&e[b.selected].setState(0);
                b.selected=null
                })
            })
        },
    setInputValue:function(a,b){
        var c=this.chart.options.rangeSelector,c=a.hasFocus?c.inputEditDateFormat||"%Y-%m-%d":c.inputDateFormat||"%b %e, %Y";
        if(b)a.HCTime=b;
        a.value=
        va(c,a.HCTime)
        },
    drawInput:function(a){
        var b=this,c=b.chart,d=c.options.rangeSelector,e=b.div,f=a==="min",g;
        b.boxSpanElements[a]=U("span",{
            innerHTML:P.lang[f?"rangeSelectorFrom":"rangeSelectorTo"]
            },d.labelStyle,e);
        g=U("input",{
            name:a,
            className:"highcharts-range-selector",
            type:"text"
        },u({
            width:"80px",
            height:"16px",
            border:"1px solid silver",
            marginLeft:"5px",
            marginRight:f?"5px":"0",
            textAlign:"center"
        },d.inputStyle),e);
        g.onfocus=g.onblur=function(a){
            a=a||window.event||{};
            
            g.hasFocus=a.type==="focus";
            b.setInputValue(g)
            };
        g.onchange=function(){
            var a=g.value,d=Date.parse(a),e=c.xAxis[0].getExtremes();
            isNaN(d)&&(d=a.split("-"),d=Date.UTC(F(d[0]),F(d[1])-1,F(d[2])));
            if(!isNaN(d)&&(f&&d>=e.dataMin&&d<=b.rightBox.HCTime||!f&&d<=e.dataMax&&d>=b.leftBox.HCTime))c.xAxis[0].setExtremes(f?d:e.min,f?e.max:d,r,r,{
                trigger:"rangeSelectorInput"
            })
            };
            
        return g
        },
    render:function(a,b){
        var c=this,d=c.chart,e=d.renderer,f=d.container,g=d.options.rangeSelector,h=c.buttons,i=P.lang,j=c.div,j=d.options.chart.style,k=g.buttonTheme,l=g.inputEnabled!==
        !1,m=k&&k.states,o=d.plotLeft,p;
        if(!c.rendered&&(c.zoomText=e.text(i.rangeSelectorZoom,o,d.plotTop-10).css(g.labelStyle).add(),p=o+c.zoomText.getBBox().width+5,n(c.buttonOptions,function(a,b){
            h[b]=e.button(a.text,p,d.plotTop-25,function(){
                c.clickButton(b,a);
                c.isActive=!0
                },k,m&&m.hover,m&&m.select).css({
                textAlign:"center"
            }).add();
            p+=h[b].width+(g.buttonSpacing||0);
            c.selected===b&&h[b].setState(2)
            }),l))c.divRelative=j=U("div",null,{
            position:"relative",
            height:0,
            fontFamily:j.fontFamily,
            fontSize:j.fontSize,
            zIndex:1
        }),f.parentNode.insertBefore(j,f),c.divAbsolute=c.div=j=U("div",null,u({
            position:"absolute",
            top:d.plotTop-25+"px",
            right:d.chartWidth-d.plotLeft-d.plotWidth+"px"
            },g.inputBoxStyle),j),c.leftBox=c.drawInput("min"),c.rightBox=c.drawInput("max");
        l&&(c.setInputValue(c.leftBox,a),c.setInputValue(c.rightBox,b));
        c.rendered=!0
        },
    destroy:function(){
        var a=this.leftBox,b=this.rightBox,c=this.boxSpanElements,d=this.divRelative,e=this.divAbsolute,f=this.zoomText;
        O(this.chart.container,qb,this.mouseDownHandler);
        n([this.buttons],function(a){
            ta(a)
            });
        if(f)this.zoomText=f.destroy();
        if(a)a.onfocus=a.onblur=a.onchange=null;
        if(b)b.onfocus=b.onblur=b.onchange=null;
        n([a,b,c.min,c.max,e,d],function(a){
            Ra(a)
            });
        this.leftBox=this.rightBox=this.boxSpanElements=this.div=this.divAbsolute=this.divRelative=null
        }
    };

Highcharts.RangeSelector=Qb;
$a.prototype.callbacks.push(function(a){
    function b(){
        f=a.xAxis[0].getExtremes();
        g.render(x(f.min,f.dataMin),K(f.max,f.dataMax))
        }
        function c(){
        f=a.xAxis[0].getExtremes();
        h.render(f.min,
            f.max)
        }
        function d(a){
        g.render(a.min,a.max)
        }
        function e(a){
        h.render(a.min,a.max)
        }
        var f,g=a.scroller,h=a.rangeSelector;
    g&&(D(a.xAxis[0],"afterSetExtremes",d),D(a,"resize",b),b());
    h&&(D(a.xAxis[0],"afterSetExtremes",e),D(a,"resize",c),c());
    D(a,"destroy",function(){
        g&&(O(a,"resize",b),O(a.xAxis[0],"afterSetExtremes",d));
        h&&(O(a,"resize",c),O(a.xAxis[0],"afterSetExtremes",e))
        })
    });
Highcharts.StockChart=function(a,b){
    var c=a.series,d,e={
        marker:{
            enabled:!1,
            states:{
                hover:{
                    radius:5
                }
            }
        },
shadow:!1,
states:{
    hover:{
        lineWidth:2
    }
}
},
f={
    shadow:!1,
    borderWidth:0
};

a.xAxis=Ja(la(a.xAxis||{}),function(a){
    return w({
        minPadding:0,
        maxPadding:0,
        ordinal:!0,
        title:{
            text:null
        },
        labels:{
            overflow:"justify"
        },
        showLastLabel:!0
        },a,{
        type:"datetime",
        categories:null
    })
    });
a.yAxis=Ja(la(a.yAxis||{}),function(a){
    d=a.opposite;
    return w({
        labels:{
            align:d?"right":"left",
            x:d?-2:2,
            y:-2
        },
        showLastLabel:!1,
        title:{
            text:null
        }
    },a)
});
a.series=null;
a=w({
    chart:{
        panning:!0
        },
    navigator:{
        enabled:!0
        },
    scrollbar:{
        enabled:!0
        },
    rangeSelector:{
        enabled:!0
        },
    title:{
        text:null
    },
    tooltip:{
        shared:!0,
        crosshairs:!0
        },
    legend:{
        enabled:!1
        },
    plotOptions:{
        line:e,
        spline:e,
        area:e,
        areaspline:e,
        arearange:e,
        areasplinerange:e,
        column:f,
        columnrange:f,
        candlestick:f,
        ohlc:f
    }
},a,{
    _stock:!0,
    chart:{
        inverted:!1
        }
    });
a.series=c;
return new $a(a,b)
};

var jc=T.init,kc=T.processData,lc=xa.prototype.tooltipFormatter;
T.init=function(){
    jc.apply(this,arguments);
    var a=this.options.compare;
    if(a)this.modifyValue=function(b,c){
        var d=this.compareValue,b=a==="value"?b-d:b=100*(b/d)-100;
        if(c)c.change=b;
        return b
        }
    };
    
T.processData=function(){
    kc.apply(this,
        arguments);
    if(this.options.compare)for(var a=0,b=this.processedXData,c=this.processedYData,d=c.length,e=this.xAxis.getExtremes().min;a<d;a++)if(typeof c[a]==="number"&&b[a]>=e){
        this.compareValue=c[a];
        break
    }
    };
    
xa.prototype.tooltipFormatter=function(a){
    a=a.replace("{point.change}",(this.change>0?"+":"")+Oa(this.change,this.series.tooltipOptions.changeDecimals||2));
    return lc.apply(this,[a])
    };
(function(){
    var a=T.init,b=T.getSegments;
    T.init=function(){
        var b,d;
        a.apply(this,arguments);
        b=this.chart;
        (d=this.xAxis)&&
        d.options.ordinal&&D(this,"updatedData",function(){
            delete d.ordinalIndex
            });
        if(d&&d.options.ordinal&&!d.hasOrdinalExtension){
            d.hasOrdinalExtension=!0;
            d.beforeSetTickPositions=function(){
                var a,b=[],c=!1,e,j=this.getExtremes(),k=j.min,j=j.max,l;
                if(this.options.ordinal){
                    n(this.series,function(c,d){
                        if(c.visible!==!1&&c.takeOrdinalPosition!==!1&&(b=b.concat(c.processedXData),a=b.length,d&&a)){
                            b.sort(function(a,b){
                                return a-b
                                });
                            for(d=a-1;d--;)b[d]===b[d+1]&&b.splice(d,1)
                                }
                            });
                a=b.length;
                if(a>2){
                    e=b[1]-b[0];
                    for(l=a-1;l--&&!c;)b[l+1]-b[l]!==e&&(c=!0)
                        }
                        c?(this.ordinalPositions=b,c=d.val2lin(k,!0),e=d.val2lin(j,!0),this.ordinalSlope=j=(j-k)/(e-c),this.ordinalOffset=k-c*j):this.ordinalPositions=this.ordinalSlope=this.ordinalOffset=r
                }
            };
        
    d.val2lin=function(a,b){
        var c=this.ordinalPositions;
        if(c){
            var d=c.length,e,k;
            for(e=d;e--;)if(c[e]===a){
                k=e;
                break
            }
            for(e=d-1;e--;)if(a>c[e]||e===0){
                c=(a-c[e])/(c[e+1]-c[e]);
                k=e+c;
                break
            }
            return b?k:this.ordinalSlope*(k||0)+this.ordinalOffset
            }else return a
            };
            
    d.lin2val=function(a,
        b){
        var c=this.ordinalPositions;
        if(c){
            var d=this.ordinalSlope,e=this.ordinalOffset,k=c.length-1,l,m;
            if(b)a<0?a=c[0]:a>k?a=c[k]:(k=Y(a),m=a-k);else for(;k--;)if(l=d*k+e,a>=l){
                d=d*(k+1)+e;
                m=(a-l)/(d-l);
                break
            }
            return m!==r&&c[k]!==r?c[k]+(m?m*(c[k+1]-c[k]):0):a
            }else return a
            };
            
    d.getExtendedPositions=function(){
        var a=d.series[0].currentDataGrouping,e=d.ordinalIndex,h=a?a.count+a.unitName:"raw",i=d.getExtremes(),j,k;
        if(!e)e=d.ordinalIndex={};
            
        if(!e[h])j={
            series:[],
            getExtremes:function(){
                return{
                    min:i.dataMin,
                    max:i.dataMax
                    }
                },
        options:{
            ordinal:!0
            }
        },n(d.series,function(d){
        k={
            xAxis:j,
            xData:d.xData,
            chart:b,
            destroyGroupedData:lb
        };
        
        k.options={
            dataGrouping:a?{
                enabled:!0,
                forced:!0,
                approximation:"open",
                units:[[a.unitName,[a.count]]]
                }:{
                enabled:!1
                }
            };
        
    d.processData.apply(k);
        j.series.push(k)
        }),d.beforeSetTickPositions.apply(j),e[h]=j.ordinalPositions;
return e[h]
};

d.getGroupIntervalFactor=function(a,b,c){
    for(var d=0,e=c.length,k=[];d<e-1;d++)k[d]=c[d+1]-c[d];
    k.sort(function(a,b){
        return a-b
        });
    c=k[Y(e/2)];
    return e*c/(b-
        a)
    };
    
d.postProcessTickInterval=function(a){
    var b=this.ordinalSlope;
    return b?a/(b/d.closestPointRange):a
    };
    
d.getNonLinearTimeTicks=function(a,b,c,e,j,k,l){
    var m=0,n=0,p,t={},q,w,x,u=[],z=d.options.tickPixelInterval;
    if(!j||b===r)return db(a,b,c,e);
    for(w=j.length;n<w;n++){
        x=n&&j[n-1]>c;
        j[n]<b&&(m=n);
        if(n===w-1||j[n+1]-j[n]>k*5||x)p=db(a,j[m],j[n],e),u=u.concat(p),m=n+1;
        if(x)break
    }
    a=p.info;
    if(l&&a.unitRange<=C[sa]){
        n=u.length-1;
        for(m=1;m<n;m++)(new Date(u[m]))[Da]()!==(new Date(u[m-1]))[Da]()&&(t[u[m]]=
            fa,q=!0);
        q&&(t[u[0]]=fa);
        a.higherRanks=t
        }
        u.info=a;
    if(l&&v(z)){
        var l=a=u.length,n=[],A;
        for(q=[];l--;)m=d.translate(u[l]),A&&(q[l]=A-m),n[l]=A=m;
        q.sort();
        q=q[Y(q.length/2)];
        q<z*0.6&&(q=null);
        l=u[a-1]>c?a-1:a;
        for(A=void 0;l--;)m=n[l],c=A-m,A&&c<z*0.8&&(q===null||c<q*0.8)?(t[u[l]]&&!t[u[l+1]]?(c=l+1,A=m):c=l,u.splice(c,1)):A=m
            }
            return u
    };
    
var e=b.pan;
b.pan=function(a){
    var d=b.xAxis[0],h=!1;
    if(d.options.ordinal&&d.series.length){
        var i=b.mouseDownX,j=d.getExtremes(),k=j.dataMax,l=j.min,m=j.max,o;
        o=b.hoverPoints;
        var p=d.closestPointRange,i=(i-a)/(d.translationSlope*(d.ordinalSlope||p)),r={
            ordinalPositions:d.getExtendedPositions()
            },q,p=d.lin2val,t=d.val2lin;
        if(r.ordinalPositions){
            if(V(i)>1)o&&n(o,function(a){
                a.setState()
                }),i<0?(o=r,r=d.ordinalPositions?d:r):o=d.ordinalPositions?d:r,q=r.ordinalPositions,k>q[q.length-1]&&q.push(k),o=p.apply(o,[t.apply(o,[l,!0])+i,!0]),i=p.apply(r,[t.apply(r,[m,!0])+i,!0]),o>K(j.dataMin,l)&&i<x(k,m)&&d.setExtremes(o,i,!0,!1,{
                trigger:"pan"
            }),b.mouseDownX=a,L(b.container,{
                cursor:"move"
            })
            }else h=
            !0
            }else h=!0;
    h&&e.apply(b,arguments)
    }
}
};

T.getSegments=function(){
    var a=this,d,e=a.options.gapSize;
    b.apply(a);
    if(e)d=a.segments,n(d,function(b,g){
        for(var h=b.length-1;h--;)b[h+1].x-b[h].x>a.xAxis.closestPointRange*e&&d.splice(g+1,0,b.splice(h+1,b.length-h))
            })
    }
    })();
u(Highcharts,{
    Axis:Sa,
    CanVGRenderer:ob,
    Chart:$a,
    Color:wa,
    Legend:Ab,
    MouseTracker:zb,
    Point:xa,
    Tick:Za,
    Tooltip:yb,
    Renderer:Ua,
    Series:W,
    SVGRenderer:pa,
    VMLRenderer:Ka,
    dateFormat:va,
    pathAnim:Db,
    getOptions:function(){
        return P
        },
    hasBidiBug:$b,
    numberFormat:Oa,
    seriesTypes:R,
    setOptions:function(a){
        P=w(P,a);
        Nb();
        return P
        },
    addEvent:D,
    removeEvent:O,
    createElement:U,
    discardElement:Ra,
    css:L,
    each:n,
    extend:u,
    map:Ja,
    merge:w,
    pick:p,
    splat:la,
    extendClass:aa,
    pInt:F,
    wrap:rb,
    svg:ia,
    canvas:ca,
    vml:!ia&&!ca,
    product:"Highstock",
    version:"1.2.4"
})
})();
