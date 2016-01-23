<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    12/6/2015
 * Time:    7:26 PM
 **/

$rc = \System\Request\RequestContext::instance();
$data = $rc->getResponseData();

switch($data['mode'])
{
    case('create-post'):{
        $fields = $rc->getAllFields();
        $default_action = array('name'=>'create-post', 'label'=>"Create Post");
    } break;
    case('update-post'):{
        $fields = $data['fields'];
        $default_action = array('name'=>'update-post', 'label'=>"Update Post");
    } break;
}

require_once("header.php");
?>
    <div class="row">
        <?php
        require_once("sidebar.php");
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3 class="page-header">
                <span class="glyphicon glyphicon-plus"></span> <?= $data['mode']=='create-post'?"Create":"Update"; ?> Post
            </h3>
            <div class="text-center mid-margin-bottom <?= $data['status'] ? 'text-success bg-success' : 'text-danger bg-danger';?>"><?= $rc->getFlashData(); ?></div>

            <form method="post" enctype="multipart/form-data" <?= $data['mode']=='update-post'? 'action="'.home_url('/'.$rc->getRequestUrlParam(0).'/update-post/?post-id='.$data['post-id'],0).'"':''; ?>>
                <?php if($data['mode']=='update-post'){ ?><input type="hidden" name="post-id" value="<?= $data['post-id']; ?>"/><?php } ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group form-group-sm">
                            <label for="post-title"><span class="glyphicon glyphicon-leaf"></span> Title</label>
                            <input name="post-title" id="post-title" type="text" class="form-control" value="<?= isset($fields['post-title']) ? $fields['post-title'] : ''; ?>" placeholder="Title of Your Post"/>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="post-url"><span class="glyphicon glyphicon-link"></span> Post URL</label>
                            <div class="input-group">
                                <span class="input-group-addon"><?php home_url('/')?></span>
                                <input name="post-url" id="post-url" type="text" class="form-control" value="<?= isset($fields['post-url']) ? $fields['post-url'] : ''; ?>" placeholder="post-title"/>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="post-content"><span class="glyphicon glyphicon-pencil"></span> Content</label>
                            <textarea name="post-content" id="post-content" class="form-control height-50vh"><?= isset($fields['post-content']) ? $fields['post-content'] : ''; ?></textarea>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="post-excerpt"><span class="glyphicon glyphicon-star-empty"></span> Excerpt</label>
                            <textarea name="post-excerpt" id="post-excerpt" class="form-control height-15vh"><?= isset($fields['post-excerpt']) ? $fields['post-excerpt'] : ''; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-sm">
                            <label for="post-category"><span class="glyphicon glyphicon-tag"></span> Category</label>
                            <select name="post-category" id="post-category" class="form-control">
                                <?php
                                foreach($data['categories'] as $category)
                                {
                                    ?>
                                    <option value="<?= $category->getId(); ?>" <?= selected($category->getId(), isset($fields['post-category'])?$fields['post-category']:null); ?>><?= $category->getCaption(); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group form-group-sm">
                            <label for="post-date"><span class="glyphicon glyphicon-calendar"></span> Date</label>
                            <div class="row">
                                <div class="col-xs-4">
                                    <?= drop_month('post-date[month]', isset($fields['post-date']['month']) ? $fields['post-date']['month'] : null ); ?>
                                </div>
                                <div class="col-xs-4">
                                    <?= drop_month_days('post-date[day]', isset($fields['post-date']['day']) ? $fields['post-date']['day'] : null ); ?>
                                </div>
                                <div class="col-xs-4">
                                    <?= drop_years('post-date[year]', isset($fields['post-date']['year']) ? $fields['post-date']['year'] : null ); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="post-time"><span class="glyphicon glyphicon-time"></span> Time</label>
                            <div class="row">
                                <div class="col-xs-4">
                                    <?= drop_hours('post-time[hour]', isset($fields['post-time']['hour']) ? $fields['post-time']['hour'] : null); ?>
                                </div>
                                <div class="col-xs-4">
                                    <?= drop_minutes('post-time[minute]', isset($fields['post-time']['minute']) ? $fields['post-time']['minute'] : null); ?>
                                </div>
                                <div class="col-xs-4">
                                    <?= drop_AmPM('post-time[am_pm]',  isset($fields['post-time']['am_pm']) ? $fields['post-time']['am_pm'] : date('A')); ?>
                                </div>
                            </div>
                        </div>

                        <div class="btn-group pull-right">
                            <button name="<?= $default_action['name']; ?>" type="submit" class="btn btn-primary">
                                <span class="glyphicon <?= $data['mode']=='create-post'?'glyphicon-plus':'glyphicon-edit'; ?>"></span> <?= $default_action['label']; ?>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php
require_once("footer.php");
?>