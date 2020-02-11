<?php

defined('_EXEC') or die;

require 'plugins/php-qr-code/qrlib.php';

class Login_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_login($data)
	{
		$query = Functions::get_json_decoded_query($this->database->select('users', [
			'[>]accounts' => [
				'account' => 'id'
			],
			'[>]room_packages' => [
				'accounts.room_package' => 'id'
			],
			'[>]table_packages' => [
				'accounts.table_package' => 'id'
			],
			'[>]client_packages' => [
				'accounts.client_package' => 'id'
			]
		], [
			'users.id(user_id)',
			'users.firstname(user_firstname)',
			'users.lastname(user_lastname)',
			'users.avatar(user_avatar)',
			'users.username(user_username)',
			'users.password(user_password)',
			'users.user_permissions(user_user_permissions)',
			'users.opportunity_areas(user_opportunity_areas)',
			'users.status(user_status)',
			'accounts.id(account_id)',
			'accounts.name(account_name)',
			'accounts.path(account_path)',
			'accounts.type(account_type)',
			'accounts.time_zone(account_time_zone)',
			'accounts.currency(account_currency)',
			'accounts.language(account_language)',
			'accounts.logotype(account_logotype)',
			'accounts.operation(account_operation)',
			'accounts.reputation(account_reputation)',
			'accounts.zaviapms(account_zaviapms)',
			'accounts.sms(account_sms)',
			'accounts.status(account_status)',
			'room_packages.id(room_package_id)',
			'room_packages.quantity_end(room_package_quantity_end)',
			'table_packages.id(table_package_id)',
			'table_packages.quantity_end(table_package_quantity_end)',
			'client_packages.id(client_package_id)',
			'client_packages.quantity_end(client_package_quantity_end)'
		], [
			'AND' => [
				'OR' => [
					'users.email' => $data['username'],
					'users.username' => $data['username']
				]
			]
		]));

		if (!empty($query))
		{
			foreach ($query[0]['user_user_permissions'] as $key => $value)
			{
				$value = $this->database->select('user_permissions', [
					'code'
				], [
					'id' => $value
				]);

				if (!empty($value))
					$query[0]['user_user_permissions'][$key] = $value[0]['code'];
				else
					unset($query[0]['user_user_permissions'][$key]);
			}

			$data = [
				'user' => [
					'id' => $query[0]['user_id'],
					'firstname' => $query[0]['user_firstname'],
					'lastname' => $query[0]['user_lastname'],
					'avatar' => $query[0]['user_avatar'],
					'username' => $query[0]['user_username'],
					'password' => $query[0]['user_password'],
					'user_permissions' => $query[0]['user_user_permissions'],
					'opportunity_areas' => $query[0]['user_opportunity_areas'],
					'status' => $query[0]['user_status']
				],
				'account' => [
					'id' => $query[0]['account_id'],
					'name' => $query[0]['account_name'],
					'path' => $query[0]['account_path'],
					'type' => $query[0]['account_type'],
					'time_zone' => $query[0]['account_time_zone'],
					'currency' => $query[0]['account_currency'],
					'language' => $query[0]['account_language'],
					'logotype' => $query[0]['account_logotype'],
					'operation' => $query[0]['account_operation'],
					'reputation' => $query[0]['account_reputation'],
					'zaviapms' => $query[0]['account_zaviapms'],
					'sms' => $query[0]['account_sms'],
					'status' => $query[0]['account_status']
				]
			];

			if ($query[0]['account_type'] == 'hotel')
			{
				$data['account']['room_package'] = [
					'id' => $query[0]['room_package_id'],
					'quantity_end' => $query[0]['room_package_quantity_end']
				];
			}
			else if ($query[0]['account_type'] == 'restaurant')
			{
				$data['account']['table_package'] = [
					'id' => $query[0]['table_package_id'],
					'quantity_end' => $query[0]['table_package_quantity_end']
				];
			}
			else if ($query[0]['account_type'] == 'others')
			{
				$data['account']['client_package'] = [
					'id' => $query[0]['client_package_id'],
					'quantity_end' => $query[0]['client_package_quantity_end']
				];
			}

			return $data;
		}
		else
			return null;
	}
}