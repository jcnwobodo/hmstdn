<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/23/2016
 * Time:    5:22 AM
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
                <span class="glyphicon glyphicon-hourglass"></span> Manage Consultations
            </h3>

            <div class="btn-group pull-right">
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=booked'); ?>" class="btn btn-primary">Booked</a>
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=completed'); ?>" class="btn btn-success">Completed</a>
            </div>


            <?php
            if(is_object($data['consultations']) and $data['consultations']->size())
            {
                ?>
                <form method="post">
                    <div class="table-responsive clear-both">
                        <table class="table table-stripped table-bordered table-hover full-margin-top">
                            <thead>
                            <tr>
                                <td colspan="7" class="lead"><span class="glyphicon glyphicon-hourglass"></span> <?= ucwords($data['status']); ?> Consultations</td>
                            </tr>
                            <tr>
                                <td width="4%">SN</td>
                                <td><span class="glyphicon glyphicon-calendar"></span> Date</td>
                                <td><span class="glyphicon glyphicon-time"></span> Time</td>
                                <td>Card Number #</td>
                                <td><span class="glyphicon glyphicon-user">Patient</td>
                                <td><span class="glyphicon glyphicon-tasks"></td>
                                <?php if($data['status']=='booked'){ ?><td width="5%"><span class="glyphicon glyphicon-check"></span></td><?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sn = 0;
                            foreach($data['consultations'] as $consultation)
                            {
                                ?>
                                <tr>
                                    <td><?= ++$sn; ?></td>
                                    <td class="text-nowrap"><?= $consultation->getMeetingDate()->getDateTimeStrF("M d, Y"); ?></td>
                                    <td class="text-nowrap">
                                        <?= $consultation->getStartTime()->getDateTimeStrF("g:i:s A"); ?> -
                                        <?= $consultation->getEndTime()->getDateTimeStrF("g:i:s A"); ?>
                                    </td>
                                    <td><?= $consultation->getPatient()->getCardNumber(); ?></td>
                                    <td><?= $consultation->getPatient()->getPersonalInfo()->getNames(); ?></td>
                                    <td>
                                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/consultation-info/?cid='.$consultation->getId()); ?>" title="More Info">
                                            <span class="glyphicon glyphicon-zoom-in"></span>
                                        </a>
                                    </td>
                                    <?php if($data['status']=='booked'){ ?>
                                    <td><input type="checkbox" name="consultation-ids[]" value="<?= $consultation->getId(); ?>"/></td>
                                    <?php } ?>
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
                            case 'booked' : {
                                ?>
                                <input name="action" type="submit" class="btn btn-success" value="Mark as Completed">
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
                    <p class="lead">There are currently no <?= $data['status']; ?> consultations.</p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php
require_once("footer.php");
?>