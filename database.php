<?php

class linker{
    
    function read_config(){
        $config = array ();
    
        if ($file = fopen("db.config", "r")) {
            while(!feof($file)) {
                $line = fgets($file);
                array_push( $config, $this -> get_string_between($line, '[', ']') );
            }
            fclose($file);
    
            return array (
                "username" => $config[0],
                "password" => $config[1],
                "servername" => $config[2],
                "dbname" => $config[3],
                "home_url" => $config[4],
            );
        }else{
            die('CAN NOT OPEN db.config');
        }
    }

    function connect(){
        $config = $this -> read_config();

        // Create connection
        $conn = new mysqli($config["servername"], $config["username"],  $config["password"], $config["dbname"]);

        // Check connection
        if ($conn->connect_error) {
            die("CONNECTION FAIL: " . $conn -> connect_error);
        }else{
            error_log('CONNECTION IS GOOD');
            return $conn;
        } 
    }

    function safety_first($data) {
        $conn = $this -> connect();

        $data = str_replace(array("\n", "\r", "\r\n"), '', $data);
        $data = $conn->real_escape_string($data);
        $data = strip_tags($data);
        $data = htmlentities($data);
        
        return $data; 	
    }

    function find_url($connection, $col_name, $value){
        $sql = "SELECT id, url_short, url_real FROM links WHERE ".$col_name." LIKE '$value'";
        $res = $connection -> query( $sql );
        $row = mysqli_fetch_assoc($res);

        return($row);
    }

    function create_url($connection, $link, $short){
        $sql = "INSERT INTO links (url_short, url_real) VALUES ('$short', '$link')";
        $res = $connection -> query( $sql );

        return($res);
    }
    
    function main($url){
        $config = $this -> read_config();
        $conn = $this -> connect();
        $res = $this -> find_url($conn, "url_real", $url);
        $res_short = $this -> find_url($conn, "url_short", $url);

        if ($res['id']){
            //IF URL ALREADY BEEN USED RETURN IT
            error_log('LINK ALREADY EXISTS');
            return $res['url_short'];
        }elseif($res_short['id']){
            error_log('LINK ALREADY EXISTS AS SHORT');
            return $res_short['url_short'];
        }else{
            //CREATE SHORT URL
            $short_url = $this -> create_short($url);
            //REQUEST IF SHORT URL ALREADY EXISTS
            $res = $this -> find_url($conn, "url_short", $short_url);
            if ($res['id']){
                //CALL THiS FUNCTION AGAIN
                error_log('SHORT LINK ALREADY EXISTS');
                return $this -> main($url);
            }else{
                //PAST SHORT URL INTO DATABASE
                error_log('EVERYTHING IS FINE');
                $this -> create_url($conn, $url, $config["home_url"].$short_url);
                return $config["home_url"].$short_url;
            }
        }
    }

    function create_short($url){
        $abc = array (
            '0'=>'A',
            '1'=>'a',
            '2'=>'B',
            '3'=>'b',
            '4'=>'C',
            '5'=>'c',
            '6'=>'D',
            '7'=>'d',
            '8'=>'E',
            '9'=>'e',
            '-'=>'F',
        );
        //WHAT CAN BE BETTER THEN CRC32
        $temp = str_split(strval(crc32($url)));
        $res = '';
        foreach ($temp as $char){
            $res = $res.$abc[$char];
        }
        return($res);

    }

    function use_url($url){
        $config = $this -> read_config();
        $conn = $this -> connect();
        $res = $this -> find_url($conn, "url_short", $url);
        if ($res['id']){
            //RETURN REAL URL
            return $res['url_real'];
        }else{
            return $config['home_url'];
        }
    }

    //stackoverflow copy-paste function to get substring between two symbols
    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
    
}
?>