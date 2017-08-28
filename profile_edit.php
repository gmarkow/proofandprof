  <?php
  ob_start();
  session_start();
  require_once 'dbconnect.php';
  $dbh = new dbconnection;
  
  // if session is not set this will redirect to login page
  if( !isset($_SESSION['user']) ) {
    header("Location: index.php");
    exit;
  }

  if(isset($_POST['profile_update'])){
    $inputs = $dbh->validate_inputs($_SESSION, $_POST);
    if(!$_SESSION['user']){
      echo "Error";
    }

    $query = create_update_query($inputs);
    if( $query ){ 
      $res = $dbh->upsert($query);
    } else {
      //$errors;
    }
  }

  $profile_data = $dbh->query(get_profile_query());
  // select loggedin users detail
  $res = $dbh->query("SELECT * FROM profiles WHERE userId=".$_SESSION['user']);
  $userRow=$res[0];
  require_once('templates/head_logged_in.php');
?>

      <form action="profile_edit.php" method="POST">
        <input id='profile_update' name='profile_update' type='hidden' value='1'>

        <label for='location_zip'>Zip</label>
        <p> <?php echo $userRow['location_zip']; ?></p>
        <input id='location_zip' name='location_zip' type='text' value='<?php echo $userRow['location_zip']?>'></input>
        
        <label for='user_introduction'>Introduction</label>
        <p> <?php echo $userRow['user_introduction']; ?></p>
        <textarea id='user_introduction' name='user_introduction' type='textarea'><?php echo $userRow['user_introduction']; ?></textarea>
        
        <label for='user_description'>Description</label>
        <p> <?php echo $userRow['user_description']; ?></p>
        <textarea id='user_description' name='user_description' type='textarea'><?php echo $userRow['user_description']; ?></textarea>
        
        <button type="submit">Submit Changes</button>
      </form>
    </div>
  </div>

    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>

<?php 
// $query = "UPDATE profiles SET user_introduction='" . $inputs['post']['user_introduction'] . "', user_description='" . $inputs['post']['user_description'] . "', location_zip='" . $inputs['post']['location_zip'] . "' WHERE userId=" . $inputs['session']['user'] ."";
function create_update_query($inputs){
  $query = "UPDATE profiles SET ";
  $newdata = 0;
  foreach ($inputs['post'] as $key => $value) {
    if($value != '' && $key != 'profile_update'){
      $query .= $key . "='" . $value . "',";
      $newdata = 1;
    }
  }

  $query = rtrim($query, ",");
  $query .= " WHERE userId=" . $inputs['session']['user'];

  if( $new_data = 1){
    return $query;
  } else {
    return 0;
  }

}

function get_profile_query(){
  $query = "SELECT location_zip, user_description, user_introduction, userEmail FROM profiles WHERE userId=" . $_SESSION['user']; 
  return $query;
}
ob_end_flush();
 ?>