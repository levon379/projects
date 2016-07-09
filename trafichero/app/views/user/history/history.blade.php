@extends('layout.user')

@section('content')
<div class="content-sec">
    <div class="breadcrumbs">
        <ul>
            <li><a href="dashboard" title=""><i class="fa fa-home"></i></a>/</li>
            <?php
            if (isset($site_name) && !empty($site_name)) {
                echo '<li><a title="">' . $site_name . '</a>/</li>';
            }
            ?>
            <li><a title="">History</a></li>
        </ul>
    </div><!-- breadcrumbs -->
    <div style="width: 40%">
        <canvas id="canvas" height="450" width="600"></canvas>
    </div>
    <span>
        Visits counts per hours for last <?php echo $last_month_data[0]->updated; ?> days.
    </span>
    <br />
    <br />
    <a class="button float-shadow">Last Day Visits -  <?php echo $last_day_visits_count; ?></a>
    <br />
    <a class="button float-shadow">Last Week (last 7 days) Visits -  <?php echo $last_week_visits_count; ?></a>
    <br />
    <a class="button float-shadow">Last Month (last 30 days) Visits -  <?php echo $last_month_visits_count; ?></a>
    <br />
    <a class="button float-shadow">Last 3 Months (last 90 days) Visits -  <?php echo $last_three_months_visits_count; ?></a>
</div>
@stop
@section('scripts')
<script type="text/javascript">
    var last_month_data = [
<?php
$i = 0;
foreach ($last_month_data[0] as $key => $val) {
    if ($i > 1 && $i < 26) {
        echo $last_month_data[0]->$key . ", ";
    }
    $i ++;
}
?>
    ];

    var randomScalingFactor = function () {
        return Math.round(Math.random() * 100)
    };

    var barChartData = {
        labels: ["0h", "1h", "2h", "3h", "4h", "5h", "6h", "7h", "8h", "9h", "10h", "11h", "12h", "13h", "14h", "15h", "16h", "17h", "18h", "19h", "20h", "21h", "22h", "23h"],
        datasets: [
            {
                fillColor: "rgba(220,220,220,0.5)",
                strokeColor: "rgba(220,220,220,0.8)",
                highlightFill: "rgba(220,220,220,0.75)",
//                fillColor: "red",
//                strokeColor: "green",
//                highlightFill: "blue",
                highlightStroke: "rgba(220,220,220,1)",
//                data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(),
//                    randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(),
//                    randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
                data: last_month_data
            },
        ]

    }
    window.onload = function () {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx).Bar(barChartData, {
            responsive: true
        });
    }
</script>
@stop