<?php

class conversations extends dbconnection
{
  
  public function __construct(){
    $dbh = new dbconnection;
    
    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
      header("Location: index.php");
      exit;
    }
    $inputs = $dbh->validate_inputs($_SESSION, $_POST, $_GET);

   if(isset($_POST['send_message'])){
    $inputs['to_user']['userId'] = $inputs['post']['to'];
    $attachment_path = '';
     if( $_FILES['image_upload']['size'] != 0 ){
        $attachment_path = $this->do_image_upload($inputs);
        $inputs['attachment'] = $attachment_path;
      }

    $query = $this->create_message_query($inputs);
    $dbh->upsert($query);
    }


    $res = $dbh->query("SELECT * FROM profiles WHERE userId=".$_SESSION['user']);
    $userRow=$res[0];
    $conversations_query = $this->get_conversations($inputs);
    $conversations = $dbh->query($conversations_query);
    
    require_once(VIEW_DIR . 'head_logged_in.php');
    require_once(VIEW_DIR . 'conversations.php');
    require_once(VIEW_DIR . 'footer.php');
  }

  public function get_conversations($inputs){ 
      $query = "SELECT subject, body, time_sent, userName, `read`, userId, attachment FROM messages LEFT JOIN `users` ON messages.from = users.userId WHERE (`to`=" . $inputs['session']['user'] . " AND `from`=" . $inputs['get']['from_user'] . ") OR (`to`=" . $inputs['get']['from_user'] . " AND `from`=" . $inputs['session']['user'] . ") ORDER BY time_sent ASC";
      return $query;
  }

  public function create_message_query($inputs){
    $query = "INSERT INTO messages (`to`, `from`, `subject`, `body`, `read`, `attachment`, `time_sent`) VALUES ('" . $inputs['to_user']['userId'] . "', '" . $inputs['session']['user'] . "', '" . $inputs['post']['subject'] . "', '" . $inputs['post']['body'] . "', 0, '" . $inputs['attachment'] ."'," . time() . ")";
    return $query;
  }

  public function get_user_by($user_id){

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
           
          return substr($target_file, 3);;
      } else {
          echo "Sorry, there was an error uploading your file.";
      }
    }
  }
}
?>