      <p>Your conversation with <?php echo $this->dbh->convert_user($inputs['get']['from_user']); ?></p>
        <?php
          $options_array = array(
              "Not Rated",
              "Clearly a cut and paste intro/spam",
              "Asked to end contact",
              "Inappropriate Message",
              "Inappropriat Image",
              "I Feel threatned by this message"
              );
          $number_of_options = sizeof($options_array); 
          foreach ($conversations as $conversation) {

            $rate_this_message = '';
            if($conversation['userId'] == $inputs['session']['user']){
              echo "<p>From: you</p>";
            } else {
             echo "<p>From: " . $conversation['userName'] . "</p>";
             if($conversation['read'] == 0){echo "<span style='color:red'>New Message</span>";}
             $rate_this_message = 
          "<form action='?route=conversations&from_user=".$conversation['userId']."' method='POST'>
            <input id='message_index' name='message_index' type='hidden' value='" . $conversation['index'] . "'>
            <select id='message_rating' name='message_rating'>";
            for ($i=0; $i < $number_of_options; $i++) {
                if($i == $conversation['rating']){
                  $rate_this_message .= "<option selected value='".$i."'>" . $options_array[$i] . "</option>"; 
              }  else {
              $rate_this_message .= "<option value='".$i."'>" . $options_array[$i] . "</option>"; 
              }
            }
            $rate_this_message .= "</select> 
            <button type='submit'>Rate It</button>
          </form>";
            }
            echo "<p>Subject: " . $conversation['subject'] . "</p>";
            echo "<p>Time: " . date('Y-m-d H:i', $conversation['time_sent']) . "</p>";
            echo "<p>" . $conversation['body'] . "</p>";
            if($conversation['attachment'] != ''){
              echo "<img style='width:50px;height:50px;' src='processor.php?file_path=".$conversation['attachment']."'/>"; 
            }
            echo $rate_this_message;
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

