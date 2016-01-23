<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    11/25/2015
 * Time:    2:17 PM
 **/

$data = \System\Request\RequestContext::instance()->getResponseData();
require_once("header.php");
?>
<div class="row">
    <?php
    require_once("sidebar.php");
    ?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h1 class="page-header"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</h1>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <img src="<?php home_url("/Assets/images/image-2.png") ?>" class="img-responsive"/>
            </div>
        </div>

        <!-- Comments -->
        <div class="tiny-padding-all full-margin-top border-width-1px border-surround border-color1">
            <div class="row">
                <div class="col-sm-12 lead"><span class="glyphicon glyphicon-comment"></span> Comments</div>
            </div>
            <div class="row">
                <a href="<?php home_url('/admin-area-area/manage-comments/?status=approved'); ?>">
                    <div class="col-sm-4">
                        <span class="glyphicon glyphicon-check"></span> Approved: <?= $data['num_approved_comments']; ?>
                    </div>
                </a>
                <a href="<?php home_url('/admin-area-area/manage-comments/?status=pending'); ?>">
                    <div class="col-sm-4">
                        <span class="glyphicon glyphicon-hourglass"></span> Pending: <?= $data['num_pending_comments']; ?>
                    </div>
                </a>
                <a href="<?php home_url('/admin-area-area/manage-comments/?status=deleted'); ?>">
                    <div class="col-sm-4">
                        <span class="glyphicon glyphicon-trash"></span> Deleted: <?= $data['num_deleted_comments']; ?>
                    </div>
                </a>
            </div>
        </div>

    </div>
</div>
<?php
require_once("footer.php");
?>