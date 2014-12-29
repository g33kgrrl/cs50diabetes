<?php

    /*******************************\
    *                               *
    * cfgbolus_form.php             *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Renders the Bolus config-     *
    *   uration form.               *
    *                               *
    \*******************************/

?>

<div>
    <h2><?=$title?></h2>

    <form action="cfgbolus.php" method="post">
        <fieldset>

            <div class="bgentry">
                <input type="checkbox" name="enable" value=true <?=$enabled?>> Enable Insulin Bolusing
            </div>

            <div class="bgEntry">
                Carb Ratio: <input autofocus class="form-small" name="carbRatio" type="number" min="3" max="150" value="<?=$carbRatio?>" /> gm/U
            </div>

            <div class="bgEntry">
                Sensitivity: <input class="form-small" name="sensitivity" type="number" min="10" max="400" value="<?=$sensitivity?>" /> mg/dL per U
            </div>

            <div class="bgEntry">
                BG Target Range: <input class="form-small" name="bgTargetMin" type="number" min="60" max="250" value="<?=$bgTargetMin?>" />
                to <input class="form-small" name="bgTargetMax" type="number" min="60" max="250" value="<?=$bgTargetMax?>" /> mg/dL
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>

        </fieldset>
    </form>
</div>
