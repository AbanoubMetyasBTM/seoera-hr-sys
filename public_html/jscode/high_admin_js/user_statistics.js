$(function(){
    
    var base_url2=$(".base_url_class").val();
    var base_url=base_url2+"public_html/";

    var csrf_seoera_sys=$(".csrf_input_class").val();
    
    
        
    $('#get_statistics_btn').click(function(){

        var select_year=$(".select_year_class").val();
        var select_month=$(".select_month_class").val();
        var select_user_id=$("#select_user_id").val();

        location.href = base_url2+"high_admin/dashboard/show_user_salary/"+select_user_id+"/"+select_month+"/"+select_year;
        
        return false;
    });
    
    
    
    if ($("#working_chart").length > 0) 
    {
        
        if ($("#working_chart").children().length == 0) {
                
            $("#working_chart").html('<img style="margin-left:50%;margin-top:20%" src="'+ base_url2+"public_html/img/ajax-loader.gif"+'" >');

        }
        
        var max_work_time = parseInt($('.max_work_time').val());
        var max_late_time = parseInt($('.max_late_time').val());
        var max_over_time = parseInt($('.max_over_time').val());
        var min_check_in_time = parseInt($('.min_check_in_time').val());
        console.log(max_work_time);
        
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
          var data = google.visualization.arrayToDataTable([
            ["My Work Activities", "In Minutes", { role: "style" } ],
            ["Max Work Time (Minutes)", max_work_time, "color:#286090"],
            ["Max Late Time (Minutes)", max_late_time, "color:#d9534f"],
            ["Max Over Time (Minutes)", max_over_time, "color:#449d44"],
            ["Min Check in Time (Datetime)", min_check_in_time, "color:#5bc0de;"]
          ]);

          var view = new google.visualization.DataView(data);
          view.setColumns([0, 1,
                           { calc: "stringify",
                             sourceColumn: 1,
                             type: "string",
                             role: "annotation" },
                           2]);

          var options = {
            title: "My Work Activities (.min)",
    //        width: 600,
    //        height: 400,
            bar: {groupWidth: "95%"},
            legend: { position: "none" },
          };
          var chart = new google.visualization.BarChart(document.getElementById("working_chart"));
          chart.draw(view, options);
      }
        
    }
        
        
    
    // ./Get Working Activities Charts
    
 
    var work_time_arr =[['Date', 'Check In', 'Start Work Time' , 'Check Out' , 'End Work Time']];

    if ($("#worktime_chart").length > 0){
            
            if ($("#worktime_chart").children().length == 0) {
                
                $("#worktime_chart").html('<img style="margin-left:50%;margin-top:20%" src="'+ base_url2+"public_html/img/ajax-loader.gif"+'" >');
                
                console.log($('.mywork_data').data('mywork'));
                var work_data =  $('.mywork_data').data('mywork');
                
                var start_work_time = '';
                var end_work_time = '';
                
                start_work_time = $('.start_work_time').val().split(":");
                end_work_time = $('.end_work_time').val().split(":");
                
                start_work_time = (start_work_time[0]*60*60 + start_work_time[1]*60)/3600;
                end_work_time = (end_work_time[0]*60*60 + end_work_time[1]*60)/3600;
                
                //console.log(start_work_time);
                //console.log(end_work_time);
                
                if (work_data.length >2) 
                {
                    
                    $.each(work_data,function(index,value){
                        var temp = [];
                        var checkin = value['check_in'].split(":");
                        checkin = (checkin[0]*60*60+checkin[1]*60)/3600;
                        
                        var checkout = value['check_out'].split(":");
                        checkout = (checkout[0]*60*60+checkout[1]*60)/3600;
                        
                        temp.push( value['day'] + " Check In : "+value['check_in'] + " Check Out : "+ value['check_out'], checkin , start_work_time , checkout , end_work_time );
                        work_time_arr.push(temp);
                        
                        
                    });
                    
                }
                else{
                    work_time_arr.push(['' ,0 , 0 , 0 , 0]);
                }
                
            }
            
            //google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawWorkTimeChart);

            function drawWorkTimeChart() 
            {
                console.log(work_time_arr);
              var data = google.visualization.arrayToDataTable(
                  work_time_arr
              );

              var options = {
                title: 'Working Time',
                curveType: 'function',
                legend: { position: 'bottom' }
              };

              var chart = new google.visualization.LineChart(document.getElementById('worktime_chart'));

              chart.draw(data, options);
            }
            
            
        }
       
    // ./Get Working Time Table Chart
    
    
    //update $user holidays
    $(".update_this_user_holidays").click(function(){
        var obj={};
        obj.user_id=$("#select_user_id").val();
        obj.month=$(".select_month_class").val();
        obj.year=$(".select_year_class").val();
        obj.remain_of_normal_holidays_id=$("#remain_of_normal_holidays_id").val();
        obj.remain_of_abnormal_holidays_id=$("#remain_of_abnormal_holidays_id").val();
        obj.csrf_seoera_sys=csrf_seoera_sys;
        
        console.log(obj);
        
        var this_element=$(this);
        this_element.append('<img class="img_loader_class" src="'+ base_url2+"public_html/img/ajax-loader.gif"+'" >');

        $.ajax({
            url:base_url2+'high_admin/dashboard/update_user_holidays',
            type:'POST',
            data:obj,
            success:function(data){
                console.log(data);
                $(".img_loader_class").hide();
                this_element.attr("disabled","disabled");
                
                var json_data=JSON.parse(data);
                
                
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
        
        return false;
    });
    
    
    // Get Users Tasks Status Chart 
    
        if ($("#users_tasks_chart").length > 0){
            
            if ($("#users_tasks_chart").children().length == 0) {

                $("#users_tasks_chart").html('<img style="margin-left:50%;margin-top:20%" src="'+ base_url2+"public_html/img/ajax-loader.gif"+'" >');

            }
            //google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawUsersTasks);
            
            function drawUsersTasks() {

                var done = $('.done').val();
                var waiting = $('.waiting').val();
                var in_process = $('.in_process').val();
                var testing = $('.testing').val();

    //            console.log(done);
    //            console.log(waiting);
    //            console.log(in_process);
    //            console.log(testing);

                var data = google.visualization.arrayToDataTable([
                  ['Status', 'Tasks'],
                  ['Done',     parseInt(done)],
                  ['Waiting',      parseInt(waiting)],
                  ['In Process',  parseInt(in_process)],
                  ['Testing', parseInt(testing)]
                ]);

                var options = {
                  title: 'Employee Tasks Activities For me',
                  pieHole: 0.4

                };

                var chart = new google.visualization.PieChart(document.getElementById('users_tasks_chart'));
                chart.draw(data, options);
            }
        } 
        
    // ./Get Users Tasks Status Chart
    
    
    
});