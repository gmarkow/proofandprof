<?php

class dbconnection
{

	public $dbh;
	function __construct(){
    $user     = 'gpmdate';
    $pass     = 'tshirt11';
    $dbname   = 'gpmdate';
    $host     = 'localhost';
		try {
		    $this->dbh = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass);
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    die();
		}
	}

	public function query($sql){
		$result = $this->dbh->query($sql)->fetchAll();
		return $result;
	}

  public function convert_user($id_or_name){
    if( is_int($id_or_name) ){
      $query = "SELECT userName FROM users WHERE userId=" . $id_or_name;
    } else {
      $query = "SELECT userId FROM users WHERE userName='" . $id_or_name . "'";
    }

    $result = $this->query($query);
    return $result[0][0];
  }

	public function upsert($sql){
		$result = $this->dbh->exec($sql);
		return $result;
	}

	public function search_for_user($search_item, $search_by = 'userName'){
  	if( $search_by == 'userName'){
  		$query = "SELECT * FROM profiles WHERE userName='" . $search_item . "'";
  	} elseif ( $search_by == 'userId') {
  		$query = "SELECT * FROM profiles WHERE userId='" . $search_item . "'";
  	} else {
  		return false;
  	}

  	$result = $this->query($query); 
  	$result = ( !$result ? false : $result[0]);
  	return $result;
  }

	public function validate_inputs($dirty_session = null, $dirty_post = null, $dirty_get = null){
		$post     = null;
		$session  = null;
    $get      = null;
    foreach ($dirty_session as $key => $value) {
      $session[$key] = filter_var($value, FILTER_VALIDATE_INT); 
    }

    
    foreach ($dirty_post as $key => $value) {
    	switch($key){
    		case 'location_zip':
      		$post[$key] = filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
      		break;
      	default:
      		$post[$key] = filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 
      		break;
      }
    }

    if( isset($dirty_get) ){
      foreach ($dirty_get as $key => $value) {
        $get[$key] = filter_var($value, FILTER_VALIDATE_INT); 
      }
    }

    $result = array(
      'session' => $session,
      'post'    => $post,
      'get'     => $get
      );

    return $result; 
  }

}
	