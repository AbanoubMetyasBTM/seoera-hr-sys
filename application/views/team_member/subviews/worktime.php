<!-- FIRST ROW OF BLOCKS -->     
<div class="row">
    
    
    
    <!-- Working CHART BLOCK -->
    <div class="col-md-9">
        <div class="col-md-12 dash-unit" >
            <dtitle>Working Chart</dtitle>
            <hr>
            <?php if (!empty($user)): ?>
                
                <input type="hidden" class = "start_work_time" name="start_work_time" value="<?= $user->start_work_time ?>">
                <input type="hidden" class = "end_work_time" name="end_work_time" value="<?= $user->end_work_time ?>">
            
            <?php endif ?>
            
            <div style="display: none" class="mywork_data" data-mywork="<?= htmlentities(json_encode($work), ENT_QUOTES , 'UTF-8')  ?>">
                    
            </div>
            <div id="worktime_chart" style="width:100%;height: 375px"></div>
        </div>
    </div>
    
    
    
    <!-- Dropdown Months BLOCK -->
    <div class="col-md-3">
        <div class="dash-unit">
            <dtitle>Select Your Month</dtitle>
            <hr>
            
            <form action="<?= base_url('team_member/dashboard/worktime') ?>" method="POST" style="text-align: center;">
                
                <div class="form-group">

                    <?php
                        $already_selected_value = intval($year_selected);
                        $earliest_year = 2000;

                        echo generate_select_years($already_selected_value, $earliest_year , 'select_year' , 'select_year');
                    ?>

                </div>
                
                <hr>
                <div class="form-group">

                    <select class="form-control select_month" style="cursor: pointer" name="select_month">

                        <?php if ($month_selected == 1): ?>
                            <option selected value="1">January</option>
                        <?php endif ?>

                        <?php if ($month_selected != 1): ?>
                            <option value="1">January</option>
                        <?php endif ?>

                        <?php if ($month_selected == 2): ?>
                            <option selected value="2">February</option>
                        <?php endif ?>

                        <?php if ($month_selected != 2): ?>
                            <option value="2">February</option>
                        <?php endif ?>

                        <?php if ($month_selected == 3): ?>
                            <option selected value="3">March</option>
                        <?php endif ?>

                        <?php if ($month_selected != 3): ?>
                            <option value="3">March</option>
                        <?php endif ?>

                        <?php if ($month_selected == 4): ?>
                            <option selected value="4">April</option>
                        <?php endif ?>

                        <?php if ($month_selected != 4): ?>
                            <option value="4">April</option>
                        <?php endif ?>

                        <?php if ($month_selected == 5): ?>
                            <option selected value="5">May</option>
                        <?php endif ?>

                        <?php if ($month_selected != 5): ?>
                            <option value="5">May</option>
                        <?php endif ?>

                        <?php if ($month_selected == 6): ?>
                            <option selected value="6">June</option>
                        <?php endif ?>

                        <?php if ($month_selected != 6): ?>
                            <option value="6">June</option>
                        <?php endif ?>  

                        <?php if ($month_selected == 7): ?>
                            <option selected value="7">July</option>
                        <?php endif ?>

                        <?php if ($month_selected != 7): ?>
                            <option value="7">July</option>
                        <?php endif ?> 


                        <?php if ($month_selected == 8): ?>
                            <option selected value="8">August</option>
                        <?php endif ?>

                        <?php if ($month_selected != 8): ?>
                            <option value="8">August</option>
                        <?php endif ?> 

                        <?php if ($month_selected == 9): ?>
                            <option selected value="9">September</option>
                        <?php endif ?>

                        <?php if ($month_selected != 9): ?>
                            <option value="9">September</option>
                        <?php endif ?>

                        <?php if ($month_selected == 10): ?>
                            <option selected value="10">October</option>
                        <?php endif ?>

                        <?php if ($month_selected != 10): ?>
                            <option value="10">October</option>
                        <?php endif ?>

                        <?php if ($month_selected == 11): ?>
                            <option selected value="11">November</option>
                        <?php endif ?>

                        <?php if ($month_selected != 11): ?>
                            <option value="11">November</option>
                        <?php endif ?>

                        <?php if ($month_selected == 12): ?>
                            <option selected value="12">December</option>
                        <?php endif ?>

                        <?php if ($month_selected != 12): ?>
                            <option value="12">December</option>
                        <?php endif ?>

                    </select>

                </div>
                
                <input type="hidden" class="csrf_input_class" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">

                <br>
                
                <button type="submit" name="submit" class="btn btn-primary"> Show Chart <i class="fa fa-dashboard"></i> </button>

            
            </form>
            
        </div>
    </div>
    
    
</div>