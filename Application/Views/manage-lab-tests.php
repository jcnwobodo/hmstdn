<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/23/2016
 * Time:    4:29 PM
 **/

$rc = \System\Request\RequestContext::instance();
$data = $rc->getResponseData();

require_once("Application/Views/admin-area/header.php");
?>
    <div class="row">
        <?php
        $fd = ($rc->getRequestUrlParam(0)=='lab-tech-area'?'lab-center':$rc->getRequestUrlParam(0));
        require_once("Application/Views/".($fd)."/sidebar.php");
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3 class="page-header">
                <span class="glyphicon glyphicon-tint"></span> Manage Lab. Tests
            </h3>

            <div class="btn-group pull-right">
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=completed'); ?>" class="btn btn-success">Completed</a>
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=pending'); ?>" class="btn btn-warning">Pending</a>
                <?php if($rc->getRequestUrlParam(0)!='lab-tech-area'){ ?>
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=deleted'); ?>" class="btn btn-danger">Deleted</a>
                <?php } ?>
            </div>

            <?php
            if(is_object($data['tests']) and $data['tests']->size())
            {
                ?>
                <form method="post">
                    <div class="table-responsive clear-both">
                        <table class="table table-stripped table-bordered table-hover full-margin-top">
                            <thead>
                            <tr>
                                <td colspan="7" class="lead"><span class="glyphicon glyphicon-tint"></span> <?= ucwords($data['status']); ?> Lab. Tests</td>
                            </tr>
                            <tr>
                                <td width="4%">SN</td>
                                <td><span class="glyphicon glyphicon-user"></span> Doctor</td>
                                <?php if($data['status']=='completed'){ ?>
                                    <td><span class="glyphicon glyphicon-user"></span> Operator</td>
                                <?php } ?>
                                <td><span class="glyphicon glyphicon-alert"></span> Disease</td>
                                <?php if($data['status']=='completed'){?>
                                    <td><span class="glyphicon glyphicon-option-horizontal"></span> Result</td>
                                <?php } ?>
                                <td><span class="glyphicon glyphicon-calendar"></span> Date</td>
                                <td width="5%">&hellip;</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sn = 0;
                            foreach($data['tests'] as $test)
                            {
                                ?>
                                <tr>
                                    <td><?= ++$sn; ?></td>
                                    <td>
                                        <label for="<?= "ln".$sn; ?>">
                                            <?= $test->getConsultation()->getDoctor()->getPersonalInfo()->getShortName(); ?>
                                        </label>
                                    </td>
                                    <?php if($data['status']=='completed'){ ?>
                                        <td><?= $test->getOperator()->getPersonalInfo()->getShortName(); ?></td>
                                    <?php } ?>
                                    <td>
                                        <label for="<?= "ln".$sn; ?>">
                                            <?= $test->getDisease()->getName(); ?>
                                        </label>
                                    </td>
                                    <?php if($data['status']=='completed'){ ?>
                                        <td><?= $test->getResult() ? 'Positive': 'Negative'; ?></td>
                                    <?php } ?>
                                    <td class="text-nowrap"><?= $test->getRequestDate()->getDateTimeStrF("m-d-Y - g:i A"); ?></td>
                                    <td><input type="checkbox" name="test-ids[]" id="<?= "ln".$sn; ?>" value="<?= $test->getId(); ?>"></td>
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
                            case 'pending' : {
                                if($rc->getRequestUrlParam(0)=='lab-tech-area')
                                {
                                    ?>
                                    <input name="action" type="submit" class="btn btn-success" value="Mark as Positive">
                                    <input name="action" type="submit" class="btn btn-warning" value="Mark as Negative">
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <input name="action" type="submit" class="btn btn-danger" value="Delete">
                                    <?php
                                }
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
                    <p class="lead">There are currently no <?= $data['status']; ?> tests.</p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php
require_once("Application/Views/admin-area/footer.php");
?>