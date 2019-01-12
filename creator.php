<?php
require_once('database.php');

if (isset($_GET['url'])){
    $db = new linker;
    //SAFETY FIRST
    $url = $db -> safety_first($_GET['url']);

    if (filter_var($url, FILTER_VALIDATE_URL)) {
        //CHECK IF THIS IS A REAL URL
        $output = $db -> main($url);
        print($output);
    }else{
        //ERROR NOT A URL
    }
}
?>