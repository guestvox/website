<?php

defined('_EXEC') or die;

require 'plugins/php-qr-code/qrlib.php';

class Tables_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function get_tables()
	{
		$query = $this->database->select('tables', [
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

	public function get_count_tables()
	{
		$query = $this->database->count('tables', [
			'account' => Session::get_value('account')['id']
		]);

		return $query;
	}

	public function get_table($id)
	{
		$query = $this->database->select('tables', [
			'number',
			'name',
			'qr',
			'status'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function new_table($data)
	{
        $query = null;

		if ($data['type'] == 'many')
		{
			for ($i = $data['since']; $i <= $data['to']; $i++)
			{
				$exist = $this->database->count('tables', [
					'AND' => [
						'account' => Session::get_value('account')['id'],
						'number' => $i
					]
				]);

				if ($exist <= 0)
				{
					if ($this->get_count_tables() < Session::get_value('account')['table_package']['quantity_end'])
					{
						$data['token'] = Functions::get_random(8);
						$data['qr']['filename'] = 'qr_' . Session::get_value('account')['path'] . '_table_' . $data['token'] . '.png';
						$data['qr']['content'] = 'https://' . Configuration::$domain . '/' . Session::get_value('account')['path'] . '/myvox/table/' . $data['token'];
						$data['qr']['dir'] = PATH_UPLOADS . $data['qr']['filename'];
						$data['qr']['level'] = 'H';
						$data['qr']['size'] = 5;
						$data['qr']['frame'] = 3;

						$query = $this->database->insert('tables', [
							'account' => Session::get_value('account')['id'],
							'token' => strtoupper($data['token']),
							'number' => $i,
							'name' => null,
							'qr' => $data['qr']['filename']
						]);
					}
				}
			}
		}
		else if ($data['type'] == 'one')
		{
			$exist = $this->database->count('tables', [
				'AND' => [
					'account' => Session::get_value('account')['id'],
					'number' => $data['number']
				]
			]);

			if ($exist <= 0)
			{
				if ($this->get_count_tables() < Session::get_value('account')['table_package']['quantity_end'])
				{
					$data['token'] = Functions::get_random(8);
					$data['qr']['filename'] = 'qr_' . Session::get_value('account')['path'] . '_table_' . $data['token'] . '.png';
					$data['qr']['content'] = 'https://' . Configuration::$domain . '/' . Session::get_value('account')['path'] . '/myvox/table/' . $data['token'];
					$data['qr']['dir'] = PATH_UPLOADS . $data['qr']['filename'];
					$data['qr']['level'] = 'H';
					$data['qr']['size'] = 5;
					$data['qr']['frame'] = 3;

					$query = $this->database->insert('tables', [
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
			$query = $this->database->insert('tables', [
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
				'status' => true
			]);
		}

		return $query;
	}

	public function edit_table($data)
	{
		if (!empty($data['number']) AND isset($data['number']))
		{
			$query = null;

			$exist = $this->database->count('tables', [
				'AND' => [
					'id[!]' => $data['id'],
					'account' => Session::get_value('account')['id'],
					'number' => $data['number']
				]
			]);

			if ($exist <= 0)
			{
				$query = $this->database->update('tables', [
					'number' => $data['number'],
					'name' => $data['name']
				], [
					'id' => $data['id']
				]);
			}
		}

		$query = $this->database->update('tables', [
			'name' => $data['name']
		], [
			'id' => $data['id']
		]);

		return $query;
	}

	public function delete_table($id)
	{
		$query = null;

		$deleted = $this->get_table($id);

		if (!empty($deleted))
		{
			$query = $this->database->delete('tables', [
				'id' => $id
			]);

			if (!empty($query))
				Functions::undoloader($deleted['qr']);
		}

		return $query;
	}
}
