<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    12/5/2015
 * Time:    3:10 PM
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
            <span class="glyphicon glyphicon-plus"></span> Add Location
        </h3>

        <form method="post">
            <div class="row mid-margin-bottom">
                <div class="col-md-12">
                    <div class="btn-group pull-right">
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?type=district'); ?>" class="btn btn-primary">District</a>
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?type=lga'); ?>" class="btn btn-primary">LGA</a>
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?type=state'); ?>" class="btn btn-primary">State</a>
                    </div>
                </div>
            </div>
            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="location-name">Name of <?= ucwords($data['type']);?></label>
                    </div>
                    <div class="col-sm-9">
                        <input name="location-name" id="location-name" type="text" class="form-control" required value="<?= isset($fields['location-name']) ? $fields['location-name'] : ''; ?>"/>
                    </div>
                </div>
            </div>
            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="location-slogan">Slogan</label>
                    </div>
                    <div class="col-sm-9">
                        <input name="location-slogan" id="location-slogan" type="text" class="form-control" value="<?= isset($fields['location-slogan']) ? $fields['location-slogan'] : ''; ?>"/>
                    </div>
                </div>
            </div>
            <?php
            if($data['type'] != 'state')
            {
                ?>
                <div class="form-group form-group-sm">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="parent-state">State</label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" name="parent-state" id="parent-state">
                                <?php
                                foreach($data['states'] as $state)
                                {
                                    ?>
                                    <option value="<?= $state->getId(); ?>" <?= selected($state->getId(), isset($fields['parent-state'])?$fields['parent-state']:null); ?>><?= $state->getLocationName(); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <?php
            }
            if($data['type'] != 'state' and $data['type'] != 'lga') {
                ?>
                <div class="form-group form-group-sm">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="parent-lga">LGA</label>
                        </div>
                        <div class="col-sm-9">
                            <select name="parent-lga" id="parent-lga" class="form-control">
                                <?php
                                foreach($data['lgas'] as $lga)
                                {
                                    ?>
                                    <option value="<?= $lga->getId(); ?>" <?= selected($lga->getId(), isset($fields['parent-lga'])?$fields['parent-lga']:null); ?>><?= $lga->getLocationName(); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="location-coordinates-latitude">Coordinates</label>
                    </div>
                    <div class="col-sm-5 col-xs-6">
                        <input name="location-coordinates[latitude]" id="location-coordinates-latitude" type="text" class="form-control" placeholder="Latitude" required value="<?= isset($fields['location-coordinates']['latitude']) ? $fields['location-coordinates']['latitude'] : ''; ?>"/>
                    </div>
                    <div class="col-sm-4 col-xs-6">
                        <input name="location-coordinates[longitude]" id="location-coordinates-longitude" type="text" class="form-control" placeholder="Longitude" required value="<?= isset($fields['location-coordinates']['longitude']) ? $fields['location-coordinates']['longitude'] : ''; ?>"/>
                    </div>
                </div>
            </div>
            <div class="text-center mid-margin-bottom <?= $data['status'] ? 'text-success bg-success' : 'text-danger bg-danger';?>"><?= $rc->getFlashData(); ?></div>
            <div class="btn-group pull-right">
                <button name="add" type="submit" class="btn btn-success">
                    Add Location <span class="glyphicon glyphicon-plus"></span>
                </button>
            </div>
        </form>
    </div>
</div>
<?php
require_once("footer.php");
?>