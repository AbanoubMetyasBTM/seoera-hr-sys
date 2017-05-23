<?php


    /**
     * Dump helper. Functions to dump variables to the screen, in a nicley formatted manner.
     * @author Joost van Veen
     * @version 1.0
     */
    if (!function_exists('dump')) {
        function dump ($var, $label = 'Dump', $echo = TRUE)
        {
            // Store dump in variable 
            ob_start();
            var_dump($var);
            $output = ob_get_clean();

            // Add formatting
            $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
            $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;width: 50%;margin: 0 auto;">' . $label . ' => ' . $output . '</pre>';

            // Output
            if ($echo == TRUE) {
                echo $output;
            }
            else {
                return $output;
            }
        }
    }


    if (!function_exists('dump_exit')) {
        function dump_exit($var, $label = 'Dump', $echo = TRUE) {
            dump ($var, $label, $echo);
            exit;
        }
    }
    
    
    function get_words($str,$num_of_words)
    {
        $word_arr=  explode(" ", $str);
        $word_arr=  array_slice($word_arr,0,$num_of_words);
        
        return implode(" ", $word_arr);
    }
    
    
    function resize_image($file, $w, $h, $crop=FALSE) {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width-($width*abs($r-$w/$h)));
            } else {
                $height = ceil($height-($height*abs($r-$w/$h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w/$h > $r) {
                $newwidth = $h*$r;
                $newheight = $h;
            } else {
                $newheight = $w/$r;
                $newwidth = $w;
            }
        }
        $src = imagecreatefromjpeg($file);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        return $dst;
    }
    
    
    function cms_upload($user_id=0,$files,$folder,$width=0,$height=0)
    {
        $uploaded=array();
        //check if folder_exist
        $CI=&get_instance();
        $url=$CI->config->item("upload_url")."$folder";
        if (!file_exists($url)) {
            mkdir($url,0777,TRUE);
        }
        
        //upload
        if (!empty($_FILES[$files])) {
            foreach ($_FILES[$files]['name'] as $key => $name) {
                
                $ext = pathinfo($name, PATHINFO_EXTENSION); 
                if (in_array($ext, array("mp4","jpeg","png","jpg","MP4","JPEG","PNG","JPG","csv","CSV"))) {
                    //encrypt $name
                    $name=md5($name."student_activities".date('Y-m-d H:i:s').$user_id.$key.time()).".".$ext;
                    if ($_FILES[$files]['error'][$key]==0&&move_uploaded_file($_FILES[$files]['tmp_name'][$key],$url.'/'.$name)) {
                       
                        if ($width>0&&$height>0&&in_array($ext, array("jpeg","png","jpg","JPEG","PNG","JPG"))) {
                            smart_resize_image($url.'/'.$name,null,$width,$height,false,$url.'/'.$name);
                        }
                        
                        $uploaded[]= "uploads/$folder/".$name;
                    }
                    else
                    {
                        $uploaded[]=$_FILES[$files]['error'][$key];
                    }
                }
                else
                {
                    return "not allowed type";
                }
            }//end foreach

        }
        else{
            // dump("No files are selected");
            $error_msg="No files are selected";
        }
        if (!empty($error_msg)) {
            return $error_msg;
        }
        return $uploaded;
    }
    
    function datetime_now()
    {
        return date("Y-m-d H:i:s");
    }
    
    
    function get_time($oldtime)
    {
        $old_Date=new DateTime($oldtime);
        $now_date=new DateTime();
        $diff=$now_date->diff($old_Date);

        if ($diff->y >0) {
            return date("Y",  strtotime($oldtime));
        }
        else if($diff->m >0||$diff->d>7){
            return date("F j, Y",strtotime($oldtime)); 
        }
        else if($diff->d >0){
            return date('D H:m', strtotime($oldtime));
        }
        else if($diff->h >0){
            return date('g:i a',strtotime($oldtime));
        }
        else if($diff->i >0)
        {
            return "$diff->i min";
        }
        else
        {
            return "now";
        }
    }
    
    function convert_inside_obj_to_arr($objs,$col)
    {
        $arr=array();
        foreach ($objs as $key => $obj) {
            $arr[]=$obj->$col;
        }
        return $arr;
    }
    
    
    function string_safe($string) { 
        $except = array('\\', '/', ':', '*', '?', '"', '<', '>', '|',' '); 
        return str_replace($except, '', $string); 
    } 
    
    
    function convertCurrency($amount, $from, $to){
        $url  = "https://www.google.com/finance/converter?a=$amount&from=$from&to=$to";
        $data = file_get_contents($url);
        preg_match("/<span class=bld>(.*)<\/span>/",$data, $converted);
        $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
        return round($converted, 2);
    }
    
    function get_currency_convet_rate($from="USD", $to="EGP")
    {
        
        $url  = "http://rate-exchange.herokuapp.com/fetchRate?from=$from&to=$to";
        $data = file_get_contents($url);
        $data=  json_decode($data);
        
        return $data->Rate;
    }
    
    function format_currency($value) {
        return round($value, 2);
    }

    
    function split_word_into_chars($word,$number_of_chars,$include_end_of_text="yes")
    {
        $number_of_chars=$number_of_chars/3;
        
        $arr = str_split($word, 3);
        
        $arr=  array_slice($arr, 0,$number_of_chars);
        
        if ($include_end_of_text=="yes") {
            $arr[]=" ...";
        }
        
        return implode("",$arr);
    }
    
    
    function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }
    
    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']) )
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    
    
    function cmp_price_value($a, $b)
    {
        //return strcmp(doubleval($b->price), doubleval($a->price));
        return strcmp(doubleval($a->price), doubleval($b->price));

    }