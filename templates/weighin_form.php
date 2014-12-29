<form action="weighin.php" method="post">
    <h1>
        <?=$title?>
    </h1>
    <fieldset>
        <table>
            <tbody>
                <tr>
                    <td class="right">Current Weight:</td>
                    <td class="left">
                        <input class="form-small" name="curWeight" type="number" placeholder="lb" maxlength=6
                               min=1 max=2000 step=0.5 required /> lb.
                    </td>
                </tr>
                <tr>
                    <td class="right">Comment:</td>
                    <td class="left">
                        <input class="form-small" name="comment" placeholder="..." size=32 value="" type="text"/> *
                    </td>
                </tr>
                <tr>
                    <td class="right">Current Height:</td>
                    <td class="left">
                        <select class="form-small" name="height">
<?php
        for ($idx = 48; $idx < 66; $idx++)
        {
            print "<option value={$idx}>" . floor($idx / 12) . "'" . $idx % 12 . '"</option>';
        }
        print "<option selected value=null>height</option>";
        for ($idx = 66; $idx < 96; $idx++)
        {
            print "<option value={$idx}>" . floor($idx / 12) . "'" . $idx % 12 . '"</option>';
        }
?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="right">Goal Weight:</td>
                    <td class="left"><input class="form-small" name="goalWeight" placeholder="lb" maxlength=3 value=null type="number" min=1 max=999 /> lb. *</td>
                </tr>
            </tbody>
            <tfoot>
                <tf>
                    <td colspan=2>* Optional, except on first weigh-in</td>
                </tf>
            </tfoot>
        </table>
        <div class="form-group">
            <button type="submit" class="btn btn-default">Weigh-In</button>
        </div>
    </fieldset>
</form>
