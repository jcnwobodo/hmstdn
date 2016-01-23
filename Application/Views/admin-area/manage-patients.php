<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/22/2016
 * Time:    5:46 AM
 **/

$rc = \System\Request\RequestContext::instance();
$data = $rc->getResponseData();

require_once("header.php");
?>
    <div class="row">
        <?php
        require_once("sidebar.php");
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3 class="page-header">
                <span class="glyphicon glyphicon-user"></span> Manage Patients
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/add-patient/'); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> <span class="sr-only">Add Patient</span></a>
            </h3>

            <div class="row">
                <div class="col-sm-12">
                    <div class="btn-group pull-right">
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=active'); ?>" class="btn btn-success">Active</a>
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=inactive'); ?>" class="btn btn-warning">Inactive</a>
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=deleted'); ?>" class="btn btn-danger">Deleted</a>
                    </div>
                </div>
            </div>


            <?php
            if(is_object($data['patients']) and $data['patients']->size())
            {
                ?>
                <form method="post">
                    <div class="table-responsive clear-both">
                        <table class="table table-stripped table-bordered table-hover full-margin-top">
                            <thead>
                            <tr>
                                <td colspan="5" class="lead"><?= ucwords($data['status']); ?> Patients</td>
                            </tr>
                            <tr>
                                <td>SN</td>
                                <td>Card Number #</td>
                                <td>Names</td>
                                <td>Gender</td>
                                <td><span class="glyphicon glyphicon-check"></span></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sn = 0;
                            foreach($data['patients'] as $patient)
                            {
                                $p = $patient->getPersonalInfo();
                                ?>
                                <tr>
                                    <td><?= ++$sn; ?></td>
                                    <td><?= $patient->getCardNumber(); ?></td>
                                    <td><?= $p->getNames(); ?></td>
                                    <td><?= $p->getGender(); ?></td>
                                    <td><input type="checkbox" name="patient-ids[]" value="<?= $patient->getId(); ?>"></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="btn-group pull-right">
                        <?php
                        switch($data['status'])
                        {
                            case 'inactive' : {
                                ?>
                                <input name="action" type="submit" class="btn btn-success" value="Activate">
                                <input name="action" type="submit" class="btn btn-danger" value="Delete">
                                <?php
                            } break;
                            case 'active' : {
                                ?>
                                <input name="action" type="submit" class="btn btn-primary" value="Deactivate">
                                <input name="action" type="submit" class="btn btn-danger" value="Delete">
                                <?php
                            } break;
                            case 'deleted' : {
                                ?>
                                <input name="action" type="submit" class="btn btn-success" value="Restore">
                                <input name="action" type="submit" class="btn btn-danger" value="Delete Permanently">
                                <?php
                            } break;
                        }
                        ?>
                    </div>
                </form>
                <?php
            }
            else
            {
                ?>
                <div class="clear-both text-center text-primary">
                    <p class="lead full-margin-top">There are currently no <?= $data['status']; ?> patients.</p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php
require_once("footer.php");
?>