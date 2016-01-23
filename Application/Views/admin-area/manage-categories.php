<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    12/5/2015
 * Time:    10:47 PM
 **/

$rc = \System\Request\RequestContext::instance();
$data = $rc->getResponseData();

require_once("header.php");
?>
    <div class="row">
        <?php
        require_once("sidebar.php");
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3 class="page-header">
                <span class="glyphicon glyphicon-tags"></span> Manage Categories
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/add-category/?type='.$data['type']); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> <span class="sr-only">Add Location</span></a>
            </h3>

            <div class="row">
                <div class="col-sm-6">
                    <div class="btn-group">
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status='.$data['status'].'&type=post'); ?>" class="btn btn-primary">Post</a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="btn-group pull-right">
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=approved&type='.$data['type']); ?>" class="btn btn-success">Approved</a>
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=deleted&type='.$data['type']); ?>" class="btn btn-danger">Deleted</a>
                    </div>
                </div>
            </div>


            <?php
            if(is_object($data['categories']) and $data['categories']->size())
            {
                ?>
                <form method="post">
                    <div class="table-responsive clear-both">
                        <table class="table table-stripped table-bordered table-hover full-margin-top">
                            <thead>
                            <tr>
                                <td colspan="4" class="lead"><?= ucwords($data['status']); ?> Categories (<?= ucwords($data['type']); ?>)</td>
                            </tr>
                            <tr>
                                <td width="4%">SN</td>
                                <td>Caption</td>
                                <td>GUID</td>
                                <td width="5%">&hellip;</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sn = 0;
                            foreach($data['categories'] as $category)
                            {
                                ?>
                                <tr>
                                    <td><?= ++$sn; ?></td>
                                    <td><?= $category->getCaption(); ?></td>
                                    <td>/<?= $category->getGuid(); ?></td>
                                    <td><input type="checkbox" name="category-ids[]" value="<?= $category->getId(); ?>"></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="btn-group pull-right">
                        <?php
                        switch($data['status'])
                        {
                            case 'approved' : {
                                ?>
                                <input name="action" type="submit" class="btn btn-danger" value="Delete">
                                <?php
                            } break;
                            case 'deleted' : {
                                ?>
                                <input name="action" type="submit" class="btn btn-success" value="Restore">
                                <input name="action" type="submit" class="btn btn-danger" value="Delete Permanently">
                                <?php
                            } break;
                            default : {
                                ?>
                                <input name="action" type="submit" class="btn btn-danger" value="Delete">
                                <input name="action" type="submit" class="btn btn-success" value="Restore">
                                <?php
                            }
                        }
                        ?>
                    </div>
                </form>
                <?php
            }
            else
            {
                ?>
                <div class="clear-both text-center text-primary">
                    <p class="lead">There are currently no <?= $data['status'].' '.$data['type']; ?> categories.</p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php
require_once("footer.php");
?>