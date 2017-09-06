<?php
class my_connections
{
  function __construct(){
    $this->dbh = new dbconnection;
    $this->inputs = $this->dbh->validate_inputs($_SESSION, $_POST, $_GET);
    $this->connections = array();
    if(isset($_GET['update_connection'])){
      $this->update_connection($this->inputs['get']['update_connection']);
    }
    // $i_messaged = $this->i_messaged();
    // $messaged_me = $this->messaged_me();
    $this->merge_messages( $this->i_messaged(), $this->messaged_me() );
    $this->create_connections();

    require_once(VIEW_DIR . 'head_logged_in.php');
    require_once(VIEW_DIR . 'my_connections.php');
    require_once(VIEW_DIR . 'footer.php');
  }

  public function i_messaged(){
    $query = "SELECT DISTINCT `to` FROM messages WHERE `from`='" . $this->inputs['session']['user']. "'";
    $result = $this->dbh->query($query);
    return $result;
  }

  public function messaged_me(){
    $query = "SELECT DISTINCT `from` FROM messages WHERE `to`='" . $this->inputs['session']['user']. "'";
    $result = $this->dbh->query($query);
    return $result;
  }

  public function merge_messages($i_sent, $they_sent){
    foreach ($i_sent as $sent) {
      $this->connections[ $sent['to'] ]['from_me'] = '1';
    }

    foreach ($they_sent as $t_sent) {
      $this->connections[ $t_sent['from'] ]['from_them'] = '1';
    }
  }

  public function create_connections(){
    $query = 'SELECT * FROM `connections` WHERE `userId`=' .$this->inputs['session']['user'] . ' AND connection_id IN (' ;
    foreach($this->connections as $key => $connection){
      $query .= $key . ', ';
    }
    $query = rtrim($query, ', ');
    $query = $query .= ')';
    $result = $this->dbh->query($query);
    return $query;

  }

  public function update_connection($connection_id){
    $met_in_person = (isset($this->inputs['post']['met_in_person']) ? '1' : '0' );  
    $vouch_online = (isset($this->inputs['post']['vouch_online']) ? '1' : '0' );  
    $vouch_afk = (isset($this->inputs['post']['vouch_afk']) ? '1' : '0' );  

    $query = "INSERT INTO table (`met_in_person`, `vouch_online`, `vouch_afk`) VALUES ('" . $met_in_person . "', '" . $vouch_online . "', '" . $vouch_afk . "') WHERE `userId`=" .$this->inputs['session']['user'] . "AND `connection_id`=" . $connection_id . "ON DUPLICATE KEY UPDATE `met_in_person`='" . $met_in_person . "', `vouch_online`='" . $vouch_online . "', `vouch_afk`='" . $vouch_afk . "'";
    $stopper = 0;
  }
}