<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    12/7/2015
 * Time:    4:55 PM
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
                <span class="glyphicon glyphicon-book"></span> Manage Pages
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/add-page/'); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> <span class="sr-only">Add Page</span></a>
            </h3>

            <div class="btn-group pull-right">
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=published'); ?>" class="btn btn-primary">Published</a>
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=draft'); ?>" class="btn btn-primary">Draft</a>
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=deleted'); ?>" class="btn btn-primary">Deleted</a>
            </div>


            <?php
            if(is_object($data['pages']) and $data['pages']->size())
            {
                ?>
                <form method="post">
                    <div class="table-responsive clear-both">
                        <table class="table table-stripped table-bordered table-hover full-margin-top">
                            <thead>
                            <tr>
                                <td colspan="4" class="lead"><?= ucwords($data['status']); ?> Pages</td>
                            </tr>
                            <tr>
                                <td width="4%">SN</td>
                                <td><span class="glyphicon glyphicon-list"></span> Page Details</td>
                                <td width="20%"><span class="glyphicon glyphicon-calendar"></span> Date</td>
                                <td width="5%"><span class="glyphicon glyphicon-check"></span></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sn = 0;
                            foreach($data['pages'] as $post)
                            {
                                ?>
                                <tr>
                                    <td><?= ++$sn; ?></td>
                                    <td>
                                        <strong><?= $post->getTitle(); ?></strong>
                                        <p><?= remove_text_formatting($post->getExcerpt()); ?></p>
                                        <p class="text-right no-margin">
                                            <a class="btn" href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/update-page/?page-id='.$post->getId()); ?>"><span class="glyphicon glyphicon-edit"></span> Edit Page</a>
                                        </p>
                                    </td>
                                    <td><?= $post->getDateCreated()->getDateTimeStr(); ?></td>
                                    <td><input type="checkbox" name="page-ids[]" value="<?= $post->getId(); ?>"></td>
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
                            case 'published' : {
                                ?>
                                <input name="action" type="submit" class="btn btn-warning" value="Un-Publish">
                                <?php
                            } break;
                            case 'draft' : {
                                ?>
                                <input name="action" type="submit" class="btn btn-success" value="Publish">
                                <input name="action" type="submit" class="btn btn-danger" value="Delete">
                                <?php
                            } break;
                            case 'deleted' : {
                                ?>
                                <input name="action" type="submit" class="btn btn-primary" value="Restore">
                                <input name="action" type="submit" class="btn btn-danger" value="Delete Permanently">
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
                    <p class="lead">There are currently no <?= $data['status']; ?> pages.</p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php
require_once("footer.php");
?>