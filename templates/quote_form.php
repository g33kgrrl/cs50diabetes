<div id="heading"><h1>Get a Stock Quote</h1></div>
<br/>
<form action="quote.php" method="post">
    <fieldset>
        <div class="form-group">
            <input autofocus class="form-control" required name="symbol"
                   placeholder="symbol" type="text" maxlength=8 size=8 />
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-default">Get Quote</button>
        </div>
    </fieldset>
</form>
