<?php

defined('_EXEC') or die;

class Subscription_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function get_subscription()
    {
        $property = $this->model->select('accounts', [
            'id_account',
            'name',
            'register_date',

        ], ['id_account' => Session::get_value('account')['id']]);

        $settings = $this->model->select('settings', [
            'id_setting',
            'private_key',
            'timezone',
            'language',
            'code'
        ], [
            'id_account' => Session::get_value('account')['id']
        ]);
    }
}
