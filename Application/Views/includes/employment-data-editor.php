<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/20/2016
 * Time:    1:01 PM
 **/
?>
<fieldset class="full-margin-bottom">
    <legend><span class="glyphicon glyphicon-briefcase"></span> Employment Details</legend>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="department">Department</label>
            </div>
            <div class="col-sm-9">
                <input name="department" id="department" required type="text" maxlength="50" class="form-control" placeholder="Employee's Department" value="<?= isset($fields['department']) ? $fields['department'] : ''; ?>"/>
            </div>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="specialization">Specialization</label>
            </div>
            <div class="col-sm-9">
                <input name="specialization" id="specialization" required type="text" maxlength="50" class="form-control" placeholder="Employee's Area of Specialization" value="<?= isset($fields['specialization']) ? $fields['specialization'] : ''; ?>"/>
            </div>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="employee-id">Employee ID</label>
            </div>
            <div class="col-sm-9">
                <input name="employee-id" id="employee-id" required type="email" maxlength="50" class="form-control" placeholder="firstname.lastname@company.com" value="<?= isset($fields['employee-id']) ? $fields['employee-id'] : ''; ?>"/>
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