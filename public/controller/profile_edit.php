<?php 
class profile_edit{
  function __construct(){

  $this->dbh = new dbconnection;
  
  // if session is not set this will redirect to login page
  if( !isset($_SESSION['user']) ) {
    header("Location: index.php");
    exit;
  }

  if( isset($_POST['profile_update']) || isset($_POST['profile_add_image']) ){
    $inputs = $this->dbh->validate_inputs($_SESSION, $_POST);
    if(!$_SESSION['user']){
      echo "Error";
    }

    if( isset($_POST['profile_update'])){
      $query = $this->create_update_query($inputs);
      if( $query ){ 
        $res = $this->dbh->upsert($query);
      } else {
        //$errors;
      }
    } else {
      $inputs['attachment'] = '';
      if( $_FILES['image_upload']['size'] != 0 ){
        $attachment_path = $this->do_image_upload($inputs);
        $inputs['attachment'] = $attachment_path;
        if(isset($inputs['post']['make_image_default'])){
          if($inputs['post']['make_image_default'] == 'on'){
            $inputs['meta_type'] = 1;
            $query2 = "UPDATE `profiles_meta` SET `meta_type` = '2' WHERE `userId`='" . $_SESSION['user'] . "' AND `meta_type`='1'";
            $this->dbh->upsert($query2);
            $query2 = "DELETE FROM  `profiles_meta` WHERE `userId`='" . $_SESSION['user'] . "' AND `value`=''";
            $this->dbh->upsert($query2);
          } else {
            $inputs['meta_type'] = 2;
          }
        } else {
            $inputs['meta_type'] = 2;
        }
        $upload_image_query = $this->upload_image_query($inputs);
        $this->dbh->upsert($upload_image_query);
      }
    }
  }

  $profile_data = $this->dbh->query($this->get_profile_query());
  $profile_images = $this->dbh->query($this->get_profile_images());

  require_once(VIEW_DIR . '/head_logged_in.php');
  require_once(VIEW_DIR . '/profile_edit.php');
  require_once(VIEW_DIR . 'footer.php');

  }


  public function create_update_query($inputs){
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

public function get_profile_query(){
  $query = "SELECT location_zip, user_description, user_introduction, userEmail FROM profiles WHERE userId=" . $_SESSION['user']; 
  return $query;
}

public function get_profile_images(){
  $query = "SELECT `value`, `meta_type` FROM profiles_meta WHERE userId=" . $_SESSION['user'] . " ORDER BY `meta_type` ASC"; 
  return $query;
}

  public function upload_image_query($inputs){
    $query = "INSERT INTO `profiles_meta` (`userId`, `meta_type`, `value`, `timestamp`) VALUES ('" . $inputs['session']['user'] . "', '" . $inputs['meta_type'] . "','" . $inputs['attachment'] ."','" . time() . "')";
    return $query;
  }

public function do_image_upload($inputs){
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
}
?>