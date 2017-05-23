$(function(){
    
    var base_url2=$(".base_url_class").val();
    var base_url=base_url2+"public_html/";

    var csrf_seoera_sys=$(".csrf_input_class").val();
    
    
    console.log("admin"+base_url2);
//    console.log(csrf_seoera_sys);
    
//INDEX

    $('body').on('click' , '.show_task_modal' , function(){
        
        var task = [];
        task = $(this).data('cols');
        
        $('.task_header').html(task['task_title']);
        
        var modal_body = "";
        
        //task.splice(0,3);
        
        $.each(task,function(key,value){
            //console.log(key);
            //console.log(value);
            if (key == "task_title" || key == "task_desc" || key == "task_priority"  || key == "task_statues" || key == "task_note_by_user"
                || key == "task_note_by_client" || key == "task_start_date" || key == "task_end_date" || key == "username" ) {
                
            
                modal_body += '<div class="row">'+
                                    '<div class="col-md-6" style="font-weight: bold;">'+
                                        key+
                                    '</div>'+
                                    '<div class="col-md-6">'+
                                        value+
                                    '</div>'+
                                '</div>'
            }
            
        });
        //console.log(modal_body);
        $('.task_body').html(modal_body);
        
    });
    
    // Get Users Tasks Status Chart 
    
        if ($("#users_tasks_chart_in_dashboard").length > 0){
            
            if ($("#users_tasks_chart_in_dashboard").children().length == 0) {
                $("#users_tasks_chart_in_dashboard").html('<img style="margin-left:50%;margin-top:20%" src="'+ base_url2+"public_html/img/ajax-loader.gif"+'" >');
            }
            
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawUsersTasks);
            
            function drawUsersTasks() {

                var done = $('.done').val();
                var waiting = $('.waiting').val();
                var in_process = $('.in_process').val();
                var testing = $('.testing').val();

                var data = google.visualization.arrayToDataTable([
                  ['Status', 'Tasks'],
                  ['Done',     parseInt(1)],
                  ['Waiting',      parseInt(2)],
                  ['In Process',  parseInt(3)],
                  ['Testing', parseInt(4)]
                ]);

                var options = {
                  title: 'Employee Tasks Activities For me',
                  pieHole: 0.4

                };

                var chart = new google.visualization.PieChart(document.getElementById('users_tasks_chart_in_dashboard'));
                chart.draw(data, options);
            }
        } 
        
    // ./Get Users Tasks Status Chart
    
    //top_5_gained_overtime_chart_id
    if ($("#top_5_gained_overtime_chart_id").length>0) {
        
        if ($("#top_5_gained_overtime_chart_id").children().length == 0) {
            $("#top_5_gained_overtime_chart_id").html('<img style="margin-left:50%;margin-top:20%" src="'+ base_url2+"public_html/img/ajax-loader.gif"+'" >');
        }
        
        //google.charts.load("current", {packages:['corechart']});
        google.charts.setOnLoadCallback(drawChart_top_5_overtime);
        function drawChart_top_5_overtime() {
            var data_json=JSON.parse($(".top_5_gained_overtime_data").val());
            var pased_data=[];
            pased_data.push(["Member", "OverTime", { role: "style" } ]);
            
            
                
            $.each(data_json,function(i,v){
                var label=v.username+" "+v.max_over_time;
                
                v.max_over_time=v.max_over_time.split(":");
                v.max_over_time=(parseInt(v.max_over_time[0]*60) + parseInt(v.max_over_time[1]));

                pased_data.push([label, parseInt(v.max_over_time) , "#337AB7"]);
            });
            
            var data = google.visualization.arrayToDataTable(pased_data);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                             { calc: "stringify",
                               sourceColumn: 1,
                               type: "string",
                               role: "annotation" },
                             2]);

            var options = {
              title: "Tasks 5 Users Gained Overtime",
              bar: {groupWidth: "95%"},
              legend: { position: "none" },
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("top_5_gained_overtime_chart_id"));
            chart.draw(view, options);
      }
        
        
    }
    
    //END top_5_gained_overtime_chart_id
    
    //top_5_gained_latetime_chart_id
    if ($("#top_5_gained_latetime_chart_id").length>0) {
        
        if ($("#top_5_gained_latetime_chart_id").children().length == 0) {
            $("#top_5_gained_latetime_chart_id").html('<img style="margin-left:50%;margin-top:20%" src="'+ base_url2+"public_html/img/ajax-loader.gif"+'" >');
        }
        
        //google.charts.load("current", {packages:['corechart']});
        google.charts.setOnLoadCallback(drawChart_top_5_latetime);
        function drawChart_top_5_latetime() {
            var data_json=JSON.parse($(".top_5_gained_latetime_data").val());
            var pased_data=[];
            pased_data.push(["Member", "OverTime", { role: "style" } ]);
            
            
                
            $.each(data_json,function(i,v){
                var label=v.username+" "+v.max_late_time;
                
                v.max_late_time=v.max_late_time.split(":");
                v.max_late_time=(parseInt(v.max_late_time[0]*60) + parseInt(v.max_late_time[1]));

                pased_data.push([label, parseInt(v.max_late_time) , "#D9534F"]);
            });
            
            var data = google.visualization.arrayToDataTable(pased_data);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                             { calc: "stringify",
                               sourceColumn: 1,
                               type: "string",
                               role: "annotation" },
                             2]);

            var options = {
              title: "Tasks 5 Users Made Latetime",
              bar: {groupWidth: "95%"},
              legend: { position: "none" },
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("top_5_gained_latetime_chart_id"));
            chart.draw(view, options);
      }
        
        
    }
    
    //END top_5_gained_overtime_chart_id
    
    //most_5_done_tasks_id
    if ($("#most_5_done_tasks_id").length>0) {
        
        if ($("#most_5_done_tasks_id").children().length == 0) {
            $("#most_5_done_tasks_id").html('<img style="margin-left:50%;margin-top:20%" src="'+ base_url2+"public_html/img/ajax-loader.gif"+'" >');
        }
        
        //google.charts.load("current", {packages:['corechart']});
        google.charts.setOnLoadCallback(drawChart_most_5_done_tasks);
        function drawChart_most_5_done_tasks() {
            var data_json=JSON.parse($(".most_5_done_tasks_data").val());
            var pased_data=[];
            pased_data.push(["Member", "OverTime", { role: "style" } ]);
            
            
                
            $.each(data_json,function(i,v){
                pased_data.push([v.username, v.max_done_tasks , "#D9534F"]);
            });
            
            var data = google.visualization.arrayToDataTable(pased_data);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                             { calc: "stringify",
                               sourceColumn: 1,
                               type: "string",
                               role: "annotation" },
                             2]);

            var options = {
              title: "Tasks 5 Users Made Latetime",
              bar: {groupWidth: "95%"},
              legend: { position: "none" },
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("most_5_done_tasks_id"));
            chart.draw(view, options);
      }
        
        
    }
    
    //END most_5_done_tasks_id
    
    
    
//END INDEX


//tasks
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
    
    $(".reorder_tasks").click(function(){
        var tasks_items=[];
        
        $.each($("#sortable").children(),function(index,value){
            var task_id=$(this).data("taskid");
            var task_order=index;
            
            tasks_items.push([task_id,task_order]);
        });
        
        console.log(JSON.stringify(tasks_items));
        var this_element=$(this);
        this_element.append("<img src='"+base_url+"img/ajax-loader.gif' class='ajax_loader_class' width='20'>");

        $.ajax({
            url:base_url2+'high_admin/tasks/reorder_tasks',
            type:'POST',
            data:{'csrf_seoera_sys':csrf_seoera_sys,'tasks_items':tasks_items},
            success:function(data){
                $(".ajax_loader_class").hide();

                var json_data=JSON.parse(data);
                
                console.log(json_data);
                
                if (typeof (json_data)!="undefiend") {
                    if (typeof (json_data.success)!="undefined") {
                        this_element.append(" "+json_data.success);
                    }
                    
                    if (typeof (json_data.error)!="undefined") {
                        this_element.append(" "+json_data.error);
                    }
                }
                
                
            }
        });
        
    });
    
    
    $("#get_tasks_btn").click(function(){
        var user_id=$("#select_user_id").val();
        
        location.href=base_url2+"high_admin/tasks/index/"+user_id;
        
        return false;
    });

//END tasks

//demands
    
    //holiday demand
    $("#get_holiday_demands_btn").click(function(){
        var userid=$("#select_user_id").val();
        location.href=base_url2+"high_admin/demands/holiday_demands/"+userid;
        
        return false;
    });

    $("body").on("click",".accept_holiday_Demand",function(){
        var obj={};
        obj.holiday_id=$(this).data("demandid");
        obj.csrf_seoera_sys=csrf_seoera_sys;
        
        var this_element=$(this);
        
        $.ajax({
            url:base_url2+"high_admin/demands/accept_holiday_demand",
            type:"POST",
            data:obj,
            success:function(data){
                console.log(data);
                this_element.parent().html(data);
            }
        });
        
        return false;
    });
    
    $("body").on("click",".refuse_holiday_Demand",function(){
        var obj={};
        obj.holiday_id=$(this).data("demandid");
        obj.csrf_seoera_sys=csrf_seoera_sys;
        
        var this_element=$(this);
        
        $.ajax({
            url:base_url2+"high_admin/demands/refuse_holiday_demand",
            type:"POST",
            data:obj,
            success:function(data){
                console.log(data);
                this_element.parent().html(data);
            }
        });
        
        return false;
    });
    //END holiday demand

    //delay demand
    $("#get_delay_demands_btn").click(function(){
        var userid=$("#select_user_id").val();
        location.href=base_url2+"high_admin/demands/delay_demands/"+userid;
        return false;
    });

    $("body").on("click",".accept_delay_Demand",function(){
        var obj={};
        obj.delay_id=$(this).data("demandid");
        obj.csrf_seoera_sys=csrf_seoera_sys;
        
        var this_element=$(this);
        
        $.ajax({
            url:base_url2+"high_admin/demands/accept_delay_demand",
            type:"POST",
            data:obj,
            success:function(data){
                this_element.parent().html(data);
            }
        });
        
        return false;
    });
    
    $("body").on("click",".refuse_delay_Demand",function(){
        var obj={};
        obj.delay_id=$(this).data("demandid");
        obj.csrf_seoera_sys=csrf_seoera_sys;
        
        var this_element=$(this);
        
        $.ajax({
            url:base_url2+"high_admin/demands/refuse_delay_demand",
            type:"POST",
            data:obj,
            success:function(data){
                this_element.parent().html(data);
            }
        });
        
        return false;
    });
    //END holiday demand


//END demands


    
    
    //general
    
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
                data:{'csrf_seoera_sys':csrf_seoera_sys,'item_id':item_id},
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
    
    //END general

    $("body").on("click",".show_user_other_data",function(){
        var data=$(this).data("otherdata");    
        var shown_cols=$(this).data("showncols");
        
        console.log(data);
        console.log(shown_cols);

        var data_array=[];
        $.each(data,function(i,v){
            data_array[i]=v;
        }); 
        
        var html_tags="";
        
        $.each(shown_cols,function(index,value){
            html_tags+='<div class="col-md-12">';
                html_tags+='<div class="col-md-6">';
                    html_tags+='<p>'+value+':</p>';
                html_tags+='</div>';
                html_tags+='<div class="col-md-6">';
                    html_tags+='<p>'+data_array[value]+'</p>';
                html_tags+='</div>';
            html_tags+='</div>';
            
        });
        
        $("#user_info_modal .modal-body").html(html_tags);
        $("#user_info_modal").modal("show");
        
        return false;
    });
    
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
                data:{'csrf_seoera_sys':csrf_seoera_sys,'user_id':admin_id},
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
                data:{'csrf_seoera_sys':csrf_seoera_sys,'support_msg_id':id},
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