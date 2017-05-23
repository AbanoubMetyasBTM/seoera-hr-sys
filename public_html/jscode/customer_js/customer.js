$(function () {

    var base_url2 = $(".base_url_class").val();
    var base_url = base_url2 + "public_html/";

    var csrf_seoera_sys = $(".csrf_input_class").val();


    console.log("customer" + base_url2);


    //tasks 
    $('#tasks').DataTable();

    
    
    // Get Tasks Status Chart 
    
        if ($("#tasks_chart").length > 0){
            
            if ($("#tasks_chart").children().length == 0) {

                $("#tasks_chart").html('<img style="margin-left:50%;margin-top:20%" src="'+ base_url2+"public_html/img/ajax-loader.gif"+'" >');

            }
            google.charts.load('current', {'packages':['corechart']});
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
    
    
    // Get Users Tasks Status Chart 
    
        if ($("#users_tasks_chart").length > 0){
            
            if ($("#users_tasks_chart").children().length == 0) {

                $("#users_tasks_chart").html('<img style="margin-left:50%;margin-top:20%" src="'+ base_url2+"public_html/img/ajax-loader.gif"+'" >');

            }
            google.charts.load('current', {'packages':['corechart']});
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