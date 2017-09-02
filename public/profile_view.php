<?php
  ob_start();
  session_start();

  require_once 'dbconnect.php';
    require_once 'zips_api.php';
  $dbh = new dbconnection;
  $zips = new zipcodes;
    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }

    $get_profile_id = filter_var($_GET['userId'], FILTER_VALIDATE_INT);
    $profile_query = get_profile($get_profile_id);
    $user_profile = $dbh->query($profile_query);
    $user_profile = $user_profile[0];
    $profile_images = $dbh->query(get_profile_images($get_profile_id));
    $res=$dbh->query("SELECT `userName`, `location_zip` FROM profiles WHERE userId=".$_SESSION['user']);
    $userRow=$res[0];
    require_once('templates/head_logged_in.php');
    ?>
    <div class="page-header">
      <h3><?php echo $user_profile['userName']; ?>'s profile:</h3>
    </div>
    <p><?php echo $user_profile['user_introduction']; ?>
    <p><?php echo $user_profile['user_description']; ?>
    <?php 
      if(isset($profile_images)){
        foreach ($profile_images as $profile_image) {
          echo "<img style='height:50px; width:50px;' src='processor.php?file_path=".$profile_image['value']."'/><br>"; 
        }
      }
    ?>
<?php
  
  function get_profile($profile_id){
    $query = "SELECT `userName`, `user_description`, `user_introduction` FROM `profiles` WHERE `userId`='" . $profile_id ."'";
    return $query;
  }

  function get_profile_images($profile_id){
    $query = "SELECT `value` FROM `profiles_meta` WHERE `userId`='" . $profile_id ."' ORDER BY meta_type ASC";
    return $query;
  }

  ob_end_flush();
?>