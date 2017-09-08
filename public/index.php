<?php
require_once('configs.php');
require_once('dbconnect.php');
require_once('secure_sessions.php');

$session = new SecureSessionHandler('cheese');

ini_set('session.save_handler', 'files');
session_set_save_handler($session, true);
session_save_path(PRIVATE_DIR . '/sessions');

$session->start();

if ( ! $session->isValid(5)) {
    $session->destroy();
}

//$session->put('hello.world', 'bonjour');
//echo $session->get('hello.world'); // bonjour

ob_start();
if( isset($_GET['route'])){
  $route = $_GET['route'];
  include('controller/' . $route . '.php');
  new $route;
} else {
  include('view/template/homepage.php');
}
ob_end_flush(); 
