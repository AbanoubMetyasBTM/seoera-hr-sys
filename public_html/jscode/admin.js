$(function(){
    
    var base_url2=$(".base_url_class").val();
    var base_url=base_url2+"public_html/";

    var csrf_seoera=$(".csrf_input_class").val();
    
    
    console.log("admin"+base_url2);
//    console.log(csrf_seoera);
    
    
    //cat 
    $('#cat_table').DataTable();

    
    
    $('body').on("click",".remove_item",function(){
        var confirm_res = confirm("Are you Sure?");
        if (confirm_res == true) {
            console.log(confirm_res);
            var item_id=$(this).data("itemid");
            var delete_url=$(this).data("deleteurl");
            //show load img
            $(this).append("<img src='"+base_url+"img/ajax-loader.gif' class='ajax_loader_class' width='20'>");
            $.ajax({
                url:delete_url,
                type:'POST',
                data:{'csrf_seoera':csrf_seoera,'item_id':item_id},
                success:function(data){
                    console.log(data);
                    var returned_data=JSON.parse(data);
                    
                    if (returned_data.deleted=="yes") {
                        $('#row'+item_id).fadeOut(400);
                        $("tr[data-parentid="+item_id+"]").fadeOut(400);
                    }

                }
            });
                    
        }//end confirmation if
        
        return false;
    });
    
    //END Cat
    
    //sldier
    
    $(".slider_img_remover").click(function(){
        $(this).parent().remove();
        var removed_id=$(this).data("photoid");
        var ids=JSON.parse($("#json_values_of_slider_id").val());
        
        var video_removed_id=$(this).data("videoid");
        //reset value of json_values_of_slider_id
        
        $.each(ids,function(index,value){
            if (removed_id==value) {
                            console.log("value");

                ids.splice(index,1);
            }
        });
        
        
        console.log("Photos"+ids);

        
        $("#json_values_of_slider_id").val('['+ids.toString()+']');
        
        return false;
    });
    
    $(".add_slider_img_btn").click(function(){
        
        var new_item=$(".slider_img .item").first().clone();
        $(".slider_img").append(new_item);
        
        return false;
    });
    
    
    //end slider
    
    
   
    //admin
   $('body').on("click",".remove_admin",function(){
        var confirm_res = confirm("Are you Sure?");
        if (confirm_res == true) {
            var admin_id=$(this).data("adminid");
            var this_element=$(this);

                    console.log(admin_id);
            //show load img
            $(this).append("<img src='"+base_url+"img/ajax-loader.gif' class='ajax_loader_class' width='20'>");
            
            
            $.ajax({
                url:base_url2+'admin/dashboard/remove_admin',
                type:'POST',
                data:{'csrf_seoera':csrf_seoera,'user_id':admin_id},
                success:function(data){
                    console.log(data);
                    console.log(JSON.parse(data));
                    var returned_data=JSON.parse(data);
                    
                    if (returned_data.deleted=="yes") {
                        $('#row'+admin_id).fadeOut(400);
                    }
                    else
                    {
                        this_element.html(returned_data.dump.error);
                    }

                }
            });
                    
        }//end confirmation if
        
        return false;
    });
    
    
    //END admin
    //support Messages
    
    $('body').on("click",".remove_support_msg",function(){
        var confirm_res = confirm("Are you Sure?");
        if (confirm_res == true) {
            var id=$(this).data("id");
            var this_element=$(this);

            console.log(id);
            //show load img
            $(this).append("<img src='"+base_url+"img/ajax-loader.gif' class='ajax_loader_class' width='20'>");
            $.ajax({
                url:base_url2+'admin/dashboard/remove_support_msg',
                type:'POST',
                data:{'csrf_seoera':csrf_seoera,'support_msg_id':id},
                success:function(data){
                    console.log(data);
                    console.log(JSON.parse(data));
                    var returned_data=JSON.parse(data);
                    
                    if (returned_data.deleted=="yes") {
                        $('#row'+id).fadeOut(400);
                    }
                }
            });
                    
        }//end confirmation if
        
        return false;
    });
    //END Support Messages
    
    
    //edit content
    
    $(".add_page_slider_img_btn").click(function(){
        
        var new_item=$(".slider_img .item").first().clone();
        $(".slider_img").append(new_item);
        
        return false;
    });
    
    //footer 
    
    
});