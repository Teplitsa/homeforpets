<?php

/**
 * Custom page url rule
 */
class PageUrlRule extends CBaseUrlRule
{
	/**
	 * @var boolean $lastSlashEnabled Enable slash bonding
	 */
    public $lastSlashEnabled = false;
	
	/**
	 * @var integer $lastSlashType Slash bonding type
	 */
    public $lastSlashType = null;

	/**
	 * Parse url
	 */
    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        if ($pages = preg_split("/\//",$pathInfo))
        {
			$element = end($pages);
			if ($page = Page::model()->findByAttributes(array('link' => $element)))
			{
				$link = $page->getFullLink();
				if ($this->lastSlashEnabled and $this->lastSlashType == ADD_LAST_SLASH)
					$link .= "/";
				
				if (!$this->lastSlashEnabled and (strrpos($request->requestUri, "/") + 1) === strlen($request->requestUri))
					$link .= "/";
				
				if ($link !== $request->requestUri)
					$request->redirect($link, true, 301);
				else
					return "/page/view/id/" . $page->id;
			}
        }
        return false;
    }

	/**
	 * Create url
	 */
	public function createUrl($manager, $route, $params, $ampersand)
    {
        return false;
    }
}
?>