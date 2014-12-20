<form action="buy.php" method="post">
    <h1>
        Buy Shares for
        <?=htmlspecialchars($_SESSION['username'])?>'s Portfolio
    </h1>
    <div class="medium">
        CA$H on Hand: $<?=number_format($_SESSION['cash'], 4)?>
    </div>
    <fieldset>
<?php
    $idx = 0;
    $count = 0;
    if (count($portfolio) > 0)
    {
?>
        <table>
            <thead>
                <tr>
                    <th>Choose</th>
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
            if ($stock['shares'] == null)
            {
?>
                <tr class="highlight">
                    <td>
<?php
                if ($stock['price'] <= $_SESSION['cash'])
                {
                    $count++;
?>
                        <input class="form-tiny" name="idx"
                               value="<?=$idx?>" type="radio">
<?php
                }
                else
                {
                    echo "na";
                }
?>
                    </td>
                    <td><?=htmlspecialchars($stock['symbol'])?></td>
                    <td class="ileft">
                        <?=htmlspecialchars($stock['name'])?>
                    </td>
                    <td class="irightpad2">
                        $<?=number_format($stock['price'], 4)?>
                    </td>
                    <td class="smallital" colspan=2>(last viewed)</td>
                </tr>
<?php
            }
            else
            {
?>
                <tr>
                    <td>
<?php
                if ($stock['price'] <= $_SESSION['cash'])
                {
                    $count++;
?>
                        <input class="form-tiny" name="idx"
                               value="<?=$idx?>" type="radio"></td>
<?php
                }
                else
                {
                    echo "na";
                }
?>
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
        <p class="medium">
            OR choose a new stock:
            <input class="form-small" name="sym"
                   placeholder="symbol" size=8 type="text"/>
        </p>
<?php
    }
    else
    {
?>
        <br/>
        <div class="medium">Choose a stock:
            <input class="form-small" name="sym"
                   placeholder="symbol" size=8 type="text"/>
        </div>
        <br/>
<?php
    }
?>
        <div class="medium">
            <p>Shares to Buy:
                <input autofocus class="form-small" required name="buy"
                       placeholder="shares" size=5 maxlength=5 type="text"/></p>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-default">Buy</button>
        </div>
    </fieldset>
</form>
