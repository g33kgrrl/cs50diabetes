<div>
    <h1 class="bigredul"><?=htmlspecialchars($title)?></h1>
    <p class="medital">
<?php
    $started = false;
    if (!empty($conf_msg1)  &&  isset($conf_msg1))
    {
        echo htmlspecialchars($conf_msg1);
        $started = true;
    }
    if (!empty($conf_msg2)  &&  isset($conf_msg2))
    {
        if ($started)
        {
            echo "<br/>";
        }
        echo htmlspecialchars($conf_msg2);
    }
?>
    </p>
    <p class="bigred">Is this correct?</p>
    <br/><br/>
    <form action="<?=$controller?>" method="post">
        <fieldset>
            <div class="form-group">
                <button type="submit" class="btn btn-default">Yes</button>
                &nbsp; &nbsp;
                <button type="button" class="btn btn-default"
                        onclick="javascript:history.go(-1)">No</button>
            </div>
        </fieldset>
    </form>
</div>
