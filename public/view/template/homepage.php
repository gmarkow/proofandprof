<?php

require_once(VIEW_DIR . 'head_logged_out.php');
?>


<div class="col-lg-6">
  <a href="?route=login">
    <div id="signin-link" class="login-link">
    <!-- <img src="assets/images/signup.png"> -->
    <p class="login-text">Sign Up</p>
    </div>
  </a>
</div>

<div class="col-lg-6">
  <a href="?route=signin">
    <div  id="login-link" class="login-link">
    <!-- <img src="assets/images/login.png"> -->
    <p class="login-text">Log In</p>
    </div>
  </a>
</div>
<div class="clearfix"></div>

<?php    require_once(VIEW_DIR . 'footer.php'); ?>