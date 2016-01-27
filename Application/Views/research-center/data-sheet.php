<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/24/2016
 * Time:    3:51 PM
 **/

$requestContext = \System\Request\RequestContext::instance();
$data = $requestContext->getResponseData();

$state_disease_counter = $data['state-disease-counter'];
$state_counter = $data['state-counter'];
$disease_counter = $data['disease-counter'];
$location_names = $data['location-names'];
$disease_names = $data['disease-names'];

$chart_data1 = $data['chart-data-1'];
$chart_data2 = $data['chart-data-2'];

$filtered_by = $requestContext->fieldIsSet('filter-by') ? $requestContext->getField('filter-by') : 'nil';
$fields = $requestContext->getAllFields();

include_once('header.php');
include_once("Application/_Libraries/fusioncharts/fusioncharts.php");
?>
    <script type="text/javascript" src="<?php home_url('/Application/_Libraries/fusioncharts/js/fusioncharts.js');?>"></script>
    <script type="text/javascript" src="<?php home_url('/Application/_Libraries/fusioncharts/js/themes/fusioncharts.theme.fint.js');?>"></script>

    <div class="row">
        <div class="col-md-10 col-md-offset-1 data-sheet">

            <h1 class="page-header no-margin full-margin-bottom"><span class="glyphicon glyphicon-book"></span> Researcher's Data-sheet</h1>

            <?php require_once("filter-form.php"); ?>

            <?php
            if($filtered_by!='disease') //Filtering by Location, Both or Nil
            {
                ?>
                <div class="height-50vh data-section full-margin-bottom">
                <?php
                $columnChart = new FusionCharts("column2d", "diseases-count" , '100%', '400', "chart-1", "json", $chart_data1);
                $columnChart->render();
                ?>
                <div class="table-responsive clear-both">
                    <table class="table table-stripped table-bordered table-hover full-margin-top">
                        <thead>
                        <tr>
                            <td colspan="6" class="lead"><span class="glyphicon glyphicon-alert"></span>
                                <?php
                                if($filtered_by=='location')
                                {
                                    ?>Prevailing Diseases in <?= $location_names[$fields['location']];
                                }
                                elseif($filtered_by=='both')
                                {
                                    ?><?= $disease_names[$fields['disease']]; ?> Incidences in <?= $location_names[$fields['location']];
                                }
                                else
                                {
                                    ?>Top  <?= $data['summary-limit']; ?> Prevailing Diseases
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="mid-padding-all"><div id="chart-1"></div></td>
                        </tr>
                        <tr>
                            <td width="4%">SN</td>
							<?php if($filtered_by == 'both'){?><td>Location</td><?php } ?>
                            <td>Disease Name</td>
                            <td width="15%" class="text-nowrap">Number of Incidences</td>
                            <?php if($filtered_by != 'both'){?><td width="15%">Proportion (%)</td><?php } ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sn = 0;
                        $total = array_sum($data['disease-counter']);
                        foreach($data['disease-counter'] as $disease_id => $disease_count)
                        {
                            ?>
                            <tr>
                                <td><?= ++$sn; ?></td>
                                <?php if($filtered_by == 'both'){?><td class="text-nowrap"><?= $location_names[$fields['location']]; ?></td><?php } ?>
                                <td class="text-nowrap"><?= $disease_names[$disease_id]; ?></td>
                                <td><?= $disease_count; ?></td>
                                <?php if($filtered_by != 'both'){?><td><?= round( ($disease_count/$total * 100), 4); ?></td><?php } ?>
                            </tr>
                            <?php
                            if($filtered_by=='nil'){ if($sn >= $data['summary-limit']) break;}
                        }
                        ?>
						<?php if($filtered_by != 'both'){?>
                        <tr>
                            <td colspan="2" class="text-right">Total: </td>
                            <td><strong> <?= $total; ?></strong></td>
                            <td><strong> 100.0000%</strong></td>
                        </tr>
						<?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
                <?php
            }
            ?>

            <?php
            if($filtered_by!='location' and $filtered_by!='both') //Filtered by Disease or Nil
            {
                ?>
                <div class="height-50vh data-section">
                <?php
                $columnChart = new FusionCharts("column2d", "location-count" , '100%', '400', "chart-2", "json", $chart_data2);
                $columnChart->render();
                ?>
                <div class="table-responsive clear-both">
                    <table class="table table-stripped table-bordered table-hover full-margin-top">
                        <thead>
                        <tr>
                            <td colspan="4" class="lead"><span class="glyphicon glyphicon-globe"></span>
                                <?php
                                if($filtered_by=='disease')
                                {
                                    ?>Locations Hit by <?= $disease_names[$fields['disease']];
                                }
                                else
                                {
                                    ?>Top <?php $data['summary-limit']; ?> Worst Hit Locations
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="mid-padding-all"><div id="chart-2"></div></td>
                        </tr>
                        <tr>
                            <td width="4%">SN</td>
                            <td>Location Name</td>
                            <td width="15%" class="text-nowrap">Number of Incidences</td>
                            <td width="15%">Proportion (%)</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sn = 0;
                        $total = array_sum($data['state-counter']);
                        foreach($data['state-counter'] as $state_id => $state_count)
                        {
                            ?>
                            <tr>
                                <td><?= ++$sn; ?></td>
                                <td class="text-nowrap"><?= $location_names[$state_id]; ?></td>
                                <td><?= $state_count; ?></td>
                                <td><?= round( ($state_count/$total * 100), 4); ?></td>
                            </tr>
                            <?php
                            if($filtered_by=='nil'){ if($sn >= $data['summary-limit']) break;}
                        }
                        ?>
                        <tr>
                            <td colspan="2" class="text-right">Total: </td>
                            <td><strong> <?= $total; ?></strong></td>
                            <td><strong> 100.0000%</strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
                <?php
            }
            ?>

            <?php
            if($filtered_by=='nil')
            {
                ?>
                <div class="height-50vh data-section">
                    <div class="table-responsive clear-both">
                        <table class="table table-stripped table-bordered table-hover full-margin-top">
                            <thead>
                            <tr>
                                <td colspan="4" class="lead"><span class="glyphicon glyphicon-globe"></span> Top <?= $data['summary-limit']; ?>
                                    Worst Hit Locations with Top <?= (int)($data['summary-limit']/2); ?> Prevailing Diseases Each <span
                                        class="glyphicon glyphicon-globe"></span></td>
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
                            foreach ($data['state-counter'] as $state_id => $state_count) {
                                ?>
                                <tr>
                                    <td><?= ++$sn; ?></td>
                                    <td class="text-nowrap"><?= $location_names[$state_id]; ?></td>
                                    <td>
                                        <?php
                                        $dn = 1;
                                        foreach ($state_disease_counter[$state_id] as $prevailing_disease_id => $disease_count) {
                                            print($disease_names[$prevailing_disease_id] . "<br/>");
                                            if ($dn++ >= (int)($data['summary-limit']/2)) break;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $dn = 1;
                                        foreach ($state_disease_counter[$state_id] as $prevailing_disease_id => $disease_count) {
                                            print($disease_count . "<br/>");
                                            if ($dn++ >= (int)($data['summary-limit']/2)) break;
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                if ($sn >= $data['summary-limit']) break;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
            }
            ?>

        </div>
    </div>
<?php include_once("footer.php"); ?>