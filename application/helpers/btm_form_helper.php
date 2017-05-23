<?php

function generate_img_tags_for_form($filed_name,$filed_label,$required_field="",$checkbox_field_name,$need_alt_title="yes",$required_alt_title="",$old_path_value="",$old_title_value="",$old_alt_value="",$recomended_size="",$disalbed="",$displayed_img_width="50",$display_label="" ){
    $filed_name_id=$filed_label."id";
    $filed_name_id_jquery="#".$filed_name_id;
    
    $checkbox_field_name_id=$checkbox_field_name."id";
    $checkbox_field_name_id_jquery="#".$checkbox_field_name_id;
    
    $title_field_name=$filed_label."title";
    $alt_field_name=$filed_label."alt";

    
    $html_tags='<script type="text/javascript">';
        $html_tags.='$(function(){';
            $html_tags.='$("'.$checkbox_field_name_id_jquery.'").change(function(){';
                $html_tags.='var check=$(this).is(":checked");';
                $html_tags.='if (check==true) {';
                    $html_tags.='$("'.$filed_name_id_jquery.'").removeAttr("disabled")';
                $html_tags.='}';            
                $html_tags.='else{';
                    $html_tags.='$("'.$filed_name_id_jquery.'").attr("disabled","disabled");';
                $html_tags.='}';
            $html_tags.='});';
        $html_tags.='});';
    
    $html_tags.='</script>';

    $html_tags.='<div class="col-md-12 form-group">';    
        $html_tags.='<label for="">'.$display_label.' '.$recomended_size.'</label>';
        $html_tags.='<div class="col-md-12">';
        
            $html_tags.='<div class="col-md-4">';
                $html_tags.='<input type="file" class="form-control" name="'.$filed_name.'" '.$disalbed.' id="'.$filed_name_id.'" '.$required_field.' >';
            $html_tags.='</div>';
            
            if ($need_alt_title=="yes") {
                $html_tags.='<div class="col-md-4">';
                    $html_tags.='<input type="text" class="form-control" placeholder="image title" name="'.$title_field_name.'" '.$required_alt_title.' value="'.$old_title_value.'">';
                $html_tags.='</div>';

                $html_tags.='<div class="col-md-4">';
                    $html_tags.='<input type="text" class="form-control" placeholder="image alt" name="'.$alt_field_name.'" '.$required_alt_title.' value="'.$old_alt_value.'">';
                $html_tags.='</div>';
            }
            
        $html_tags.='</div>';
        
        if ($disalbed!="") {
            $html_tags.='<div class="col-md-12">';
                $html_tags.='<div class="col-md-4">';

                    $html_tags.='<div class="row-fluid">';
                        $html_tags.='<img src="'.$old_path_value.'" alt="'.$old_alt_value.'" title="'.$old_title_value.'" width="'.$displayed_img_width.'">';
                    $html_tags.='</div>';

                    $html_tags.='<div class="row-fluid">';
                        $html_tags.='<input type="checkbox" name="'.$checkbox_field_name.'" id="'.$checkbox_field_name_id.'">:upload new image';
                    $html_tags.='</div>';

                $html_tags.='</div>';
            $html_tags.='</div>';
        }
        
        
    $html_tags.='</div>';

    return $html_tags;
}

function generate_inputs_html($labels_name , $fields_name , $required , $type , $values , $class)
{
    $html_tags = "";
    
    foreach ($fields_name as $key => $value) {
        
        $html_tags.='<div class="col-md-12 form-group">';    
            $html_tags.='<label for="">'.$labels_name[$key].'</label>';
            $html_tags.='<div>';
            
            if ($type[$key] == 'textarea') {
                
                $html_tags .= '<textarea name="'.$value.'" style="resize:vertical" class="form-control '.$class[$key].'" id="'.$fields_name[$key].'_id">'.$values[$key].'</textarea>';
                
            }
            else if($type[$key] == 'number')
            {
                $html_tags.='<input type="'.$type[$key].'" step="0.01" class="form-control '.$class[$key].'" '.$required[$key].' name="'.$value.'" value="'.$values[$key].'" id="'.$fields_name[$key].'_id" >';

            }
            else{
                
                $html_tags.='<input type="'.$type[$key].'" class="form-control '.$class[$key].'" '.$required[$key].' name="'.$value.'" value="'.$values[$key].'" id="'.$fields_name[$key].'_id" >';
                
            }

            $html_tags.='</div>';
        $html_tags.='</div>';
        
    }
    
    
    return $html_tags;
    
}

function generate_select_years($already_selected_value , $earliest_year , $class , $name  )
{
    
    echo '<select class="form-control '.$class.'" style="cursor: pointer" name="'.$name.'" >';
    foreach (range(date('Y'), $earliest_year) as $x) {
        echo '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
    }
    echo '</select>';
    
}

//generate_array_input create array of items of array of fields field 
//like that
//(1)
//<input type="text" name="field[]" value="1" />
//<textarea>1</textarea>
//(/1)
//(2)
//<input type="text" name="field[]" value="2" />
//<textarea>2</textarea>
//(/2)

//$label_name,$field_name,$required,$type,$values,$class all of these prameters are arraies
//except $values its array of arraies
//$values = array(
//  array("Home","First Page","About Us"),
//  array("Home","First Page","About Us")
//);
function generate_array_input($label_name,$field_name,$required,$type,$values,$class,$add_tiny_mce=""){
    
    $field_id=$field_name[0]."_id";
    $add_item_class=$field_name[0]."_add_item";
    $remove_item_class=$field_name[0]."_remove_item";
    
    $contain_items_class=$field_name[0]."_contain_items";
    $first_item_class=$field_name[0]."_first_item";
    
    $html_tag="";
    $new_tags="";
    
    $html_tag.='<script type="text/javascript">'.PHP_EOL;
        $html_tag.='$(function(){'.PHP_EOL;
        
            $html_tag.='$(".'.$remove_item_class.'").click(function(){'.PHP_EOL;
                $html_tag.='$(this).parent().remove();'.PHP_EOL;
                $html_tag.='return false;'.PHP_EOL;
            $html_tag.='});'.PHP_EOL;
            
            $html_tag.='var text_area_counter='.(count($values[0])+1).' '.PHP_EOL;
            
            $html_tag.='$(".'.$add_item_class.'").click(function(){'.PHP_EOL;
                $html_tag.='var new_id="'.$field_id.'"+"textarea"+text_area_counter'.PHP_EOL;
                
                $html_tag.=PHP_EOL.'console.log(new_id)'.PHP_EOL;
                
                $new_tags.='<div class="row" style="margin: 10px;">';
                    $new_tags.='<div class="col-md-12">';

                        foreach ($field_name as $key => $single_field) {
                            $new_tags.='<label for="">'.$label_name[$key].'</label>';
                            if ($type[$key]!="textarea") {
                                $new_tags.='<input type="'.$type[$key].'" class="'.$class[$key].'" name="'.$field_name[$key].'[]">';
                            }
                            else{
                                $new_tags.='<textarea id="new_id" class="'.$class[$key].'" style="resize:vertical" name="'.$field_name[$key].'[]"></textarea>';
                                
                                
                            }

                        }//end foreach
                    $new_tags.='</div>';
                $new_tags.='</div>';
                
                
                
                //$html_tag.='$(".'.$contain_items_class.'").append($(".'.$first_item_class.'").first().clone());';
                $html_tag.='$(".'.$contain_items_class.'").append(\''.$new_tags.'\');'.PHP_EOL;
                
                $html_tag.='$("#new_id").attr("id",new_id);';
                
                if ($add_tiny_mce=="yes") {
                    $html_tag.="/*tinymce.remove();*/window.tinymce.dom.Event.domLoaded = true;".PHP_EOL;
                    $html_tag.='tinyMCE.init({ selector: "#"+new_id});'.PHP_EOL;
                }
                
                //increase count of text_area_counter
                $html_tag.='text_area_counter++;'.PHP_EOL;
                $html_tag.='return false;'.PHP_EOL;
            $html_tag.='});'.PHP_EOL;
            
        $html_tag.='});'.PHP_EOL;
    $html_tag.='</script>'.PHP_EOL;

    $html_tag.='<div class="col-md-12 form-group">';
        $html_tag.='<label for="">'.$label_name[0].' Section </label>';
        $html_tag.='<div class="col-md-12">';
            
        if (isset($values[0])&&count($values[0])&&is_array($values[0])) {
            foreach ($values[0] as $value_key => $item_values) {
                $html_tag.='<div class="row" style="margin: 10px;">';
                foreach ($field_name as $field_key => $filed) {
                    //$values[$field_key][$value_key]
                        $html_tag.='<div class="col-md-12">';
                            $html_tag.='<label for="">'.$label_name[$field_key].'</label>';
                            if ($type[$field_key]!="textarea") {
                                $html_tag.='<input type="'.$type[$field_key].'" class="'.$class[$field_key].'" name="'.$field_name[$field_key].'[]" value="'.$values[$field_key][$value_key].'">';
                            }
                            else{
                                $html_tag.='<textarea class="'.$class[$field_key].'" style="resize:vertical" name="'.$field_name[$field_key].'[]">'.$values[$field_key][$value_key].'</textarea>';
                            }
                        $html_tag.='</div>';
                   
                }//end fileds foreach
                $html_tag.='<button type="button" class="btn btn-danger '.$remove_item_class.'">Remove</button>';
                $html_tag.='</div>';
                
            }//end values foreach 
        }//end if 
        
        $html_tag.='</div>';
        
        $html_tag.='<div class="col-md-12 '.$contain_items_class.'">';
            $html_tag.='<div class="row '.$first_item_class.'" style="margin: 10px;">';
                $html_tag.='<div class="col-md-12">';
                    
                    foreach ($field_name as $key => $single_field) {
                        $html_tag.='<label for="">'.$label_name[$key].'</label>';
                        if ($type[$key]!="textarea") {
                            $html_tag.='<input type="'.$type[$key].'" class="'.$class[$key].'" name="'.$field_name[$key].'[]">';
                        }
                        else{
                            $html_tag.='<textarea id="tinymcetest" class="'.$class[$key].'" style="resize:vertical" name="'.$field_name[$key].'[]"></textarea>';
                        }
                        
                    }//end foreach
                $html_tag.='</div>';
            $html_tag.='</div>';
        $html_tag.='</div>';
        
        $html_tag.='<div class="col-md-12">';
            $html_tag.='<button type="button" data-newid="'.(count($values[0])+1).'" class="btn btn-warning '.$add_item_class.'">Add Item</button>';
        $html_tag.='</div>';

        
    $html_tag.='</div>';
    
    return $html_tag;
}
                
function generate_slider_imgs_tags()
{
    //under construction
}
                
                    
/**
 * generate_select_tags
 *
 * @return select tag with it selected option
 * 
 * @param field_name string
 * @param $label_name string
 * @param $text array() option text
 * @param $values array() option value
 * @param $selected_value array of selected values
 * @param $class string do not forget to add form-control
 * @param stirng $multiple put multipe if u want to select mutiple value 
 */            
function generate_select_tags($field_name,$label_name,$text,$values,$selected_value,$class="",$multiple=""){
    $html_tags="";
    
    $field_id=$field_name."_id";
    
    $html_tags.='<div class="form-group col-md-12">';
        $html_tags.='<label for="">'.$label_name.'</label>';
    
        $html_tags.='<select '.$multiple.' name="'.$field_name.'" id="'.$field_id.'" class="'.$class.'">';
            foreach ($values as $key => $value) {
                $selected="";
                if (in_array($value, $selected_value)) {
                    $selected="selected";
                }
                $html_tags.='<option value="'.$values[$key].'" '.$selected.' >'.$text[$key].'</option>';
            }
        $html_tags.='</select>';
    
    $html_tags.='</div>';
    
			
		
    return $html_tags;
}



/**
 * generate_depended_selects
 *
 * @return string 2 select elements ,on change of first element 
 * second elment change relativley
 * 
 * @param string $field_name_1
 * @param string $field_label_1 
 * @param string_array $field_text_1 array of first select options text
 * @param string_array $field_values_1 array of first select options values
 * @param string $field_required_1 this field is required or not
 * @param string $field_class_1 elemet classes pls do not forget form-control
 * 
 * @param string $field_name_2
 * @param string $field_label_2 
 * @param string_array $field_text_2 array of second select options text
 * @param string_array $field_values_2 array of second select options values
 * @param string_array $field_2_depend_values depended values that select2 will change by select 1 values
 * @param string $field_required_2 this field is required or not
 * @param string $field_class_2 elemet classes pls do not forget form-control
 */ 
function generate_depended_selects(
            $field_name_1,$field_label_1,$field_text_1,$field_values_1,$field_selected_value_1
            ,$field_required_1="",$field_class_1="",
            $field_name_2,$field_label_2,$field_text_2,$field_values_2,$field_selected_value_2,
            $field_2_depend_values,$field_required_2="",$field_class_2=""
    ){
    
    $field_id_1=$field_name_1."_id";
    $field_id_2=$field_name_2."_id";

    $field_div_container_2=$field_name_2."_div_container";
    
    $html_tags="";
    
    $html_tags.='<script type="text/javascript">'.PHP_EOL;
        $html_tags.='$(function(){'.PHP_EOL;
            $html_tags.='$("#'.$field_id_1.'").change(function(){'.PHP_EOL;
                $html_tags.='var select_1_value=$(this).val();'.PHP_EOL;
                $html_tags.='console.log(select_1_value);'.PHP_EOL;
                $html_tags.='$("#'.$field_id_2.' option").hide();'.PHP_EOL;
                $html_tags.='$(".'.$field_div_container_2.'").show();'.PHP_EOL;
                $html_tags.='var childs=$("#'.$field_id_2.' option[data-targetid="+select_1_value+"]");'.PHP_EOL;
                $html_tags.='$.each(childs,function(index,value){'.PHP_EOL;
                    $html_tags.='$(this).show();'.PHP_EOL;
                    $html_tags.='if (index==0) {'.PHP_EOL;
                        $html_tags.='$(this).attr("selected","selected")'.PHP_EOL;
                    $html_tags.='}'.PHP_EOL;
                $html_tags.='});'.PHP_EOL;
            $html_tags.='});'.PHP_EOL;
        $html_tags.='});'.PHP_EOL;
    $html_tags.='</script>'.PHP_EOL;

    
    $html_tags.='<div class="col-md-12 form-group">';
        $html_tags.='<div class="row">';
            //first select
            $html_tags.='<div class="col-md-6">';
                $html_tags.='<label>'.$field_label_1.'</label>';
                $html_tags.='<select id="'.$field_id_1.'" name="'.$field_name_1.'" class="'.$field_class_1.'" '.$field_required_1.'>';
                    $html_tags.='<option value=""></option>';
                    
                    foreach ($field_values_1 as $key => $value) {
                        $selected_value_1="";
                        if ($value==$field_selected_value_1) {
                            $selected_value_1="selected";
                        }
                        $html_tags.='<option value="'.$field_values_1[$key].'" '.$selected_value_1.' >'.$field_text_1[$key].'</option>';
                    }
                    
                $html_tags.='</select>';
            $html_tags.='</div>';
            
            //second select
            $display_none_select_2="";
            
            
            if ($field_selected_value_2=="") {
                $display_none_select_2="display:none;";
            }
            $html_tags.='<div class="col-md-6 '.$field_div_container_2.'" style="'.$display_none_select_2.'" >';
                $html_tags.='<label>'.$field_label_2.'</label>';
                $html_tags.='<select id="'.$field_id_2.'" name="'.$field_name_2.'" class="'.$field_class_2.'" '.$field_required_2.'>';
                    
                    foreach ($field_values_2 as $key => $value) {
                        $selected_option="";
                        $hide_option="style='display:none;'";
                        if ($field_2_depend_values[$key]==$field_selected_value_1) {
                            $hide_option="";
                        }
                        if ($value==$field_selected_value_2) {
                            $selected_option="selected";
                        }
                        $html_tags.='<option value="'.$field_values_2[$key].'" data-targetid="'.$field_2_depend_values[$key].'" '.$selected_option.' '.$hide_option.' >'.$field_text_2[$key].'</option>';
                    }
                    
                $html_tags.='</select>';
            $html_tags.='</div>';

        $html_tags.='</div>';
    $html_tags.='</div>';

    
    return $html_tags;
}


            