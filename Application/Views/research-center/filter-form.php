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
$fields = $requestContext->getAllFields();
?>
<form method="post" enctype="multipart/form-data" class="full-margin-bottom">

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="filter-by"><span class="glyphicon glyphicon-filter"></span> Filter Results By</label>
            </div>
            <div class="col-sm-9">
                <select name="filter-by" id="filter-by" class="form-control">
                    <option value="nil">nil</option>
                    <option value="location" <?= selected('location', isset($fields['filter-by']) ? $fields['filter-by'] : null); ?>> Location</option>
                    <option value="disease" <?= selected('disease', isset($fields['filter-by']) ? $fields['filter-by'] : null); ?>> Disease</option>
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
                <label for="start-date"><span class="glyphicon glyphicon-calendar"></span> From</label>
            </div>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-xs-5">
                        <?= drop_month('start-date[month]', isset($fields['start-date']['month']) ? $fields['start-date']['month'] : null ); ?>
                    </div>
                    <div class="col-xs-3 no-padding">
                        <?= drop_month_days('start-date[day]', isset($fields['start-date']['day']) ? $fields['start-date']['day'] : null ); ?>
                    </div>
                    <div class="col-xs-4">
                        <?= drop_years('start-date[year]', isset($fields['start-date']['year']) ? $fields['start-date']['year'] : null ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="end-date"><span class="glyphicon glyphicon-calendar"></span> To</label>
            </div>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-xs-5">
                        <?= drop_month('end-date[month]', isset($fields['end-date']['month']) ? $fields['end-date']['month'] : null ); ?>
                    </div>
                    <div class="col-xs-3 no-padding">
                        <?= drop_month_days('end-date[day]', isset($fields['end-date']['day']) ? $fields['end-date']['day'] : null ); ?>
                    </div>
                    <div class="col-xs-4">
                        <?= drop_years('end-date[year]', isset($fields['end-date']['year']) ? $fields['end-date']['year'] : null ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="btn-group pull-right">
        <button name="filter" type="submit" class="btn btn-primary">
            Filter Report <span class="glyphicon glyphicon-filter"></span>
        </button>
    </div>
    <div class="clear-both">&nbsp;</div>
</form>

