<div class="mct_table_subhead">
            <div class="mct_table_subhead_empty"></div>
            <ul>
                <li>Today</li>
                <li>This Week</li>
                <li>This Month</li>
                <li>This Year</li>
                <li>All time</li>
            </ul>
        </div>
        <ul class="mct_performance_report_names">
            <li>Winning trades</li>
            <li>Bad trades</li>
            <li>Win trades rate</li>
            <li>Loose trade rate</li>
            <li>Best asset</li>
            <li>Worst asset</li>
            <li>Best strategy</li>
            <li>Worst strategy</li>
        </ul>
        <ul class="mct_performance_report_stat">
			<li>{$allinfo.PerformanceData.winningTrades.dayResult}</li>
            <li>{$allinfo.PerformanceData.badTrades.dayResult}</li>
            <li>{$allinfo.PerformanceData.winTradesRate.day}</li>
            <li>{$allinfo.PerformanceData.loseTradesRate.day}</li>
            <li>{if empty($allinfo.PerformanceData.bestAsset.dayRate)}-{else}{$allinfo.PerformanceData.bestAsset.dayRate}{/if}</li>
            <li>{if empty($allinfo.PerformanceData.worstAsset.dayRate)}-{else}{$allinfo.PerformanceData.worstAsset.dayRate}{/if}</li>
            <li>{if empty($allinfo.PerformanceData.bestStrategy.dayRate)}-{else}{$allinfo.PerformanceData.bestStrategy.dayRate}{/if}</li>
            <li>{if empty($allinfo.PerformanceData.worstStrategy.dayRate)}-{else}{$allinfo.PerformanceData.worstStrategy.dayRate}{/if}</li>
        </ul>
        <ul class="mct_performance_report_stat">
            <li>{$winning_trades.dataCounted.weekResult}</li>
            <li>{$bad_trades.dataCounted.weekResult}</li>
            <li>{$allinfo.PerformanceData.winTradesRate.week}</li>
            <li>{$allinfo.PerformanceData.loseTradesRate.week}</li>
            <li>{if empty($allinfo.PerformanceData.bestAsset.weekRate)}-{else}{$allinfo.PerformanceData.bestAsset.weekRate}{/if}</li>
            <li>{if empty($allinfo.PerformanceData.worstAsset.weekRate)}-{else}{$allinfo.PerformanceData.worstAsset.weekRate}{/if}</li>
            <li>{if empty($allinfo.PerformanceData.bestStrategy.weekRate)}-{else}{$allinfo.PerformanceData.bestStrategy.weekRate}{/if}</li>
            <li>{if empty($allinfo.PerformanceData.worstStrategy.weekRate)}-{else}{$allinfo.PerformanceData.worstStrategy.weekRate}{/if}</li>
        </ul>
        <ul class="mct_performance_report_stat">
           <li>{$winning_trades.dataCounted.monthResult}</li>
            <li>{$bad_trades.dataCounted.monthResult}</li>
            <li>{$allinfo.PerformanceData.winTradesRate.month}</li>
            <li>{$allinfo.PerformanceData.loseTradesRate.month}</li>
			<li>{if empty($allinfo.PerformanceData.bestAsset.yearRate)}-{else}{$allinfo.PerformanceData.bestAsset.yearRate}{/if}</li>
            <li>{if empty($allinfo.PerformanceData.worstAsset.monthRate)}-{else}{$allinfo.PerformanceData.worstAsset.monthRate}{/if}</li>
            <li>{if empty($allinfo.PerformanceData.bestStrategy.monthRate)}-{else}{$allinfo.PerformanceData.bestStrategy.monthRate}{/if}</li>
            <li>{if empty($allinfo.PerformanceData.worstStrategy.monthRate)}-{else}{$allinfo.PerformanceData.worstStrategy.monthRate}{/if}</li>
        </ul>
        <ul class="mct_performance_report_stat">
            <li>{$winning_trades.dataCounted.yearResult}</li>
            <li>{$bad_trades.dataCounted.yearResult}</li>
            <li>{$allinfo.PerformanceData.winTradesRate.year}</li>
            <li>{$allinfo.PerformanceData.loseTradesRate.year}</li>
			<li>{if empty($allinfo.PerformanceData.bestAsset.yearRate)}-{else}{$allinfo.PerformanceData.bestAsset.yearRate}{/if}</li>
			<li>{if empty($allinfo.PerformanceData.worstAsset.yearRate)}-{else}{$allinfo.PerformanceData.worstAsset.yearRate}{/if}</li>
			<li>{if empty($allinfo.PerformanceData.bestStrategy.yearRate)}-{else}{$allinfo.PerformanceData.bestStrategy.yearRate}{/if}</li>
			<li>{if empty($allinfo.PerformanceData.worstStrategy.yearRate)}-{else}{$allinfo.PerformanceData.worstStrategy.yearRate}{/if}</li>
        </ul>
        <ul class="mct_performance_report_stat">
            <li>{$winning_trades.dataCounted.allTimePeriod}</li>
            <li>{$bad_trades.dataCounted.allTimePeriod}</li>
            <li>{$allinfo.PerformanceData.winTradesRate.allTime}</li>
            <li>{$allinfo.PerformanceData.loseTradesRate.allTime}</li>
            <li>{if empty($allinfo.PerformanceData.bestAsset.allTimeRate)}-{else}{$allinfo.PerformanceData.bestAsset.allTimeRate}{/if}</li>
            <li>{if empty($allinfo.PerformanceData.worstAsset.allTimeRate)}-{else}{$allinfo.PerformanceData.worstAsset.allTimeRate}{/if}</li>
            <li>{if empty($allinfo.PerformanceData.bestStrategy.allTimeRate)}-{else}{$allinfo.PerformanceData.bestStrategy.allTimeRate}{/if}</li>
            <li>{if empty($allinfo.PerformanceData.worstStrategy.allTimeRate)}-{else}{$allinfo.PerformanceData.worstStrategy.allTimeRate}{/if}</li>
        </ul>
        <div class="mct_performance_report_success">Success rate:</div>
        <ul class="mct_performance_report_names">
            <li>Call strategy</li>
            <li>Put strategy</li>
            <li>Touch strategy</li>
            <li>No Touch strategy</li>
            <li>Boundary In strategy</li>
            <li>Boundary Out strategy</li>

        </ul>
        <ul class="mct_performance_report_stat">
            <li>{$user_strategy.day.day_call}</li>
            <li>{$user_strategy.day.day_put}</li>
            <li>{$user_strategy.day.day_touch}</li>
            <li>{$user_strategy.day.day_boundary_inside}</li>
            <li>{$user_strategy.day.day_boundary_out}</li>
            <li>{$user_strategy.day.day_put}</li>
        </ul>
        <ul class="mct_performance_report_stat">
            <li>{$user_strategy.week.week_call}</li>
            <li>{$user_strategy.week.week_put}</li>
            <li>{$user_strategy.week.week_touch}</li>
            <li>{$user_strategy.week.week_no_touch}</li>
            <li>{$user_strategy.week.week_boundary_inside}</li>
            <li>{$user_strategy.week.week_boundary_out}</li>
        </ul>
        <ul class="mct_performance_report_stat">
            <li>{$user_strategy.month.month_call}</li>
            <li>{$user_strategy.month.month_put}</li>
            <li>{$user_strategy.month.month_touch}</li>
            <li>{$user_strategy.month.month_no_touch}</li>
            <li>{$user_strategy.month.month_boundary_inside}</li>
            <li>{$user_strategy.month.month_boundary_out}</li>
        </ul>
        <ul class="mct_performance_report_stat">
            <li>{$user_strategy.year.year_call}</li>
            <li>{$user_strategy.year.year_put}</li>
            <li>{$user_strategy.year.year_touch}</li>
            <li>{$user_strategy.year.year_no_touch}</li>
            <li>{$user_strategy.year.year_boundary_inside}</li>
            <li>{$user_strategy.year.year_boundary_out}</li>
        </ul>
        <ul class="mct_performance_report_stat">
            <li>{$user_strategy.all_time.alltime_call}</li>
            <li>{$user_strategy.all_time.alltime_put}</li>
            <li>{$user_strategy.all_time.alltime_touch}</li>
            <li>{$user_strategy.all_time.alltime_no_touch}</li>
            <li>{$user_strategy.all_time.alltime_boundary_inside}</li>
            <li>{$user_strategy.all_time.alltime_boundary_out}</li>
        </ul>

    </div>