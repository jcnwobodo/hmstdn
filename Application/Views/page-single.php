<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/24/2016
 * Time:    5:42 AM
 **/

$requestContext = \System\Request\RequestContext::instance();
$data = $requestContext->getResponseData();
$page = $data['item'];
$rel_pages = $data['pages'];

include_once('header.php');
?>
<div class="row">
    <div class="col-md-7 col-md-offset-1 col-sm-10 col-sm-offset-1">
        <h3 class="page-header no-margin full-margin-bottom"><?= $page->getTitle(); ?></h3>
        <div>
            <?= $page->getContent(); ?>
        </div>
    </div>

    <div class="col-md-3 col-sm-10">
        <div>
            <h4 class="page-header no-margin full-margin-bottom"><span class="glyphicon glyphicon-duplicate"></span> Pages</h4>
            <?php
            if(is_object($rel_pages) and $rel_pages->size())
            {
                ?>
                <ul style="list-style: square">
                    <?php
                    foreach($rel_pages as $rel_page)
                    {
                        ?>
                    <li><a href="<?php home_url("/page/".$rel_page->getGuid())?>" class="navbar-link"><?= $rel_page->getTitle(); ?></a></li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<?php
include_once("footer.php");
?>