<?php

/*******************************\
*                               *
* chgpwd_form.php               *
*                               *
* Computer Science 50           *
* Final Project                 *
*                               *
* Renders the Change Password   *
*   form.                       *
*                               *
\*******************************/

?>

<form action="chgpwd.php" method="post">
    <div id="heading">
        <h1>Change Password</h1>
        <br/>
    </div>
    <fieldset>
        <div class="form-group">
            <input autofocus class="form-control" required name="oldpwd"
                   placeholder="Old Password" type="password" />
        </div>
        <div class="form-group">
            <input class="form-control" required name="password"
                   placeholder="Password" type="password" />
        </div>
        <div class="form-group">
            <input class="form-control" required name="confirm"
                   placeholder="Confirm Password" type="password" />
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-default">Change Password</button>
        </div>
    </fieldset>
</form>
