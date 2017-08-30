<?php 

class zipcodes 
{

  private $url;
  private $distance;
  private $units;
  private $zip;
  public function __construct(){
    $this->api_key = 'AsdCUnoFJr8n5rY4i36J5NhkRNjlS1btto5oMt3vVbT0DR5VUbEZZWkQJDcCFn59';
  }


  public function get_zips($distance = '25', $units = 'mi'){
    $this->distance = $distance;
    $this->units = $units;
    $zips_json = $this->curl_it();
  }

  public function curl_it(){
    $this->url = 'https://www.zipcodeapi.com/rest/'. $this->api_key . '/multi-radiusjson/'. $this->distance .'/' . $this->units;
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