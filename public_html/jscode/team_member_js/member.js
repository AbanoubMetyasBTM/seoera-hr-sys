$(function () {

    var base_url2 = $(".base_url_class").val();
    var base_url = base_url2 + "public_html/";

    var csrf_seoera_sys = $(".csrf_input_class").val();


    console.log("member" + base_url2);


    //tasks 
    $('#tasks').DataTable();
    
    //Hoiliday
    $('#holidays').DataTable();
    
    // Permissions
    $('#permissions').DataTable();
    
    //$( ".datepicker" ).datepicker();
    
    // Show Task Modal and Load Data
    
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
    
    // ./Show Task Modal and Load Data
    
    
    // Get Working Activities Charts
    
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
    
    
    // Get Working Time Table Chart
        
//        $('.select_month').change(function(){
//
//            console.log($(this+":selected").val());
//            var month = $(this+":selected").val();
//
//            location.href = base_url2+"team_member/dashboard/worktime/"+month;
//
//        });
        
        
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
            
            google.charts.load('current', {'packages':['corechart']});
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
    
    
    
    // Get Tasks Status Chart 
    
        if ($("#tasks_chart").length > 0){
            
            if ($("#tasks_chart").children().length == 0) {

                $("#tasks_chart").html('<img style="margin-left:50%;margin-top:20%" src="'+ base_url2+"public_html/img/ajax-loader.gif"+'" >');

            }
            //google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawTasks);
            
            function drawTasks() {

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
                  title: 'My Tasks Activities',
                  pieHole: 0.4

                };

                var chart = new google.visualization.PieChart(document.getElementById('tasks_chart'));
                chart.draw(data, options);
            }
        } 
    // ./Get Tasks Status Chart 
    
    
    // Get Holidays Chart 
    
        if ($("#holidays_chart").length > 0){
            
            if ($("#holidays_chart").children().length == 0) {

                $("#holidays_chart").html('<img style="margin-left:50%;margin-top:20%" src="'+ base_url2+"public_html/img/ajax-loader.gif"+'" >');

            }
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawHolidays);
            
            function drawHolidays() {

                var all = $('.all').val();
                var not_accept = $('.not_accept').val();
                var accept = $('.accept').val();

                //console.log(all);
                //console.log(not_accept);
                //console.log(accept);

                var data = google.visualization.arrayToDataTable([
                  ['Status', 'Number'],
//                  ['All',     parseInt(all)],
                  ['Accepted',      parseInt(accept)],
                  ['Not Accepted',  parseInt(not_accept)]
                ]);

                var options = {
                  title: 'My Holidays Activities , You Demand ('+all+') Holiday in this Month',
                  pieHole: 0.4

                };

                var chart = new google.visualization.PieChart(document.getElementById('holidays_chart'));
                chart.draw(data, options);
            }
        }
          
    // ./Get Holidays Chart 
    
    // Get Permissions Chart 
    
        if ($("#permissions_chart").length > 0){
            
            if ($("#permissions_chart").children().length == 0) {

                $("#permissions_chart").html('<img style="margin-left:50%;margin-top:20%" src="'+ base_url2+"public_html/img/ajax-loader.gif"+'" >');

            }
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawPermissions);
            
            function drawPermissions() {

                var all = $('.all').val();
                var not_accept = $('.not_accept').val();
                var accept = $('.accept').val();

                //console.log(all);
                //console.log(not_accept);
                //console.log(accept);

                var data = google.visualization.arrayToDataTable([
                  ['Status', 'Number'],
//                  ['All',     parseInt(all)],
                  ['Accepted',      parseInt(accept)],
                  ['Not Accepted',  parseInt(not_accept)]
                ]);

                var options = {
                  title: 'My Permissions Activities , You Demand ('+all+') Permission in this Month',
                  pieHole: 0.4

                };

                var chart = new google.visualization.PieChart(document.getElementById('permissions_chart'));
                chart.draw(data, options);
            }
        }
          
    // ./Get Permissions Chart 


});