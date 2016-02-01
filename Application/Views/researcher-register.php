<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/24/2016
 * Time:    3:00 PM
 **/


$rc = \System\Request\RequestContext::instance();
$data = $rc->getResponseData();

$fields = $rc->getAllFields();
if($rc->fieldIsSet('register')) if($data['status']==1) $fields = array();

require_once("header.php");
?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h1 class="page-header no-margin full-margin-bottom">
            <span class="glyphicon glyphicon-user"></span> Researcher Registration Form
        </h1>

        <form method="post" enctype="multipart/form-data" action="<?php home_url('/register/'); ?>">

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
            <!--/GENERAL USER DATA--->

            <!--EMPLOYMENT DATA--->
            <?php
            include_once("Application/Views/includes/access-data-editor.php");
            ?>
            <!--/EMPLOYMENT DATA--->

            <div class="btn-group pull-right">
                <button name="register" type="submit" class="btn btn-primary btn-lg">
                    Register ! <span class="glyphicon glyphicon-plus"></span>
                </button>
            </div>
        </form>
    </div>
</div>
<?php
require_once("footer.php");
?>