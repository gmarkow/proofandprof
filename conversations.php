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
  $inputs = $dbh->validate_inputs($_SESSION, $_POST, $_GET);

 if(isset($_POST['send_message'])){
  $inputs['to_user']['userId'] = $inputs['post']['to'];
  $query = create_message_query($inputs);
  $dbh->upsert($query);
  }


  $res = $dbh->query("SELECT * FROM profiles WHERE userId=".$_SESSION['user']);
  $userRow=$res[0];
  $conversations_query = get_conversations($inputs);
  $conversations = $dbh->query($conversations_query);
  
  require_once('templates/head_logged_in.php');
?>
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
            echo "<hr>";
          }
        ?>

    <p>Reply</p>
    <form action="conversations.php?from_user=<?php echo $inputs['get']['from_user']; ?>" method="POST">
      <input id='send_message' name='send_message' type='hidden' value='1'>
      
      <input id='to' name='to' type='hidden' value='<?php echo $inputs['get']['from_user']; ?>' />

      <label for='subject'>Subject:</label>
      <input id='subject' name='subject' type='text' />

      <label for='body'>Message:</label>
      <textarea id='body' name='body' type='textarea'></textarea>

      <button type="submit">Send Message</button>
    </form>


      </div>
    </div>

    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>

<?php
  function get_conversations($inputs){ 
      $query = "SELECT subject, body, time_sent, userName, `read`, userId FROM messages LEFT JOIN `users` ON messages.from = users.userId WHERE (`to`=" . $inputs['session']['user'] . " AND `from`=" . $inputs['get']['from_user'] . ") OR (`to`=" . $inputs['get']['from_user'] . " AND `from`=" . $inputs['session']['user'] . ") ORDER BY time_sent ASC";
      return $query;
  }

  function create_message_query($inputs){
    $query = "INSERT INTO messages (`to`, `from`, `subject`, `body`, `read`, `time_sent`) VALUES ('" . $inputs['to_user']['userId'] . "', '" . $inputs['session']['user'] . "', '" . $inputs['post']['subject'] . "', '" . $inputs['post']['body'] . "', 0, " . time() . ")";
    return $query;
  }

  function get_user_by($user_id){

  }