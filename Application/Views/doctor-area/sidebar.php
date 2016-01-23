<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/23/2016
 * Time:    3:46 AM
 **/

$requestContext = \System\Request\RequestContext::instance();
$method = $requestContext->getRequestUrlParam(1);

$group1 = array('manage-consultations', 'consultation-info');
$group2 = array('request-lab-test', 'lab-test-records');
?>
<div class="col-sm-3 col-md-2 sidebar">

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-1">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-1" aria-expanded="false" aria-controls="collapse-1" class="btn-link">
                        <span class="glyphicon glyphicon-briefcase"></span> My Consultations
                    </a>
                </h4>
            </div>
            <div id="collapse-1" class="panel-collapse collapse <?= in_array($method, $group1)? 'in': ''; ?>" role="tabpanel" aria-labelledby="heading-1">
                <div class="panel-body no-padding">
                    <ul class="btn-group btn-group-vertical list-unstyled">
                        <li><a href="<?php home_url('/doctor-area/manage-consultations/'); ?>" class="btn"><span class="glyphicon glyphicon-tasks"></span> Manage Consultations</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-2">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-2" aria-expanded="false" aria-controls="collapse-2" class="btn-link">
                        <span class="glyphicon glyphicon-tint"></span> Lab. Centre
                    </a>
                </h4>
            </div>
            <div id="collapse-2" class="panel-collapse collapse <?= in_array($method, $group2)? 'in': ''; ?>" role="tabpanel" aria-labelledby="heading-2">
                <div class="panel-body no-padding">
                    <ul class="btn-group btn-group-vertical list-unstyled">
                        <li><a href="<?php home_url('/doctor-area/request-lab-test/'); ?>" class="btn"><span class="glyphicon glyphicon-eye-open"></span> Request Lab. Test</a></li>
                        <li><a href="<?php home_url('/doctor-area/lab-test-records/'); ?>" class="btn"><span class="glyphicon glyphicon-record"></span> Lab. Test Records</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

</div>