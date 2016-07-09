@extends('layout.default')

@section('styles')
{{HTML::style('css/visualization.css')}}
@stop

@section('content')
<div class="content-sec">
    <div class="breadcrumbs">
        <ul>
            <li><a href="dashboard" title=""><i class="fa fa-home"></i></a>/</li>
            <li><a title="">Visualization</a></li>
        </ul>
    </div><!-- breadcrumbs -->
    <div class="container">
        <div class="row">


            <div class="col-xs-2">
                Group By:
                <select class="form-control" name="group" id="group">
                    <option value="activity">Activity</option>
                    <option value="page_title">Page Title</option>
                    <option value="page">Page URL</option>
                    <option value="location">Country</option>
                    <option value="provider">Serving Agent</option>
                    <option value="browser">Browser</option>
                    <option value="search_engine">Search Engine</option>
                    <option value="search_term">Search Term</option>
                </select>
            </div>
            <!--<input type="button" id="check" value="Check" style="float:left;" />-->


        </div>

        <div id="chart"></div>



    </div>
</div>
@stop
@section('scripts')
{{HTML::script('js/jsonp.js')}}
{{HTML::script('js/underscore.min.js')}}

<script>
    var group = size = color = '';

    var colors = {
        activity: {
            active: 'green',
            inactive: 'orange',
            out: 'red',
        },
        volumeCategory: {
            Top: 'mediumorchid',
            Middle: 'cornflowerblue',
            Bottom: 'gold'
        },
        lastPriceCategory: {
            Top: 'aqua',
            Middle: 'chartreuse',
            Bottom: 'crimson'
        },
        standardDeviationCategory: {
            Top: 'slateblue',
            Middle: 'darkolivegreen',
            Bottom: 'orangered'
        },
        default: '#4CC1E9'
    };
    start('active');
    var width, height, fill, data, force, tick, svg, nodes, maxRadius, padding, nodes;

    function  getCenters(vname, size) {
        var centers, map;
        data.sort(compare);
        //console.log(data);
        centers = _.uniq(_.pluck(data, vname)).map(function (d) {
            return {name: d, value: 1};
        });
        centers.sort(compare);

        map = d3.layout.treemap().size(size).ratio(1 / 1);
        map.nodes({children: centers});
        
        return centers;
    }
    ;

    function compare(a, b) {
        if (a.name < b.name)
            return -1;
        if (a.name > b.name)
            return 1;
        return 0;
    }

    function labels(centers) {
        svg.selectAll(".label").remove();

        svg.selectAll(".label")
                .data(centers).enter().append("text")
                .attr("class", "label")
                .text(function (d) {
                    return d.name
                })
                .attr("transform", function (d) {
                    return "translate(" + (d.x + (d.dx / 2)) + ", " + (d.y + 20) + ")";
                });
    }
    
    function draw(varname) {
        //console.log(varname);
        var centers = getCenters(varname, [width, height]);
        //console.log(centers);

        force.on("tick", tick(centers, varname));
        labels(centers)
        //force.chargeDistance([2])
        force.start();
    }


    function changeColor(val) {
        d3.selectAll("circle")
                .transition()
                .style('fill', function (d) {
                    return val ? colors[val][d[val]] : colors['default']
                })
                .duration(1000);

        $('.colors').empty();
        if (val) {
            for (var label in colors[val]) {
                $('.colors').append('<div class="col-xs-1 color-legend" style="background:' + colors[val][label] + ';">' + label + '</div>')
            }
        }
    }

    function collide(alpha) {
        var quadtree = d3.geom.quadtree(data);
        return function (d) {
            var r = d.radius + maxRadius + padding,
                    nx1 = d.x - r,
                    nx2 = d.x + r,
                    ny1 = d.y - r,
                    ny2 = d.y + r;
//                    nx1 = d.x,
//                    nx2 = d.x,
//                    ny1 = d.y,
//                    ny2 = d.y;
            quadtree.visit(function (quad, x1, y1, x2, y2) {
                if (quad.point && (quad.point !== d)) {
                    var x = d.x - quad.point.x,
                            y = d.y - quad.point.y,
                            l = Math.sqrt(x * x + y * y),
                            r = d.radius + quad.point.radius + padding;
//                    r = 45;
                    if (l < r) {
                        l = (l - r) / l * alpha;
                        d.x -= x *= l;
                        d.y -= y *= l;
//                        d.x -= x;
//                        d.y -= y;
                        quad.point.x += x;
                        quad.point.y += y;
                    }
                }
                return x1 > nx2 || x2 < nx1 || y1 > ny2 || y2 < ny1;
            });
        };
    }

    function tick(centers, varname) {

        var foci = {};
        for (var i = 0; i < centers.length; i++) {
            foci[centers[i].name] = centers[i];
        }
        //console.log(foci);
        //console.debug(nodes);
        //console.debug(typeof nodes[0][1]);
        //console.debug(nodes[0][1]);
        return function (e) {
            for (var i = 0; i < data.length; i++) {
                var o = data[i];
                //console.log(o);
                var f = foci[o[varname]];
                //console.log(f);//return false;
                o.y += ((f.y + (f.dy / 2)) - o.y) * e.alpha;
                //console.log("o.y: "+o.y);
                o.x += ((f.x + (f.dx / 2)) - o.x) * e.alpha;
                //console.log("o.x: "+o.x);//return false;
            }
            nodes.each(collide(.11)) 
                    .attr("cx", function (d) { //console.debug(111);
                        return d.x;
                    })
                    .attr("cy", function (d) {
                        return d.y;
                    });     
        }

    }

    function showPopover(d) { //console.debug(d); return false;

        $(this).popover({
            placement: 'auto top',
            container: 'body',
            trigger: 'manual',
            html: true,
            content: function () {
                return "ip: " + d.ip + "<br />" +
                        "Activity: " + d.activity + "<br />" +
                        "Date In: " + d.date_in + "<br />" +
                        "Date Out: " + d.date_out + "<br />" +
                        "Location: " + d.location + ", " + d.timezone + "<br />" +
                        "Provider: " + d.provider + "<br />" +
                        "Device: " + d.device_type + ", " + d.device_brand + ", " + d.device_model + "<br />" +
                        "OS: " + d.os + "<br />" +
                        "Browser: " + d.browser + "<br />" +
                        "Page: " + d.page;
            }
        });
        $(this).popover('show')
    }

    function removePopovers() {
        $('.popover').each(function () {
            $(this).remove();
        });
    }
    
    function nodes_f() {
        
        
        //console.log(data);
        nodes = svg.selectAll("circle")
                    .data(data);
            //console.log(nodes);return false;

        nodes.enter().append("circle")
                .attr("id", function (d) {
                    return d.ip;
                })
                .attr("class", "node")
                .attr("cx", function (d) { //console.debug(d);
                    return d.x;
                })
                .attr("cy", function (d) {
                    return d.x;
                })
                .attr("r", function (d) {
                    return d.radius;
                })
                .style("fill", function (d, i) {
                    var circle_act = d.activity;
                    return colors.activity[circle_act];
                })
                .on("mouseover", function (d) {
                    showPopover.call(this, d);
                })
                .on("mouseout", function (d) {
                    removePopovers();
                });
    }
    
    var old_data_cirlcles = "";

    function new_data() {
        var group_term = $('#group').val();
        //alert(group_term);
        if(old_data_cirlcles != "") {
            clearInterval(old_data_cirlcles);
        } else {
            console.log('undef');
        }

        $.ajax({
            'async': false,
            'global': false,
            'url': "{{ URL::asset('data_ip_4.json')}}",
            'dataType': "json",
            //"jsonpCallback": "data",
            'success': function (data1) {
                //create(data1.results);

                data1 = getDataMapping(data1.results, size);
                //console.log(data1);//return false;

                for (var i = 0; i < data.length; i++) {
                    var ip = data[i].ip;
                    //console.log(ip);
                    var k = 0;
                    for (var j = 0; j < data1.length; j++) {
                        if (data1[j].ip == ip) {
                            //var ip = data[i].ip;
                            //console.log(data1[j].ip);
                            var group_new_item = data1[j][group_term];
                            data[i][group_term] = group_new_item;
                            //data[i] = data[1][j];
                            if (group_term == "activity") {
                                $('#' + ip).css('fill', colors[group_term][group_new_item]);
                            }
                            k++;
                            //console.log(ip);
                        }
                    }
                    //console.log(k);
                    if (k == 0) {
                        //console.log(ip);
                        $('#' + ip).remove();
                        data.splice(i, 1);
                    }
                }
                for (var z = 0; z < data1.length; z++) {
                    var nip = data1[z].ip;
                    var n = 0;
                    for (var t = 0; t < data.length; t++) {
                        if (data[t].ip == nip) {
                            n++;
                        }
                    }
                    if (n == 0) {
                        //console.log(data1[z]);
                        //var new_item_activity = data1[z].activity;
                        data1[z].x = 800;
                        data1[z].y = 50;
                        //var new_item = data1[z];
                        //console.log('data1z',data1[z]);
                        //data[data.length] = data1[z];
                        data.push(data1[z]);
                        //console.log(data);
                    }
                }
                nodes = "";
                svg.html("");
                nodes_f();
                //console.log(data1[1][group_term]);
                //console.log("data");
                //console.log(data);
                draw(group_term);
                console.log("group_term: "+group_term);
                old_data_cirlcles = setInterval(function(){  console.log(111);draw(group_term); }, 1000);
                //draw(group_term);

            }
        });
    }
    
    
    var default_circles = "";

//    $('#check').click(function () {
//        
//        if(default_circles != "") {
//            clearInterval(default_circles);
//        } else {
//            console.log('undef2');
//        }
//        new_data();
////        setInterval(function(){ console.log(222); new_data(); }, 5000);
//        default_circles = setInterval(function() {
////            if(old_data_cirlcles != "") {
////                clearInterval(old_data_cirlcles);
////            } else {
////                console.log('undef');
////            }
//            console.log(222);
//            new_data(); }, 5000);
//
//    });
    
    $('#group').change(function () {
            //draw(group);
            new_data();
//            if(old_data_cirlcles != "") {
//                clearInterval(old_data_cirlcles);
//            } else {
//                console.log('undef');
//            }
//            if(default_circles != "") {
//                clearInterval(default_circles);
//            } else {
//                console.log('undef2');
//            }
//            default_circles = setInterval(function() {
//            
//            console.log(333);
//            new_data(); }, 5000);
        });

    function start(type) {
        $.ajax({
            'async': false,
            'global': false,
            'url': "{{ URL::asset('data_ip.json')}}",
            'dataType': "json",
            //"jsonpCallback": "data",
            'success': function (data) {
                //console.log(window.colors);
                create(data.results);
            }
        });
    }

    function getDataMapping(data, vname) {
        var max = d3.max(_.pluck(data, vname));
        //console.log(data.length);//return false;
        //test_data = [];
        for (var j = 0; j < data.length; j++) { //console.debug(Math.random());
            data[j].radius = (vname != '') ? radius * (data[j][vname] / max) : 15;
            data[j].x = data[j].x ? data[j].x : Math.random() * width;//console.debug("x: "+data[j].x+"ip: "+data[j].ip);
            data[j].y = data[j].y ? data[j].y : Math.random() * height;//console.debug("y: "+data[j].y);
            data[j].volumeCategory = getCategory('volume', data[j]);
            data[j].lastPriceCategory = getCategory('lastPrice', data[j]);
            data[j].standardDeviationCategory = getCategory('standardDeviation', data[j]);
            //test_data[j] = data[j].standardDeviationCategory;
        }
//console.log("test-data: "+test_data);
        return data;
    }

    function getCategory(type, d) {
        var max = d3.max(_.pluck(data, type));
        var val = d[type] / max;

        if (val > 0.4)
            return 'Top';
        else if (val > 0.1)
            return 'Middle';
        else
            return 'Bottom';
    }


    function create(data) {

        var radius = 75;
        //width = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
        width = $('.content-sec').width();
        height = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
        //console.log('height: ' + height);
        fill = d3.scale.ordinal().range(['#FF00CC', '#FF00CC', '#00FF00', '#00FF00', '#FFFF00', '#FF0000', '#FF0000', '#FF0000', '#FF0000', '#7F0000']);
        //console.log('fill: ' + fill);
        svg = d3.select("#chart").append("svg")
                .attr("width", width)
                .attr("height", height);

        data = getDataMapping(data, size);

        //console.log(data);//return false;

        padding = 5;
        maxRadius = d3.max(_.pluck(data, 'radius'));
        //console.log(_.pluck(data, 'radius'));return false;

        var maximums = {
            volume: d3.max(_.pluck(data, 'volume')),
            lasPrice: d3.max(_.pluck(data, 'lastPrice')),
            standardDeviation: d3.max(_.pluck(data, 'standardDeviation'))
        };

        window.data = data;
        nodes_f();


        $('#board').change(function () {
            $('#chart').empty();

            start(this.value);
        });

        $('#size').change(function () {
            var val = this.value;
            var max = d3.max(_.pluck(data, val));

            d3.selectAll("circle")
                    .data(getDataMapping(data, this.value))
                    .transition()
                    .attr('r', function (d, i) {
                        return val ? (radius * (data[i][val] / max)) : 15
                    })
                    .attr('cx', function (d) {
                        return d.x
                    })
                    .attr('cy', function (d) {
                        return d.y
                    })
                    .duration(1000);

            size = this.value;

            force.start();
        });

        $('#color').change(function () {
            color = this.value;
            changeColor(this.value);
        });

        force = d3.layout.force();
        changeColor('activity');
        //window.data = data;
        draw('activity');
        
        if(default_circles != "") {
            clearInterval(default_circles);
        } else {
            console.log('undef2');
        }
        //new_data();
//        setInterval(function(){ console.log(222); new_data(); }, 5000);
        default_circles = setInterval(function() {
//            if(old_data_cirlcles != "") {
//                clearInterval(old_data_cirlcles);
//            } else {
//                console.log('undef');
//            }
            //console.log(222);
            new_data(); }, 5000);

    }
    


</script>
@stop