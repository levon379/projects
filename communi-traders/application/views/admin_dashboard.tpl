<div class="box box-color box-bordered">

<div class="row">
          <div class="col-lg-3">
			<a href="#">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-10">
                      TotalActive/Non Active Users
                    </div>
                    <div class="col-xs-2 text-right">
						<i class="fa fa-bar-chart-o"></i>
						<i class="fa fa-cog"></i>
                    </div>
                  </div>
                </div>
			</a>
            <div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
					<div class="col-xs-6">
                    <i class="fa fa-users fa-4x"></i>
                  </div>
					  <div class="col-xs-6 text-right">
					  
						<p class="announcement-heading">456</p>
						<p class="announcement-text">New Mentions!</p>
					  </div>
					</div>	
				</div>
            </div>
          </div>
		  
          <div class="col-lg-3">
			<a href="#">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-10">
                      Current Live Open Trades
                    </div>
                    <div class="col-xs-2 text-right">
						<i class="fa fa-bar-chart-o"></i>
						<i class="fa fa-cog"></i>
                    </div>
                  </div>
                </div>
			</a>
            <div class="panel panel-warning">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
				  <i class="fa fa-tags fa-4x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading">12</p>
                    <p class="announcement-text">To-Do Items</p>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
          <div class="col-lg-3">
			<a href="#">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-10">
                      Clicks On New Account Openin
                    </div>
                    <div class="col-xs-2 text-right">
						<i class="fa fa-bar-chart-o"></i>
						<i class="fa fa-cog"></i>
                    </div>
                  </div>
                </div>
			</a>
            <div class="panel panel-danger">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="fa fa-tasks fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading">18</p>
                    <p class="announcement-text">Crawl Errors</p>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
          <div class="col-lg-3">
		  <a href="#">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-10">
                      Avg Adoption Score
                    </div>
                    <div class="col-xs-2 text-right">
						<i class="fa fa-bar-chart-o"></i>
						<i class="fa fa-cog"></i>
                    </div>
                  </div>
                </div>
              </a>
            <div class="panel panel-success">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="fa fa-comments fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading">56</p>
                    <p class="announcement-text">New Orders!</p>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
		  <div class="col-lg-3">
		  <a href="#">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-10">
                      Current Users on Forum
                    </div>
                    <div class="col-xs-2 text-right">
						<i class="fa fa-bar-chart-o"></i>
						<i class="fa fa-cog"></i>
                    </div>
                  </div>
                </div>
              </a>
            <div class="panel panel-success">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="fa fa-comments fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading">56</p>
                    <p class="announcement-text">New Orders!</p>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
		  <div class="col-lg-3">
		  <a href="#">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-10">
                      Clicks On Copy Trade/Week
                    </div>
                    <div class="col-xs-2 text-right">
						<i class="fa fa-bar-chart-o"></i>
						<i class="fa fa-cog"></i>
                    </div>
                  </div>
                </div>
              </a>
            <div class="panel panel-success">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="fa fa-comments fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading">56</p>
                    <p class="announcement-text">New Orders!</p>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
    <div class="box-title container">
        <div class="actions">
            <a href="#" class="btn btn-mini content-refresh">
                <i class="fa fa-refresh"></i>
            </a>
            <a href="#" class="btn btn-mini content-remove">
                <i class="fa fa-times"></i>
            </a>
            <a href="#" class="btn btn-mini content-slideUp">
                <i class="fa fa-angle-down"></i>
            </a>
        </div>
    </div>
<form method="post">
{$ci_csrf_token}
		<div id="reportrange_1" class="pull-left" style="cursor: pointer;">
			<i class="fa fa-calendar fa-lg"></i>
			<span>{$config.date_from|date_format} - {$config.date_to|date_format}</span> <b class="caret"></b>
		</div>
		<div id="reportrange_2" class="pull-right" style="cursor: pointer;">
			<i class="fa fa-calendar fa-lg"></i>
			<span>{$config.date_from|date_format} - {$config.date_to|date_format}</span> <b class="caret"></b>
		</div>	
</form>		
	{literal}
	<script>datarange()</script>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
{/literal}
<div class="container">
<div id="container_1" class="col-lg-6" style="min-width: 310px;   margin: 0 auto"></div>
<div id="container_2" class="col-lg-6" style="min-width: 310px;  margin: 0 auto"></div>
</div>
{literal}
<script>

$(function () {

		 $('#container_1').highcharts({
            title: {
                text: 'TOTAL Shares & Trades',
                x: -20 //center
            },
            xAxis: {
                categories: []
            },
            yAxis: {
                
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                data: []
            }]
        });

        $('#container_2').highcharts({
            title: {
                text: 'Avg Winning Rate/Week',
                x: -20 //center
            },
            xAxis: {
                categories: ['Jun 2','Jun 4','6','8','10','12','14','16','18','20','22','24','26','28','30']
            },
            yAxis: {
                
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                data: [0,500,1000,105,1000,3000,2000,5000,8000,25000,19000,37000,40000,10000,16000]
            }, {
                data: [0,200,40,200,1000,6000,4000,9000,15000,6000,26000,30000,35000,25000,22000]
            }]
        });
		
    });
</script>
{/literal}
<div class="container">
<div id="container" class="col-lg-5" style="min-width: 310px;   margin: 0 auto"></div>
{literal}
<script>
$(function () {
Highcharts.getOptions().plotOptions.pie.colors = (function () {
            var colors = [],
                base = Highcharts.getOptions().colors[0],
                i

            for (i = 0; i < 200; i++) {
                colors.push(Highcharts.Color(base).brighten((i - 2) / 5).get());
            }
            return colors;
		}());
    $('#container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Active / Non Active Users'
        },
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            },
			
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            data: [
                ['Non Active',    10000],
                {
                    name: 'Active',
                    y: 25000,
                    sliced: true,
                    selected: true
                }
            ]
        }]
		
    });
});
</script>
{/literal}