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
        $stat_summary_command = new StatSummaryCommand();
        $stat_summary_command->execute($requestContext);
        $data = $requestContext->getResponseData();

        $requestContext->setView('research-center/data-sheet.php');
    }
}