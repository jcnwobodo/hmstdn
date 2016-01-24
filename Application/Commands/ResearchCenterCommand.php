<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/24/2016
 * Time:    3:42 PM
 **/

namespace Application\Commands;


use Application\Models\User;
use Application\Models\Disease;
use Application\Models\LabTest;
use Application\Models\Location;
use System\Request\RequestContext;

class ResearchCenterCommand extends SecureCommand
{
    public function execute(RequestContext $requestContext)
    {
        if($this->securityPass($requestContext, User::UT_RESEARCHER, 'research-center'))
        {
            parent::execute($requestContext);
        }
    }

    protected function doExecute(RequestContext $requestContext)
    {
        if($requestContext->fieldIsSet('filter') and $requestContext->fieldIsSet('filter-by') and $requestContext->getField('filter-by') != 'nil')
        {
            $fields = $requestContext->getAllFields();
            $sd = $fields['start-date'];
            $ed = $fields['end-date'];
            $start_date = mktime(0,0,0,$sd['month'],$sd['day'],$sd['year']);
            $end_date = mktime(0,0,0,$ed['month'],$ed['day'],$ed['year']);

            switch($requestContext->getField('filter-by'))
            {
                case 'location' :{
                    $location_id = $fields['location'];
                    $tests = LabTest::getMapper('LabTest')->findByDateRangeAndLocation($start_date,$end_date,$location_id);
                } break;
                case 'disease' :{
                    $disease_id = $fields['disease'];
                    $tests = LabTest::getMapper('LabTest')->findByDateRangeAndDisease($start_date,$end_date,$disease_id);
                }
            }
            $data = array('tests' => $tests);
            $requestContext->setResponseData($data);
        }

        $stat_summary_command = new StatSummaryCommand();
        $stat_summary_command->execute($requestContext);

        $requestContext->setView('research-center/data-sheet.php');
    }
}