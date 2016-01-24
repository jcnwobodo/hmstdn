<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/24/2016
 * Time:    5:35 AM
 **/

namespace Application\Commands;


use Application\Models\Post;
use System\Request\RequestContext;

class PageCommand extends PageAndPostCommand
{
    public function doExecute(RequestContext $requestContext)
    {
        parent::doExecute($requestContext);
        $data = $requestContext->getResponseData();
        $data['pages'] = Post::getMapper('Post')->findByStatus(Post::STATUS_PUBLISHED);

        $requestContext->setResponseData($data);
        $requestContext->setView('page-single.php');
    }
}