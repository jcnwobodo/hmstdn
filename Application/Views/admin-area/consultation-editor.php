<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/22/2016
 * Time:    11:07 AM
 **/

$rc = \System\Request\RequestContext::instance();
$data = $rc->getResponseData();

require_once("header.php");
?>
<script type="text/javascript">
    function filterDoctorsList()
    {
        var clinic_options = document.getElementById('clinic').childNodes;
        var selected = '';

        for(var i = 0; i < clinic_options.length; ++i)
        {
            var option = clinic_options[i];
            if(option.selected){ selected = option.value; break; }
        }

        if(selected != '')
        {
            selected = 'c'+selected;
            var doctor_options = document.getElementById('doctor').options;

            for(var j=0; j < doctor_options.length; ++j)
            {
                var current_option = doctor_options[j];
                if(current_option.getAttribute('class') == selected)
                {
                    current_option.setAttribute("style", "display:block !important;");
                }
                else if(current_option.getAttribute('class') != 'c0'){
                    current_option.setAttribute("style", "display:none !important;")
                }
            }
        }
    }
</script>
<div class="row">
    <?php
    require_once("sidebar.php");
    ?>

    <?php
    switch($data['mode'])
    {
        case('add-consultation'):{
            $fields = $rc->getAllFields();
            $default_action = array('name'=>$data['mode'], 'label'=>"Add Consultation");
        } break;
        case('update-consultation'):{
            $fields = $data['fields'];
            $default_action = array('name'=>$data['mode'], 'label'=>"Update Consultation");
        } break;
    }
    ?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h3 class="page-header">
            <span class="glyphicon glyphicon-plus"></span> <?= $data['mode']=='add-consultation'?"Add":"Update"; ?> Consultation
        </h3>
        <div class="text-center mid-margin-bottom <?= $data['status'] ? 'text-success bg-success' : 'text-danger bg-danger';?>"><?= $rc->getFlashData(); ?></div>

        <form method="post" enctype="multipart/form-data" <?= $data['mode']=='update-consultation'? 'action="'.home_url('/'.$rc->getRequestUrlParam(0).'/update-consultation/?consultation-id='.$data['consultation-id'],0).'"':''; ?>>
            <?php if($data['mode']=='update-consultation'){ ?><input type="hidden" name="consultation-id" value="<?= $data['consultation-id']; ?>"/><?php } ?>

            <!-- Clinic -->
            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="clinic"><span class="glyphicon glyphicon-plus-sign"></span> Clinic</label>
                    </div>
                    <div class="col-sm-9">
                        <select name="clinic" class="form-control" id="clinic" required onchange="filterDoctorsList()">
                            <option></option>
                            <?php
                            foreach($data['clinics'] as $clinic)
                            {
                                ?>
                                <option value="<?= $clinic->getId(); ?>" <?= selected($clinic->getId(), isset($fields['clinic']) ? $fields['clinic'] : null); ?>>[<?= $clinic->getClinicId(); ?>] <?= $clinic->getName(); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <!--Doctor -->
            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="doctor"><span class="glyphicon glyphicon-user"></span> Doctor</label>
                    </div>
                    <div class="col-sm-9">
                        <select name="doctor" class="form-control" id="doctor" required>
                            <option class="c0"></option>
                            <?php
                            foreach($data['doctors'] as $doctor)
                            {
                                $p = $doctor->getPersonalInfo();
                                $e = $doctor->getEmploymentData();
                                ?>
                                <option value="<?= $doctor->getId(); ?>" <?= selected($doctor->getId(), isset($fields['doctor']) ? $fields['doctor'] : null); ?> class="c<?= $e->getClinic()->getId(); ?>">
                                    <?= $p->getNames()." (".$e->getSpecialization().")"; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <!--Patient -->
            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="patient"><span class="glyphicon glyphicon-user"></span> Patient</label>
                    </div>
                    <div class="col-sm-9">
                        <select name="patient" class="form-control" id="patient" required>
                            <option></option>
                            <?php
                            foreach($data['patients'] as $patient)
                            {
                                $p = $patient->getPersonalInfo();
                                ?>
                                <option value="<?= $patient->getId(); ?>" <?= selected($patient->getId(), isset($fields['patient']) ? $fields['patient'] : null); ?>>
                                    <?= "[".$patient->getCardNumber()."] ".$p->getNames(); ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <!--Date -->
            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="meeting-date"><span class="glyphicon glyphicon-calendar"></span> Consultation Date</label>
                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-xs-5">
                                <span class="help-block">Month</span>
                                <?= drop_month('meeting-date[month]', isset($fields['meeting-date']['month']) ? $fields['meeting-date']['month'] : null, 'class="form-control" required'); ?>
                            </div>
                            <div class="col-xs-3 no-padding">
                                <span class="help-block">Day</span>
                                <?= drop_month_days('meeting-date[day]', isset($fields['meeting-date']['day']) ? $fields['meeting-date']['day'] : null, 'class="form-control" required'); ?>
                            </div>
                            <div class="col-xs-4">
                                <span class="help-block">Year</span>
                                <?= drop_years('meeting-date[year]', isset($fields['meeting-date']['year']) ? $fields['meeting-date']['year'] : null, 'class="form-control" required'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Start time -->
            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="start-time"><span class="glyphicon glyphicon-time"></span> Start Time</label>
                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-xs-4">
                                <span class="help-block">Hour</span>
                                <?= drop_hours('start-time[hour]', isset($fields['start-time']['hour']) ? $fields['start-time']['hour'] : null, 'class="form-control" required'); ?>
                            </div>
                            <div class="col-xs-4">
                                <span class="help-block">Minute</span>
                                <?= drop_minutes('start-time[minute]', isset($fields['start-time']['minute']) ? $fields['start-time']['minute'] : null, 'class="form-control" required'); ?>
                            </div>
                            <div class="col-xs-4">
                                <span class="help-block">AM/PM</span>
                                <?= drop_AmPM('start-time[am_pm]',  isset($fields['start-time']['am_pm']) ? $fields['start-time']['am_pm'] : null, 'class="form-control" required'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--End time -->
            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="start-time"><span class="glyphicon glyphicon-time"></span> End Time</label>
                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-xs-4">
                                <?= drop_hours('end-time[hour]', isset($fields['end-time']['hour']) ? $fields['end-time']['hour'] : null, 'class="form-control" required'); ?>
                            </div>
                            <div class="col-xs-4">
                                <?= drop_minutes('end-time[minute]', isset($fields['end-time']['minute']) ? $fields['end-time']['minute'] : null, 'class="form-control" required'); ?>
                            </div>
                            <div class="col-xs-4">
                                <?= drop_AmPM('end-time[am_pm]',  isset($fields['end-time']['am_pm']) ? $fields['end-time']['am_pm'] : null, 'class="form-control" required'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="btn-group pull-right">
                <button name="<?= $default_action['name']; ?>" type="submit" class="btn btn-primary">
                    <span class="glyphicon <?= $data['mode']=='add-consultation'?'glyphicon-plus':'glyphicon-edit'; ?>"></span> <?= $default_action['label']; ?>
                </button>
            </div>
        </form>
    </div>
</div>
<?php
require_once("footer.php");
?>