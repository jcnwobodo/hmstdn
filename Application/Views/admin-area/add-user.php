<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/20/2016
 * Time:    4:39 AM
 **/

$rc = \System\Request\RequestContext::instance();
$data = $rc->getResponseData();

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
                <span class="glyphicon glyphicon-plus"></span> Add Staff (<?= ucfirst($data['type']); ?>)
            </h3>

            <div class="row mid-margin-bottom">
                <div class="col-md-12">
                    <div class="btn-group pull-right">
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?type=admin'); ?>" class="btn btn-primary">Admin</a>
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?type=doctor'); ?>" class="btn btn-primary">Doctor</a>
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?type=lab_technician'); ?>" class="btn btn-primary">Lab. Technician</a>
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?type=receptionist'); ?>" class="btn btn-primary">Receptionist</a>
                    </div>
                </div>
            </div>

            <form method="post" enctype="multipart/form-data" action="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?type='.$data['type']); ?>">

                <div class="text-center mid-margin-bottom <?= $data['status'] ? 'text-success bg-success' : 'text-danger bg-danger';?>">
                    <?= $rc->getFlashData(); ?>
                </div>

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
                </fieldset>
                <fieldset class="full-margin-bottom">
                    <legend><span class="glyphicon glyphicon-envelope"></span> Contact Details</legend>

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
                                <input name="contact-phone" id="contact-phone" type="tel" maxlength="11" class="form-control" placeholder="08012345678" value="<?= isset($fields['contact-phone']) ? $fields['contact-phone'] : ''; ?>"/>
                            </div>
                        </div>
                    </div>

                </fieldset>
                <!--/GENERAL USER DATA--->

                <!--EMPLOYMENT DATA--->
                <?php
                include_once("Application/Views/includes/employment-data-editor.php");
                ?>
                <!--/EMPLOYMENT DATA--->

                <div class="btn-group pull-right">
                    <button name="add" type="submit" class="btn btn-primary btn-lg">
                        Add Staff <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php
require_once("footer.php");
?>