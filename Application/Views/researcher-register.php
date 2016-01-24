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
            <?php
            include_once("Application/Views/includes/user-profile-editor.php");
            ?>
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