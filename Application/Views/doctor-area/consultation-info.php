<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/23/2016
 * Time:    5:57 AM
 **/

$rc = \System\Request\RequestContext::instance();

$data = $rc->getResponseData();

$consultation = $data['consultation'];
$fields = $data['fields'];

require_once("header.php");
?>
<div class="row">
    <?php
    require_once("sidebar.php");
    ?>

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h3 class="page-header">
            <span class="glyphicon glyphicon-plus"></span> Consultation Information
        </h3>

        <form method="post" enctype="multipart/form-data" action="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?cid='.$consultation->getId()); ?>">

            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="date"><span class="glyphicon glyphicon-calendar"></span> Meeting Date</label>
                    </div>
                    <div class="col-sm-9">
                        <input id="date" type="text" class="form-control" value="<?= $consultation->getMeetingDate()->getDateTimeStrF('F d, Y'); ?>" disabled/>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="time"><span class="glyphicon glyphicon-time"></span> Time</label>
                    </div>
                    <div class="col-sm-9">
                        <input id="time" type="text" class="form-control" value="<?=
                        $consultation->getStartTime()->getDateTimeStrF('g:i:s A')." - ".$consultation->getEndTime()->getDateTimeStrF('g:i:s A');
                        ?>" disabled/>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="patient"><span class="glyphicon glyphicon-user"></span> Patient</label>
                    </div>
                    <div class="col-sm-2">
                        <img src="<?php
						$photo = $consultation->getPatient()->getPersonalInfo()->getProfilePhoto();
						if(is_object($photo)) {home_url('/'.$photo->getFullPath());} ?>" class="img-thumbnail img-responsive"/>
                    </div>
                    <div class="col-sm-7">
                        <input id="card-number" type="text" class="form-control" value="#<?= $consultation->getPatient()->getCardNumber(); ?>" disabled/>
                        <input id="name" type="text" class="form-control" value="<?= $consultation->getPatient()->getPersonalInfo()->getNames(); ?>" disabled/>
                        <input id="email" type="text" class="form-control" value="<?= $consultation->getPatient()->getPersonalInfo()->getEmail(); ?>" disabled/>
                        <input id="phone" type="text" class="form-control" value="<?= $consultation->getPatient()->getPersonalInfo()->getPhone(); ?>" disabled/>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="doctor"><span class="glyphicon glyphicon-user"></span> Doctor</label>
                    </div>
                    <div class="col-sm-9">
                        <input id="doctor" type="text" disabled class="form-control" value="<?= $consultation->getDoctor()->getPersonalInfo()->getNames(); ?>"/>
                    </div>
                </div>
            </div>

            <div class="text-center mid-margin-bottom <?= $data['status'] ? 'text-success bg-success' : 'text-danger bg-danger';?>">
                <?= $rc->getFlashData(); ?>
            </div>

            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="notes"><span class="glyphicon glyphicon-edit"></span> Notes</label>
                    </div>
                    <div class="col-sm-9">
                        <textarea name="notes" id="notes" class="form-control" required style="height: 8em"><?= isset($fields['notes']) ? $fields['notes'] : ''; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="diagnoses"><span class="glyphicon glyphicon-edit"></span> Diagnoses</label>
                    </div>
                    <div class="col-sm-9">
                        <textarea name="diagnoses" id="diagnoses" class="form-control" required style="height: 5em"><?= isset($fields['diagnoses']) ? $fields['diagnoses'] : ''; ?></textarea>
                        <div>
                            <p class="btn-group btn-group-sm">
                                <a href="<?php home_url("/doctor-area/request-lab-test/?cid=".$consultation->getId()); ?>" class="btn btn-default" target="_blank">
                                    <span class="glyphicon glyphicon-flag"></span> Request Lab. Test
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="treatment"><span class="glyphicon glyphicon-edit"></span> Treatment</label>
                    </div>
                    <div class="col-sm-9">
                        <textarea name="treatment" id="treatment" class="form-control" style="height: 3em"><?= isset($fields['treatment']) ? $fields['treatment'] : ''; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="btn-group pull-right">
                <button name="update" type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-floppy-saved"></span> Update Consultation
                </button>
            </div>

        </form>

    </div>
</div>
<?php
require_once("footer.php");
?>