<?php

defined('_EXEC') or die;

require 'plugins/php_qr_code/qrlib.php';

class Master_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function get_accounts($id = null)
    {
       if ($id == null)
       {
            $query = Functions::get_json_decoded_query($this->database->select('accounts', [
                'id',
                'token',
                'name',
                'path',
                'type',
                'country',
                'city',
                'zip_code',
                'address',
                'time_zone',
                'currency',
                'language',
                'fiscal',
                'contact',
                'logotype',
                'qrs',
                'package',
                'operation',
                'reputation',
                'siteminder',
                'zaviapms',
                'ambit',
                'sms',
                'settings',
                'status'
            ]));
    
            return $query;
       }
       else
       {
            $query = Functions::get_json_decoded_query($this->database->select('accounts', [
                '[>]packages' => [
                    'accounts.package' => 'id'
                ]
            ], [
                'accounts.id(account_id)',
                'accounts.token(account_token)',
                'accounts.name(account_name)',
                'accounts.path(account_path)',
                'accounts.type(account_type)',
                'accounts.country(account_country)',
                'accounts.city(account_city)',
                'accounts.time_zone(account_time_zone)',
                'accounts.currency(account_currency)',
                'accounts.language(account_language)',
                'accounts.logotype(account_logotype)',
                'accounts.qrs(account_qrs)',
                'accounts.package(account_package)',
                'accounts.operation(account_operation)',
                'accounts.reputation(account_reputation)',
                'accounts.siteminder(account_siteminder)',
                'accounts.zaviapms(account_zaviapms)',
                'accounts.ambit(account_ambit)',
                'accounts.settings(account_settings)',
                'packages.id(package_id)',
                'packages.quantity_end(package_quantity_end)'
            ],[
                'accounts.id' => $id
            ]));

          return $query[0];
       }
    }

    public function update_user_account($id)
    {
        $query = $this->database->update('users', [
            'account' => $id
        ], [
            'id' => Session::get_value('user')['id']
        ]);

        return $query;
    }
}
