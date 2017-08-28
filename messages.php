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

  $inputs = $dbh->validate_inputs($_SESSION, $_POST);
  if(isset($_POST['send_message'])){
    $inputs['to_user'] = $dbh->search_for_user($inputs['post']['to']);
    $query = create_message_query($inputs);
    $dbh->upsert($query);
    
  }

  $query = get_latest_messages($inputs);
  $latest_messages = $dbh->query($query);
  // select loggedin users detail
  $res = $dbh->query("SELECT * FROM profiles WHERE userId=".$_SESSION['user']);
  $userRow=$res[0];
  require_once('templates/head_logged_in.php');
?>
    <p>New Message</p>
    <form action="messages.php" method="POST">
      <input id='send_message' name='send_message' type='hidden' value='1'>
      
      <label for='to'>Who To?</label>
      <input id='to' name='to' type='text' />

      <label for='subject'>Subject:</label>
      <input id='subject' name='subject' type='text' />

      <label for='body'>Message:</label>
      <textarea id='body' name='body' type='textarea'></textarea>

      <button type="submit">Send Message</button>
    </form>

    <p><?php echo $res[0]['userName']; ?>'s messages</p>
    <table>
      <th>From</th>
      <th>Subject</th>
    <?php
      foreach ($latest_messages as $message) {
        echo "<tr><td>". $message['userName'] ."</td><td><a href='conversations.php?from_user=" . $message['from'] . "'>" . $message['subject'] . "</a></td></tr>";
        # code...
      }
    ?>
    </table>
    </div>
    </div>

    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>

<?php 
  function create_message_query($inputs){
    $query = "INSERT INTO messages (`to`, `from`, `subject`, `body`, `read`, `time_sent`) VALUES ('" . $inputs['to_user']['userId'] . "', '" . $inputs['session']['user'] . "', '" . $inputs['post']['subject'] . "', '" . $inputs['post']['body'] . "', 0, " . time() . ")";
    return $query;
  }

  function get_latest_messages($inputs){
    $query = "SELECT userName, `from`, subject,  body FROM messages  LEFT JOIN `users` ON messages.from = users.userId WHERE  `time_sent` IN (SELECT MAX(time_sent) FROM messages GROUP BY `from`) AND `to`=" .$inputs['session']['user'];
    //$query = "SELECT * FROM messages WHERE `to`=" . $inputs['session']['user'] . " ";
    return $query;
  }

  ob_end_flush(); 
?>
