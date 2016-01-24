<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/24/2016
 * Time:    4:11 PM
 **/

$requestContext = $rc = \System\Request\RequestContext::instance();
$data = $requestContext->getResponseData();
?>
<form method="post" enctype="multipart/form-data" class="full-margin-bottom">

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="disease"><span class="glyphicon glyphicon-filter"></span> Filter Results By</label>
            </div>
            <div class="col-sm-9">
                <select name="disease" id="disease" class="form-control">
                    <option value="">nil</option>
                    <option value="location" <?= selected('location', isset($fields['filter-by']) ? $fields['filter-by'] : null); ?>> Location</option>
                    <option value="disease" <?= selected('disease', isset($fields['filter-by']) ? $fields['filter-by'] : null); ?>> Disease</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="disease"><span class="glyphicon glyphicon-alert"></span> Disease</label>
            </div>
            <div class="col-sm-9">
                <select name="disease" id="disease" class="form-control">
                    <?php
                    foreach($data['diseases'] as $disease)
                    {
                        ?>
                        <option value="<?= $disease->getId(); ?>" <?= selected($disease->getId(), isset($fields['disease']) ? $fields['disease'] : null); ?>>
                            <?= $disease->getName(); ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="location"><span class="glyphicon glyphicon-globe"></span> Patient's Location</label>
            </div>
            <div class="col-sm-9">
                <select name="location" id="location" class="form-control">
                    <?php
                    foreach($data['locations'] as $location)
                    {
                        ?>
                        <option value="<?= $location->getId(); ?>" <?= selected($location->getId(), isset($fields['location']) ? $fields['location'] : null); ?>>
                            <?= $location->getLocationName(); ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>

    <div class="btn-group pull-right">
        <button name="request" type="submit" class="btn btn-primary">
            Submit Request <span class="glyphicon glyphicon-send"></span>
        </button>
    </div>
    <div class="clear-both">&nbsp;</div>
</form>

