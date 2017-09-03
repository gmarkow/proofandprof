<?php
class userhome extends dbconnection
{
  function __construct(){

    require_once 'dbconnect.php';
    require_once (CONTROLLER_DIR . 'zips_api.php');
    $dbh = new dbconnection;
    $zips = new zipcodes;
      // if session is not set this will redirect to login page
      if( !isset($_SESSION['user']) ) {
          header("Location: index.php");
          exit;
      }
      // select loggedin users detail
      $res=$dbh->query("SELECT `userName`, `location_zip` FROM profiles WHERE userId=".$_SESSION['user']);
      $userRow=$res[0];
      if(isset($userRow['location_zip'])){
          $nearby_zips = $zips->get_zips($userRow['location_zip']);
          if($nearby_zips == "404"){
              echo "<h2>Zip Code Unknown</h2>";
          } else {
              $nearby_profiles_query = $this->get_nearby_users($nearby_zips);
              $nearby_profiles = $dbh->query($nearby_profiles_query); 
          }
      }
  require_once(VIEW_DIR . 'head_logged_in.php');
  include(VIEW_DIR . 'userhome.php');
  require_once(VIEW_DIR . 'footer.php');
  }

public function get_nearby_users($nearby_zips){
      //$query = "SELECT `userId`, `userName`, `user_introduction` FROM `profiles` WHERE `location_zip` IN ("; 
      //SELECT profiles.userId, `userName`, `user_introduction`, profiles_meta.value FROM `profiles` LEFT JOIN `profiles_meta` ON profiles_meta.userID = profiles.userId WHERE `location_zip` IN (";
      $query = "SELECT profiles.userId, `userName`, `user_introduction`, profiles_meta.value FROM `profiles` LEFT JOIN `profiles_meta` ON profiles_meta.userID = profiles.userId WHERE `location_zip` IN (";
      $zip_string = '';
      foreach ($nearby_zips as $nearby_zip) {
          $zip_string .= "'" . $nearby_zip->zip_code . "',";
      }
      $zip_string = rtrim($zip_string, ',');
      $query .= $zip_string . ") AND meta_type='1'";
      return $query;
  }


    
}
?>