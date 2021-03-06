<?php

/*******************************\
*                               *
* register_form.php             *
*                               *
* Computer Science 50           *
* Final Project                 *
*                               *
* Render the Register form.     *
*                               *
\*******************************/

?>

<form action="register.php" method="post">
    <div id="heading">
        <h1>Register as a new user</h1>
        <br/>
    </div>
    <fieldset>
        <div class="form-group">
            <input autofocus class="form-control" required name="username"
                   placeholder="Username" type="text" />
        </div>
        <div class="form-group">
            <input autofocus class="form-control" required name="firstName"
                   placeholder="First name" type="text" />
        </div>
        <div class="form-group">
            <input autofocus class="form-control" required name="lastName"
                   placeholder="Last name" type="text" />
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
            <button type="submit" class="btn btn-default">Register</button>
        </div>
    </fieldset>
</form>
