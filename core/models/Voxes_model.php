<?php

defined('_EXEC') or die;

class Voxes_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_voxes()
	{
		$voxes = [];

		$query = $this->database->select('voxes', [
			'id',
			'data',
		], [
			'account' => Session::get_value('account')['id']
		]);

		foreach ($query as $key => $value)
		{
			$value['data'] = json_decode(Functions::get_openssl('decrypt', $value['data']), true);

			$break = false;

			if (Functions::check_access(['{views_opportunity_areas}']) == true AND !in_array($value['data']['opportunity_area'], Session::get_value('user')['opportunity_areas']))
				$break = true;

			if (Functions::check_access(['{views_own}']) == true AND $value['data']['created_user'] != Session::get_value('user')['id'] AND !in_array(Session::get_value('user')['id'], $value['data']['assigned_users']))
				$break = true;

			if (Functions::check_access(['{views_confidentiality}']) == false && $value['data']['confidentiality'] == true)
				$break = true;

			if ($break == false)
			{
				$value['data']['room'] = $this->get_room($value['data']['room'])['name'];
				$value['data']['opportunity_area'] = $this->get_opportunity_area($value['data']['opportunity_area'])['name'][Session::get_value('settings')['language']];
				$value['data']['opportunity_type'] = $this->get_opportunity_type($value['data']['opportunity_type'])['name'][Session::get_value('settings')['language']];
				$value['data']['location'] = $this->get_location($value['data']['location'])['name'][Session::get_value('settings')['language']];
				$value['data']['guest_treatment'] = $this->get_guest_treatment($value['data']['guest_treatment'])['name'];

				if (!empty($value['data']['comments']))
				{
					$value['data']['attachments'] = (is_array($value['data']['attachments'])) ? $value['data']['attachments'] : [];

					foreach ($value['data']['comments'] as $subvalue)
					{
						$subvalue['attachments'] = (is_array($subvalue['attachments'])) ? $subvalue['attachments'] : [];
						$value['data']['attachments'] = array_merge($value['data']['attachments'], $subvalue['attachments']);
					}
				}

				$aux[$key] = Functions::get_formatted_date_hour($value['data']['started_date'], $value['data']['started_hour']);

				array_push($voxes, $value);
			}
		}

		if (!empty($voxes))
			array_multisort($aux, SORT_DESC, $voxes);

		return $voxes;
	}

	public function get_vox($id, $viewed = false)
	{
		$query = $this->database->select('voxes', [
			'id',
			'type',
			'data',
		], [
			'id' => $id,
		]);

		if (!empty($query))
		{
			$query[0]['data'] = json_decode(Functions::get_openssl('decrypt', $query[0]['data']), true);

			// ---

			if ($viewed == true)
			{
				if ($query[0]['data']['readed'] == false)
					$query[0]['data']['readed'] = true;

				if ($query[0]['data']['status'] == 'open')
				{
					if (!in_array(Session::get_value('user')['id'], $query[0]['data']['viewed_by']))
						array_push($query[0]['data']['viewed_by'], Session::get_value('user')['id']);

					array_push($query[0]['data']['changes_history'], [
						'type' => 'viewed',
						'user' => Session::get_value('user')['id'],
						'date' => Functions::get_current_date(),
						'hour' => Functions::get_current_hour(),
					]);
				}

				$this->database->update('voxes', [
					'data' => Functions::get_openssl('encrypt', json_encode($query[0]['data']))
				], [
					'id' => $id
				]);
			}

			// ---

			$query[0]['data']['room'] = $this->get_room($query[0]['data']['room']);
			$query[0]['data']['opportunity_area'] = $this->get_opportunity_area($query[0]['data']['opportunity_area']);
			$query[0]['data']['opportunity_type'] = $this->get_opportunity_type($query[0]['data']['opportunity_type']);
			$query[0]['data']['location'] = $this->get_location($query[0]['data']['location']);

			if (!empty($query[0]['data']['assigned_users']))
			{
				foreach ($query[0]['data']['assigned_users'] as $key => $value)
					$query[0]['data']['assigned_users'][$key] = $this->get_user($value);
			}

			$query[0]['data']['guest_treatment'] = $this->get_guest_treatment($query[0]['data']['guest_treatment']);
			$query[0]['data']['guest_type'] = $this->get_guest_type($query[0]['data']['guest_type']);
			$query[0]['data']['reservation_status'] = $this->get_reservation_status($query[0]['data']['reservation_status']);

			if (!empty($query[0]['data']['comments']))
			{
				foreach ($query[0]['data']['comments'] as $key => $value)
					$query[0]['data']['comments'][$key]['user'] = $this->get_user($value['user']);
			}

			$query[0]['data']['created_user'] = $this->get_user($query[0]['data']['created_user']);
			$query[0]['data']['edited_user'] = $this->get_user($query[0]['data']['edited_user']);
			$query[0]['data']['completed_user'] = $this->get_user($query[0]['data']['completed_user']);
			$query[0]['data']['reopened_user'] = $this->get_user($query[0]['data']['reopened_user']);

			if (!empty($query[0]['data']['viewed_by']))
			{
				foreach ($query[0]['data']['viewed_by'] as $key => $value)
					$query[0]['data']['viewed_by'][$key] = $this->get_user($value);
			}

			if (!empty($query[0]['data']['changes_history']))
			{
				$query[0]['data']['changes_history'] = array_reverse($query[0]['data']['changes_history']);

				foreach ($query[0]['data']['changes_history'] as $key => $value)
				{
					$query[0]['data']['changes_history'][$key]['user'] = $this->get_user($value['user']);
				}
			}

			return $query[0];
		}
		else
			return null;
	}

	public function new_vox($data, $public = false)
	{
		if ($public == false)
		{
			$this->component->load_component('uploader');

			$_com_uploader = new Upload;

			foreach ($data['attachments']['name'] as $key => $value)
			{
				if (!empty($data['attachments']['name'][$key]))
				{
					$ext = explode('.', $data['attachments']['name'][$key]);
					$ext = end($ext);

					if ($ext == 'doc' || $ext == 'docx' || $ext == 'xls' || $ext == 'xlsx')
						$data['attachments']['type'][$key] = 'application/' . $ext;

					$_com_uploader->SetFileName($data['attachments']['name'][$key]);
					$_com_uploader->SetTempName($data['attachments']['tmp_name'][$key]);
					$_com_uploader->SetFileType($data['attachments']['type'][$key]);
					$_com_uploader->SetFileSize($data['attachments']['size'][$key]);
					$_com_uploader->SetUploadDirectory(PATH_UPLOADS);
					$_com_uploader->SetValidExtensions(['jpg','jpeg','png','pdf','doc','docx','xls','xlsx']);
					$_com_uploader->SetMaximumFileSize('unlimited');

					$data['attachments'][$key] = $_com_uploader->UploadFile();
				}
			}

			unset($data['attachments']['name'], $data['attachments']['type'], $data['attachments']['tmp_name'], $data['attachments']['error'], $data['attachments']['size']);
		}

		$query = $this->database->insert('voxes', [
			'account' => ($public == false) ? Session::get_value('account')['id'] : $data['account'],
			'type' => $data['type'],
			'data' => Functions::get_openssl('encrypt', json_encode([
				'token' => $this->security->random_string(8),
				'room' => $data['room'],
				'opportunity_area' => $data['opportunity_area'],
				'opportunity_type' => $data['opportunity_type'],
				'started_date' => Functions::get_formatted_date($data['started_date']),
				'started_hour' => Functions::get_formatted_hour($data['started_hour']),
				'location' => $data['location'],
				'cost' => ($public == false AND $data['type'] == 'incident') ? $data['cost'] : null,
				'urgency' => ($public == false) ? $data['urgency'] : 'medium',
				'confidentiality' => ($public == false AND $data['type'] == 'incident') ? $data['confidentiality'] : null,
				'assigned_users' => ($public == false AND !empty($data['assigned_users'])) ? $data['assigned_users'] : [],
				'observations' => ($data['type'] == 'request') ? $data['observations'] : null,
				'subject' => ($public == false AND $data['type'] == 'incident') ? $data['subject'] : null,
				'description' => ($data['type'] == 'incident') ? $data['description'] : null,
				'action_taken' => ($public == false AND $data['type'] == 'incident') ? $data['action_taken'] : null,
				'guest_treatment' => ($public == false) ? $data['guest_treatment'] : null,
				'name' => ($public == false AND $data['type'] == 'incident') ? $data['name'] : null,
				'lastname' => $data['lastname'],
				'guest_id' => ($public == false AND $data['type'] == 'incident') ? $data['guest_id'] : null,
				'guest_type' => ($public == false AND $data['type'] == 'incident') ? $data['guest_type'] : null,
				'reservation_number' => ($public == false AND $data['type'] == 'incident') ? $data['reservation_number'] : null,
				'reservation_status' => ($public == false AND $data['type'] == 'incident') ? $data['reservation_status'] : null,
				'check_in' => ($public == false AND $data['type'] == 'incident') ? $data['check_in'] : null,
				'check_out' => ($public == false AND $data['type'] == 'incident') ? $data['check_out'] : null,
				'attachments' => ($public == false) ? $data['attachments'] : [],
				'viewed_by' => [],
				'comments' => [],
				'changes_history' => [
					[
						'type' => 'create',
						'user' => ($public == false) ? Session::get_value('user')['id'] : null,
						'date' => Functions::get_current_date(),
						'hour' => Functions::get_current_hour(),
					]
				],
				'created_user' => ($public == false) ? Session::get_value('user')['id'] : null,
				'edited_user' => null,
				'completed_user' => null,
				'reopened_user' => null,
				'created_date' => Functions::get_current_date(),
				'created_hour' => Functions::get_current_hour(),
				'edited_date' => null,
				'edited_hour' => null,
				'completed_date' => null,
				'completed_hour' => null,
				'reopened_date' => null,
				'reopened_hour' => null,
				'readed' => false,
				'status' => 'open',
				'origin' => ($public == false) ? 'internal' : 'external',
			])),
		]);

		return !empty($query) ? $this->database->id($query) : null;
	}

	public function edit_vox($data)
	{
		$query = null;

		$editer = $this->database->select('voxes', [
			'type',
			'data'
		], [
			'id' => $data['id']
		]);

		if (!empty($editer))
		{
			$editer[0]['data'] = json_decode(Functions::get_openssl('decrypt', $editer[0]['data']), true);

			// ---

			if (!empty($data['assigned_users']))
			{
				$data['assigned_users'] = array_merge($editer[0]['data']['assigned_users'], $data['assigned_users']);
				$data['assigned_users'] = array_unique($data['assigned_users']);
				$data['assigned_users'] = array_values($data['assigned_users']);
			}
			else
				$data['assigned_users'] = $editer[0]['data']['assigned_users'];

			// ---

			$this->component->load_component('uploader');

			$_com_uploader = new Upload;

			foreach ($data['attachments']['name'] as $key => $value)
			{
				if (!empty($data['attachments']['name'][$key]))
				{
					$ext = explode('.', $data['attachments']['name'][$key]);
					$ext = end($ext);

					if ($ext == 'doc' || $ext == 'docx' || $ext == 'xls' || $ext == 'xlsx')
						$data['attachments']['type'][$key] = 'application/' . $ext;

					$_com_uploader->SetFileName($data['attachments']['name'][$key]);
					$_com_uploader->SetTempName($data['attachments']['tmp_name'][$key]);
					$_com_uploader->SetFileType($data['attachments']['type'][$key]);
					$_com_uploader->SetFileSize($data['attachments']['size'][$key]);
					$_com_uploader->SetUploadDirectory(PATH_UPLOADS);
					$_com_uploader->SetValidExtensions(['jpg','jpeg','png','pdf','doc','docx','xls','xlsx']);
					$_com_uploader->SetMaximumFileSize('unlimited');

					$data['attachments'][$key] = $_com_uploader->UploadFile();
				}
			}

			unset($data['attachments']['name'], $data['attachments']['type'], $data['attachments']['tmp_name'], $data['attachments']['error'], $data['attachments']['size']);

			$data['attachments'] = array_merge($editer[0]['data']['attachments'], $data['attachments']);

			// ---

			$data['changes_history'] = [
				[
					'type' => 'edit',
					'fields' => [

					],
					'user' => Session::get_value('user')['id'],
					'date' => Functions::get_current_date(),
					'hour' => Functions::get_current_hour(),
				]
			];

			if ($editer[0]['type'] != $data['type'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'type',
					'before' => $editer[0]['type'],
					'after' => $data['type']
				]);
			}

			if ($editer[0]['data']['room'] != $data['room'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'room',
					'before' => $editer[0]['data']['room'],
					'after' => $data['room']
				]);
			}

			if ($editer[0]['data']['opportunity_area'] != $data['opportunity_area'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'opportunity_area',
					'before' => $editer[0]['data']['opportunity_area'],
					'after' => $data['opportunity_area']
				]);
			}

			if ($editer[0]['data']['opportunity_type'] != $data['opportunity_type'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'opportunity_type',
					'before' => $editer[0]['data']['opportunity_type'],
					'after' => $data['opportunity_type']
				]);
			}

			if ($editer[0]['data']['location'] != $data['location'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'location',
					'before' => $editer[0]['data']['location'],
					'after' => $data['location']
				]);
			}

			if ($data['type'] == 'incident')
			{
				if ($editer[0]['data']['cost'] != $data['cost'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'cost',
						'before' => $editer[0]['data']['cost'],
						'after' => $data['cost']
					]);
				}
			}

			if ($editer[0]['data']['urgency'] != $data['urgency'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'urgency',
					'before' => $editer[0]['data']['urgency'],
					'after' => $data['urgency']
				]);
			}

			if ($data['type'] == 'incident')
			{
				if ($editer[0]['data']['confidentiality'] != $data['confidentiality'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'confidentiality',
						'before' => $editer[0]['data']['confidentiality'],
						'after' => $data['confidentiality']
					]);
				}
			}

			if ($editer[0]['data']['assigned_users'] != $data['assigned_users'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'assigned_users',
					'before' => $editer[0]['data']['assigned_users'],
					'after' => $data['assigned_users']
				]);
			}

			if ($data['type'] == 'request')
			{
				if ($editer[0]['data']['observations'] != $data['observations'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'observations',
						'before' => $editer[0]['data']['observations'],
						'after' => $data['observations']
					]);
				}
			}

			if ($data['type'] == 'incident')
			{
				if ($editer[0]['data']['subject'] != $data['subject'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'subject',
						'before' => $editer[0]['data']['subject'],
						'after' => $data['subject']
					]);
				}

				if ($editer[0]['data']['description'] != $data['description'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'description',
						'before' => $editer[0]['data']['description'],
						'after' => $data['description']
					]);
				}

				if ($editer[0]['data']['action_taken'] != $data['action_taken'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'action_taken',
						'before' => $editer[0]['data']['action_taken'],
						'after' => $data['action_taken']
					]);
				}
			}

			if ($editer[0]['data']['guest_treatment'] != $data['guest_treatment'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'guest_treatment',
					'before' => $editer[0]['data']['guest_treatment'],
					'after' => $data['guest_treatment']
				]);
			}

			if ($data['type'] == 'incident')
			{
				if ($editer[0]['data']['name'] != $data['name'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'name',
						'before' => $editer[0]['data']['name'],
						'after' => $data['name']
					]);
				}
			}

			if ($editer[0]['data']['lastname'] != $data['lastname'])
			{
				array_push($data['changes_history'][0]['fields'], [
					'field' => 'lastname',
					'before' => $editer[0]['data']['lastname'],
					'after' => $data['lastname']
				]);
			}

			if ($data['type'] == 'incident')
			{
				if ($editer[0]['data']['guest_id'] != $data['guest_id'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'guest_id',
						'before' => $editer[0]['data']['guest_id'],
						'after' => $data['guest_id']
					]);
				}

				if ($editer[0]['data']['guest_type'] != $data['guest_type'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'guest_type',
						'before' => $editer[0]['data']['guest_type'],
						'after' => $data['guest_type']
					]);
				}

				if ($editer[0]['data']['reservation_number'] != $data['reservation_number'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'reservation_number',
						'before' => $editer[0]['data']['reservation_number'],
						'after' => $data['reservation_number']
					]);
				}

				if ($editer[0]['data']['reservation_status'] != $data['reservation_status'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'reservation_status',
						'before' => $editer[0]['data']['reservation_status'],
						'after' => $data['reservation_status']
					]);
				}

				if ($editer[0]['data']['check_in'] != $data['check_in'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'check_in',
						'before' => $editer[0]['data']['check_in'],
						'after' => $data['check_in']
					]);
				}

				if ($editer[0]['data']['check_out'] != $data['check_out'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'check_out',
						'before' => $editer[0]['data']['check_out'],
						'after' => $data['check_out']
					]);
				}

				if ($editer[0]['data']['attachments'] != $data['attachments'])
				{
					array_push($data['changes_history'][0]['fields'], [
						'field' => 'attachments',
						'before' => $editer[0]['data']['attachments'],
						'after' => $data['attachments']
					]);
				}
			}

			if (!empty($data['changes_history'][0]['fields']))
				$data['changes_history'] = array_merge($editer[0]['data']['changes_history'], $data['changes_history']);
			else
				$data['changes_history'] = $editer[0]['data']['changes_history'];

			// ---

			$query = $this->database->update('voxes', [
				'type' => $data['type'],
				'data' => Functions::get_openssl('encrypt', json_encode([
					'token' => $editer[0]['data']['token'],
					'room' => $data['room'] ?  : null,
					'opportunity_area' => $data['opportunity_area'],
					'opportunity_type' => $data['opportunity_type'],
					'started_date' => Functions::get_formatted_date($editer[0]['data']['started_date']),
					'started_hour' => Functions::get_formatted_hour($editer[0]['data']['started_hour']),
					'location' => $data['location'],
					'cost' => ($data['type'] == 'incident') ? $data['cost'] : null,
					'urgency' => $data['urgency'],
					'confidentiality' => ($data['type'] == 'incident') ? $data['confidentiality'] : null,
					'assigned_users' => $data['assigned_users'],
					'observations' => ($data['type'] == 'request') ? $data['observations'] : null,
					'subject' => ($data['type'] == 'incident') ? $data['subject'] : null,
					'description' => ($data['type'] == 'incident') ? $data['description'] : null,
					'action_taken' => ($data['type'] == 'incident') ? $data['action_taken'] : null,
					'guest_treatment' => $data['guest_treatment'],
					'name' => ($data['type'] == 'incident') ? $data['name'] : null,
					'lastname' => $data['lastname'],
					'guest_id' => ($data['type'] == 'incident') ? $data['guest_id'] : null,
					'guest_type' => ($data['type'] == 'incident') ? $data['guest_type'] : null,
					'reservation_number' => ($data['type'] == 'incident') ? $data['reservation_number'] : null,
					'reservation_status' => ($data['type'] == 'incident') ? $data['reservation_status'] : null,
					'check_in' => ($data['type'] == 'incident') ? $data['check_in'] : null,
					'check_out' => ($data['type'] == 'incident') ? $data['check_out'] : null,
					'attachments' => $data['attachments'],
					'viewed_by' => $editer[0]['data']['viewed_by'],
					'comments' => $editer[0]['data']['comments'],
					'changes_history' => $data['changes_history'],
					'created_user' => $editer[0]['data']['created_user'],
					'edited_user' => Session::get_value('user')['id'],
					'completed_user' => $editer[0]['data']['completed_user'],
					'reopened_user' => $editer[0]['data']['reopened_user'],
					'created_date' => Functions::get_formatted_date($editer[0]['data']['created_date']),
					'created_hour' => Functions::get_formatted_hour($editer[0]['data']['created_hour']),
					'edited_date' => Functions::get_current_date(),
					'edited_hour' => Functions::get_current_hour(),
					'completed_date' =>  Functions::get_formatted_date($editer[0]['data']['completed_date']),
					'completed_hour' => Functions::get_formatted_hour($editer[0]['data']['completed_hour']),
					'reopened_date' =>  Functions::get_formatted_date($editer[0]['data']['reopened_date']),
					'reopened_hour' => Functions::get_formatted_hour($editer[0]['data']['reopened_hour']),
					'readed' => $editer[0]['data']['readed'],
					'status' => $editer[0]['data']['status'],
					'origin' => $editer[0]['data']['origin'],
				])),
			], [
				'id' => $data['id']
			]);
		}

		return $query;
	}

	public function new_comment_vox($id, $data)
	{
		$query = null;

		$editer = $this->database->select('voxes', [
			'data'
		], [
			'id' => $id
		]);

		if (!empty($editer))
		{
			$editer[0]['data'] = json_decode(Functions::get_openssl('decrypt', $editer[0]['data']), true);

			$this->component->load_component('uploader');

			$_com_uploader = new Upload;

			foreach ($data['attachments']['name'] as $key => $value)
			{
				if (!empty($data['attachments']['name'][$key]))
				{
					$ext = explode('.', $data['attachments']['name'][$key]);
					$ext = end($ext);

					if ($ext == 'doc' || $ext == 'docx' || $ext == 'xls' || $ext == 'xlsx')
						$data['attachments']['type'][$key] = 'application/' . $ext;

					$_com_uploader->SetFileName($data['attachments']['name'][$key]);
					$_com_uploader->SetTempName($data['attachments']['tmp_name'][$key]);
					$_com_uploader->SetFileType($data['attachments']['type'][$key]);
					$_com_uploader->SetFileSize($data['attachments']['size'][$key]);
					$_com_uploader->SetUploadDirectory(PATH_UPLOADS);
					$_com_uploader->SetValidExtensions(['jpg','jpeg','png','pdf','doc','docx','xls','xlsx']);
					$_com_uploader->SetMaximumFileSize('unlimited');

					$data['attachments'][$key] = $_com_uploader->UploadFile();
				}
			}

			unset($data['attachments']['name'], $data['attachments']['type'], $data['attachments']['tmp_name'], $data['attachments']['error'], $data['attachments']['size']);

			array_push($editer[0]['data']['comments'], [
				'user' => Session::get_value('user')['id'],
				'date' => Functions::get_current_date(),
				'hour' => Functions::get_current_hour(),
				'message' => $data['response_to'] . ' ' . $data['message'],
				'attachments' => $data['attachments'],
			]);

			array_push($editer[0]['data']['changes_history'], [
				'type' => 'new_comment',
				'user' => Session::get_value('user')['id'],
				'date' => Functions::get_current_date(),
				'hour' => Functions::get_current_hour(),
			]);

			$query = $this->database->update('voxes', [
				'data' => Functions::get_openssl('encrypt', json_encode($editer[0]['data']))
			], [
				'id' => $id
			]);
		}

		return $query;
	}

	public function complete_vox($id)
	{
		$query = null;

		$editer = $this->database->select('voxes', [
			'data'
		], [
			'id' => $id
		]);

		if (!empty($editer))
		{
			$editer[0]['data'] = json_decode(Functions::get_openssl('decrypt', $editer[0]['data']), true);

			$editer[0]['data']['completed_user'] = Session::get_value('user')['id'];
			$editer[0]['data']['completed_date'] = Functions::get_current_date();
			$editer[0]['data']['completed_hour'] = Functions::get_current_hour();
			$editer[0]['data']['status'] = 'close';

			array_push($editer[0]['data']['changes_history'], [
				'type' => 'complete',
				'user' => Session::get_value('user')['id'],
				'date' => Functions::get_current_date(),
				'hour' => Functions::get_current_hour(),
			]);

			$query = $this->database->update('voxes', [
				'data' => Functions::get_openssl('encrypt', json_encode($editer[0]['data']))
			], [
				'id' => $id
			]);
		}

		return $query;
	}

	public function reopen_vox($id)
	{
		$query = null;

		$editer = $this->database->select('voxes', [
			'data'
		], [
			'id' => $id
		]);

		if (!empty($editer))
		{
			$editer[0]['data'] = json_decode(Functions::get_openssl('decrypt', $editer[0]['data']), true);

			$editer[0]['data']['reopened_user'] = Session::get_value('user')['id'];
			$editer[0]['data']['reopened_date'] = Functions::get_current_date();
			$editer[0]['data']['reopened_hour'] = Functions::get_current_hour();
			$editer[0]['data']['status'] = 'open';

			array_push($editer[0]['data']['changes_history'], [
				'type' => 'reopen',
				'user' => Session::get_value('user')['id'],
				'date' => Functions::get_current_date(),
				'hour' => Functions::get_current_hour(),
			]);

			$query = $this->database->update('voxes', [
				'data' => Functions::get_openssl('encrypt', json_encode($editer[0]['data']))
			], [
				'id' => $id
			]);
		}

		return $query;
	}

	// ---

	public function get_sms()
	{
		$query = $this->database->select('settings', [
			'sms'
		], [
			'account' => Session::get_value('account')['id']
		]);

		return !empty($query) ? $query[0]['sms'] : 0;
	}

	public function edit_sms($sms)
	{
		$query = $this->database->update('settings', [
			'sms' => $sms
		], [
			'account' => Session::get_value('account')['id']
		]);

		return $query;
	}

	// ---

	public function get_rooms()
	{
		$query = $this->database->select('rooms', [
			'id',
			'name'
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
			'id',
			'account',
			'name'
		], [
			'OR' => [
				'id' => $id,
				'code' => $id,
			]
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_opportunity_areas($option, $public = false, $account = null)
	{
		if ($public == true)
		{
			$and = [
				'account' => $account,
				$option => true,
				'public' => true,
			];
		}
		else
		{
			$and = [
				'account' => Session::get_value('account')['id'],
				$option => true,
			];
		}

		$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
			'id',
			'name'
		], [
			'AND' => $and,
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		return $query;
	}

	public function get_opportunity_area($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
			'id',
			'name'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_opportunity_types($opportunity_area, $option, $public = false)
	{
		if ($public == true)
		{
			$and = [
				'opportunity_area' => $opportunity_area,
				$option => true,
				'public' => true,
			];
		}
		else
		{
			$and = [
				'opportunity_area' => $opportunity_area,
				$option => true,
			];
		}

		$query = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
			'id',
			'name'
		], [
			'AND' => $and,
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		return $query;
	}

	public function get_opportunity_type($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
			'id',
			'name'
		], [
			'id' => $id,
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_locations($option, $public = false, $account = null)
	{
		if ($public == true)
		{
			$and = [
				'account' => $account,
				$option => true,
				'public' => true,
			];
		}
		else
		{
			$and = [
				'account' => Session::get_value('account')['id'],
				$option => true,
			];
		}

		$query = Functions::get_json_decoded_query($this->database->select('locations', [
			'id',
			'name'
		], [
			'AND' => $and,
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		return $query;
	}

	public function get_location($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('locations', [
			'id',
			'name'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_guest_treatments($public = false, $account = null)
	{
		if ($public == false)
			$account = Session::get_value('account')['id'];

		$query = $this->database->select('guest_treatments', [
			'id',
			'name'
		], [
			'account' => $account,
			'ORDER' => [
				'name' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_guest_treatment($id)
	{
		$query = $this->database->select('guest_treatments', [
			'id',
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_guest_types()
	{
		$query = $this->database->select('guest_types', [
			'id',
			'name'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'name' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_guest_type($id)
	{
		$query = $this->database->select('guest_types', [
			'id',
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_reservation_statuss()
	{
		$query = $this->database->select('reservation_status', [
			'id',
			'name'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'name' => 'ASC'
			]
		]);

		return $query;
	}

	public function get_reservation_status($id)
	{
		$query = $this->database->select('reservation_status', [
			'id',
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_users($option = null, $params = null, $public = false, $account = null)
	{
		$query = null;

		if ($public == false)
			$account = Session::get_value('account')['id'];

		if ($option == 'ids')
		{
			$query = $this->database->select('users', [
				'name',
				'lastname',
				'email',
				'cellphone',
			], [
				'id' => $params
			]);
		}
		else if ($option == 'opportunity_area')
		{
			$query = Functions::get_json_decoded_query($this->database->select('users', [
				'name',
				'lastname',
				'email',
				'cellphone',
				'opportunity_areas',
			], [
				'account' => $account
			]));

			foreach ($query as $key => $value)
			{
				if (!in_array($params, $value['opportunity_areas']))
					unset($query[$key]);
			}
		}
		else
		{
			$query = $this->database->select('users', [
				'id',
				'username',
			], [
				'account' => $account,
				'ORDER' => [
					'username' => 'ASC'
				]
			]);
		}

		return $query;
	}

	public function get_user($id)
	{
		$query = $this->database->select('users', [
			'id',
			'name',
			'lastname',
			'username',
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_account($id)
	{
		$query = $this->database->select('accounts', [
			'id',
			'name',
		], [
			'id' => $id
		]);

		if (!empty($query))
		{
			$query[0]['settings'] = $this->database->select('settings', [
				'language'
			], [
				'account' => $id
			])[0];

			return $query[0];
		}
		else
			return null;
	}

	// public function getSslPage($url)
	// {
	//     $ch = curl_init();
	//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	//     curl_setopt($ch, CURLOPT_HEADER, false);
	//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	//     curl_setopt($ch, CURLOPT_URL, $url);
	//     curl_setopt($ch, CURLOPT_REFERER, $url);
	//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//     $result = curl_exec($ch);
	//     curl_close($ch);
	//     return $result;
	// }
}
