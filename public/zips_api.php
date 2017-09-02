<?php 

class zipcodes 
{

  private $url;
  private $distance;
  private $units;
  private $zip;
  private $dbh;
  public function __construct(){
    $this->api_key = 'S0eRxKN5DPHwtSCBlYoAWzh3Y1S7vosnoHfWr225RJClBeWXdky9UPdSQ5ZmtsKS';
    $this->dbh = new dbconnection;
  }


  public function get_zips($zip, $distance = '25', $units = 'mi'){
    $this->distance = $distance;
    $this->units = $units;
    $this->zip = $zip;
    $zips_json = $this->stored_already($zip);
    if( !$zips_json){
      $zips_json = $this->curl_it();
      $zips = $this->store_it($zips_json);
    } else {
      $zips_1 = json_decode($zips_json['nearby']);
      $zips = $zips_1->zip_codes;
    }

    return $zips;
  }

  public function store_it($zips_json){
    $datum = json_decode($zips_json);
    if(isset($datum->error_code)){
      return "404";
    }
    foreach ($datum->zip_codes as $data) {
      if($data->zip_code == $this->zip){
        $township = $data->city;
      }
    }

    $query = "INSERT INTO `locations` (`zip`, `township`, `nearby`) VALUES ('".$this->zip."', '" . $township .  "', '" . $zips_json . "')";
    $this->dbh->upsert($query);
    return $datum->zip_codes;

  }

  public function stored_already(){
    $query  = "SELECT * FROM `locations` WHERE `zip`=" . $this->zip;
    $result = $this->dbh->query($query);
    if(!isset($result[0])){
      return 0;
    }

    return $result[0];
  }

  public function curl_it(){
    $this->url = 'https://www.zipcodeapi.com/rest/'. $this->api_key . '/radius.json/' . $this->zip .'/'. $this->distance .'/' . $this->units;
        // create curl resource 
    $ch = curl_init(); 
    
    // set url 
    curl_setopt($ch, CURLOPT_URL, $this->url); 

    //return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    // $output contains the output string 
    $result = curl_exec($ch); 

    // close curl resource to free up system resources 
    curl_close($ch); 
    return $result;

  }



}