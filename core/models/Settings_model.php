<?php

defined('_EXEC') or die;

require "plugins/php-qr-code/qrlib.php";

class Settings_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_opportunity_areas($relation = true)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
			'id',
			'name',
			'request',
			'incident',
			'public',
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		if ($relation == true)
		{
			foreach ($query as $key => $value)
			{
				$relation1 = $this->database->count('opportunity_types', [
					'opportunity_area' => $value['id']
				]);

				$relation2 = false;

				foreach ($this->get_users() as $subvalue)
				{
					if (in_array($value['id'], $subvalue['opportunity_areas']))
						$relation2 = true;
				}

				$relation3 = false;

				// foreach ($this->get_voxes() as $subvalue)
				// {
				// 	if ($value['id'] == $subvalue['data']['opportunity_area'])
				// 		$relation3 = true;
				// }

				$relation4 = $this->database->count('reports', [
					'opportunity_area' => $value['id']
				]);

				$relation5 = false;

				foreach ($this->get_reports() as $subvalue)
				{
					if (in_array($value['id'], $subvalue['addressed_to_opportunity_areas']))
						$relation5 = true;
				}

				$query[$key]['relation'] = ($relation1 > 0 OR $relation2 > true  OR $relation3 == true OR $relation4 > 0 OR $relation5 == true) ? true : false;
			}
		}

		return $query;
	}

	public function get_opportunity_area($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
			'id',
			'name',
			'request',
			'incident',
			'public',
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function new_opportunity_area($data)
	{
		$query = null;

		$exist = $this->database->count('opportunity_areas', [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en'],
				]),
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->insert('opportunity_areas', [
				'account' => Session::get_value('account')['id'],
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en'],
				]),
				'request' => !empty($data['request']) ? true : false,
				'incident' => !empty($data['incident']) ? true : false,
				'public' => !empty($data['public']) ? true : false,
			]);
		}

		return $query;
	}

	public function edit_opportunity_area($data)
	{
		$query = null;

		$exist = $this->database->count('opportunity_areas', [
			'AND' => [
				'id[!]' => $data['id'],
				'account' => Session::get_value('account')['id'],
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en'],
				]),
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->update('opportunity_areas', [
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en'],
				]),
				'request' => !empty($data['request']) ? true : false,
				'incident' => !empty($data['incident']) ? true : false,
				'public' => !empty($data['public']) ? true : false,
			], [
				'id' => $data['id']
			]);
		}

		return $query;
	}

	public function delete_opportunity_area($id)
	{
		$query = $this->database->delete('opportunity_areas', [
			'id' => $id
		]);

		return $query;
	}

	// ---

	public function get_opportunity_types()
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
			'[>]opportunity_areas' => [
				'opportunity_area' => 'id'
			]
		], [
			'opportunity_types.id',
			'opportunity_areas.name(opportunity_area)',
			'opportunity_types.name',
			'opportunity_types.request',
			'opportunity_types.incident',
			'opportunity_types.public',
		], [
			'opportunity_types.account' => Session::get_value('account')['id'],
			'ORDER' => [
				'opportunity_areas.name ' => 'ASC',
				'opportunity_types.name' => 'ASC'
			]
		]));

		foreach ($query as $key => $value)
		{
			$relation1 = false;

			// foreach ($this->get_voxes() as $subvalue)
			// {
			// 	if ($value['id'] == $subvalue['data']['opportunity_type'])
			// 		$relation1 = true;
			// }

			$relation2 = $this->database->count('reports', [
				'opportunity_type' => $value['id']
			]);;

			$query[$key]['relation'] = ($relation1 == true OR $relation2 > 0) ? true : false;
		}

		return $query;
	}

	public function get_opportunity_type($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
			'id',
			'opportunity_area',
			'name',
			'request',
			'incident',
			'public',
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function new_opportunity_type($data)
	{
		$query = null;

		$exist = $this->database->count('opportunity_types', [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en'],
				]),
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->insert('opportunity_types', [
				'account' => Session::get_value('account')['id'],
				'opportunity_area' => $data['opportunity_area'],
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en'],
				]),
				'request' => !empty($data['request']) ? true : false,
				'incident' => !empty($data['incident']) ? true : false,
				'public' => !empty($data['public']) ? true : false,
			]);
		}

		return $query;
	}

	public function edit_opportunity_type($data)
	{
		$query = null;

		$exist = $this->database->count('opportunity_types', [
			'AND' => [
				'id[!]' => $data['id'],
				'account' => Session::get_value('account')['id'],
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en'],
				]),
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->update('opportunity_types', [
				'opportunity_area' => $data['opportunity_area'],
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en'],
				]),
				'request' => !empty($data['request']) ? true : false,
				'incident' => !empty($data['incident']) ? true : false,
				'public' => !empty($data['public']) ? true : false,
			], [
				'id' => $data['id']
			]);
		}

		return $query;
	}

	public function delete_opportunity_type($id)
	{
		$query = $this->database->delete('opportunity_types', [
			'id' => $id
		]);

		return $query;
	}

	// ---

	public function get_locations()
	{
		$query = Functions::get_json_decoded_query($this->database->select('locations', [
			'id',
			'name',
			'request',
			'incident',
			'public',
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		foreach ($query as $key => $value)
		{
			$relation1 = false;

			// foreach ($this->get_voxes() as $subvalue)
			// {
			// 	if ($value['id'] == $subvalue['data']['location'])
			// 		$relation1 = true;
			// }

			$relation2 = $this->database->count('reports', [
				'location' => $value['id']
			]);

			$query[$key]['relation'] = ($relation1 == true OR $relation2 > 0) ? true : false;
		}

		return $query;
	}

	public function get_location($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('locations', [
			'id',
			'name',
			'request',
			'incident',
			'public',
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function new_location($data)
	{
		$query = null;

		$exist = $this->database->count('locations', [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en'],
				]),
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->insert('locations', [
				'account' => Session::get_value('account')['id'],
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en'],
				]),
				'request' => !empty($data['request']) ? true : false,
				'incident' => !empty($data['incident']) ? true : false,
				'public' => !empty($data['public']) ? true : false,
			]);
		}

		return $query;
	}

	public function edit_location($data)
	{
		$query = null;

		$exist = $this->database->count('locations', [
			'AND' => [
				'id[!]' => $data['id'],
				'account' => Session::get_value('account')['id'],
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en'],
				]),
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->update('locations', [
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en'],
				]),
				'request' => !empty($data['request']) ? true : false,
				'incident' => !empty($data['incident']) ? true : false,
				'public' => !empty($data['public']) ? true : false,
			], [
				'id' => $data['id']
			]);
		}

		return $query;
	}

	public function delete_location($id)
	{
		$query = $this->database->delete('locations', [
			'id' => $id
		]);

		return $query;
	}

	// ---

	public function get_rooms()
	{
		$query = Functions::get_json_decoded_query($this->database->select('rooms', [
			'id',
			'name',
			'qr',
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		foreach ($query as $key => $value)
		{
			$relation = false;

			// foreach ($this->get_voxes() as $subvalue)
			// {
			// 	if ($value['id'] == $subvalue['data']['room'])
			// 		$relation = true;
			// }

			$query[$key]['relation'] = ($relation == true) ? true : false;
		}

		return $query;
	}

	public function get_room($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('rooms', [
			'id',
			'name',
			'qr'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function new_room($data)
	{
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
					$qr_content = "http://guestvox.com/myvox/" . $qr_code;

					QRcode::png($qr_content, $qr_dir . $qr_filename, $qr_level, $qr_size, $qr_frame_size);

					$qr_dir . basename($qr_filename);

					$query = $this->database->insert('rooms', [
						'account' => Session::get_value('account')['id'],
						'code' => strtoupper($qr_code),
						'name' => $data['name'],
						'qr' => json_encode([
							'name' => $qr_filename,
							'code' => $qr_code,
						]),
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
				$qr_content = "http://guestvox.com/myvox/" . $qr_code;

				QRcode::png($qr_content, $qr_dir . $qr_filename, $qr_level, $qr_size, $qr_frame_size);

				$qr_dir . basename($qr_filename);

				$query = $this->database->insert('rooms', [
					'account' => Session::get_value('account')['id'],
					'code' => strtoupper($qr_code),
					'name' => $data['name'],
					'qr' => json_encode([
						'name' => $qr_filename,
						'code' => $qr_code,
					]),
				]);
			}
		}

		return true;
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
				unlink(PATH_UPLOADS . $deleted['qr']['name']);
		}

		return $query;
	}

	// ---

	public function get_guest_treatments()
	{
		$query = $this->database->select('guest_treatments', [
			'id',
			'name',
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'name' => 'ASC'
			]
		]);

		foreach ($query as $key => $value)
		{
			$relation = false;

			// foreach ($this->get_voxes() as $subvalue)
			// {
			// 	if ($value['id'] == $subvalue['data']['guest_treatment'])
			// 		$relation = true;
			// }

			$query[$key]['relation'] = ($relation == true) ? true : false;
		}

		return $query;
	}

	public function get_guest_treatment($id)
	{
		$query = $this->database->select('guest_treatments', [
			'id',
			'name',
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function new_guest_treatment($data)
	{
		$query = null;

		$exist = $this->database->count('guest_treatments', [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->insert('guest_treatments', [
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
			]);
		}

		return $query;
	}

	public function edit_guest_treatment($data)
	{
		$query = null;

		$exist = $this->database->count('guest_treatments', [
			'AND' => [
				'id[!]' => $data['id'],
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->update('guest_treatments', [
				'name' => $data['name'],
			], [
				'id' => $data['id']
			]);
		}

		return $query;
	}

	public function delete_guest_treatment($id)
	{
		$query = $this->database->delete('guest_treatments', [
			'id' => $id
		]);

		return $query;
	}

	// ---

	public function get_guest_types()
	{
		$query = $this->database->select('guest_types', [
			'id',
			'name',
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'name' => 'ASC'
			]
		]);

		foreach ($query as $key => $value)
		{
			$relation = false;

			// foreach ($this->get_voxes() as $subvalue)
			// {
			// 	if ($value['id'] == $subvalue['data']['guest_type'])
			// 		$relation = true;
			// }

			$query[$key]['relation'] = ($relation == true) ? true : false;
		}

		return $query;
	}

	public function get_guest_type($id)
	{
		$query = $this->database->select('guest_types', [
			'id',
			'name',
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function new_guest_type($data)
	{
		$query = null;

		$exist = $this->database->count('guest_types', [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->insert('guest_types', [
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
			]);
		}

		return $query;
	}

	public function edit_guest_type($data)
	{
		$query = null;

		$exist = $this->database->count('guest_types', [
			'AND' => [
				'id[!]' => $data['id'],
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->update('guest_types', [
				'name' => $data['name'],
			], [
				'id' => $data['id']
			]);
		}

		return $query;
	}

	public function delete_guest_type($id)
	{
		$query = $this->database->delete('guest_types', [
			'id' => $id
		]);

		return $query;
	}

	// ---

	public function get_reservation_statuss()
	{
		$query = $this->database->select('reservation_status', [
			'id',
			'name',
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'name' => 'ASC'
			]
		]);

		foreach ($query as $key => $value)
		{
			$relation = false;

			// foreach ($this->get_voxes() as $subvalue)
			// {
			// 	if ($value['id'] == $subvalue['data']['reservation_status'])
			// 		$relation = true;
			// }

			$query[$key]['relation'] = ($relation == true) ? true : false;
		}

		return $query;
	}

	public function get_reservation_status($id)
	{
		$query = $this->database->select('reservation_status', [
			'id',
			'name',
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function new_reservation_status($data)
	{
		$query = null;

		$exist = $this->database->count('reservation_status', [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->insert('reservation_status', [
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
			]);
		}

		return $query;
	}

	public function edit_reservation_status($data)
	{
		$query = null;

		$exist = $this->database->count('reservation_status', [
			'AND' => [
				'id[!]' => $data['id'],
				'account' => Session::get_value('account')['id'],
				'name' => $data['name'],
			]
		]);

		if ($exist <= 0)
		{
			$query = $this->database->update('reservation_status', [
				'name' => $data['name'],
			], [
				'id' => $data['id']
			]);
		}

		return $query;
	}

	public function delete_reservation_status($id)
	{
		$query = $this->database->delete('reservation_status', [
			'id' => $id
		]);

		return $query;
	}

	// ---

	// public function get_voxes()
	// {
	// 	$query = $this->database->select('voxes', [
	// 		'data'
	// 	], [
	// 		'account' => Session::get_value('account')['id']
	// 	]);
	//
	// 	foreach ($query as $key => $value)
	// 		$query[$key]['data'] = json_decode(Functions::get_openssl('decrypt', $value['data']), true);
	//
	// 	return $query;
	// }

	public function get_users()
	{
		$query = Functions::get_json_decoded_query($this->database->select('users', [
			'opportunity_areas'
		], [
			'account' => Session::get_value('account')['id']
		]));

		return $query;
	}

	public function get_reports()
	{
		$query = Functions::get_json_decoded_query($this->database->select('reports', [
			'addressed_to_opportunity_areas'
		], [
			'account' => Session::get_value('account')['id']
		]));

		foreach ($query as $key => $value)
			$query[$key]['addressed_to_opportunity_areas'] = (!empty($value['addressed_to_opportunity_areas'])) ? $value['addressed_to_opportunity_areas'] : [];

		return $query;
	}
}
