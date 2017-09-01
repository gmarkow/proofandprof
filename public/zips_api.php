<?php 

class zipcodes 
{

  private $url;
  private $distance;
  private $units;
  private $zip;
  public function __construct(){
    $this->api_key = 'S0eRxKN5DPHwtSCBlYoAWzh3Y1S7vosnoHfWr225RJClBeWXdky9UPdSQ5ZmtsKS';
  }


  public function get_zips($zip, $distance = '25', $units = 'mi'){
    $this->distance = $distance;
    $this->units = $units;
    $this->zip = $zip;
    $this->stored_already();
    $zips_json = $this->curl_it();
    $zips = json_decode($zips_json);
  }

  public function stored_already(){
    //$stoper =0;
    $newdbh = new dbconnection;
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
    $result = json_decode($result);

    // close curl resource to free up system resources 
    curl_close($ch); 
    return $result;

  }



}