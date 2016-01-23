<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    12/2/2015
 * Time:    5:39 AM
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
            <span class="glyphicon glyphicon-globe"></span> Manage Locations
            <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/add-location/?type='.$data['type']); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> <span class="sr-only">Add Location</span></a>
        </h3>

        <div class="row">
            <div class="col-sm-6">
                <div class="btn-group">
                    <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status='.$data['status'].'&type=district'); ?>" class="btn btn-primary">District</a>
                    <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status='.$data['status'].'&type=lga'); ?>" class="btn btn-primary">LGA</a>
                    <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status='.$data['status'].'&type=state'); ?>" class="btn btn-primary">State</a>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="btn-group pull-right">
                    <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=approved&type='.$data['type']); ?>" class="btn btn-success">Approved</a>
                    <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=pending&type='.$data['type']); ?>" class="btn btn-primary">Pending</a>
                    <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=deleted&type='.$data['type']); ?>" class="btn btn-danger">Deleted</a>
                </div>
            </div>
        </div>


        <?php
        if(is_object($data['locations']) and $data['locations']->size())
        {
            ?>
            <form method="post">
                <div class="table-responsive clear-both">
                    <table class="table table-stripped table-bordered table-hover full-margin-top">
                        <thead>
                        <tr>
                            <td colspan="6" class="lead"><?= ucwords($data['status']); ?> Catchment <?= ucwords($data['type']); ?>s</td>
                        </tr>
                        <tr>
                            <td>SN</td>
                            <td>Location Name</td>
                            <?php if($data['type']=='district'){ ?><td>LGA</td><?php } ?>
                            <?php if($data['type']!='state'){ ?><td>State</td><?php } ?>
                            <td>Coordinates (Lat. , Long.)</td>
                            <td>&hellip;</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sn = 0;
                        foreach($data['locations'] as $location)
                        {
                            ?>
                            <tr>
                                <td><?= ++$sn; ?></td>
                                <td><?= $location->getLocationName(); ?></td>
                                <?php if($data['type']=='district'){ ?><td><?= $location->getParent()->getLocationName(); ?></td><?php } ?>
                                <?php if($data['type']!='state'){ ?><td><?= $data['type']=='lga' ? $location->getParent()->getLocationName() : $location->getParent()->getParent()->getLocationName(); ?></td><?php } ?>
                                <td><?= $location->getLatitude().' , '.$location->getLongitude(); ?></td>
                                <td><input type="checkbox" name="location-ids[]" value="<?= $location->getId(); ?>"></td>
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
                            ?>
                            <input name="action" type="submit" class="btn btn-success" value="Approve">
                            <input name="action" type="submit" class="btn btn-danger" value="Delete">
                            <?php
                        } break;
                        case 'approved' : {
                            ?>
                            <input name="action" type="submit" class="btn btn-primary" value="Disapprove">
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
                            <input name="action" type="submit" class="btn btn-success" value="Approve">
                            <input name="action" type="submit" class="btn btn-default" value="Disapprove">
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
                <p class="lead">There are currently no <?= $data['status'].' '.$data['type']; ?>s.</p>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<?php
require_once("footer.php");
?>