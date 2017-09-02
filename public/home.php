<?php
	ob_start();
	session_start();

	require_once 'dbconnect.php';
    require_once 'zips_api.php';
  $dbh = new dbconnection;
  $zips = new zipcodes;
    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    // select loggedin users detail
    $res=$dbh->query("SELECT `userName`, `location_zip` FROM profiles WHERE userId=".$_SESSION['user']);
    $userRow=$res[0];
    $nearby_zips = $zips->get_zips($userRow['location_zip']);
    $nearby_profiles_query = get_nearby_users($nearby_zips);
    $nearby_profiles = $dbh->query($nearby_profiles_query);	
  require_once('templates/head_logged_in.php');
?>
   
    	<div class="page-header">
    	<h3>Near You</h3>
    	</div>
        
        <?php
            $i = 0;
            echo "<div class='row'>";
            foreach ($nearby_profiles as $nearby_profile) {
                if($i % 3 === 0){echo "</div><div class='row'>";}
                echo "<div class='col-lg-4'>";
                    echo "<div class='profile-summary-container'>";
                        echo "<h4>" . $nearby_profile['userName'] . "</h4>";
                        echo "<a href='profile_view.php?userId=" . $nearby_profile['userId'] . "'>View " . $nearby_profile['userName'] . "</a>";
                    echo "</div>";
                echo "</div>";
                $i++;
            }
            echo "</div>";
        ?>
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

<?php 

    function get_nearby_users($nearby_zips){
        $query = "SELECT `userId`, `userName`, `user_introduction` FROM `profiles` WHERE `location_zip` IN ("; 
        $zip_string = '';
        foreach ($nearby_zips as $nearby_zip) {
            $zip_string .= "'" . $nearby_zip->zip_code . "',";
        }
        $zip_string = rtrim($zip_string, ',');
        $query .= $zip_string . ")";
        return $query;
    }

ob_end_flush();
?>