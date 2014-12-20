<div>
    <h1><?=$title?></h1>
    <table>
        <thead>
            <tr>
                <th>Symbol</th>
                <th class="left">Description</th>
                <th>Share Price</th>
                <th>Shares</th>
                <th>Total Value</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach ($portfolio as $stock)
    {
?>
            <tr>
                <td><?=htmlspecialchars($stock['symbol'])?></td>
                <td class="left"><?=htmlspecialchars($stock['name'])?></td>
                <td class="rightpad2">
                    $<?=number_format($stock['price'], 4)?>
                </td>
                <td class="rightpad1"><?=$stock['shares']?></td>
                <td class="rightpad1">
                    $<?=number_format($stock['value'], 4)?>
                </td>
            </tr>
<?php
    }
    if ($total_shares == 0)
    {
?>
        <tr><td colspan=5 class="bigred">NO STOCKS IN PORTFOLIO</td></tr>
<?php
        $total_shares = '--';
    }
?>
            <tr>
                <td colspan=3 class="bright">CA$H on Hand</td>
                <td colspan=2 class="brightpad1">
                    $<?=number_format($_SESSION['cash'], 4)?>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan=3 class="bright">TOTAL</th>
                <th class="brightpad1"><?=$total_shares?></th>
                <th class="brightpad1">
                    $<?=number_format($net_worth, 4)?>
                </th>
            </tr>
        </tfoot>
    </table>
</div>
