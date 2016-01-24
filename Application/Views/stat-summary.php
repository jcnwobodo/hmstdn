<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/24/2016
 * Time:    9:52 AM
 **/

$requestContext = \System\Request\RequestContext::instance();
$data = $requestContext->getResponseData();

$state_disease_counter = $data['state-disease-counter'];
$state_counter = $data['state-counter'];
$disease_counter = $data['disease-counter'];
$location_names = $data['location-names'];
$disease_names = $data['disease-names'];

include_once('header.php');
?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <h2 class="page-header no-margin full-margin-bottom"><span class="glyphicon glyphicon-book"></span> Researcher's Data-sheet</h2>

        <div class="height-50vh data-section">
            <div class="table-responsive clear-both">
                <table class="table table-stripped table-bordered table-hover full-margin-top">
                    <thead>
                    <tr>
                        <td colspan="4" class="lead"><span class="glyphicon glyphicon-globe"></span> Top 10 Worst Hit Locations with Top 5 Prevailing Diseases Each <span class="glyphicon glyphicon-globe"></span></td>
                    </tr>
                    <tr>
                        <td width="4%">SN</td>
                        <td>Location Name</td>
                        <td>Prevailing Diseases</td>
                        <td width="20%" class="text-nowrap">Number of Incidences</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sn = 0;
                    foreach($data['state-counter'] as $state_id => $state_count)
                    {
                        ?>
                        <tr>
                            <td><?= ++$sn; ?></td>
                            <td class="text-nowrap"><?= $location_names[$state_id]; ?></td>
                            <td>
                                <?php
                                $dn = 1;
                                foreach($state_disease_counter[$state_id] as $prevailing_disease_id => $disease_count)
                                {
                                    print($disease_names[$prevailing_disease_id]."<br/>");
                                    if($dn++ >=5) break;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $dn = 1;
                                foreach($state_disease_counter[$state_id] as $prevailing_disease_id => $disease_count)
                                {
                                    print($disease_count."<br/>");
                                    if($dn++ >=5) break;
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                        if($sn >=10) break;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="height-50vh data-section full-margin-bottom">
            <div class="table-responsive clear-both">
                <table class="table table-stripped table-bordered table-hover full-margin-top">
                    <thead>
                    <tr>
                        <td colspan="3" class="lead"><span class="glyphicon glyphicon-alert"></span> Top 10 Prevailing Diseases</td>
                    </tr>
                    <tr>
                        <td width="4%">SN</td>
                        <td>Disease Name</td>
                        <td width="20%" class="text-nowrap">Number of Incidences</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sn = 0;
                    foreach($data['disease-counter'] as $disease_id => $disease_count)
                    {
                        ?>
                        <tr>
                            <td><?= ++$sn; ?></td>
                            <td class="text-nowrap"><?= $disease_names[$disease_id]; ?></td>
                            <td><?= $disease_count; ?></td>
                        </tr>
                        <?php
                        if($sn >=10) break;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="height-50vh data-section">
            <div class="table-responsive clear-both">
                <table class="table table-stripped table-bordered table-hover full-margin-top">
                    <thead>
                    <tr>
                        <td colspan="3" class="lead"><span class="glyphicon glyphicon-globe"></span> Top 10 Worst Hit Locations</td>
                    </tr>
                    <tr>
                        <td width="4%">SN</td>
                        <td>Location Name</td>
                        <td width="20%" class="text-nowrap">Number of Incidences</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sn = 0;
                    foreach($data['state-counter'] as $state_id => $state_count)
                    {
                        ?>
                        <tr>
                            <td><?= ++$sn; ?></td>
                            <td class="text-nowrap"><?= $location_names[$state_id]; ?></td>
                            <td><?= $state_count; ?></td>
                        </tr>
                        <?php
                        if($sn >=10) break;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-center">
            <h2>Want to find out more?</h2>
            <p class="lead">
                Register now as a Researcher on tropical diseases to gain more insights form our vast data collections.
            </p>
            <div class="row">
                <div class="col-md-5">
                    <p class="pull-right">
                        <a href="<?php home_url('/register/'); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Register Now!</a>
                    </p>
                </div>
                <div class="col-md-2"> OR </div>
                <div class="col-md-5">
                    <p class="pull-left">
                        <a href="<?php home_url('/login/'); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-user"></span> Login</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
<?php include_once("footer.php"); ?>