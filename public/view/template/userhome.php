<?php
require_once(VIEW_DIR . 'head_logged_in.php');
?>


<div class="page-header">
      <h3>Near You</h3>
      </div>
        
        <?php
            if(isset($userRow['location_zip']) && isset($nearby_profiles)){
                $i = 0;
                echo "<div class='row'>";
                foreach ($nearby_profiles as $nearby_profile) {
                    if($i % 3 === 0){echo "</div><div class='row'>";}
                    echo "<div class='col-lg-4'>";
                        echo "<div class='profile-summary-container'>";
                            echo "<h4>" . $nearby_profile['userName'] . "</h4>";
                            echo "<img style='height:50px; width:50px;' src='processor.php?file_path=".$nearby_profile['value']."'/><br>"; 
                            echo "<a href='?route=profile_view&userId=" . $nearby_profile['userId'] . "'>View " . $nearby_profile['userName'] . "</a>";
                        echo "</div>";
                    echo "</div>";
                    $i++;
                }
                echo "</div>";
            } else {
                echo "<h1>We need to know where you'd like us to search!!</h1>";
            }
        ?>
        <div class="row">
        <div class="col-lg-12">
        <h1>Focuses on PHP, MySQL, Ajax, jQuery, Web Design and more...</h1>
        </div>
        </div>