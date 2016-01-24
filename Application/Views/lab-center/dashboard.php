<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/23/2016
 * Time:    4:21 PM
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

        </div>
    </div>
<?php
require_once("footer.php");
?>