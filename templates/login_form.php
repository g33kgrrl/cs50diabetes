<?php

/*******************************\
*                               *
* login_form.php                *
*                               *
* Computer Science 50           *
* Final Project                 *
*                               *
* Render the login form.        *
*                               *
\*******************************/

?>

<form action="login.php" method="POST">
    <fieldset>
        <div class="form-group">
            <input autofocus class="form-control" required name="username"
                   placeholder="Username" type="text"/>
        </div>
        <div class="form-group">
            <input class="form-control" required name="password"
                   placeholder="Password" type="password"/>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-default">Log In</button>
        </div>
        <div>
            OR <a href="register.php">Register</a> for an account
        </div>
    </fieldset>
</form>
