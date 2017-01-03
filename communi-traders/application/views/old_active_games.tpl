<table class="table open_games">
    <thead>
        <tr>
            <th>Asset</th>
            <th>Stragtegy</th>
            <th>Time of expire</th>
            <th>P&L</th>
            <th>In/Out</th>
        </tr>
    </thead>
    <tbody>
        {section name=i loop=$currentTrades}
            <tr>
                <td>{$currentTrades[i].asset}</td>
                <td>{$currentTrades[i].strategy}</td>
                <td>{$currentTrades[i].time_remains}</td>
                <td>{$currentTrades[i].pl}</td>
                {if $currentTrades[i].status eq 'In'}
                    <td bgcolor="#15B841">{$currentTrades[i].status}</td>
                {else}
                    <td>{$currentTrades[i].status}</td>
                {/if}
            </tr>
        {/section}
    </tbody>
</table>