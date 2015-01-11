<?php

/**
 * Custom web application behavior
 */
class WebApplicationBranchBehavior extends CBehavior
{
	/**
	 * @var string $branch Default branch name
	 */
	public $branch = "frontend";

    /**
	 * Run Web Application on a current branch
	 */
    public function runBranch()
    {
		$this->onModuleCreate = array($this, 'changeModulesBranch');
        $this->onModuleCreate(new CEvent ($this->owner));
		$this->owner->run();
    }

    /**
	 * Custom modules create event
	 */
    public function onModuleCreate($event)
    {
		$this->raiseEvent('onModuleCreate', $event);
	}

    /**
	 * Changes file paths for controllers and views
	 */
    protected function changeModulesBranch($event)
    {
        $event->sender->controllerPath .= DIRECTORY_SEPARATOR . $this->branch;
        $event->sender->viewPath .= DIRECTORY_SEPARATOR . $this->branch;
    }
}
?>