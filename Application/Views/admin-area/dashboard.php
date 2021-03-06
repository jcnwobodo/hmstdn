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
        <h1 class="page-header"><span class="glyphicon glyphicon-dashboard"></span> Welcome to <?php site_info('name')?> Administration Page.</h1>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <img src="<?php home_url("/Assets/images/image-2.png") ?>" class="img-responsive"/>
            </div>
        </div>

    </div>
</div>
<?php
require_once("footer.php");
?>