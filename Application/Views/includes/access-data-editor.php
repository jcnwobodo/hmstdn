<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/24/2016
 * Time:    3:02 PM
 **/
?>
<fieldset class="full-margin-bottom">
    <legend><span class="glyphicon glyphicon-briefcase"></span> Login Details</legend>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="researcher-id">Login Email</label>
            </div>
            <div class="col-sm-9">
                <input name="researcher-id" id="researcher-id" required type="email" maxlength="50" class="form-control" placeholder="firstname.lastname@company.com" value="<?= isset($fields['researcher-id']) ? $fields['researcher-id'] : ''; ?>"/>
            </div>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="password1">Password</label>
            </div>
            <div class="col-sm-9">
                <input name="password1" id="password1" required type="password" maxlength="50" class="form-control" value="<?= isset($fields['password1']) ? $fields['password1'] : ''; ?>"/>
            </div>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="password2">Confirm Password</label>
            </div>
            <div class="col-sm-9">
                <input name="password2" id="password2" required type="password" maxlength="50" class="form-control" value="<?= isset($fields['password2']) ? $fields['password2'] : ''; ?>"/>
            </div>
        </div>
    </div>

</fieldset>
