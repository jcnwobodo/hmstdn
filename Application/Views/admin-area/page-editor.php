<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    12/7/2015
 * Time:    4:36 PM
 **/

$rc = \System\Request\RequestContext::instance();
$data = $rc->getResponseData();

switch($data['mode'])
{
    case('create-page'):{
        $fields = $rc->getAllFields();
        $default_action = array('name'=>$data['mode'], 'label'=>"Create Page");
    } break;
    case('update-page'):{
        $fields = $data['fields'];
        $default_action = array('name'=>$data['mode'], 'label'=>"Update Page");
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
                <span class="glyphicon glyphicon-plus"></span> <?= $data['mode']=='create-page'?"Create":"Update"; ?> Page
            </h3>
            <div class="text-center mid-margin-bottom <?= $data['status'] ? 'text-success bg-success' : 'text-danger bg-danger';?>"><?= $rc->getFlashData(); ?></div>

            <form method="post" enctype="multipart/form-data" <?= $data['mode']=='update-page'? 'action="'.home_url('/'.$rc->getRequestUrlParam(0).'/update-page/?page-id='.$data['page-id'],0).'"':''; ?>>
                <?php if($data['mode']=='update-page'){ ?><input type="hidden" name="page-id" value="<?= $data['page-id']; ?>"/><?php } ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group form-group-sm">
                            <label for="page-title"><span class="glyphicon glyphicon-leaf"></span> Title</label>
                            <input name="page-title" id="page-title" type="text" class="form-control" value="<?= isset($fields['page-title']) ? $fields['page-title'] : ''; ?>" placeholder="Title of Page" spellcheck="true" required/>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="page-url"><span class="glyphicon glyphicon-link"></span> Page URL</label>
                            <div class="input-group">
                                <span class="input-group-addon"><?= strtolower(home_url('/page/',0)); ?></span>
                                <input name="page-url" id="page-url" type="text" class="form-control" value="<?= isset($fields['page-url']) ? $fields['page-url'] : ''; ?>" placeholder="page-title" spellcheck="true" required/>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="page-content"><span class="glyphicon glyphicon-pencil"></span> Content</label>
                            <textarea name="page-content" id="page-content" class="form-control height-50vh" required><?= isset($fields['page-content']) ? $fields['page-content'] : ''; ?></textarea>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="page-excerpt"><span class="glyphicon glyphicon-star-empty"></span> Excerpt</label>
                            <textarea name="page-excerpt" id="page-excerpt" class="form-control height-15vh"><?= isset($fields['page-excerpt']) ? $fields['page-excerpt'] : ''; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-sm">
                            <label for="page-date"><span class="glyphicon glyphicon-calendar"></span> Date</label>
                            <div class="row">
                                <div class="col-xs-5">
                                    <?= drop_month('page-date[month]', isset($fields['page-date']['month']) ? $fields['page-date']['month'] : null ); ?>
                                </div>
                                <div class="col-xs-3 no-padding"r>
                                    <?= drop_month_days('page-date[day]', isset($fields['page-date']['day']) ? $fields['page-date']['day'] : null ); ?>
                                </div>
                                <div class="col-xs-4">
                                    <?= drop_years('page-date[year]', isset($fields['page-date']['year']) ? $fields['page-date']['year'] : null ); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="page-time"><span class="glyphicon glyphicon-time"></span> Time</label>
                            <div class="row">
                                <div class="col-xs-4">
                                    <?= drop_hours('page-time[hour]', isset($fields['page-time']['hour']) ? $fields['page-time']['hour'] : null); ?>
                                </div>
                                <div class="col-xs-4">
                                    <?= drop_minutes('page-time[minute]', isset($fields['page-time']['minute']) ? $fields['page-time']['minute'] : null); ?>
                                </div>
                                <div class="col-xs-4">
                                    <?= drop_AmPM('page-time[am_pm]',  isset($fields['page-time']['am_pm']) ? $fields['page-time']['am_pm'] : date('A')); ?>
                                </div>
                            </div>
                        </div>

                        <div class="btn-group pull-right">
                            <button name="<?= $default_action['name']; ?>" type="submit" class="btn btn-primary">
                                <span class="glyphicon <?= $data['mode']=='create-page'?'glyphicon-plus':'glyphicon-edit'; ?>"></span> <?= $default_action['label']; ?>
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