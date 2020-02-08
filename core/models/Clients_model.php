<?php

defined('_EXEC') or die;

require 'plugins/php-qr-code/qrlib.php';

class Clients_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function get_clients()
	{
		$query = $this->database->select('clients', [
			'id',
			'token',
			'name',
			'qr'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'name' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_count_clients()
	{
		$query = $this->database->count('clients', [
			'account' => Session::get_value('account')['id']
		]);

		return $query;
	}

	public function get_client($id)
	{
		$query = $this->database->select('clients', [
			'name',
			'qr'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function new_client($data)
	{
        $query = null;

		$exist = $this->database->count('clients', [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'name' => $data['name']
			]
		]);

		if ($exist <= 0)
		{
			if ($this->get_count_clients() < Session::get_value('account')['client_package']['quantity_end'])
			{
				$data['token'] = Functions::get_random(8);
				$data['qr']['filename'] = 'qr_' . Session::get_value('account')['path'] . '_client_' . $data['token'] . '.png';
				$data['qr']['content'] = 'https://' . Configuration::$domain . '/' . Session::get_value('account')['path'] . '/myvox/client/' . $data['token'];
				$data['qr']['dir'] = PATH_UPLOADS . $data['qr']['filename'];
				$data['qr']['level'] = 'H';
				$data['qr']['size'] = 5;
				$data['qr']['frame'] = 3;

				$query = $this->database->insert('clients', [
					'account' => Session::get_value('account')['id'],
					'token' => strtoupper($data['token']),
					'name' => $data['name'],
					'qr' => $data['qr']['filename']
				]);

				QRcode::png($data['qr']['content'], $data['qr']['dir'], $data['qr']['level'], $data['qr']['size'], $data['qr']['frame']);
			}
		}

		return $query;
	}

	public function edit_client($data)
	{
		$query = null;

		$exist = $this->database->count('clients', [
			'AND' => [
				'id[!]' => $data['id'],
				'account' => Session::get_value('account')['id'],
				'name' => $data['name']
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->update('clients', [
				'name' => $data['name']
			], [
				'id' => $data['id']
			]);
		}

		return $query;
	}

	public function delete_client($id)
	{
		$query = null;

		$deleted = $this->get_client($id);

		if (!empty($deleted))
		{
			$query = $this->database->delete('clients', [
				'id' => $id
			]);

			if (!empty($query))
				Functions::undoloader($deleted['qr']);
		}

		return $query;
	}
}
