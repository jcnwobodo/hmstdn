<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/23/2016
 * Time:    3:41 AM
 **/

$data = \System\Request\RequestContext::instance()->getResponseData();
require_once("header.php");
?>
    <div class="row">
        <?php
        require_once("sidebar.php");
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header"><span class="glyphicon glyphicon-home"></span> Welcome to the Consultation Room</h1>
            <h3><span class="glyphicon glyphicon-user"></span> Doctor <?= $data['current-user'];?></h3>
            <hr/>

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