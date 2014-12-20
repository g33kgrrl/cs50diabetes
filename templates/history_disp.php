<div>
    <h1><?=$title?></h1>
    <table>
        <thead>
            <tr>
                <th>Date/Time</th>
                <th>Action</th>
                <th>Shares</th>
                <th>Symbol</th>
                <th>Share Price</th>
                <th>Net Volume</th>
            </tr>
        </thead>
        <tbody>
<?php
    $netvolstr = '$' . number_format($net_volume, 4);
    foreach ($history as $trans)
    {
?>
            <tr>
                <td class="left"><?=$trans['time']?></td>
                <td><?=$trans['action']?></td>
                <td class="rightpad1"><?=$trans['shares']?></td>
                <td><?=htmlspecialchars($trans['symbol'])?></td>
                <td class="rightpad2">
                    $<?=number_format($trans['price'], 4)?>
                </td>
                <td class="rightpad1">
                    $<?=number_format($trans['value'], 4)?>
                </td>
            </tr>
<?php
    }
    if ($total_shares == 0)
    {
?>
        <tr><td colspan=7 class="bigred">NO HISTORY</td></tr>
<?php
        $total_shares = '--';
        $netvolstr = '$ --';
    }
?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan=2 class="bright">TOTAL</th>
                <th class="brightpad1"><?=$total_shares?></th>
                <th colspan=2>&nbsp;</th>
                <th class="brightpad1">
                    <?=$netvolstr?>
                </th>
            </tr>
        </tfoot>
    </table>
    <div class="medital"><a href="javascript:history.go(-1)">Back</a></div>
</div>
