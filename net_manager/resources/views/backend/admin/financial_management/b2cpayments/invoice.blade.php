
<br>
<br>

<table>
    <tr style="text-align: right;">
        <td>
            <b style="color: #ff0000;">{$herstatus}</b>
        </td>
    </tr>
</table>

<b>{$item.tav}</b>
<br />
{$item.naam}
<br />
{$item.adres}
<br />
{$item.postcode} {$item.woonplaats}
<br />
<br />
<br />
Factuurdatum: {$item.verzenddatum}
<br />
<b>Factuurnummer: {$item.factuurnummer}</b>
<br />
Relatienummer: {$item.gebruiker_nummer}
<br />
<br />
{if $item.termijnen > 1}
Termijn: {$item.termijn}
<br />
{if $item.uitleg neq ""}
{$item.uitleg}
<br />
{/if}
<br />
{/if}

<table  cellspacing="0" cellpadding="3" >
    <tr style="text-align: right; border-bottom: 1px #000 solid;">
        <td style="border-bottom: 1px #000 solid; text-align:left;">
            <b>Code</b>
        </td >
        <td style="border-bottom: 1px #000 solid; text-align:left;">
            <b>Omschrijving</b>
        </td>
        <td style="border-bottom: 1px #000 solid;">
            <b>Aantal</b>
        </td>
        <td style="border-bottom: 1px #000 solid;">
            <b>Bedrag</b>
        </td>
        <td style="border-bottom: 1px #000 solid;">
            <b>Btw</b>
        </td>
        <td style="border-bottom: 1px #000 solid;">
            <b>Totaalbedrag</b>
        </td>
    </tr>

    {foreach from=$item.facturen item=factuur}
    <tr style="text-align: right;">
        <td style="text-align:left;">{$factuur.code} &nbsp;</td>
        <td style="text-align:left;">{$factuur.omschrijving} &nbsp;</td>
        <td>{$factuur.aantal} &nbsp;</td>
        <td>&euro; {$factuur.bedrag} &nbsp;</td>
        <td>{$factuur.btw}% &nbsp;</td>
        <td>&euro; {$factuur.totaalbedrag} &nbsp;</td>
    </tr>
    {/foreach}


    <tr>
        <td></td>
        <td></td>
        <td></td>

    </tr>

    <tr style="text-align: right;">
        <td></td>
        <td></td>
        <td></td>

        {if $item.termijnen > 1}
        <td colspan="2">
            <b>Bedrag termijn {$item.termijn}</b>
        </td>

        <td>
            &euro; {$totaal}
        </td>
        {/if}
    </tr>

    {if $nOpenstaand > 0 && $nOpenstaand != $GrandTotaal}
    <tr style="text-align: right;">
        <td></td>
        <td></td>
        <td></td>


        <td colspan="2">
            <b>Openstaand</b>
        </td>

        <td>
            &euro; {$nOpenstaand}
        </td>
    </tr>
    {/if}
    <tr style="text-align: right;">
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2">
            <b>Totaalbedrag excl. BTW</b>
        </td>

        <td>
            &euro; {$nBTW}
        </td>
    </tr>

    <tr style="text-align: right;">
        <td></td>
        <td></td>
        <td></td>

        <td colspan="2">
            <b>Totaalbedrag</b>
        </td>
        <td>
            &euro; {$GrandTotaal}
        </td>
    </tr>
</table>