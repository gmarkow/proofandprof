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