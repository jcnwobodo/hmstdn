<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: HMSTDN
 * Date:    2/1/2016
 * Time:    12:34 PM
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
                <span class="glyphicon glyphicon-plus-sign"></span> Manage Clinics
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/add-clinic/'); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> <span class="sr-only">Add Clinic</span></a>
            </h3>

            <div class="btn-group pull-right">
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=approved'); ?>" class="btn btn-primary">Approved</a>
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=deleted'); ?>" class="btn btn-danger">Deleted</a>
            </div>


            <?php
            if(is_object($data['clinics']) and $data['clinics']->size())
            {
                ?>
                <form method="post">
                    <div class="table-responsive clear-both">
                        <table class="table table-stripped table-bordered table-hover full-margin-top">
                            <thead>
                            <tr>
                                <td colspan="8" class="lead"><span class="glyphicon glyphicon-plus-sign"></span> <?= ucwords($data['status']); ?> Clinics</td>
                            </tr>
                            <tr>
                                <td width="4%">SN</td>
                                <td>Clinic Name</td>
                                <td>Clinic ID</td>
                                <td>Location</td>
                                <td>Phone</td>
                                <td width="5%"><span class="glyphicon glyphicon-edit"></span></td>
                                <td width="5%"><input id="check_button" type="checkbox" onChange="checker('clinic-ids[]', 'check_button');" title="Select All"/></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sn = 0;
                            foreach($data['clinics'] as $clinic)
                            {
                                ?>
                                <tr>
                                    <td><?= ++$sn; ?></td>
                                    <td><?= $clinic->getName(); ?></td>
                                    <td><?= $clinic->getClinicId(); ?></td>
                                    <td><?= $clinic->getLocationState()->getLocationName(); ?></td>
                                    <td><?= $clinic->getContactPhone(); ?></td>
                                    <td><a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/update-clinic/?cid='.$clinic->getId())?>"><span class="glyphicon glyphicon-edit"></span></a> </td>
                                    <td><input type="checkbox" name="clinic-ids[]" value="<?= $clinic->getId(); ?>"></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="pull-right text-right">
                        <?php
                        switch($data['status'])
                        {
                            case 'approved' : {
                                ?>
                                <input name="action" type="submit" class="btn btn-danger" value="Delete">
                                <p class="text-warning">Please ensure that all employees assigned to this clinic have been re-assigned to another clinic before deletion</p>
                                <?php
                            } break;
                            case 'deleted' : {
                                ?>
                                <input name="action" type="submit" class="btn btn-primary" value="Restore">
                                <input name="action" type="submit" class="btn btn-danger" value="Delete Permanently">
                                <p class="text-warning">Please ensure that all employees assigned to this clinic have been re-assigned to another clinic before deletion</p>
                                <?php
                            }
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
                    <p class="lead">There are currently no <?= $data['status']; ?> clinics.</p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php
require_once("footer.php");
?>