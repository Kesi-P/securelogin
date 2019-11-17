<?php include_once("header.php") ?>
<section class="parent">
  <div class="child">

    <?php
      if (!func::checkingLoginState($dbh))
      {
        //echo $_SESSION['username'];
        if(isset($_POST['username']) && isset($_POST['password']))
        {
          $query = "SELECT * FROM users WHERE user_username = :username AND user_password = :password";
            $username = $_POST['username'];
            $password = $_POST['password'];

            $stmt = $dbh->prepare($query);
            $stmt->execute(array(':username'=>$username, ':password'=>$password));

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //echo $stmt;
            if($row['user_id'] > 0)
            {
              // func::createRecord($row['user_id'],$row['user_username'])
              // header("location:index.php");
              echo func::createRecord(32);
              echo "s1tring";
            }
        }
        else {
          echo '
          <form action="login.php" method="post">
            <label>Username</label><br>
            <input type="text" name="username" /><br>
            <label>Password</label><br>
            <input type="password" name="password" /><br>
            <input type="submit" value="login" />
          </form>
          ';
        }
      }
      else
      {
        header("location:index.php");

      }
     ?>

  </div>
</section>
