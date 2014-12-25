<?php

/*******************************\
*                               *
* footer.php                    *
*                               *
* Computer Science 50           *
* Final Project                 *
*                               *
* Render the universal page     *
*   footer.                     *
*                               *
\*******************************/

?>

        <div>
            <footer>
                <table class="open">
                    <tr>
<?php
              if (empty($_SESSION['id']))
              {
?>
                        <td><a href="javascript:history.go(-1);">Back</a></td>
                        <td><a href="register.php">Register</a></td>
                        <td><a href="login.php">Log In</a></td>
<?php
              }
              else
              {
?>
                        <td><a href="javascript:history.go(-1);">Back</a></td>
                        <td><a href="index.php">Home</a></td>
                        <td><a href="bg.php">Enter BG</a></td>
                        <td><a href="bglog.php">BG Log</a></td>
                        <td><a href="food.php">Food</a></td>
                        <td><a href="weight.php">Weight</a></td>
                        <td><a href="chgpwd.php">Change Password</a></td>
                        <td><a href="logout.php">Log Out</a></td>
<?php
              }
?>
                    </tr>
                </table>
<?php
              if (!empty($_SESSION['id']))
              {
?>
                <p class="small">
                    (logged in as <?=htmlspecialchars($_SESSION['username'])?> [id=<?=$_SESSION['id']?>])<br/>
                </p>
<?php
              }
?>
                <p class="dkblue">
                    Copyright <a class="dkblue" href="diag.php">&copy;</a> Inane Asylum, Inc.
                </p>
            </footer>
        </div>
    </body>
</html>
