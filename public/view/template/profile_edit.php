 <form action="?route=profile_edit" method="POST">
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

    <form action="?route=profile_edit" method="POST" enctype="multipart/form-data">
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