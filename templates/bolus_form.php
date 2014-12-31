<?php

    /*******************************\
    *                               *
    * bolus_form.php                *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Renders the Bolus form.       *
    *                               *
    \*******************************/

?>

<div>
    <h2><?=$title?></h2>

    <form action="bolus.php" method="post">
        <fieldset>

            <div>
                <table class="bgTable">

<?php
                    $mealtimes = [ 'F', 'BB', 'AB', 'BL', 'AL', 'BD', 'AD', 'B', 'R' ];
                    $longnames = [ 'Fasting', 'Before Breakfast', 'After Breakfast', 'Before Lunch',
                        'After Lunch', 'Before Dinner', 'After Dinner', 'Bedtime', 'Random' ];

                    $cnt = 2;

                    foreach ($mealtimes as $idx => $mealtime) {
                        if (strlen($mealtime) === 1) {
?>
                    
                    <tr>
                        <td colspan="2" class="<?=$mealtime?> center">
                    
                <?php
                            $cnt = 2;
                        } else {
                            if ($cnt > 1) {
                ?>
                    
                    <tr>
                
                <?php
                            $cnt = 0;
                        }
                ?>
                
                        <td class="<?=$mealtime?>">
                
                <?php
                            ++$cnt;
                        }
                ?>
                            <input type="radio" name="mealtime" id="<?=$mealtime?>" value="<?=$mealtime?>" required />
                            <label for="<?=$mealtime?>"><?=$longnames[$idx]?></label>
                        </td>

                <?php
                        if ($cnt > 1) {
                ?>
                
                    </tr>
                
                <?php
                        }
                    }
                ?>

                </table>
            </div>

            <div class="bgEntry">
                Carbs: <input autofocus class="form-small" name="carbs" placeholder="###" type="number" min="1" max="999" value="" /> gm
            </div>

            <div class="bgEntry">
                BG: <input class="form-small" name="BG" placeholder="###" type="number" min="1" max="999" value="" /> mg/dL
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>

        </fieldset>
    </form>
</div>
