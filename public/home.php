<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
    require_once 'zips_api.php';
  $dbh = new dbconnection;
  $zips = new zipcodes;
  $zips->get_zips('34689');
	
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		header("Location: index.php");
		exit;
	}
	// select loggedin users detail
	$res=$dbh->query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
	$userRow=$res[0];
  require_once('templates/head_logged_in.php');
?>
   
    	<div class="page-header">
    	<h3>Coding Cage - Programming Blog</h3>
    	</div>
        
        <div class="row">
        <div class="col-lg-12">
        <h1>Focuses on PHP, MySQL, Ajax, jQuery, Web Design and more...</h1>
        </div>
        </div>
    
    </div>
    
    </div>
    
    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
</body>
</html>
<?php ob_end_flush(); ?>