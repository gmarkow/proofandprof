      <p>Your conversation with <?php echo $dbh->convert_user($inputs['get']['from_user']); ?></p>
        <?php
          foreach ($conversations as $conversation) {

            if($conversation['userId'] == $inputs['session']['user']){
              echo "<p>From: you</p>";
            } else {
             echo "<p>From: " . $conversation['userName'] . "</p>";
            }
            echo "<p>Subject: " . $conversation['subject'] . "</p>";
            echo "<p>Time: " . date('Y-m-d H:i', $conversation['time_sent']) . "</p>";
            echo "<p>" . $conversation['body'] . "</p>";
            if($conversation['attachment'] != ''){
              echo "<img src='processor.php?file_path=".$conversation['attachment']."'/>"; 
            }
            echo "<hr>";
          }
        ?>

    <p>Reply</p>
    <form action="?route=conversations&from_user=<?php echo $inputs['get']['from_user']; ?>" method="POST" enctype="multipart/form-data">
      <input id='send_message' name='send_message' type='hidden' value='1'>
      
      <input id='to' name='to' type='hidden' value='<?php echo $inputs['get']['from_user']; ?>' />

      <label for='subject'>Subject:</label>
      <input id='subject' name='subject' type='text' />
      <br>

      <label for='body'>Message:</label>
      <textarea id='body' name='body' type='textarea'></textarea>
      <br>

      <label for='image_upload'>Upload a sweet image:</label>
      <input type="file" name="image_upload" id="image_upload">
      <br>

      <button type="submit">Send Message</button>
    </form>