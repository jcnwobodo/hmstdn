<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/20/2016
 * Time:    9:09 PM
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
                <span class="glyphicon glyphicon-user"></span> Manage Staff List
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/add-user/?type='.$data['type']); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> <span class="sr-only">Add Staff</span></a>
            </h3>

            <div class="row">
                <div class="col-sm-6">
                    <div class="btn-group">
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?type=admin'); ?>" class="btn btn-primary">Admin</a>
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?type=doctor'); ?>" class="btn btn-primary">Doctor</a>
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?type=lab_technician'); ?>" class="btn btn-primary">Lab. Technician</a>
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?type=receptionist'); ?>" class="btn btn-primary">Receptionist</a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="btn-group pull-right">
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=active&type='.$data['type']); ?>" class="btn btn-success">Active</a>
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=inactive&type='.$data['type']); ?>" class="btn btn-warning">Inactive</a>
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=deleted&type='.$data['type']); ?>" class="btn btn-danger">Deleted</a>
                    </div>
                </div>
            </div>


            <?php
            if(is_object($data['users']) and $data['users']->size())
            {
                ?>
                <form method="post">
                    <div class="table-responsive clear-both">
                        <table class="table table-stripped table-bordered table-hover full-margin-top">
                            <thead>
                            <tr>
                                <td colspan="6" class="lead"><?= ucwords($data['status']); ?> Staff Members (<?= ucwords($data['type']); ?>s)</td>
                            </tr>
                            <tr>
                                <td>SN</td>
                                <td>Staff Name</td>
                                <td>Employee ID</td>
                                <td>Department</td>
                                <td>Specialization</td>
                                <td><span class="glyphicon glyphicon-check"></span></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sn = 0;
                            foreach($data['users'] as $user)
                            {
                                $p = $user->getPersonalInfo();
                                $e = $user->getEmploymentData();
                                ?>
                                <tr>
                                    <td><?= ++$sn; ?></td>
                                    <td><?= $p->getNames(); ?></td>
                                    <td><?= $user->getUsername(); ?></td>
                                    <td><?= $e->getDepartment(); ?></td>
                                    <td><?= $e->getSpecialization(); ?></td>
                                    <td><input type="checkbox" name="user-ids[]" value="<?= $user->getId(); ?>"></td>
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
                    <p class="lead full-margin-top">There are currently no <?= $data['status'].' '.$data['type']; ?>s.</p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php
require_once("footer.php");
?>