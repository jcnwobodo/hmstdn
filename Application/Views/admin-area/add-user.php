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
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?type=admin-area'); ?>" class="btn btn-primary">Admin</a>
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
                <?php
                include_once("Application/Views/includes/user-profile-editor.php");
                ?>
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