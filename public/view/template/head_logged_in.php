<?php
  $stopper = 0;
  $res = $this->dbh->query("SELECT * FROM profiles WHERE userId=".$_SESSION['user']);
  $userRow=$res[0];
?>

<!DOCTYPE html>
<html> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['userName']; ?></title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="assets/css/style.css" type="text/css" />
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</spans>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="?route=userhome">Home</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <!--  
          <ul class="nav navbar-nav">
            <li class="active"><a href="http://www.codingcage.com/2015/01/user-registration-and-login-script-using-php-mysql.html">Back to Article</a></li>
            <li><a href="http://www.codingcage.com/search/label/jQuery">jQuery</a></li>
            <li><a href="http://www.codingcage.com/search/label/PHP">PHP</a></li>
          </ul>
          -->
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <span class="glyphicon glyphicon-user"></span>&nbsp;Hi&nbsp;<?php echo $userRow['userName']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="?route=profile_edit"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Edit Profile</a></li>
                <li><a href="?route=messages"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Messages</a></li>
                <li><a href="?route=my_connections"><span class="glyphicon glyphicon-log-out"></span>&nbsp;My Connections</a></li>
                <li><a href="?route=logout&logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

  <div id="main-wrapper">
    <div class="container">