<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/22/2016
 * Time:    4:01 PM
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
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/add-consultation/'); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> <span class="sr-only">Add Consultation</span></a>
            </h3>

            <div class="btn-group pull-right">
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=booked'); ?>" class="btn btn-primary">Booked</a>
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=canceled'); ?>" class="btn btn-danger">Canceled</a>
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
                                <td>Doctor</td>
                                <td>Patient's Name</td>
                                <td>Card Number #</td>
                                <td width="5%"><span class="glyphicon glyphicon-check"></span></td>
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
                                    <td><?= $consultation->getDoctor()->getPersonalInfo()->getShortName(); ?></td>
                                    <td><?= $consultation->getPatient()->getPersonalInfo()->getNames(); ?></td>
                                    <td><?= $consultation->getPatient()->getCardNumber(); ?></td>
                                    <td><input type="checkbox" name="consultation-ids[]" value="<?= $consultation->getId(); ?>"></td>
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
                                <input name="action" type="submit" class="btn btn-danger" value="Cancel">
                                <?php
                            } break;
                            case 'canceled' : {
                                ?>
                                <input name="action" type="submit" class="btn btn-primary" value="Restore">
                                <input name="action" type="submit" class="btn btn-danger" value="Delete Permanently">
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