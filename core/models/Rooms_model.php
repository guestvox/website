<?php

defined('_EXEC') or die;

require 'plugins/php-qr-code/qrlib.php';

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
			'token',
			'number',
			'name',
			'qr'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'number' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_count_rooms()
	{
		$query = $this->database->count('rooms', [
			'account' => Session::get_value('account')['id']
		]);

		return $query;
	}

	public function get_room($id)
	{
		$query = $this->database->select('rooms', [
			'number',
			'name',
			'qr'
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
			for ($i = $data['since']; $i <= $data['to']; $i++)
			{
				$exist = $this->database->count('rooms', [
					'AND' => [
						'account' => Session::get_value('account')['id'],
						'number' => $i
					]
				]);

				if ($exist <= 0)
				{
					if ($this->get_count_rooms() < Session::get_value('account')['room_package']['quantity_end'])
					{
						$qr_dir = PATH_UPLOADS;
						$qr_code = Functions::get_random(8);
						$qr_filename = 'qr_' . $qr_code . '.png';
						$qr_size = 5;
						$qr_frame_size = 3;
						$qr_level = 'H';
						$qr_content = 'https://' . Configuration::$domain . '/myvox/room/' . $qr_code;

						QRcode::png($qr_content, $qr_dir . $qr_filename, $qr_level, $qr_size, $qr_frame_size);

						$qr_dir . basename($qr_filename);

						$query = $this->database->insert('rooms', [
							'account' => Session::get_value('account')['id'],
							'token' => strtoupper($qr_code),
							'number' => $i,
							'name' => null,
							'qr' => $qr_filename
						]);
					}
				}
			}
		}
		else if ($data['type'] == 'one')
		{
			$exist = $this->database->count('rooms', [
				'AND' => [
					'account' => Session::get_value('account')['id'],
					'number' => $data['number']
				]
			]);

			if ($exist <= 0)
			{
				if ($this->get_count_rooms() < Session::get_value('account')['room_package']['quantity_end'])
				{
					$qr_dir = PATH_UPLOADS;
					$qr_code = Functions::get_random(8);
					$qr_filename = 'qr_' . $qr_code . '.png';
					$qr_size = 5;
					$qr_frame_size = 3;
					$qr_level = 'H';
					$qr_content = 'https://' . Configuration::$domain . '/myvox/room/' . $qr_code;

					QRcode::png($qr_content, $qr_dir . $qr_filename, $qr_level, $qr_size, $qr_frame_size);

					$qr_dir . basename($qr_filename);

					$query = $this->database->insert('rooms', [
	                    'account' => Session::get_value('account')['id'],
						'token' => strtoupper($qr_code),
	                    'number' => $data['number'],
	                    'name' => $data['name'],
	                    'qr' => $qr_filename
					]);
				}
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
				'number' => $data['number']
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->update('rooms', [
				'number' => $data['number'],
				'name' => $data['name']
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
				Functions::undoloader($deleted['qr'], PATH_UPLOADS);
		}

		return $query;
	}
}
