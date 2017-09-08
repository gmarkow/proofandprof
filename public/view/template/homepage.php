<?php

require_once(VIEW_DIR . 'head_logged_out.php');
//echo "homepage";
?>


<div class="col-lg-6">
  <a class="login-link" href="?route=login">
    <img src="assets/images/signup.png">
    <p>Sign Up</p>
  </a>
</div>

<div class="col-lg-6">
  <a class="login-link" href="?route=signin">
    <img src="assets/images/login.png">
    <p>Log In</p>
  </a>
</div>
<div class="clearfix"></div>

<?php    require_once(VIEW_DIR . 'footer.php'); ?>