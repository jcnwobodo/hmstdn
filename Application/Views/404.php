<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/27/2015
 * Time:    10:46 AM
 */

$requestContext = \System\Request\RequestContext::instance();
$data = $requestContext->getResponseData();

include_once('header.php');
?>
<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <h1 class="page-header no-margin full-margin-bottom">Page not found</h1>
    </div>
</div>
<?php include_once("footer.php"); ?>