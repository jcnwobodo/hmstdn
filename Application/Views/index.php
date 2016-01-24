<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date: 10/4/2015
 * Time: 12:17 PM
 */

$requestContext = \System\Request\RequestContext::instance();
$response_data = $requestContext->getFlashData();

include_once('header.php');
?>

    <div class="row">
    <div class="col-md-7">
        <p>
            <img src="<?php home_url("/Assets/images/image-3.jpg") ?>" class="img-responsive"/>
        </p>
        <span class="lead">Welcome to</span>
        <h3 class="page-header no-margin"><?php site_info('full-name'); ?></h3>
        <p class="text-left">... {abstract} ...</p>
        <p class="text-right">
            <a href="#" class="btn btn-sm btn-primary">Learn more</a>
        </p>
    </div>

    <div class="col-md-4 col-md-offset-1">
        <form action="<?php home_url('/login/'); ?>" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Login</legend>

                <?php
                if($requestContext->fieldIsSet('login'))
                {
                    ?>
                    <div class="text-danger bg-danger text-center lead">
                        <?php print_r($response_data); ?>
                    </div>
                    <?php
                }
                ?>

                <div class="form-group form-group-sm">
                    <div class="row">
                        <div class="col-xs-4 text-nowrap">
                            <label for="username"><span class="glyphicon glyphicon-user"></span> Email</label>
                        </div>
                        <div class="col-xs-8">
                            <input name="username" id="username" type="email" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    <div class="row">
                        <div class="col-xs-4 text-nowrap">
                            <label for="password"><span class="glyphicon glyphicon-lock"></span> Password</label>
                        </div>
                        <div class="col-xs-8">
                            <input name="password" id="password" type="password" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="btn-group pull-right">
                            <button name="login" id="login" type="submit" class="btn btn-primary">
                                Login
                                <span class="glyphicon glyphicon-log-in"></span>
                            </button>
                        </div>
                    </div>
                </div>

            </fieldset>

            <br/><br/>
            <fieldset>
                <legend>Take your research to the next level <span class="glyphicon glyphicon-forward"></span></legend>
                Join our researchers network to get more insights on recent tropical diseases, causes, treatments and
                much more just for <strong>FREE</strong>
                <p class="text-right">
                    <a href="<?php home_url('/register'); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-user"></span> Register Now !</a>
                </p>
            </fieldset>
        </form>
    </div>
</div>
<?php
include_once("footer.php");
?>