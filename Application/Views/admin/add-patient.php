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
                <?php
                include_once("Application/Views/includes/user-profile-editor.php");
                ?>
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