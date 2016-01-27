<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/24/2016
 * Time:    9:48 AM
 **/

namespace Application\Commands;


use Application\Models\Disease;
use Application\Models\LabTest;
use Application\Models\Location;
use System\Request\RequestContext;

class StatSummaryCommand extends Command
{
    protected function doExecute(RequestContext $requestContext)
    {
        $locations = Location::getMapper('Location')->findTypeByStatus(Location::TYPE_STATE, Location::STATUS_APPROVED);
        $diseases = Disease::getMapper('Disease')->findByStatus(Disease::STATUS_APPROVED);

        $ini_data = $requestContext->getResponseData();
        if(is_array($ini_data) and isset($ini_data['tests']))
        {
            $tests = $ini_data['tests'];
        }
        else
        {
            $tests = LabTest::getMapper("LabTest")->findByResult(1);
        }


        $state_disease_counter = array();
        $state_counter = array();
        $disease_counter = array();

        $location_names = array();
        $disease_names = array();

        foreach($locations as $location)
        {
            $location_names[$location->getId()] = $location->getLocationName();
        }
        $locations->rewind();

        foreach($diseases as $disease)
        {
            $disease_names[$disease->getId()] = $disease->getName();
        }
        $diseases->rewind();

        foreach($tests as $test)
        {
            $patient_location = $test->getPatientLocation()->getId();
            $test_disease = $test->getDisease()->getId();

            isset($state_disease_counter[$patient_location][$test_disease]) ? $state_disease_counter[$patient_location][$test_disease]++ : $state_disease_counter[$patient_location][$test_disease] = 1;
            isset($state_counter[$patient_location]) ? $state_counter[$patient_location]++ : $state_counter[$patient_location] = 1;
            isset($disease_counter[$test_disease]) ? $disease_counter[$test_disease]++ : $disease_counter[$test_disease] = 1;
        }

        arsort($state_counter);
        arsort($disease_counter);

        $data = array();
        $data['state-disease-counter'] = $state_disease_counter;
        $data['state-counter'] = $state_counter;
        $data['disease-counter'] = $disease_counter;
        $data['location-names'] = $location_names;
        $data['disease-names'] = $disease_names;
        $data['locations'] = $locations;
        $data['diseases'] = $diseases;
        $data['page-title'] = "Statistical Abstracts";
        $data['summary-limit'] = 10;

        //Prepare Chart Data in Json
        //chart 1; diseases
        $chart_data_1 =     '{
        "chart": {
            "caption": "",
            "subCaption": "",
            "xAxisName": "Disease",
            "yAxisName": "Number of Incidences",
            "numberPrefix": "",
            "paletteColors": "#0075c2",
            "bgColor": "#ffffff",
            "borderAlpha": "20",
            "canvasBorderAlpha": "0",
            "usePlotGradientColor": "0",
            "plotBorderAlpha": "10",
            "placeValuesInside": "1",
            "rotatevalues": "0",
            "valueFontColor": "#ffffff",
            "showXAxisLine": "1",
            "xAxisLineColor": "#999999",
            "divlineColor": "#999999",
            "divLineIsDashed": "1",
            "showAlternateHGridColor": "1",
            "subcaptionFontSize": "14",
            "subcaptionFontBold": "0"
        },
        "data": [';
        $n=1;
        $elements = array();
        foreach($disease_counter as $disease_id => $disease_count)
        {
            $elements[] = '{"label": "'.$disease_names[$disease_id].'", "value": "'.$disease_count.'"}';
            if($n++ >= $data['summary-limit']) break;
        }
        $chart_data_1 .= implode(',', $elements).']}';

        //chart 2; locations
        $chart_data_2 =     '{
        "chart": {
            "caption": "",
            "subCaption": "",
            "xAxisName": "Location",
            "yAxisName": "Total Number of Incidences",
            "numberPrefix": "",
            "paletteColors": "#0075c2",
            "bgColor": "#ffffff",
            "borderAlpha": "20",
            "canvasBorderAlpha": "0",
            "usePlotGradientColor": "0",
            "plotBorderAlpha": "10",
            "placeValuesInside": "1",
            "rotatevalues": "0",
            "valueFontColor": "#ffffff",
            "showXAxisLine": "1",
            "xAxisLineColor": "#999999",
            "divlineColor": "#999999",
            "divLineIsDashed": "1",
            "showAlternateHGridColor": "1",
            "subcaptionFontSize": "14",
            "subcaptionFontBold": "0"
        },
        "data": [';
        $n=1;
        $elements = array();
        foreach($state_counter as $state_id => $state_count)
        {
            $elements[] = '{"label": "'.$location_names[$state_id].'", "value": "'.$state_count.'"}';
            if($n++ >= $data['summary-limit']) break;
        }
        $chart_data_2 .= implode(',', $elements).']}';

        $data['chart-data-1'] = $chart_data_1;
        $data['chart-data-2'] = $chart_data_2;
        $requestContext->setResponseData($data);
        $requestContext->setView('stat-summary.php');
    }
}