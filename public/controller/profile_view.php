<?php 
class profile_view
{
  function __construct(){

    require_once 'zips_api.php';
    $this->dbh = new dbconnection;
    $zips = new zipcodes;
      // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }

    $get_profile_id = filter_var($_GET['userId'], FILTER_VALIDATE_INT);
    $profile_query = $this->get_profile($get_profile_id);
    $user_profile = $this->dbh->query($profile_query);
    $user_profile = $user_profile[0];
    $profile_images = $this->dbh->query($this->get_profile_images($get_profile_id));

    require_once(VIEW_DIR . '/head_logged_in.php');
    require_once(VIEW_DIR . '/profile_view.php');
    require_once(VIEW_DIR . 'footer.php');

  }

  public function get_profile($profile_id){
    $query = "SELECT `userName`, `user_description`, `user_introduction` FROM `profiles` WHERE `userId`='" . $profile_id ."'";
    return $query;
  }

  public function get_profile_images($profile_id){
    $query = "SELECT `value` FROM `profiles_meta` WHERE `userId`='" . $profile_id ."' ORDER BY meta_type ASC";
    return $query;
  }

}
?>