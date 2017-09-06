    <p>New Message</p>
    <form action="?route=messages" method="POST"  enctype="multipart/form-data">
      <input id='send_message' name='send_message' type='hidden' value='1'>
      
      <label for='to'>Who To?</label>
      <input id='to' name='to' type='text' />
      <br>

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

    <p><?php echo $res[0]['userName']; ?>'s messages</p>
    <table>
      <th>From</th>
      <th>Subject</th>
    <?php
      foreach ($latest_messages as $message) {
        echo "<tr><td>". $message['userName'] ."</td><td><a href='?route=conversations&from_user=" . $message['from'] . "'>" . $message['subject'] . "</a></td></tr>";
      }
    ?>
    </table>