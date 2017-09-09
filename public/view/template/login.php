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
  <div id="login-form">
    <form method="post" action="?route=login" autocomplete="off">
<div id="login-1">
  <p style="color:#E0E2DB;">I am a</p>
  <div class="col-lg-4" onclick="clickedIam('iam-gender-w')">
    <!-- <a href="?route=login"> -->
      <div id="iam-gender-w" class="login-link gender-w">
        <!-- <input id="iam-gender-w-radio" type="hidden" name="gender" value="female"> -->
        <p class="login-text">Woman</p>
      </div>
    <!-- </a> -->
  </div>
  <div class="col-lg-4" onclick="clickedIam('iam-gender-d')">
    <!-- <a href="?route=login"> -->
      <div id="iam-gender-d" class="login-link gender-d">
       <!-- <input id="iam-gender-d-radio" type="hidden" name="gender" value="other"> -->
        <p class="login-text">In Between</p>
      </div>
    <!-- </a> -->
  </div> 
  <div class="col-lg-4" onclick="clickedIam('iam-gender-m')">
    <!-- <a href="?route=login"> -->
      <div id="iam-gender-m" class="login-link gender-m">
        <p class="login-text">Man</p>
      </div>
    <!-- </a> -->
  </div>
</div>
  <input id="iam-gender-input" type="hidden" name="gender" value="">

<div id="login-2">
  <p style="color:#E0E2DB;">Looking for a</p>
  <div class="col-lg-4" onclick="clickedLooking('pick-gender-w')">
    <!-- <a href="?route=login"> -->
      <div id="pick-gender-w"  class="login-link gender-w">
        <input id="pick-gender-w-checkbox" type="hidden" name="pick-gender-w" value="">
        <p class="login-text">Woman</p>
      </div>
    <!-- </a> -->
  </div>
  <div class="col-lg-4" onclick="clickedLooking('pick-gender-d')">
    <!-- <a href="?route=login"> -->
      <div id="pick-gender-d" class="login-link gender-d">
        <input id="pick-gender-d-checkbox" type="hidden" name="pick-gender-d" value="">
        <p class="login-text">In Between</p>
      </div>
    <!-- </a> -->
  </div> 
  <div class="col-lg-4" onclick="clickedLooking('pick-gender-m')">
    <!-- <a href="?route=login"> -->
      <div id="pick-gender-m" class="login-link gender-m">
        <input id="pick-gender-m-checkbox" type="hidden" name="pick-gender-m" value="">
        <p class="login-text">Man</p>
      </div>
    <!-- </a> -->
  </div>
</div>


    
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
                <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
                  <input type="text" name="zipcode" class="form-control" placeholder="Enter Zip" maxlength="50" value="<?php echo $name ?>" />
                </div>
                <span class="text-danger"><?php echo $nameError; ?></span>
            </div>    

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
              <input type="text" name="name" class="form-control" placeholder="User Name" maxlength="50" value="<?php echo $name ?>" />
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
  function clickedLooking(id){
    $("#" + id).toggleClass(id);
    var checkboxStatus = $("#" + id + "-checkbox").attr('value');
    if( checkboxStatus == "true" ){ 
      $("#" + id + "-checkbox").attr('value', false);
    }else{
      $("#" + id + "-checkbox").attr('value', true);
    } 
  }

  function clickedIam(id){
    allIams = $(".iamSet");
    var iamId;
    for (var i = allIams.length - 1; i >= 0; i--) {
      iamId = allIams[i].id;
      $("#" + iamId).toggleClass('iamSet'); 
      $("#" + iamId).toggleClass(iamId); 
    }

    var gender = id.slice(-1);
    $("#" + id).toggleClass(id);
    $("#" + id).toggleClass('iamSet'); 
    $("#iam-gender-input").val(gender);
  }
</script>

<?php    require_once(VIEW_DIR . 'footer.php'); ?>