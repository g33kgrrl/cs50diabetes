<div>
    <div>
        <h1>Stock Lookup</h1>
        <table>
            <tr>
                <td class="right">Symbol</td>
                <td class="bleft"><?=htmlspecialchars($symbol)?></td>
            </tr>
            <tr>
                <td class="right">Name</td>
                <td class="bleft"><?=htmlspecialchars($name)?></td>
            </tr>
            <tr>
                <td class="right">Share Price</td>
                <td class="bleft">$<?=number_format($price, 4)?></td>
            </tr>
        </table>
    </div>
</div>
<form action="quote.php" method="post">
    <fieldset>
        <div class="form-group">
            <br/>
            <input autofocus class="form-control" required name="symbol"
                   placeholder="symbol" type="text" maxlength=8 size=8 />
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-default">
                Get Another Quote
            </button>
        </div>
    </fieldset>
</form>
