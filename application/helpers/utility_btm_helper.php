<?php

function get_count($count)
{
    
    if ($count >=0 && $count <=999) {
            return $count;
    }
    elseif ($count >999 && $count <=9999) {
            $fst_chr = substr($count, 0, 1);
            $snd_chr = substr($count, 1, 1);
            return $fst_chr.'.'.$snd_chr.'K';
     }
     elseif ($count >9999 && $count <=99999) {
            $fst_chr = substr($count, 0, 2);
            $snd_chr = substr($count, 2, 1);
            return $fst_chr.'.'.$snd_chr.'K';
      }
      elseif ($count >99999 && $count <=999999) {
            $fst_chr = substr($count, 0, 3);
            $snd_chr = substr($count, 3, 1);
            return $fst_chr.'.'.$snd_chr.'K';
       }
       elseif ($count >999999 && $count <=9999999) {
            $fst_chr = substr($count, 0, 1);
            $snd_chr = substr($count, 1, 1);
            return $fst_chr.'.'.$snd_chr.'M';
        }
        

}

function validation_array_generator($fields,$fields_without_xss_filteration="",$not_required="",$labels=""){

    $arr=array();
    foreach ($fields as $key => $value) {

        $xss_filteration="xss_clean|";

        if ($fields_without_xss_filteration!="") {
            if (in_array($value, $fields_without_xss_filteration)) {
                $xss_filteration="";
            }
        }

        $required="|required";

        if ($not_required!="") {
            if (in_array($value, $not_required)) {
                $required="";
            }
        }

        if ($labels != "") {
            $label = $labels[$key];
        }
        else{
            $label = $value;
        }
            
        $arr["$value"]=array(
            
            "label"=>"$label",
            "field"=>"$value",
            "rules"=>"$xss_filteration"."trim".$required
        );
    }

    return $arr;
}


