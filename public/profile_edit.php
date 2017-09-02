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

  if( isset($_POST['profile_update']) || isset($_POST['profile_add_image']) ){
    $inputs = $dbh->validate_inputs($_SESSION, $_POST);
    if(!$_SESSION['user']){
      echo "Error";
    }

    if( isset($_POST['profile_update'])){
      $query = create_update_query($inputs);
      if( $query ){ 
        $res = $dbh->upsert($query);
      } else {
        //$errors;
      }
    } else {
      $inputs['attachment'] = '';
      if( $_FILES['image_upload']['size'] != 0 ){
        $attachment_path = do_image_upload($inputs);
        $inputs['attachment'] = $attachment_path;
        if(isset($inputs['post']['make_image_default'])){
          if($inputs['post']['make_image_default'] == 'on'){
            $inputs['meta_type'] = 1;
            $query2 = "UPDATE `profiles_meta` SET `meta_type` = '2' WHERE `userId`='" . $_SESSION['user'] . "' AND `meta_type`='1'";
            $dbh->upsert($query2);
            $query2 = "DELETE FROM  `profiles_meta` WHERE `userId`='" . $_SESSION['user'] . "' AND `value`=''";
            $dbh->upsert($query2);
          } else {
            $inputs['meta_type'] = 2;
          }
        } else {
            $inputs['meta_type'] = 2;
        }
        $upload_image_query = upload_image_query($inputs);
        $dbh->upsert($upload_image_query);
      }
    }
  }

  $profile_data = $dbh->query(get_profile_query());
  $profile_images = $dbh->query(get_profile_images());
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

    <form action="profile_edit.php" method="POST" enctype="multipart/form-data">
      <input id='profile_add_image' name='profile_add_image' type='hidden' value='1'>

      <label for='image_upload'>Upload a sweet image:</label>
      <input type="file" name="image_upload" id="image_upload">

      <label for="make_image_default">Make this your profile image?</label>
      <input type="checkbox" name="make_image_default" id="make_image_default">
      <br>
      
      <button type="submit">Up it!</button>
    </form>

    <?php
      foreach ($profile_images as $profile_image) {
         echo "<img style='height:50px; width:50px;' src='processor.php?file_path=".$profile_image['value']."'/>"; 
      }
    ?>
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

function get_profile_images(){
  $query = "SELECT `value`, `meta_type` FROM profiles_meta WHERE userId=" . $_SESSION['user'] . " ORDER BY `meta_type` ASC"; 
  return $query;
}

  function upload_image_query($inputs){
    $query = "INSERT INTO `profiles_meta` (`userId`, `meta_type`, `value`, `timestamp`) VALUES ('" . $inputs['session']['user'] . "', '" . $inputs['meta_type'] . "','" . $inputs['attachment'] ."','" . time() . "')";
    return $query;
  }

  function do_image_upload($inputs){
    $target_dir = "../private/" . $inputs['session']['user'] . "/pictures/";
    $target_file = $target_dir . basename($_FILES["image_upload"]["name"]);

    if ( !file_exists($target_dir) ){
      mkdir($target_dir, 0644, true);
    }


    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $check = getimagesize($_FILES["image_upload"]["tmp_name"]);

    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["image_upload"]["tmp_name"], $target_file)) {
          echo "The file ". basename( $_FILES["image_upload"]["name"]). " has been uploaded.";
           
          return substr($target_file, 3);

      } else {
          echo "Sorry, there was an error uploading your file.";
      }
    }

  
  }

ob_end_flush();
 ?>