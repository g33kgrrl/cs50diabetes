<h1>
    Sell Shares from <?=htmlspecialchars($_SESSION['username'])?>'s
    Portfolio
</h1>
<div class="medium">
    CA$H on Hand: $<?=number_format($_SESSION['cash'], 4)?>
</div>
<?php
    if (count($portfolio) == 0)
    {
?>
    <p class="bigred">NO SHARES TO SELL!</p>
<?php
    }
    else
    {
?>
<form action="sell.php" method="post">
    <fieldset>
        <table>
            <thead>
                <tr>
                    <th>Sell?</th>
                    <th>Symbol</th>
                    <th class="left">Description</th>
                    <th>Share Price</th>
                    <th>Shares</th>
                    <th>Total Value</th>
                </tr>
            </thead>
            <tbody>
    <?php
        $idx = 0;
        foreach ($portfolio as $stock)
        {
    ?>
                <tr>
                    <td><input class="form-small" required name="idx"
                               value="<?=$idx?>" type="radio"></td>
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
            $idx++;
        }
?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan=4 class="right">TOTAL</th>
                    <th class="rightpad1"><?=$total_shares?></th>
                    <th class="rightpad1">
                        $<?=number_format($total_value, 4)?>
                    </th>
                </tr>
            </tfoot>
        </table>

        <div class="medium">
            <p>Shares to sell:
                <input autofocus class="form-small" required name="sell"
                       placeholder="shares" size=5 maxlength=5 type="text" />
            </p>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-default">Sell</button>
        </div>
    </fieldset>
</form>
<?php
    }
?>
