<?php
class func
{
  public static function checkingLoginState($dbh)
  {
    if (!isset($_SESSION['id']) || !isset($_COOKIE['PHPSESSID'])) {
       session_start();
       //echo "sss"; return true;
    }
    if (isset($_COOKIE['id']) && isset($_COOKIE['token']) && isset($_COOKIE['serial']))
    {echo "sss11";
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
         }


       }
    }
  }
  public static function createRecord($len){
    $string ="jif3t7038powkLfne93bhd03dwljlnzuyLEflpemiydwrioimwr6dop4-fv";
    $s ='';
    $r_new='';
    $r_old='';
    for ($i=1; $i < $len; $i++) {
      while($r_old == $r_new){
        $r_new = rand(0,30);
      }
      $r_old = $r_new;
      $s = $s.$string[$r_new];
    }
    return $s;
  }
}
 ?>
