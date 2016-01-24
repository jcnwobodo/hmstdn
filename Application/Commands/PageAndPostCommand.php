<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/27/2015
 * Time:    1:55 PM
 */

namespace Application\Commands;

use Application\Models\Post;
use System\Exceptions\CommandNotFoundException;
use System\Request\RequestContext;

abstract class PageAndPostCommand extends Command
{
    protected function doExecute(RequestContext $requestContext)
    {
        $guid = $requestContext->getRequestUrlParam(1);
        if(strlen($guid))
        {
            $item = Post::getMapper('Post')->findByPamalink($guid);
            if(is_object($item) and $item->getStatus()==Post::STATUS_PUBLISHED)
            {
                $data['item'] = $item;
                $data['page-title'] = $item->getTitle()." | ".site_info('name',0);
                $requestContext->setResponseData($data);
                return;
            }
            throw new CommandNotFoundException("Page /{$guid} not found");
        }
        $requestContext->redirect(home_url('/'));
    }
}