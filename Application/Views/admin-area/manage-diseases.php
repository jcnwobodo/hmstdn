<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/22/2016
 * Time:    6:33 PM
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
                <span class="glyphicon glyphicon-alert"></span> Manage Diseases
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/add-disease/'); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> <span class="sr-only">Add Disease</span></a>
            </h3>

            <div class="btn-group pull-right">
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=approved'); ?>" class="btn btn-success">Approved</a>
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=deleted'); ?>" class="btn btn-danger">Deleted</a>
            </div>

            <?php
            if(is_object($data['diseases']) and $data['diseases']->size())
            {
                ?>
                <form method="post">
                    <div class="table-responsive clear-both">
                        <table class="table table-stripped table-bordered table-hover full-margin-top">
                            <thead>
                            <tr>
                                <td colspan="5" class="lead"><?= ucwords($data['status']); ?> Diseases</td>
                            </tr>
                            <tr>
                                <td width="4%">SN</td>
                                <td>Name</td>
                                <td>Causative Organisms</td>
                                <td>Signs and Symptoms</td>
                                <td width="5%">&hellip;</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sn = 0;
                            foreach($data['diseases'] as $disease)
                            {
                                ?>
                                <tr>
                                    <td><?= ++$sn; ?></td>
                                    <td><label for="<?= "ln".$sn; ?>"><?= $disease->getName(); ?></label></td>
                                    <td><?= $disease->getCausativeOrganisms(); ?></td>
                                    <td><?= $disease->getSignsAndSymptoms(); ?></td>
                                    <td><input type="checkbox" name="disease-ids[]" id="<?= "ln".$sn; ?>" value="<?= $disease->getId(); ?>"></td>
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
                            case 'approved' : {
                                ?>
                                <input name="action" type="submit" class="btn btn-danger" value="Delete">
                                <?php
                            } break;
                            case 'deleted' : {
                                ?>
                                <input name="action" type="submit" class="btn btn-success" value="Restore">
                                <input name="action" type="submit" class="btn btn-danger" value="Delete Permanently">
                                <?php
                            } break;
                            default : {
                                ?>
                                <input name="action" type="submit" class="btn btn-danger" value="Delete">
                                <input name="action" type="submit" class="btn btn-success" value="Restore">
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
                    <p class="lead">There are currently no <?= $data['status']; ?> diseases.</p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php
require_once("footer.php");
?>