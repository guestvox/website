<?php

defined('_EXEC') or die;

require "plugins/php-qr-code/qrlib.php";

class Rooms_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function get_rooms()
	{
		$query = $this->database->select('rooms', [
			'id',
			'name',
			'token',
			'qr',
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'name' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_room($id)
	{
		$query = $this->database->select('rooms', [
			'name',
			'qr',
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function new_room($data)
	{
        $query = null;

		if ($data['type'] == 'many')
		{
			$data['prefix'] = !empty($data['prefix']) ? $data['prefix'] . ' ' : '';
			$data['to'] = !empty($data['to']) ? $data['to'] : $data['since'];
			$data['suffix'] = !empty($data['suffix']) ? ' ' . $data['suffix'] : '';

			for ($i = $data['since']; $i <= $data['to']; $i++)
			{
				$data['name'] = $data['prefix'] . $i . $data['suffix'];

				$exist = $this->database->count('rooms', [
					'AND' => [
						'account' => Session::get_value('account')['id'],
						'name' => $data['name'],
					]
				]);

				if ($exist <= 0)
				{
					$qr_dir = PATH_UPLOADS;
					$qr_code = $this->security->random_string(8);
					$qr_filename = 'qr_' . $qr_code . '.png';
					$qr_size = 5;
					$qr_frame_size = 3;
					$qr_level = 'H';
					$qr_content = 'https://' . Configuration::$domain . '/myvox/' . $qr_code;

					QRcode::png($qr_content, $qr_dir . $qr_filename, $qr_level, $qr_size, $qr_frame_size);

					$qr_dir . basename($qr_filename);

					$query = $this->database->insert('rooms', [
						'account' => Session::get_value('account')['id'],
						'name' => $data['name'],
                        'token' => strtoupper($qr_code),
						'qr' => $qr_filename,
						'folio' => null
					]);
				}
			}
		}
		else if ($data['type'] == 'one')
		{
			$exist = $this->database->count('rooms', [
				'AND' => [
					'account' => Session::get_value('account')['id'],
					'name' => $data['name'],
					'folio' => !empty($data['folio']) ? $data['folio'] : null
				]
			]);

			if ($exist <= 0)
			{
				$qr_dir = PATH_UPLOADS;
				$qr_code = $this->security->random_string(8);
				$qr_filename = 'qr_' . $qr_code . '.png';
				$qr_size = 5;
				$qr_frame_size = 3;
				$qr_level = 'H';
				$qr_content = 'https://' . Configuration::$domain . '/myvox/' . $qr_code;

				QRcode::png($qr_content, $qr_dir . $qr_filename, $qr_level, $qr_size, $qr_frame_size);

				$qr_dir . basename($qr_filename);

				$query = $this->database->insert('rooms', [
                    'account' => Session::get_value('account')['id'],
                    'name' => $data['name'],
                    'token' => strtoupper($qr_code),
                    'qr' => $qr_filename,
					'folio' => !empty($data['folio']) ? $data['folio'] : null
				]);
			}
		}

		return $query;
	}

	public function edit_room($data)
	{
		$query = null;

		$exist = $this->database->count('rooms', [
			'AND' => [
				'id[!]' => $data['id'],
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->update('rooms', [
				'name' => $data['name'],
			], [
				'id' => $data['id']
			]);
		}

		return $query;
	}

	public function delete_room($id)
	{
		$query = null;

		$deleted = $this->get_room($id);

		if (!empty($deleted))
		{
			$query = $this->database->delete('rooms', [
				'id' => $id
			]);

			if (!empty($query))
				unlink(PATH_UPLOADS . $deleted['qr']);
		}

		return $query;
	}
}
