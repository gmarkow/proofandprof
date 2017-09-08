<?php

class login
{
  
  public function __construct(){

  if( isset($_SESSION['user'])!="" ){
    //header("Location: ?route=home");
  }
  $dbh = new dbconnection;

  $error = false;

  $emailError = '';
  $email      = '';
  $passError  = '';
  $name = '';
  $nameError = '';
  

  if ( isset($_POST['btn-signup']) ) {
    
    // clean user inputs to prevent sql injections
    $name = trim($_POST['name']);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);
    
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);
    
    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    
    // basic name validation
    if (empty($name)) {
      $error = true;
      $nameError = "Please enter your full name.";
    } else if (strlen($name) < 3) {
      $error = true;
      $nameError = "Name must have atleat 3 characters.";
    } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
      $error = true;
      $nameError = "Name must contain alphabets and space.";
    }
    
    //basic email validation
    if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
      $error = true;
      $emailError = "Please enter valid email address.";
    } else {
      // check email exist or not
      $query = "SELECT userEmail FROM users WHERE userEmail='$email'";
      $result = $dbh->query($query);
      $count = sizeof($result);
      if($count!=0){
        $error = true;
        $emailError = "Provided Email is already in use.";
      }
    }
    // password validation
    if (empty($pass)){
      $error = true;
      $passError = "Please enter password.";
    } else if(strlen($pass) < 6) {
      $error = true;
      $passError = "Password must have atleast 6 characters.";
    }
    
    // password encrypt using SHA256();
    $password = hash('sha256', $pass);
    
    // if there's no error, continue to signup
    if( !$error ) {
      
      $query = "INSERT INTO users(userName,userEmail,userPass) VALUES('$name','$email','$password')";
      $res = $dbh->upsert($query);
      $query = "SELECT userId FROM users WHERE userEmail='$email' AND userName='$name'";
      $recordId = $dbh->query($query);
      $recordId = $recordId[0]['userId'];
      $query = "INSERT INTO profiles(userId, userName, userEmail) VALUES('$recordId', '$name', '$email')";
      $dbh->upsert($query);
      $query = "INSERT INTO profiles_meta(userId, meta_type, value, timestamp) VALUES('$recordId', '1', '', " . time() . ")";
      $dbh->upsert($query);
      if ($res == '1') {
        $errTyp = "success";
        $errMSG = "Successfully registered, you may login now";
        //unset($name);
        //unset($email);
        unset($pass);
      } else {
        $errTyp = "danger";
        $errMSG = "Something went wrong, try again later..."; 
      } 
        
    }
    
    
  }
    include(VIEW_DIR . 'login.php');
    require_once(VIEW_DIR . 'footer.php');
  }
  
}

?>