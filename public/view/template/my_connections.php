<?php

?>
<h2>Your Connections</h2>
<table>
  <tr>
    <th>Connection Name</th>
    <th>You Sent</th>
    <th>They Sent</th>
    <th>Met in Person</th>
    <th>Vouch Online</th>
    <th>Vouch AFK</th>
  </tr>
  
  <?php
    foreach ($this->connections as $userId => $value) {
      $from_me = ( isset($value['from_me']) ? $value['from_me'] : '');
      $from_them = (isset($value['from_them']) ? $value['from_them'] : '');
      echo '<tr><form method=\'POST\' action=?route=my_connections&update_connection=' . $userId . '>';
        echo '<td>'. $userId . '</td><td>' . $from_me . '</td><td>' . $from_them . '</td><td><input type=\'checkbox\' name=\'met_in_person\' id=\'met_in_person\'></td><td><input type=\'checkbox\' name=\'vouch_online\' id=\'vouch_online\'></td><td><input type=\'checkbox\' name=\'vouch_afk\' id=\'vouch_afk\'></td><td><button type=\'submit\'>Update Contact</button>'; 
      echo '</form></tr>';
    }
  ?>
  
</table>