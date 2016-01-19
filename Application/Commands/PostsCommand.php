<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/27/2015
 * Time:    1:55 PM
 */

namespace Application\Commands;

use System\Request\RequestContext;

class PostsCommand extends Command
{
    protected function doExecute(RequestContext $requestContext)
    {
        $data = array();
        $post = $requestContext->getResponseData();
        $data['post'] = $post;
        $data['page-title'] = $post->getTitle()." | ".site_info('name',0);
        $requestContext->setResponseData($data);

        $link = $post->getGuid(); $link_segments = explode('/', $link); $parent_link = $link_segments[0];
        $possible_views = array('post.php', 'single-'.$parent_link.'.php', 'single-'.$post->getGuid().'.php');
        foreach($possible_views as $possible_view)
        {
            if($requestContext->viewExists($possible_view)) $requestContext->setView($possible_view);
        }
    }
}