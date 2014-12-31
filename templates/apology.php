<?php

    /*******************************\
    *                               *
    * apology.php                   *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Renders Apology screen.       *
    *                               *
    \*******************************/

?>

<p class="lead text-danger">
    <img alt="Sorry!" src="/img/Sorry.jpg" width=200 />
</p>
<p class="bigred">
    <?= htmlspecialchars($message) ?>
</p>
<?php if (isset($extra)) { ?>
<p class="medred">
    <?= htmlspecialchars($extra) ?>
</p>
<?php } ?>
