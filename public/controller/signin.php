<?php


class signin
{
  public function __construct(){
  $dbh = new dbconnection;
  
  // it will never let you open index(login) page if session is set
  if ( isset($_SESSION['user'])!="" ) {
    header("Location: ?route=userhome");
    exit;
  }
  
  $error = false;
   
  $emailError = '';
  $email      = '';
  $passError  = '';
  if( isset($_POST['btn-login']) ) {  
    
    // prevent sql injections/ clear user invalid inputs
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);
    
    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    // prevent sql injections / clear user invalid inputs
    
    if(empty($email)){
      $error = true;
      $emailError = "Please enter your email address.";
    } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
      $error = true;
      $emailError = "Please enter valid email address.";
    }
    
    if(empty($pass)){
      $error = true;
      $passError = "Please enter your password.";
    }
    
    // if there's no error, continue to login
    if (!$error) {
      
      $password = hash('sha256', $pass); // password hashing using SHA256
    
      $res=$dbh->query("SELECT userId, userName, userPass FROM users WHERE userEmail='$email'");
      $row= $res;
      $count = sizeof($res); // if uname/pass correct it returns must be 1 row
      
      if( $count == 1 && $row[0]['userPass']==$password ) {
        $_SESSION['user'] = $row[0]['userId'];
        header("Location: ?route=userhome");
      } else {
        $errMSG = "Incorrect Credentials, Try again...";
      }
        
    }
    
  }

    include(VIEW_DIR . 'signin.php');
    require_once(VIEW_DIR . 'footer.php');
 
  }
}
?>