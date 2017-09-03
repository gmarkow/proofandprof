<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Coding Cage - Login & Registration System</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<div class="container">

  <div id="login-form">
    <form method="post" action="?route=signin" autocomplete="off">
    
      <div class="col-md-12">
        
          <div class="form-group">
              <h2 class="">Sign In.</h2>
            </div>
        
          <div class="form-group">
              <hr />
            </div>
            
            <?php
      if ( isset($errMSG) ) {
        
        ?>
        <div class="form-group">
              <div class="alert alert-danger">
        <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
              </div>
                <?php
      }
      ?>
            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
              <input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
              <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
            
            <div class="form-group">
              <hr />
            </div>
            
            <div class="form-group">
              <button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
            </div>
            
            <div class="form-group">
              <hr />
            </div>
            
            <div class="form-group">
              <a href="?route=login">Sign Up Here...</a>
            </div>
        
        </div>
   
    </form>