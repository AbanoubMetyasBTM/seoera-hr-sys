
<!-- FIRST ROW OF BLOCKS -->     
<div class="row">

    <!-- Working CHART BLOCK -->
    <div class="col-md-9">
        <div class="col-md-12 dash-unit" >
            <dtitle> Holidays Activities </dtitle>
            <hr>
            <?php 
                $all_holidays = 0;
                if (!empty($holidays)) {
                    
                    $all_holidays = intval(count($holidays));
                    
                }
            ?>
            <input type="hidden" class="all" value="<?= $all_holidays ?>">
            <input type="hidden" class="not_accept" value="<?= intval($holidays_not_accepted) ?>">
            <input type="hidden" class="accept" value="<?= intval($holidays_accepted) ?>">
            <div id="holidays_chart" style="width:100%;height: 375px"></div>
        </div>

    </div>




    <!-- Dropdown Months BLOCK -->
    <div class="col-md-3">
        <div class="dash-unit">
            <dtitle>Select Your Month</dtitle>
            <hr>

            <form action="<?= base_url('team_member/holidays/holidays_chart') ?>" method="POST" style="text-align: center;">

                <div class="form-group">

                    <?php
                    $already_selected_value = intval($year_selected);
                    $earliest_year = 2000;

                    echo generate_select_years($already_selected_value, $earliest_year, 'select_year', 'select_year');
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

                <input type="hidden" class="csrf_input_class" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

                <br>

                <button type="submit" name="submit" class="btn btn-primary"> Show Chart <i class="fa fa-dashboard"></i> </button>


            </form>

        </div>
    </div>


</div>