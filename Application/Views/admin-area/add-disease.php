<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/22/2016
 * Time:    6:44 PM
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
                <span class="glyphicon glyphicon-plus"></span> Add Disease
            </h3>

            <form method="post" enctype="multipart/form-data" action="<?php home_url("/".$rc->getRequestUrlParam(0)."/".$rc->getRequestUrlParam(1)."/#form1")?>" id="form1">

                <div class="text-center mid-margin-bottom <?= $data['status'] ? 'text-success bg-success' : 'text-danger bg-danger';?>"><?= $rc->getFlashData(); ?></div>

                <div class="form-group form-group-sm">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="name">Name of Disease</label>
                        </div>
                        <div class="col-sm-9">
                            <input name="name" id="name" type="text" class="form-control" required value="<?= isset($fields['name']) ? $fields['name'] : ''; ?>"/>
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="causes">Causative Organisms</label>
                        </div>
                        <div class="col-sm-9">
                            <textarea name="causes" id="causes" class="form-control" required class="height-10vh" style="height: 5em;"><?= isset($fields['causes']) ? $fields['causes'] : ''; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="signs">Signs and Symptoms</label>
                        </div>
                        <div class="col-sm-9">
                            <textarea name="signs" id="signs" class="form-control" required class="height-20vh" style="height: 10em;"><?= isset($fields['signs']) ? $fields['signs'] : ''; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="btn-group pull-right">
                    <button name="add" type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span> Add Disease
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php
require_once("footer.php");
?>