<?php

//special case in seoera_sys
function get_csv_content($file_path="",$line_length=500) {
    $row = 1;
    $data=array();
    $new_row_data=array();
            
    if (($handle = fopen($file_path, "r")) !== FALSE) {
        //get line by line
        while (($data = fgetcsv($handle, $line_length, ",")) !== FALSE) {
            if ($row!=1) {
               $num = count($data);
                $row++;
                $row_data=explode(";",$data[0]);
                $needed_data=array();

                $needed_data["user_id_in_csv"]=$row_data[0];
                $needed_data["state"]=$row_data[4];
                $needed_data["time"]=$row_data[3];
                $needed_data["day_name"]=date("D",  strtotime($needed_data["time"]));

                $new_row_data[$row_data[0]][date('Y-m-d',  strtotime($row_data[3]))][$row_data[4]][]=$needed_data;

            }
            else
            {
                $row++;
            }
            
            
        }

        fclose($handle);
    }
    
    return $new_row_data;
}


function cmp_time_arr($a, $b) { 
    $a["time"]=  date("H:i",  strtotime($a["time"]));
    $b["time"]=  date("H:i",  strtotime($b["time"]));

    if($a["time"] == $b["time"]) {
        return 0;
    } 
    return ($a["time"] < $b["time"]) ? -1 : 1;
} 

