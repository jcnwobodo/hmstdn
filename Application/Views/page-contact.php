<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/19/2016
 * Time:    11:25 PM
 **/

$requestContext = \System\Request\RequestContext::instance();
$data = $requestContext->getResponseData();
$fields = $requestContext->getAllFields();

include_once('header.php');
?>
    <form method="post" enctype="multipart/form-data" action="<?php home_url('/contact/send/'); ?>">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h2 class="page-header no-margin full-margin-bottom"><span class="glyphicon glyphicon-envelope"></span> Get in touch with us</h2>

                <?php if(isset($data['status'])){ ?><div class="text-center mid-margin-bottom lead <?= $data['status'] ? 'text-success bg-success' : 'text-danger bg-danger';?>"><?= $requestContext->getFlashData(); ?></div><?php } ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="sender-subject"><span class="glyphicon glyphicon-flag"></span> Subject</label>
                        </div>
                        <div class="col-md-9">
                            <input name="sender-subject" id="sender-subject" required type="text" class="form-control" placeholder="Subject of discussion" value="<?= isset($fields['sender-subject'])?$fields['sender-subject']:'';?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="sender-name"><span class="glyphicon glyphicon-user"></span> Name</label>
                        </div>
                        <div class="col-md-9">
                            <input name="sender-name" id="sender-name" required type="text" class="form-control" placeholder="Your Name" value="<?= isset($fields['sender-name'])?$fields['sender-name']:'';?>"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="sender-email"><span class="glyphicon glyphicon-envelope"></span> Email Address</label>
                        </div>
                        <div class="col-md-9">
                            <input name="sender-email" id="sender-email" required type="email" class="form-control" placeholder="your-email@website.com" value="<?= isset($fields['sender-email'])?$fields['sender-email']:'';?>"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="sender-phone" class="text-nowrap"><span class="glyphicon glyphicon-phone"></span> Mobile Number</label>
                        </div>
                        <div class="col-md-9">
                            <input name="sender-phone" id="sender-phone" required type="tel" class="form-control" placeholder="08012345678" value="<?= isset($fields['sender-phone'])?$fields['sender-phone']:'';?>"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="sender-message"><span class="glyphicon glyphicon-pencil"></span> Message</label>
                        </div>
                        <div class="col-md-9">
                            <textarea name="sender-message" id="sender-message" required class="form-control" placeholder="Your message ..." style="height: 13em;"><?= isset($fields['sender-message'])?$fields['sender-message']:'';?></textarea>
                        </div>
                    </div>
                </div>

                <div class="btn-group-lg pull-right">
                    <button name="send" id="send" type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-envelope"></span> Send Message
                    </button>
                </div>
            </div>
        </div>
    </form>
<?php include_once("footer.php"); ?>