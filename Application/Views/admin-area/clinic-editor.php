<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: HMSTDN
 * Date:    2/1/2016
 * Time:    12:47 PM
 **/

$rc = \System\Request\RequestContext::instance();
$data = $rc->getResponseData();
$location_states = $data['location-states'];

require_once("header.php");
?>
    <div class="row">
        <?php
        require_once("sidebar.php");
        ?>

        <?php
        switch($data['mode'])
        {
            case('add-clinic'):{
                $fields = $rc->getAllFields();
                $default_action = array('name'=>$data['mode'], 'label'=>"Add Clinic");
            } break;
            case('update-clinic'):{
                $fields = $data['fields'];
                $default_action = array('name'=>$data['mode'], 'label'=>"Update Clinic");
            } break;
        }
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3 class="page-header">
                <span class="glyphicon glyphicon-plus"></span> <?= $data['mode']=='add-clinic'?"Add":"Update"; ?> Clinic
            </h3>
            <div class="text-center mid-margin-bottom <?= $data['status'] ? 'text-success bg-success' : 'text-danger bg-danger';?>"><?= $rc->getFlashData(); ?></div>

            <form method="post" enctype="multipart/form-data" <?= $data['mode']=='update-clinic'? 'action="'.home_url('/'.$rc->getRequestUrlParam(0).'/update-clinic/?cid='.$data['cid'],0).'"':''; ?>>
                <?php if($data['mode']=='update-clinic'){ ?><input type="hidden" name="cid" value="<?= $data['cid']; ?>"/><?php } ?>

                <div class="form-group form-group-sm">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="clinic-name"><span class="glyphicon glyphicon-flag"></span> Clinic Name</label>
                        </div>
                        <div class="col-sm-9">
                            <input name="clinic-name" id="clinic-name" type="text" maxlength="100" class="form-control" value="<?= isset($fields['clinic-name']) ? $fields['clinic-name'] : ''; ?>" required/>
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="clinic-id"><span class="glyphicon glyphicon-barcode"></span> Clinic ID</label>
                        </div>
                        <div class="col-sm-9">
                            <input name="clinic-id" id="clinic-id" type="text" maxlength="100" class="form-control" placeholder="HC/001" value="<?= isset($fields['clinic-id']) ? $fields['clinic-id'] : ''; ?>" required/>
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="location-state"><span class="glyphicon glyphicon-globe"></span> Location (State)</label>
                        </div>
                        <div class="col-sm-9">
                            <select name="location-state" class="form-control" id="location-state" required>
                                <option></option>
                                <?php
                                foreach($location_states as $state)
                                {
                                    ?>
                                    <option value="<?= $state->getId(); ?>" <?= selected($state->getId(), isset($fields['location-state']) ? $fields['location-state'] : null); ?>><?= $state->getLocationName(); ?></option>
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
                            <label for="location-street"><span class="glyphicon glyphicon-map-marker"></span> Town/Street/House Address</label>
                        </div>
                        <div class="col-sm-9">
                            <input name="location-street" id="location-street"  type="text" maxlength="100" class="form-control" placeholder="Street Address e.g No. 1 Enugu Road, Nsukka" value="<?= isset($fields['location-street']) ? $fields['location-street'] : ''; ?>" required/>
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="contact-email"><span class="glyphicon glyphicon-envelope"></span> Contact E-mail</label>
                        </div>
                        <div class="col-sm-9">
                            <input name="contact-email" id="contact-email" type="email" maxlength="100" class="form-control" placeholder="mail_address@domain.com" value="<?= isset($fields['contact-email']) ? $fields['contact-email'] : ''; ?>"/>
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="contact-phone"><span class="glyphicon glyphicon-phone"></span> Mobile Number</label>
                        </div>
                        <div class="col-sm-9">
                            <input name="contact-phone" id="contact-phone" type="tel" maxlength="11" class="form-control" placeholder="08012345678" value="<?= isset($fields['contact-phone']) ? $fields['contact-phone'] : ''; ?>" required/>
                        </div>
                    </div>
                </div>

                <div class="btn-group pull-right">
                    <button name="<?= $default_action['name']; ?>" type="submit" class="btn btn-primary">
                        <span class="glyphicon <?= $data['mode']=='add-clinic'?'glyphicon-plus':'glyphicon-edit'; ?>"></span> <?= $default_action['label']; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php
require_once("footer.php");
?>