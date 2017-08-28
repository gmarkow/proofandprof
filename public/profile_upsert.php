<?php
  require_once 'dbconnect.php';
  $dbh = new dbconnection;
  ob_start();
  session_start();

  $inputs = validate_inputs();
  if(!$_SESSION['user']){
    echo "Error";
  }

  $query = "UPDATE profiles SET user_introduction='" . $inputs['post']['user_introduction'] . "', user_description='" . $inputs['post']['user_description'] . "' WHERE userId=" . $inputs['session']['user'] ."";
  $res = $dbh->upsert($query);

  ob_end_flush();
/*
  function validate_inputs(){

    foreach ($_SESSION as $key => $value) {
      $session[$key] = filter_var($value, FILTER_VALIDATE_INT); 
    }
    
    foreach ($_POST as $key => $value) {
      $post[$key] = filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 
    }

    $result = array(
      'session' => $session,
      'post'    => $post
      );

    return $result; 
  }
*/
?>