<?php

    /****************************************************\
    *                                                   *
    * fsauth_form.php                                   *
    *                                                   *
    * Computer Science 50                               *
    * Final Project                                     *
    *                                                   *
    * Renders the Enter FatSecret Access Token form.    *
    *                                                   *
    \***************************************************/

?>

<div>

<div>
    <h2><?= $title ?></h2>

    <h3><a href="<?= $url ?>" target="_blank">Click here</a> to authorize the request.</h3>

    <h3>Please copy your FatSecret Access Token and paste below:

    <form action="fsauth.php" method="post">
        <fieldset>
        
            <div>
                <input autofocus class="form-small" name="fsVerifier" type="text" size="16" value="" /> 
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
            
        </fieldset>
    </form>
</div>
