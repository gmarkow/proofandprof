<?php
require_once(VIEW_DIR . 'head_logged_out.php');
?>
<!-- <!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Coding Cage - Login & Registration System</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body> -->

<div id="login-1">
  <p style="color:#E0E2DB;">I am a</p>
  <div class="col-lg-4">
    <a href="?route=login">
      <div id="gender-w" class="login-link">
        <p class="login-text">Woman</p>
      </div>
    </a>
  </div>
  <div class="col-lg-4">
    <a href="?route=login">
      <div id="gender-d" class="login-link">
        <p class="login-text">In Between</p>
      </div>
    </a>
  </div> 
  <div class="col-lg-4">
    <a href="?route=login">
      <div id="gender-m" class="login-link">
        <p class="login-text">Man</p>
      </div>
    </a>
  </div>
</div>

<div id="login-2">
  <p style="color:#E0E2DB;">Looking for a</p>
  <div id="pick-gender-w" class="col-lg-4" onclick="clicked('pick-gender-w')">
    <a href="?route=login">
      <div id="gender-w" class="login-link">
        <p class="login-text">Woman</p>
      </div>
    </a>
  </div>
  <div id="pick-gender-d" class="col-lg-4" onclick="clicked('pick-gender-d')">
    <a href="?route=login">
      <div id="gender-d" class="login-link">
        <p class="login-text">In Between</p>
      </div>
    </a>
  </div> 
  <div id="pick-gender-m" class="col-lg-4" onclick="clicked('pick-gender-m')">
    <a href="?route=login">
      <div id="gender-m" class="login-link">
        <p class="login-text">Man</p>
      </div>
    </a>
  </div>
</div>

  <div id="login-form">
    <form method="post" action="?route=login" autocomplete="off">
    
      <div class="col-md-12">
        
          <div class="form-group">
              <h2 class="">Sign Up.</h2>
            </div>
        
          <div class="form-group">
              <hr />
            </div>
            
            <?php
      if ( isset($errMSG) ) {
        
        ?>
        <div class="form-group">
              <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
        <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
              </div>
                <?php
      }
      ?>
            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
              <input type="text" name="name" class="form-control" placeholder="Enter Name" maxlength="50" value="<?php echo $name ?>" />
                </div>
                <span class="text-danger"><?php echo $nameError; ?></span>
            </div>
            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
              <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
              <input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
            
            <div class="form-group">
              <hr />
            </div>
            
            <div class="form-group">
              <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
            </div>
            
            <div class="form-group">
              <hr />
            </div>
            
            <div class="form-group">
              <a href="?route=signin">Sign in Here...</a>
            </div>
        
        </div>
   
    </form>
    </div>

<script>
  function clicked(id){
    $("#" + id).style('background-image', 'url(' +  + ')')
  }
</script>

<?php    require_once(VIEW_DIR . 'footer.php'); ?>