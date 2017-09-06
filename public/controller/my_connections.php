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
    $new_connections_query = 'INSERT INTO `connections` (`userId`, `connection_id`, `messaged_me`, `messaged_them`) VALUES ';
    $query = 'SELECT * FROM `connections` WHERE `userId`=' .$this->inputs['session']['user'] . ' AND connection_id IN (' ;
    $new_connections_values = '';
    $connection_id_query = 'SELECT `connection_id` FROM `connections` WHERE `userId`=' .$this->inputs['session']['user'];
    $connection_ids = $this->dbh->query($connection_id_query);
    foreach ($connection_ids as $connection_id) {
      $connections_array[$connection_id['connection_id']] = '1' ; 
    }

    foreach($this->connections as $key => $connection){
      $query .= $key . ', ';
      if(!isset($connections_array[$key])){
        $add_connection[$key]['from_me']   = (isset($connection['from_me']) ? '1' : '0');
        $add_connection[$key]['from_them'] = (isset($connection['from_them']) ? '1' : '0');
        $new_connections_values .= '('.$this->inputs['session']['user'].', ' . $key .   ', ' . $add_connection[$key]['from_them'] . ', ' . $add_connection[$key]['from_me'] . '),';
      }
    }

    $new_connections_values = rtrim($new_connections_values, ', ');
    $query = rtrim($query, ', ');
    $query = $query .= ')';
    
    if($new_connections_values != ''){
      $new_connections_query .= $new_connections_values; 
      $this->dbh->upsert($new_connections_query);
      $stopper = 0;
    }
    

    $connection_data = $this->dbh->query($query);
    foreach ($connection_data as $connection_d) {
      $this->connections[$connection_d['connection_id']]['met_in_person'] = $connection_d['met_in_person'];
      $this->connections[$connection_d['connection_id']]['vouch_online'] = $connection_d['vouch_online'];
      $this->connections[$connection_d['connection_id']]['vouch_afk'] = $connection_d['vouch_afk'];
    }
    return 0;

  }

  public function update_connection($connection_id){
    $met_in_person = (isset($this->inputs['post']['met_in_person']) ? '1' : '0' );  
    $vouch_online = (isset($this->inputs['post']['vouch_online']) ? '1' : '0' );  
    $vouch_afk = (isset($this->inputs['post']['vouch_afk']) ? '1' : '0' );  

    $query = "UPDATE connections SET `met_in_person`='" . $met_in_person . "', `vouch_online`='" . $vouch_online . "', `vouch_afk`='" . $vouch_afk . "' WHERE `userId`=" .$this->inputs['session']['user'] . " AND `connection_id`=" . $connection_id;// . " ON DUPLICATE KEY UPDATE `met_in_person`='" . $met_in_person . "', `vouch_online`='" . $vouch_online . "', `vouch_afk`='" . $vouch_afk . "'";
    $this->dbh->upsert($query);
  }
}