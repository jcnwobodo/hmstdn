<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/22/2016
 * Time:    2:04 AM
 **/
?>
<fieldset class="full-margin-bottom">
    <legend><span class="glyphicon glyphicon-briefcase"></span> Patient Bio-Data</legend>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="card-number">Card Number #</label>
            </div>
            <div class="col-sm-9">
                <input name="card-number" id="card-number" required type="text" maxlength="6" class="form-control" placeholder="000001" value="<?= isset($fields['card-number']) ? $fields['card-number'] : ''; ?>"/>
            </div>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="blood-group">Blood Group</label>
            </div>
            <div class="col-sm-9">
                <input name="blood-group" id="blood-group" required type="text" maxlength="2" class="form-control" value="<?= isset($fields['blood-group']) ? $fields['blood-group'] : ''; ?>"/>
            </div>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="row">
            <div class="col-sm-3">
                <label for="genotype">Genotype</label>
            </div>
            <div class="col-sm-9">
                <input name="genotype" id="genotype" required type="text" maxlength="2" class="form-control" value="<?= isset($fields['genotype']) ? $fields['genotype'] : ''; ?>"/>
            </div>
        </div>
    </div>

</fieldset>