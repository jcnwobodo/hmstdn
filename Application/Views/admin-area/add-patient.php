<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/22/2016
 * Time:    1:58 AM
 **/

$rc = \System\Request\RequestContext::instance();
$data = $rc->getResponseData();
$location_states = $data['location-states'];

$fields = $rc->getAllFields();
if($rc->fieldIsSet('add')) if($data['status']==1) $fields = array();

require_once("header.php");
?>
    <div class="row">
        <?php
        require_once("sidebar.php");
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3 class="page-header">
                <span class="glyphicon glyphicon-plus"></span> Add Patient
            </h3>

            <form method="post" enctype="multipart/form-data" action="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1)); ?>">

                <div class="text-center mid-margin-bottom <?= $data['status'] ? 'text-success bg-success' : 'text-danger bg-danger';?>">
                    <?= $rc->getFlashData(); ?>
                </div>

                <!--PATIENT DATA--->
                <?php
                include_once("Application/Views/includes/patient-bio-data-editor.php");
                ?>
                <!--/PATIENT DATA--->

                <!--GENERAL USER DATA--->
                <fieldset class="full-margin-bottom">
                    <legend><span class="glyphicon glyphicon-user"></span> Personal Data</legend>

                    <div class="form-group form-group-sm">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="first-name">Names</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input name="first-name" id="first-name" required type="text" maxlength="25" class="form-control" placeholder="First name" value="<?= isset($fields['first-name']) ? $fields['first-name'] : ''; ?>"/>
                                    </div>
                                    <div class="col-sm-4">
                                        <input name="last-name" id="last-name" required type="text" maxlength="25" class="form-control" placeholder="Last name" value="<?= isset($fields['last-name']) ? $fields['last-name'] : ''; ?>"/>
                                    </div>
                                    <div class="col-sm-4">
                                        <input name="other-names" id="other-names" type="text" maxlength="50" class="form-control" placeholder="Other names" value="<?= isset($fields['other-names']) ? $fields['other-names'] : ''; ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="gender">Gender</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <label for="female" class="radio-inline">
                                            <input type="radio" name="gender" id="female" value="F" <?= isset($fields['gender']) ? ( $fields['gender']=='F' ? 'checked="checked"' : '') : 'checked="checked"'; ?>/>
                                            Female
                                        </label>
                                    </div>
                                    <div class="col-xs-5">
                                        <label for="male" class="radio-inline">
                                            <input type="radio" name="gender" id="male" value="M" <?= isset($fields['gender']) ? ( $fields['gender']=='M' ? 'checked="checked"' : '') : '' ; ?>/>
                                            Male
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="date-of-birth"><span class="glyphicon glyphicon-calendar"></span> Date of Birth</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <span class="help-block">Month</span>
                                        <?= drop_month('date-of-birth[month]', isset($fields['date-of-birth']['month']) ? $fields['date-of-birth']['month'] : null , 'class="form-control" required'  ); ?>
                                    </div>
                                    <div class="col-xs-3">
                                        <span class="help-block">Day</span>
                                        <?= drop_month_days('date-of-birth[day]', isset($fields['date-of-birth']['day']) ? $fields['date-of-birth']['day'] : null , 'class="form-control" required' ); ?>
                                    </div>
                                    <div class="col-xs-4">
                                        <span class="help-block">Year</span>
                                        <?= drop_years('date-of-birth[year]', isset($fields['date-of-birth']['year']) ? $fields['date-of-birth']['year'] : null , date('Y'), date('Y')-100, 'class="form-control" required' ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="full-margin-bottom">
                    <legend><span class="glyphicon glyphicon-envelope"></span> Contact Details</legend>

                    <div class="form-group form-group-sm">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="residence-state"><span class="glyphicon glyphicon-globe"></span> State of Residence</label>
                            </div>
                            <div class="col-sm-9">
                                <select name="residence-state" class="form-control" id="residence-state" required>
                                    <option></option>
                                    <?php
                                    foreach($location_states as $state)
                                    {
                                        ?>
                                        <option value="<?= $state->getLocationName(); ?>" <?= selected($state->getLocationName(), isset($fields['residence-state']) ? $fields['residence-state'] : null); ?>><?= $state->getLocationName(); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="residence-street">Town/Street/House Address</label>
                            </div>
                            <div class="col-sm-9">
                                <input name="residence-street" id="residence-street"  type="text" maxlength="100" class="form-control" placeholder="Street Address e.g No. 1 Enugu Road, Nsukka" value="<?= isset($fields['residence-street']) ? $fields['residence-street'] : ''; ?>" required/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="contact-email">Contact E-mail</label>
                            </div>
                            <div class="col-sm-9">
                                <input name="contact-email" id="contact-email" type="email" maxlength="100" class="form-control" placeholder="mail_address@domain.com" value="<?= isset($fields['contact-email']) ? $fields['contact-email'] : ''; ?>"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="contact-phone">Mobile Number</label>
                            </div>
                            <div class="col-sm-9">
                                <input name="contact-phone" id="contact-phone" type="tel" maxlength="11" class="form-control" placeholder="08012345678" value="<?= isset($fields['contact-phone']) ? $fields['contact-phone'] : ''; ?>" required/>
                            </div>
                        </div>
                    </div>

                </fieldset>
                <!--/GENERAL USER DATA--->

                <div class="btn-group pull-right">
                    <button name="add" type="submit" class="btn btn-primary btn-lg">
                        Add Patient <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php
require_once("footer.php");
?>