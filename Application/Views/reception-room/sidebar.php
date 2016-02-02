<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    11/29/2015
 * Time:    1:19 PM
 **/

$requestContext = \System\Request\RequestContext::instance();
$method = $requestContext->getRequestUrlParam(1);

$group1 = array('add-patient', 'manage-patients');
$group3 = array('add-post', 'manage-posts', 'update-post', 'manage-categories', 'add-category', 'manage-comments');
$group4 = array('add-page', 'manage-pages', 'update-page');
$group5 = array('add-consultation', 'manage-consultations', 'update-consultation');
?>
<div class="col-sm-3 col-md-2 sidebar">

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="btn-link">
                        <span class="glyphicon glyphicon-leaf"></span> Patients
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse <?= in_array($method, $group1)? 'in': ''; ?>" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body no-padding">
                    <ul class="btn-group btn-group-vertical list-unstyled">
                        <li><a href="<?php home_url('/receptionist/add-patient/'); ?>" class="btn"><span class="glyphicon glyphicon-plus-sign"></span> Add Patient</a></li>
                        <li><a href="<?php home_url('/receptionist/manage-patients/'); ?>" class="btn"><span class="glyphicon glyphicon-tasks"></span> Manage Patients</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-5">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-5" aria-expanded="false" aria-controls="collapse-5" class="btn-link">
                        <span class="glyphicon glyphicon-briefcase"></span> Consultations
                    </a>
                </h4>
            </div>
            <div id="collapse-5" class="panel-collapse collapse <?= in_array($method, $group5)? 'in': ''; ?>" role="tabpanel" aria-labelledby="heading-5">
                <div class="panel-body no-padding">
                    <ul class="btn-group btn-group-vertical list-unstyled">
                        <li><a href="<?php home_url('/receptionist/add-consultation/'); ?>" class="btn"><span class="glyphicon glyphicon-plus-sign"></span> Add Consultation</a></li>
                        <li><a href="<?php home_url('/receptionist/manage-consultations/'); ?>" class="btn"><span class="glyphicon glyphicon-tasks"></span> Manage Consultations</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <div class="panel-group" id="accordion-2" role="tablist" aria-multiselectable="false">

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-3">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion-2" href="#collapse-3" aria-expanded="true" aria-controls="collapse-3" class="btn-link">
                        <span class="glyphicon glyphicon-bullhorn"></span> Posts
                    </a>
                </h4>
            </div>
            <div id="collapse-3" class="panel-collapse collapse <?= in_array($method, $group3)? 'in': ''; ?>" role="tabpanel" aria-labelledby="heading-3">
                <div class="panel-body no-padding">
                    <ul class="btn-group btn-group-vertical list-unstyled">
                        <li><a href="<?php home_url('/receptionist/add-post/'); ?>" class="btn"><span class="glyphicon glyphicon-plus-sign"></span> New Post</a></li>
                        <li><a href="<?php home_url('/receptionist/manage-posts/'); ?>" class="btn"><span class="glyphicon glyphicon-tasks"></span> Manage Posts</a></li>
                        <li><a href="<?php home_url('/receptionist/manage-categories/'); ?>" class="btn"><span class="glyphicon glyphicon-tags"></span> Manage Categories</a></li>
                        <li><a href="<?php home_url('/receptionist/manage-comments/'); ?>" class="btn"><span class="glyphicon glyphicon-comment"></span> Moderate Comments</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-4">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion-2" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4" class="btn-link">
                        <span class="glyphicon glyphicon-bookmark"></span> Pages
                    </a>
                </h4>
            </div>
            <div id="collapse-4" class="panel-collapse collapse <?= in_array($method, $group4)? 'in': ''; ?>" role="tabpanel" aria-labelledby="heading-4">
                <div class="panel-body no-padding">
                    <ul class="btn-group btn-group-vertical list-unstyled">
                        <li><a href="<?php home_url('/receptionist/add-page/'); ?>" class="btn"><span class="glyphicon glyphicon-plus-sign"></span> Add Page</a></li>
                        <li><a href="<?php home_url('/receptionist/manage-pages/'); ?>" class="btn"><span class="glyphicon glyphicon-tasks"></span> Manage Pages</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

