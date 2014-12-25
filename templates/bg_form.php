<?php

    /*******************************\
    *                               *
    * bg_form.php                   *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Renders the Enter BG form.    *
    *                               *
    \*******************************/

?>

<div>
    <h2><?= $_SESSION["username"] . "'s Blood Glucose" ?></h2>

    <form action="bg.php" method="post">
        <fieldset>
        
            <div class="bgEntry">
                <input autofocus class="form-small" name="bgReading" placeholder="###" type="number" min="1" max="999" value="" required /> mg/dL
            </div>
            
            <div>
                <table class="bgTable">
                    <tr>
                        <td colspan="2" class="F center"><input type="radio" name="mealtime" id="F" value="F" required> 
                        <label for="F">Fasting</label></td>
                    </tr>
                    <tr>
                        <td class="BB"><input type="radio" name="mealtime" id="BB" value="BB" required> <label for="BB">Before Breakfast</label></td>
                        <td class="AB"><input type="radio" name="mealtime" id="AB" value="AB" required> <label for="AB"> After Breakfast</label></td>
                    </tr>
                    <tr>
                        <td class="BL"><input type="radio" name="mealtime" id="BL" value="BL" required> <label for="BL"> Before Lunch</label></td>
                        <td class="AL"><input type="radio" name="mealtime" id="AL" value="AL" required> <label for="AL">After Lunch</label></td>
                    </tr>
                    <tr>
                        <td class="BD"><input type="radio" name="mealtime" id="BD" value="BD" required> <label for="BD">Before Dinner</label></td>
                        <td class="AD"><input type="radio" name="mealtime" id="AD" value="AD" required> <label for="AD">After Dinner</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="B center"><input type="radio" name="mealtime" id="B" value="B" required> <label for="B">Bedtime</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="R center"><input type="radio" name="mealtime" id="R" value="R" required> <label for="R">Random</label></td>
                    </tr>                    
                </table>
            
            </div>            
            <div class="form-group">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
                           
        </fieldset>
    </form>
</div>
