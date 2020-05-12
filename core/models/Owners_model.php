<?php

defined('_EXEC') or die;

require 'plugins/php-qr-code/qrlib.php';

class Owners_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function get_owners()
	{
		$query = $this->database->select('owners', [
			'id',
			'token',
			'number',
			'name',
			'qr',
			'status'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'number' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_count_owners()
	{
		$query = $this->database->count('owners', [
			'account' => Session::get_value('account')['id']
		]);

		return $query;
	}

	public function get_owner($id)
	{
		$query = $this->database->select('owners', [
			'number',
			'name',
			'qr',
			'status'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function new_owner($data)
	{
        $query = null;

		if ($data['type'] == 'many')
		{
			for ($i = $data['since']; $i <= $data['to']; $i++)
			{
				$exist = $this->database->count('owners', [
					'AND' => [
						'account' => Session::get_value('account')['id'],
						'number' => $i
					]
				]);

				if ($exist <= 0)
				{
					if ($this->get_count_owners() < Session::get_value('account')['owner_package']['quantity_end'])
					{
						$data['token'] = Functions::get_random(8);
						$data['qr']['filename'] = 'qr_' . Session::get_value('account')['path'] . '_owner_' . $data['token'] . '.png';
						$data['qr']['content'] = 'https://' . Configuration::$domain . '/' . Session::get_value('account')['path'] . '/myvox/owner/' . $data['token'];
						$data['qr']['dir'] = PATH_UPLOADS . $data['qr']['filename'];
						$data['qr']['level'] = 'H';
						$data['qr']['size'] = 5;
						$data['qr']['frame'] = 3;

						$query = $this->database->insert('owners', [
							'account' => Session::get_value('account')['id'],
							'token' => strtoupper($data['token']),
							'number' => $i,
							'name' => null,
							'qr' => $data['qr']['filename']
						]);

						QRcode::png($data['qr']['content'], $data['qr']['dir'], $data['qr']['level'], $data['qr']['size'], $data['qr']['frame']);
					}
				}
			}
		}
		else if ($data['type'] == 'one')
		{
			$exist = $this->database->count('owners', [
				'AND' => [
					'account' => Session::get_value('account')['id'],
					'number' => $data['number']
				]
			]);

			if ($exist <= 0)
			{
				if ($this->get_count_owners() < Session::get_value('account')['owner_package']['quantity_end'])
				{
					$data['token'] = Functions::get_random(8);
					$data['qr']['filename'] = 'qr_' . Session::get_value('account')['path'] . '_owner_' . $data['token'] . '.png';
					$data['qr']['content'] = 'https://' . Configuration::$domain . '/' . Session::get_value('account')['path'] . '/myvox/owner/' . $data['token'];
					$data['qr']['dir'] = PATH_UPLOADS . $data['qr']['filename'];
					$data['qr']['level'] = 'H';
					$data['qr']['size'] = 5;
					$data['qr']['frame'] = 3;

					$query = $this->database->insert('owners', [
	                    'account' => Session::get_value('account')['id'],
						'token' => strtoupper($data['token']),
	                    'number' => $data['number'],
	                    'name' => $data['name'],
	                    'qr' => $data['qr']['filename']
					]);

					QRcode::png($data['qr']['content'], $data['qr']['dir'], $data['qr']['level'], $data['qr']['size'], $data['qr']['frame']);
				}
			}
		}
		else if($data['type'] == 'department')
		{
			$query = $this->database->insert('owners', [
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
				'status' => true
			]);
		}

		return $query;
	}

	public function edit_owner($data)
	{
		if (!empty($data['number']) AND isset($data['number']))
		{
			$query = null;

			$exist = $this->database->count('owners', [
				'AND' => [
					'id[!]' => $data['id'],
					'account' => Session::get_value('account')['id'],
					'number' => $data['number']
				]
			]);

			if ($exist <= 0)
			{
				$query = $this->database->update('owners', [
					'number' => $data['number'],
					'name' => $data['name']
				], [
					'id' => $data['id']
				]);
			}
		}

		$query = $this->database->update('owners', [
			'name' => $data['name']
		], [
			'id' => $data['id']
		]);

		return $query;
	}

	public function delete_owner($id)
	{
		$query = null;

		$deleted = $this->get_owner($id);

		if (!empty($deleted))
		{
			$query = $this->database->delete('owners', [
				'id' => $id
			]);

			if (!empty($query))
				Functions::undoloader($deleted['qr']);
		}

		return $query;
	}
}
