<?php
class func
{
  public static function checkingLoginState($dbh)
  {
    if (!isset($_SESSION)) {
       session_start();
       //echo "sss"; return true;
    }
    if (isset($_COOKIE['id']) && isset($_COOKIE['token']) && isset($_COOKIE['serial']))
    {
      $query = "SELECT * FROM session WHERE session_userid = :userid AND session_token = :token AND session_serial = :serial; ";

       $userid = $_COOKIE['userid'];
       $token = $_COOKIE['token'];
       $serial = $_COOKIE['serial'];

       $stmt = $dbh->prepare($query);
       $stmt->execute(array(':userid'=>$userid, ':token'=>$token, ':serial'=>$serial));

       $row = $stmt->fetch(PDO::FETCH_ASSOC);
       if($row['session_userid'] > 0)
       {
         if(
           $row['session_userid'] == $_COOKIE['userid'] &&
           $row['session_token'] == $_COOKIE['token'] &&
           $row['session_serial'] == $_COOKIE['serial']
         )
         {
           if(
             $row['session_userid'] == $_SESSION['userid'] &&
             $row['session_token'] == $_SESSION['token'] &&
             $row['session_serial'] == $_SESSION['serial']
           )
           {
             return true;
            //echo "string";
           }
         }else
          {
           func::createSession($_COOKIE['username'],$_COOKIE['userid'],$_COOKIE['token'].$_COOKIE['serial']);
           return true;
         }


       }
    }
  }

  public static function createRecord($dbh, $user_username, $user_id)
  {
    $query ='INSERT INTO session (session_userid, session_token, session_serial, session_date) VALUES (:user_id,:token,:serial,"17/11/2019") ';

    $dbh->prepare('DELETE FROM session WHERE session_userid= :session_userid;')->execute(array(':session_userid'=>$user_id));

    $token = func::createString(32);
    $serial = func::createString(32);

    func::createCookie($user_username, $user_id, $token,$serial );
    func::createSession($user_username, $user_id, $token,$serial );

    $stmt = $dbh->prepare($query);
    $stmt->execute(array(':user_id'=>$user_id, ':token'=>$token, ':serial'=>$serial));
    echo "pass";
  }

  public static function createCookie($user_username, $user_id, $token,$serial )
  {
    setcookie('user_id',$user_id, time() + (86400) * 30, "/");
    setcookie('user_username',$user_username, time() + (86400) * 30, "/");
    setcookie('token',$token, time() + (86400) * 30, "/");
    setcookie('serial',$serial, time() + (86400) * 30, "/");
  }

  public static function deleteCookie()
  {
    setcookie('user_id','', time() -1, "/");
    setcookie('user_username','',-1, "/");
    setcookie('token','', time() -1, "/");
    setcookie('serial','', time() -1, "/");
  }

  public static function createSession($user_username, $user_id, $token,$serial )
  {
    if(!isset($_SESSIO))
    {
      session_start();
    }
    $_SESSION['user_username'] = $user_username;
    setcookie('user_id',$user_id, time() + (86400) * 30, "/");
    setcookie('token',$token, time() + (86400) * 30, "/");
    setcookie('serial',$serial, time() + (86400) * 30, "/");
  }

  public static function createString($len)
  {
    $string ="jif3t7038powkLfne93bhd03dwljlnzuyLEflpemiydwrioimwr6dop4-fv";
    return substr(str_shuffle($string),0 ,32);
  }
}
 ?>
