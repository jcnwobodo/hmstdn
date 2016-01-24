<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/23/2016
 * Time:    12:43 PM
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
                <span class="glyphicon glyphicon-tint"></span> Lab. Test Request Form
            </h3>

            <form method="post" enctype="multipart/form-data">

                <div class="text-center mid-margin-bottom <?= $data['status'] ? 'text-success bg-success' : 'text-danger bg-danger';?>"><?= $rc->getFlashData(); ?></div>

                <div class="form-group form-group-sm">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="consultation"><span class="glyphicon glyphicon-user"></span> Patient</label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" name="consultation" id="consultation">
                                <?php
                                foreach($data['consultations'] as $consultation)
                                {
                                    ?>
                                    <option value="<?= $consultation->getId(); ?>" <?= selected($consultation->getId(), isset($fields['consultation']) ? $fields['consultation'] : null); ?>>
                                        [ <?= $consultation->getMeetingDate()->getDateTimeStrF("m-d-y"); ?> ]
                                        [ <?= $consultation->getStartTime()->getDateTimeStrF("g:i A"); ?> ->
                                        <?= $consultation->getEndTime()->getDateTimeStrF("g:i A"); ?> ]
                                        <?= $consultation->getPatient()->getPersonalInfo()->getNames(); ?>
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
            </form>
        </div>
    </div>
<?php
require_once("footer.php");
?>