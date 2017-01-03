<table class="table table-bordered td_name">
    <thead>
        <tr class="table_header">
            <th>{$user_name} Performance Report:</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th></th>
            <th>Today</th>
            <th>This Week</th>
            <th>This Month</th>
            <th>This Year</th>
            <th>All time</th>
        </tr>
    </thead>
        <tbody>
            <tr>
                <td>Number of winning trades</td>                    
                <td>{$performanceRows['winningTrades'].dayResult}</td>
                <td>{$performanceRows['winningTrades'].weekResult}</td>
                <td>{$performanceRows['winningTrades'].monthResult}</td>
                <td>{$performanceRows['winningTrades'].yearResult}</td>
                <td>{$performanceRows['winningTrades'].allTimePeriod}</td>
            </tr>
            <tr>
                <td>Number of bad trades</td>
                <td>{$performanceRows['badTrades'].dayResult}</td>
                <td>{$performanceRows['badTrades'].weekResult}</td>
                <td>{$performanceRows['badTrades'].monthResult}</td>
                <td>{$performanceRows['badTrades'].yearResult}</td>
                <td>{$performanceRows['badTrades'].allTimePeriod}</td>
            </tr>
            <tr>
                <td>Win trades rate</td>
                <td>{$performanceRows['winTradesRate'].day} %</td>
                <td>{$performanceRows['winTradesRate'].week} %</td>
                <td>{$performanceRows['winTradesRate'].month} %</td>
                <td>{$performanceRows['winTradesRate'].year} %</td>
                <td>{$performanceRows['winTradesRate'].allTime} %</td>
            </tr>
            <tr>
                <td>Loose trades rate</td>
                <td>{$performanceRows['loseTradesRate'].day} %</td>
                <td>{$performanceRows['loseTradesRate'].week} %</td>
                <td>{$performanceRows['loseTradesRate'].month} %</td>
                <td>{$performanceRows['loseTradesRate'].year} %</td>
                <td>{$performanceRows['loseTradesRate'].allTime} %</td>
            </tr>
            <tr>
                <td>Best asset</td>
                <td>{$performanceRows['bestAsset'].dayRate|default:'-'}</td>
                <td>{$performanceRows['bestAsset'].weekRate|default:'-'}</td>
                <td>{$performanceRows['bestAsset'].monthRate|default:'-'}</td>
                <td>{$performanceRows['bestAsset'].yearRate|default:'-'}</td>
                <td>{$performanceRows['bestAsset'].allTimeRate|default:'-'}</td>
            </tr>
            <tr>
                <td>Worst asset</td>
                <td>{$performanceRows['worstAsset'].dayRate|default:'-'}</td>
                <td>{$performanceRows['worstAsset'].weekRate|default:'-'}</td>
                <td>{$performanceRows['worstAsset'].monthRate|default:'-'}</td>
                <td>{$performanceRows['worstAsset'].yearRate|default:'-'}</td>
                <td>{$performanceRows['worstAsset'].allTimeRate|default:'-'}</td>
            </tr>
            <tr>
                <td>Best strategy</td>
                <td>{$performanceRows['bestStrategy'].dayRate|default:'-'}</td>
                <td>{$performanceRows['bestStrategy'].weekRate|default:'-'}</td>
                <td>{$performanceRows['bestStrategy'].monthRate|default:'-'}</td>
                <td>{$performanceRows['bestStrategy'].yearRate|default:'-'}</td>
                <td>{$performanceRows['bestStrategy'].allTimeRate|default:'-'}</td>
            </tr>
            <tr>
                <td>Worst strategy</td>
                <td>{$performanceRows['worstStrategy'].dayRate|default:'-'}</td>
                <td>{$performanceRows['worstStrategy'].weekRate|default:'-'}</td>
                <td>{$performanceRows['worstStrategy'].monthRate|default:'-'}</td>
                <td>{$performanceRows['worstStrategy'].yearRate|default:'-'}</td>
                <td>{$performanceRows['worstStrategy'].allTimeRate|default:'-'}</td>
            </tr>
            <tr>
                <td>Success Rate of Calls strategy</td>
                <td>
                    {assign var='key' value=$performanceRows['procentStrategyDay'][0]|default:''}
                    {$key['call']|default:'0'}&nbsp;%
                </td>
                <td>
                    {assign var='key' value=$performanceRows['procentStrategyWeek'][0]|default:''}
                    {$key['call']|default:'0'}&nbsp;%
                </td>
                <td>
                    {assign var='key' value=$performanceRows['procentStrategyMonth'][0]|default:''}
                    {$key['call']|default:'0'}&nbsp;%
                </td>
                <td>
                    {assign var='key' value=$performanceRows['procentStrategyYear'][0]|default:''}
                    {$key['call']|default:'0'}&nbsp;%
                </td>
                <td>
                    {assign var='key' value=$performanceRows['procentStrategyAllTime'][0]|default:''}
                    {$key['call']|default:'0'}&nbsp;%
                </td>
                </tr>
                <tr>
                <td>Success Rate of puts strategy</td>
                <td>
                    {assign var='key' value=$performanceRows['procentStrategyDay'][0]|default:''}
                    {$key['put']|default:'0'}&nbsp;%
                </td>
                <td>
                    {assign var='key' value=$performanceRows['procentStrategyWeek'][0]|default:''}
                    {$key['put']|default:'0'}&nbsp;%
                </td>
                <td>
                    {assign var='key' value=$performanceRows['procentStrategyMonth'][0]|default:''}
                    {$key['put']|default:'0'}&nbsp;%
                </td>
                <td>
                    {assign var='key' value=$performanceRows['procentStrategyYear'][0]|default:''}
                    {$key['put']|default:'0'}&nbsp;%
                </td>
                <td>
                    {assign var='key' value=$performanceRows['procentStrategyAllTime'][0]|default:''}
                    {$key['put']|default:'0'}&nbsp;%
                </td>
            </tr>
            <tr>
                <td>Success Rate of touch strategy</td>
                <td>
                    {assign var='key' value=$performanceRows['procentStrategyDay'][0]|default:''}
                    {$key['touch']|default:'0'}&nbsp;%
                </td>
                <td>
                    {assign var='key' value=$performanceRows['procentStrategyWeek'][0]|default:''}
                    {$key['touch']|default:'0'}&nbsp;%
                </td>
                <td>
                    {assign var='key' value=$performanceRows['procentStrategyMonth'][0]|default:''}
                    {$key['touch']|default:'0'}&nbsp;%
                </td>
                <td>
                    {assign var='key' value=$performanceRows['procentStrategyYear'][0]|default:''}
                    {$key['touch']|default:'0'}&nbsp;%
                </td>
                <td>
                    {assign var='key' value=$performanceRows['procentStrategyAllTime'][0]|default:''}
                    {$key['touch']|default:'0'}&nbsp;%
                </td>
                </tr>
                <tr>
                    <td>Success Rate of no touch strategy</td>
                    <td>
                        {assign var='key' value=$performanceRows['procentStrategyDay'][0]|default:''}
                        {$key['no touch']|default:'0'}&nbsp;%
                    </td>
                    <td>
                        {assign var='key' value=$performanceRows['procentStrategyWeek'][0]|default:''}
                        {$key['no touch']|default:'0'}&nbsp;%
                    </td>
                    <td>
                        {assign var='key' value=$performanceRows['procentStrategyMonth'][0]|default:''}
                        {$key['no touch']|default:'0'}&nbsp;%
                    </td>
                    <td>
                        {assign var='key' value=$performanceRows['procentStrategyYear'][0]|default:''}
                        {$key['no touch']|default:'0'}&nbsp;%
                    </td>
                    <td>
                        {assign var='key' value=$performanceRows['procentStrategyAllTime'][0]|default:''}
                        {$key['no touch']|default:'0'}&nbsp;%
                    </td>
                </tr>
                <tr>
                    <td>Success Rate of boundery out  strategy</td>
                    <td>
                        {assign var='key' value=$performanceRows['procentStrategyDay'][0]|default:''}
                        {$key['bounderi out']|default:'0'}&nbsp;%
                    </td>
                    <td>
                        {assign var='key' value=$performanceRows['procentStrategyWeek'][0]|default:''}
                        {$key['bounderi out']|default:'0'}&nbsp;%
                    </td>
                    <td>
                        {assign var='key' value=$performanceRows['procentStrategyMonth'][0]|default:''}
                        {$key['bounderi out']|default:'0'}&nbsp;%
                    </td>
                    <td>
                        {assign var='key' value=$performanceRows['procentStrategyYear'][0]|default:''}
                        {$key['bounderi out']|default:'0'}&nbsp;%
                    </td>
                    <td>
                        {assign var='key' value=$performanceRows['procentStrategyAllTime'][0]|default:''}
                        {$key['bounderi out']|default:'0'}&nbsp;%
                    </td>
                </tr>
                <tr>
                    <td>Success Rate of boundary in  strategy</td>
                    <td>
                        {assign var='key' value=$performanceRows['procentStrategyDay'][0]|default:''}
                        {$key['bounderi out']|default:'0'}&nbsp;%
                    </td>
                    <td>
                        {assign var='key' value=$performanceRows['procentStrategyWeek'][0]|default:''}
                        {$key['bounderi inside']|default:'0'}&nbsp;%
                    </td>
                    <td>
                        {assign var='key' value=$performanceRows['procentStrategyMonth'][0]|default:''}
                        {$key['bounderi inside']|default:'0'}&nbsp;%
                    </td>
                    <td>
                        {assign var='key' value=$performanceRows['procentStrategyYear'][0]|default:''}
                        {$key['bounderi inside']|default:'0'}&nbsp;%
                    </td>
                    <td>
                        {assign var='key' value=$performanceRows['procentStrategyAllTime'][0]|default:''}
                        {$key['bounderi inside']|default:'0'}&nbsp;%
                    </td>
                </tr>
        </tbody>
</table>