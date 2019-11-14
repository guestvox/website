<?php

defined('_EXEC') or die;

class Api_controller extends Api_vkye
{
	public function __construct()
	{
		parent::__construct();
	}

	public function execute($params)
	{
		$this->main($params);
	}
}
