
jQuery(function ($) {
    

    var base_url2=$(".base_url_class").val();
    var base_url=base_url2+"public_html/";

    var csrf_seoera_sys=$(".csrf_input_class").val();
    
    console.log(csrf_seoera_sys);
    
    console.log("homepage"+base_url2);
//    console.log(csrf_dandy);
    
    
    //login
    $(".admin_username,.admin_password").keyup(function(event){
        if (event.which!=13) {
            return ;
        }
        $('.admin_login_ajax').click();
    });
    
    
    $('.admin_login_ajax').click(function(){
        
        var email=$('.admin_username').val();
        var password=$('.admin_password').val();
        
        //show load img
        console.log({'csrf_seoera_sys':csrf_seoera_sys,'email':email,'password':password});
        $(this).append("<img src='"+base_url+"img/ajax-loader.gif' class='ajax_loader_class' width='20'>");
        
        $.ajax({
            url:base_url2+'site/ajax_login',
            type:'POST',
            data:{'csrf_seoera_sys':csrf_seoera_sys,'email':email,'password':password},
            success:function(data){
                console.log(data);
                console.log(JSON.parse(data));
                var returned_data=JSON.parse(data);
                if (returned_data.success=="success") {
                    location.href=returned_data.url;
                }
                else
                {
                    $(".ajax_loader_class").hide();
                    $('.show_errors').html(returned_data.error);
                }
                
            }
        });
        
        
        
        
        return false;
    });
    
    
    
});
