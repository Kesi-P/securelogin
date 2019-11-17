<?php
include_once('header.php');
 ?>

<section class="parent">
  <div class="child">
    <?php
      if (!func::checkingLoginState($dbh)) {
        header("location:login.php");
        exit();

      }
      else {
        echo 'Welcome'.$_COOKIE['username'];
        echo '<a href="logout.php">Logout</a>';
      }
     ?>
  </div>

</section>


 <?php
include_once('footer.php');
  ?>
