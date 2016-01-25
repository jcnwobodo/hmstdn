<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/20/2016
 * Time:    12:42 PM
 **/

?>
<fieldset class="full-margin-bottom">
    <legend><span class="glyphicon glyphicon-user"></span> Personal Data</legend>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="first-name">Names</label>
            </div>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-4">
                        <input name="first-name" id="first-name" required type="text" maxlength="25" class="form-control" placeholder="First name" value="<?= isset($fields['first-name']) ? $fields['first-name'] : ''; ?>"/>
                    </div>
                    <div class="col-sm-4">
                        <input name="last-name" id="last-name" required type="text" maxlength="25" class="form-control" placeholder="Last name" value="<?= isset($fields['last-name']) ? $fields['last-name'] : ''; ?>"/>
                    </div>
                    <div class="col-sm-4">
                        <input name="other-names" id="other-names" type="text" maxlength="50" class="form-control" placeholder="Other names" value="<?= isset($fields['other-names']) ? $fields['other-names'] : ''; ?>"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="gender">Gender</label>
            </div>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-xs-5">
                        <label for="female" class="radio-inline">
                            <input type="radio" name="gender" id="female" value="F" <?= isset($fields['gender']) ? ( $fields['gender']=='F' ? 'checked="checked"' : '') : 'checked="checked"'; ?>/>
                            Female
                        </label>
                    </div>
                    <div class="col-xs-5">
                        <label for="male" class="radio-inline">
                            <input type="radio" name="gender" id="male" value="M" <?= isset($fields['gender']) ? ( $fields['gender']=='M' ? 'checked="checked"' : '') : '' ; ?>/>
                            Male
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="date-of-birth"><span class="glyphicon glyphicon-calendar"></span> Date of Birth</label>
            </div>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-xs-5">
                        <?= drop_month('date-of-birth[month]', isset($fields['date-of-birth']['month']) ? $fields['date-of-birth']['month'] : null ); ?>
                    </div>
                    <div class="col-xs-3">
                        <?= drop_month_days('date-of-birth[day]', isset($fields['date-of-birth']['day']) ? $fields['date-of-birth']['day'] : null ); ?>
                    </div>
                    <div class="col-xs-4">
                        <?= drop_years('date-of-birth[year]', isset($fields['date-of-birth']['year']) ? $fields['date-of-birth']['year'] : null , date('Y')-18, date('Y')-40 ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="nationality">Nationality</label>
            </div>
            <div class="col-sm-9">
                <input name="nationality" id="nationality" type="text" maxlength="50" class="form-control" placeholder="Nationality" value="<?= isset($fields['nationality']) ? $fields['nationality'] : ''; ?>"/>
            </div>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="state-of-origin">State of Origin</label>
            </div>
            <div class="col-sm-9">
                <input name="state-of-origin" id="state-of-origin" type="text" maxlength="50" class="form-control" placeholder="State of origin" value="<?= isset($fields['state-of-origin']) ? $fields['state-of-origin'] : ''; ?>"/>
            </div>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="lga-of-origin">Local Govt. of Origin</label>
            </div>
            <div class="col-sm-9">
                <input name="lga-of-origin" id="lga-of-origin" type="text" maxlength="50" class="form-control" placeholder="Local Government Area" value="<?= isset($fields['lga-of-origin']) ? $fields['lga-of-origin'] : ''; ?>"/>
            </div>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="passport-photo">Recent Passport Photograph</label>
            </div>
            <div class="col-sm-9">
                <input name="passport-photo" id="passport-photo" type="file" class="form-control"/>
                <p class="help-block">Passport must be in jpg format and not more than 200kb</p>
            </div>
        </div>
    </div>

</fieldset>

<fieldset class="full-margin-bottom">
    <legend><span class="glyphicon glyphicon-envelope"></span> Contact Details</legend>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="residence-country">Country of Residence</label>
            </div>
            <div class="col-sm-9">
                <input name="residence-country" id="residence-country" type="text" maxlength="50" class="form-control" placeholder="Country of residence e.g Nigeria" value="<?= isset($fields['residence-country']) ? $fields['residence-country'] : ''; ?>"/>
            </div>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="residence-state">State of Residence</label>
            </div>
            <div class="col-sm-9">
                <input name="residence-state" id="residence-state" type="text" maxlength="50" class="form-control" placeholder="State of Residence e.g Enugu" value="<?= isset($fields['residence-state']) ? $fields['residence-state'] : ''; ?>"/>
            </div>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="residence-city">City/Town of Residence</label>
            </div>
            <div class="col-sm-9">
                <input name="residence-city" id="residence-city" type="text" maxlength="50" class="form-control" placeholder="City or Town of Residence e.g Nsukka" value="<?= isset($fields['residence-city']) ? $fields['residence-city'] : ''; ?>"/>
            </div>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="residence-street">Street/House Address</label>
            </div>
            <div class="col-sm-9">
                <input name="residence-street" id="residence-street"  type="text" maxlength="100" class="form-control" placeholder="Street Address e.g No. 88 Aku Road, Nsukka" value="<?= isset($fields['residence-street']) ? $fields['residence-street'] : ''; ?>"/>
            </div>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="contact-email">Contact E-mail</label>
            </div>
            <div class="col-sm-9">
                <input name="contact-email" id="contact-email" type="email" maxlength="100" class="form-control" placeholder="mail_address@domain.com" value="<?= isset($fields['contact-email']) ? $fields['contact-email'] : ''; ?>"/>
            </div>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="contact-phone">Mobile Number</label>
            </div>
            <div class="col-sm-9">
                <input name="contact-phone" id="contact-phone" type="tel" maxlength="11" class="form-control" placeholder="08012345678" value="<?= isset($fields['contact-phone']) ? $fields['contact-phone'] : ''; ?>"/>
            </div>
        </div>
    </div>

</fieldset>
