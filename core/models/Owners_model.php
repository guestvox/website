<?php

defined('_EXEC') or die;

require 'plugins/php_qr_code/qrlib.php';

class Owners_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function get_owners($option = 'all')
	{
		$query = null;

		if ($option == 'all')
		{
			$query = Functions::get_json_decoded_query($this->database->select('owners', [
				'id',
				'token',
				'name',
				'number',
				'request',
				'incident',
				'workorder',
				'survey',
				'public',
				'qr',
				'status'
			], [
				'account' => Session::get_value('account')['id'],
				'ORDER' => [
					'number' => 'ASC',
					'name' => 'ASC'
				]
			]));
		}
		else if ($option == 'count')
		{
			$query = $this->database->count('owners', [
				'account' => Session::get_value('account')['id']
			]);
		}

		return $query;
	}

	public function get_owner($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('owners', [
			'name',
			'number',
			'request',
			'incident',
			'workorder',
			'survey',
			'public',
			'qr'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function new_owner($data)
	{
        $query = null;

		if ($data['type'] == 'one')
		{
			$data['token'] = strtolower(Functions::get_random(8));
			$data['qr']['filename'] = Session::get_value('account')['path'] . '_owner_qr_' . $data['token'] . '.png';
			$data['qr']['content'] = 'https://' . Configuration::$domain . '/' . Session::get_value('account')['path'] . '/myvox/owner/' . $data['token'];
			$data['qr']['dir'] = PATH_UPLOADS . $data['qr']['filename'];
			$data['qr']['level'] = 'H';
			$data['qr']['size'] = 5;
			$data['qr']['frame'] = 3;

			$query = $this->database->insert('owners', [
				'account' => Session::get_value('account')['id'],
				'token' => $data['token'],
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en']
				]),
				'number' => $data['number'],
				'request' => !empty($data['request']) ? true : false,
				'incident' => !empty($data['incident']) ? true : false,
				'workorder' => !empty($data['workorder']) ? true : false,
				'survey' => !empty($data['survey']) ? true : false,
				'public' => !empty($data['public']) ? true : false,
				'qr' => $data['qr']['filename'],
				'status' => true
			]);

			QRcode::png($data['qr']['content'], $data['qr']['dir'], $data['qr']['level'], $data['qr']['size'], $data['qr']['frame']);
		}
		else if ($data['type'] == 'many')
		{
			for ($i = $data['since']; $i <= $data['to']; $i++)
			{
				if ($this->get_owners('count') < Session::get_value('account')['package']['quantity_end'])
				{
					$data['token'] = strtolower(Functions::get_random(8));
					$data['qr']['filename'] = Session::get_value('account')['path'] . '_owner_qr_' . $data['token'] . '.png';
					$data['qr']['content'] = 'https://' . Configuration::$domain . '/' . Session::get_value('account')['path'] . '/myvox/owner/' . $data['token'];
					$data['qr']['dir'] = PATH_UPLOADS . $data['qr']['filename'];
					$data['qr']['level'] = 'H';
					$data['qr']['size'] = 5;
					$data['qr']['frame'] = 3;

					$query = $this->database->insert('owners', [
						'account' => Session::get_value('account')['id'],
						'token' => $data['token'],
						'name' => json_encode([
							'es' => $data['name_es'],
							'en' => $data['name_en']
						]),
						'number' => $i,
						'request' => !empty($data['request']) ? true : false,
						'incident' => !empty($data['incident']) ? true : false,
						'workorder' => !empty($data['workorder']) ? true : false,
						'survey' => !empty($data['survey']) ? true : false,
						'public' => !empty($data['public']) ? true : false,
						'qr' => $data['qr']['filename'],
						'status' => true
					]);

					QRcode::png($data['qr']['content'], $data['qr']['dir'], $data['qr']['level'], $data['qr']['size'], $data['qr']['frame']);
				}
			}
		}

		return $query;
	}

	public function edit_owner($data)
	{
		$query = $this->database->update('owners', [
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en']
			]),
			'number' => $data['number'],
			'request' => !empty($data['request']) ? true : false,
			'incident' => !empty($data['incident']) ? true : false,
			'workorder' => !empty($data['workorder']) ? true : false,
			'survey' => !empty($data['survey']) ? true : false,
			'public' => !empty($data['public']) ? true : false
		], [
			'id' => $data['id']
		]);

		return $query;
	}

	public function deactivate_owner($id)
	{
		$query = $this->database->update('owners', [
			'status' => false
		], [
			'id' => $id
		]);

		return $query;
	}

	public function activate_owner($id)
	{
		$query = $this->database->update('owners', [
			'status' => true
		], [
			'id' => $id
		]);

		return $query;
	}

	public function delete_owner($id)
	{
		$query = null;

		$deleted = $this->database->select('owners', [
			'qr'
		], [
			'id' => $id
		]);

		if (!empty($deleted))
		{
			$query = $this->database->delete('owners', [
				'id' => $id
			]);

			if (!empty($query))
				Functions::undoloader($deleted[0]['qr']);
		}

		return $query;
	}
}
