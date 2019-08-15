<?php

defined('_EXEC') or die;

class Settings_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_opportunity_area')
			{
				$query = $this->model->get_opportunity_area($_POST['id']);

				Functions::environment([
					'status' => (!empty($query)) ? 'success' : 'error',
					'data' => (!empty($query)) ? $query : null,
					'message' => (!empty($query)) ? null : '{$lang.error_operation_database}',
				]);
			}

			if ($_POST['action'] == 'new_opportunity_area' OR $_POST['action'] == 'edit_opportunity_area')
			{
				$labels = [];

				if (!isset($_POST['name_es']) OR empty($_POST['name_es']))
					array_push($labels, ['name_es', '']);

				if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
					array_push($labels, ['name_en', '']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_opportunity_area')
						$query = $this->model->new_opportunity_area($_POST);
					else if ($_POST['action'] == 'edit_opportunity_area')
						$query = $this->model->edit_opportunity_area($_POST);

					if (!empty($query))
					{
						$data = '';

						foreach ($this->model->get_opportunity_areas(true) as $value)
						{
							$data .=
							'<tr>
								<td align="left">' . $value['name'][Session::get_value('settings')['language']] . '</td>
								<td align="left" class="icon big">' . (($value['request'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
								<td align="left" class="icon big">' . (($value['incident'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
								<td align="left" class="icon big">' . (($value['public'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
								' . ((Functions::check_access(['{opportunityareas_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_opportunity_area" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
								' . ((Functions::check_access(['{opportunityareas_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_opportunity_area" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
							</tr>';
						}

						Functions::environment([
							'status' => 'success',
							'data' => $data,
							'message' => '{$lang.success_operation_database}',
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.error_operation_database}',
						]);
					}
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'labels' => $labels
					]);
				}
			}

			if ($_POST['action'] == 'delete_opportunity_area')
			{
				$query = $this->model->delete_opportunity_area($_POST['id']);

				if (!empty($query))
				{
					$data = '';

					foreach ($this->model->get_opportunity_areas() as $value)
					{
						$data .=
						'<tr>
							<td align="left">' . $value['name'][Session::get_value('settings')['language']] . '</td>
							<td align="left" class="icon big">' . (($value['request'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
							<td align="left" class="icon big">' . (($value['incident'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
							<td align="left" class="icon big">' . (($value['public'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
							' . ((Functions::check_access(['{opportunityareas_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_opportunity_area" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
							' . ((Functions::check_access(['{opportunityareas_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_opportunity_area" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
						</tr>';
					}

					Functions::environment([
						'status' => 'success',
						'data' => $data,
						'message' => '{$lang.success_operation_database}',
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.error_operation_database}',
					]);
				}
			}

			// ---

			if ($_POST['action'] == 'get_opportunity_type')
			{
				$query = $this->model->get_opportunity_type($_POST['id']);

				Functions::environment([
					'status' => (!empty($query)) ? 'success' : 'error',
					'data' => (!empty($query)) ? $query : null,
					'message' => (!empty($query)) ? null : '{$lang.error_operation_database}',
				]);
			}

			if ($_POST['action'] == 'new_opportunity_type' OR $_POST['action'] == 'edit_opportunity_type')
			{
				$labels = [];

				if (!isset($_POST['opportunity_area']) OR empty($_POST['opportunity_area']))
					array_push($labels, ['opportunity_area', '']);

				if (!isset($_POST['name_es']) OR empty($_POST['name_es']))
					array_push($labels, ['name_es', '']);

				if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
					array_push($labels, ['name_en', '']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_opportunity_type')
						$query = $this->model->new_opportunity_type($_POST);
					else if ($_POST['action'] == 'edit_opportunity_type')
						$query = $this->model->edit_opportunity_type($_POST);

					if (!empty($query))
					{
						$data = '';

						foreach ($this->model->get_opportunity_types() as $value)
						{
							$data .=
							'<tr>
								<td align="left">' . $value['opportunity_area'][Session::get_value('settings')['language']] . '</td>
								<td align="left">' . $value['name'][Session::get_value('settings')['language']] . '</td>
								<td align="left" class="icon big">' . (($value['request'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
								<td align="left" class="icon big">' . (($value['incident'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
								<td align="left" class="icon big">' . (($value['public'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
								' . ((Functions::check_access(['{opportunitytypes_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_opportunity_type" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
								' . ((Functions::check_access(['{opportunitytypes_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_opportunity_type" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
							</tr>';
						}

						Functions::environment([
							'status' => 'success',
							'data' => $data,
							'message' => '{$lang.success_operation_database}',
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.error_operation_database}',
						]);
					}

				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'labels' => $labels
					]);
				}
			}

			if ($_POST['action'] == 'delete_opportunity_type')
			{
				$query = $this->model->delete_opportunity_type($_POST['id']);

				if (!empty($query))
				{
					$data = '';

					foreach ($this->model->get_opportunity_types() as $value)
					{
						$data .=
						'<tr>
							<td align="left">' . $value['opportunity_area'][Session::get_value('settings')['language']] . '</td>
							<td align="left">' . $value['name'][Session::get_value('settings')['language']] . '</td>
							<td align="left" class="icon big">' . (($value['request'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
							<td align="left" class="icon big">' . (($value['incident'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
							<td align="left" class="icon big">' . (($value['public'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
							' . ((Functions::check_access(['{opportunitytypes_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_opportunity_type" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
							' . ((Functions::check_access(['{opportunitytypes_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_opportunity_type" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
						</tr>';
					}

					Functions::environment([
						'status' => 'success',
						'data' => $data,
						'message' => '{$lang.success_operation_database}',
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.error_operation_database}',
					]);
				}
			}

			// ---

			if ($_POST['action'] == 'get_location')
			{
				$query = $this->model->get_location($_POST['id']);

				Functions::environment([
					'status' => (!empty($query)) ? 'success' : 'error',
					'data' => (!empty($query)) ? $query : null,
					'message' => (!empty($query)) ? null : '{$lang.error_operation_database}',
				]);
			}

			if ($_POST['action'] == 'new_location' OR $_POST['action'] == 'edit_location')
			{
				$labels = [];

				if (!isset($_POST['name_es']) OR empty($_POST['name_es']))
					array_push($labels, ['name_es', '']);

				if (!isset($_POST['name_en']) OR empty($_POST['name_en']))
					array_push($labels, ['name_en', '']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_location')
						$query = $this->model->new_location($_POST);
					else if ($_POST['action'] == 'edit_location')
						$query = $this->model->edit_location($_POST);

					if (!empty($query))
					{
						$data = '';

						foreach ($this->model->get_locations() as $value)
						{
							$data .=
							'<tr>
								<td align="left">' . $value['name'][Session::get_value('settings')['language']] . '</td>
								<td align="left" class="icon big">' . (($value['request'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
								<td align="left" class="icon big">' . (($value['incident'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
								<td align="left" class="icon big">' . (($value['public'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
								' . ((Functions::check_access(['{locations_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_location" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
								' . ((Functions::check_access(['{locations_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_location" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
							</tr>';
						}

						Functions::environment([
							'status' => 'success',
							'data' => $data,
							'message' => '{$lang.success_operation_database}',
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.error_operation_database}',
						]);
					}

				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'labels' => $labels
					]);
				}
			}

			if ($_POST['action'] == 'delete_location')
			{
				$query = $this->model->delete_location($_POST['id']);

				if (!empty($query))
				{
					$data = '';

					foreach ($this->model->get_locations() as $value)
					{
						$data .=
						'<tr>
							<td align="left">' . $value['name'][Session::get_value('settings')['language']] . '</td>
							<td align="left" class="icon big">' . (($value['request'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
							<td align="left" class="icon big">' . (($value['incident'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
							<td align="left" class="icon big">' . (($value['public'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
							' . ((Functions::check_access(['{locations_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_location" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
							' . ((Functions::check_access(['{locations_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_location" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
						</tr>';
					}

					Functions::environment([
						'status' => 'success',
						'data' => $data,
						'message' => '{$lang.success_operation_database}',
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.error_operation_database}',
					]);
				}
			}

			// ---

			if ($_POST['action'] == 'get_room')
			{
				$query = $this->model->get_room($_POST['id']);

				Functions::environment([
					'status' => (!empty($query)) ? 'success' : 'error',
					'data' => (!empty($query)) ? $query : null,
					'message' => (!empty($query)) ? null : '{$lang.error_operation_database}',
				]);
			}

			if ($_POST['action'] == 'new_room')
			{
				$labels = [];

				if (!isset($_POST['type']) OR empty($_POST['type']))
					array_push($labels, ['type', '']);

				if ($_POST['type'] == 'many')
				{
					if (!isset($_POST['since']) OR empty($_POST['since']))
						array_push($labels, ['since', '']);
				}
				else if ($_POST['type'] == 'one')
				{
					if (!isset($_POST['name']) OR empty($_POST['name']))
						array_push($labels, ['name', '']);
				}

				if (empty($labels))
				{
					$query = $this->model->new_room($_POST);

					if (!empty($query))
					{
						$data = '';
						foreach ($this->model->get_rooms() as $value)
						{
							$data .=
							'<tr>
								<td align="left">' . $value['name'] . '</td>
								<td align="left">' . $value['qr']['code'] . '</td>
								<td align="right" class="icon"><a href="{$path.uploads}' . $value['qr']['name'] . '" download="qr_' . $value['qr']['code'] . '_' . $value['name'] . '.png"><i class="fas fa-qrcode"></i></a></td>
								' . ((Functions::check_access(['{rooms_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_room" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
								' . ((Functions::check_access(['{rooms_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_room" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
							</tr>';
						}

						Functions::environment([
							'status' => 'success',
							'data' => $data,
							'message' => '{$lang.success_operation_database}',
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.error_operation_database}',
						]);
					}

				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'labels' => $labels
					]);
				}
			}

			if ($_POST['action'] == 'edit_room')
			{
				$labels = [];

				if (!isset($_POST['name']) OR empty($_POST['name']))
					array_push($labels, ['name', '']);

				if (empty($labels))
				{
					$query = $this->model->edit_room($_POST);

					if (!empty($query))
					{
						$data = '';

						foreach ($this->model->get_rooms() as $value)
						{
							$data .=
							'<tr>
								<td align="left">' . $value['name'] . '</td>
								<td align="left">' . $value['qr']['code'] . '</td>
								<td align="right" class="icon"><a href="{$path.uploads}' . $value['qr']['name'] . '" download="qr_' . $value['qr']['code'] . '_' . $value['name'] . '.png"><i class="fas fa-qrcode"></i></a></td>
								' . ((Functions::check_access(['{rooms_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_room" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
								' . ((Functions::check_access(['{rooms_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_room" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
							</tr>';
						}

						Functions::environment([
							'status' => 'success',
							'data' => $data,
							'message' => '{$lang.success_operation_database}',
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.error_operation_database}',
						]);
					}
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'labels' => $labels
					]);
				}
			}

			if ($_POST['action'] == 'delete_room')
			{
				$query = $this->model->delete_room($_POST['id']);

				if (!empty($query))
				{
					$data = '';

					foreach ($this->model->get_rooms() as $value)
					{
						$data .=
						'<tr>
							<td align="left">' . $value['name'] . '</td>
							<td align="left">' . $value['qr']['code'] . '</td>
							<td align="right" class="icon"><a href="{$path.uploads}' . $value['qr']['name'] . '" download="qr_' . $value['qr']['code'] . '_' . $value['name'] . '.png"><i class="fas fa-qrcode"></i></a></td>
							' . ((Functions::check_access(['{rooms_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_room" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
							' . ((Functions::check_access(['{rooms_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_room" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
						</tr>';
					}

					Functions::environment([
						'status' => 'success',
						'data' => $data,
						'message' => '{$lang.success_operation_database}',
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.error_operation_database}',
					]);
				}
			}

			// ---

			if ($_POST['action'] == 'get_guest_treatment')
			{
				$query = $this->model->get_guest_treatment($_POST['id']);

				Functions::environment([
					'status' => (!empty($query)) ? 'success' : 'error',
					'data' => (!empty($query)) ? $query : null,
					'message' => (!empty($query)) ? null : '{$lang.error_operation_database}',
				]);
			}

			if ($_POST['action'] == 'new_guest_treatment' OR $_POST['action'] == 'edit_guest_treatment')
			{
				$labels = [];

				if (!isset($_POST['name']) OR empty($_POST['name']))
					array_push($labels, ['name', '']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_guest_treatment')
						$query = $this->model->new_guest_treatment($_POST);
					else if ($_POST['action'] == 'edit_guest_treatment')
						$query = $this->model->edit_guest_treatment($_POST);

					if (!empty($query))
					{
						$data = '';

						foreach ($this->model->get_guest_treatments() as $value)
						{
							$data .=
							'<tr>
								<td align="left">' . $value['name'] . '</td>
								' . ((Functions::check_access(['{guesttreatments_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_guest_treatment" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
								' . ((Functions::check_access(['{guesttreatments_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_guest_treatment" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
							</tr>';
						}

						Functions::environment([
							'status' => 'success',
							'data' => $data,
							'message' => '{$lang.success_operation_database}',
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.error_operation_database}',
						]);
					}

				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'labels' => $labels
					]);
				}
			}

			if ($_POST['action'] == 'delete_guest_treatment')
			{
				$query = $this->model->delete_guest_treatment($_POST['id']);

				if (!empty($query))
				{
					$data = '';

					foreach ($this->model->get_guest_treatments() as $value)
					{
						$data .=
						'<tr>
							<td align="left">' . $value['name'] . '</td>
							' . ((Functions::check_access(['{guesttreatments_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_guest_treatment" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
							' . ((Functions::check_access(['{guesttreatments_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_guest_treatment" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
						</tr>';
					}

					Functions::environment([
						'status' => 'success',
						'data' => $data,
						'message' => '{$lang.success_operation_database}',
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.error_operation_database}',
					]);
				}
			}

			// ---

			if ($_POST['action'] == 'get_guest_type')
			{
				$query = $this->model->get_guest_type($_POST['id']);

				Functions::environment([
					'status' => (!empty($query)) ? 'success' : 'error',
					'data' => (!empty($query)) ? $query : null,
					'message' => (!empty($query)) ? null : '{$lang.error_operation_database}',
				]);
			}

			if ($_POST['action'] == 'new_guest_type' OR $_POST['action'] == 'edit_guest_type')
			{
				$labels = [];

				if (!isset($_POST['name']) OR empty($_POST['name']))
					array_push($labels, ['name', '']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_guest_type')
						$query = $this->model->new_guest_type($_POST);
					else if ($_POST['action'] == 'edit_guest_type')
						$query = $this->model->edit_guest_type($_POST);

					if (!empty($query))
					{
						$data = '';

						foreach ($this->model->get_guest_types() as $value)
						{
							$data .=
							'<tr>
								<td align="left">' . $value['name'] . '</td>
								' . ((Functions::check_access(['{guesttypes_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_guest_type" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
								' . ((Functions::check_access(['{guesttypes_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_guest_type" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
							</tr>';
						}

						Functions::environment([
							'status' => 'success',
							'data' => $data,
							'message' => '{$lang.success_operation_database}',
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.error_operation_database}',
						]);
					}

				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'labels' => $labels
					]);
				}
			}

			if ($_POST['action'] == 'delete_guest_type')
			{
				$query = $this->model->delete_guest_type($_POST['id']);

				if (!empty($query))
				{
					$data = '';

					foreach ($this->model->get_guest_types() as $value)
					{
						$data .=
						'<tr>
							<td align="left">' . $value['name'] . '</td>
							' . ((Functions::check_access(['{guesttypes_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_guest_type" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
							' . ((Functions::check_access(['{guesttypes_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_guest_type" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
						</tr>';
					}

					Functions::environment([
						'status' => 'success',
						'data' => $data,
						'message' => '{$lang.success_operation_database}',
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.error_operation_database}',
					]);
				}
			}

			// ---

			if ($_POST['action'] == 'get_reservation_status')
			{
				$query = $this->model->get_reservation_status($_POST['id']);

				Functions::environment([
					'status' => (!empty($query)) ? 'success' : 'error',
					'data' => (!empty($query)) ? $query : null,
					'message' => (!empty($query)) ? null : '{$lang.error_operation_database}',
				]);
			}

			if ($_POST['action'] == 'new_reservation_status' OR $_POST['action'] == 'edit_reservation_status')
			{
				$labels = [];

				if (!isset($_POST['name']) OR empty($_POST['name']))
					array_push($labels, ['name', '']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_reservation_status')
						$query = $this->model->new_reservation_status($_POST);
					else if ($_POST['action'] == 'edit_reservation_status')
						$query = $this->model->edit_reservation_status($_POST);

					if (!empty($query))
					{
						$data = '';

						foreach ($this->model->get_reservation_statuss() as $value)
						{
							$data .=
							'<tr>
								<td align="left">' . $value['name'] . '</td>
								' . ((Functions::check_access(['{reservationstatus_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_reservation_status" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
								' . ((Functions::check_access(['{reservationstatus_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_reservation_status" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
							</tr>';
						}

						Functions::environment([
							'status' => 'success',
							'data' => $data,
							'message' => '{$lang.success_operation_database}',
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.error_operation_database}',
						]);
					}

				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'labels' => $labels
					]);
				}
			}

			if ($_POST['action'] == 'delete_reservation_status')
			{
				$query = $this->model->delete_reservation_status($_POST['id']);

				if (!empty($query))
				{
					$data = '';

					foreach ($this->model->get_reservation_statuss() as $value)
					{
						$data .=
						'<tr>
							<td align="left">' . $value['name'] . '</td>
							' . ((Functions::check_access(['{reservationstatus_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_reservation_status" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
							' . ((Functions::check_access(['{reservationstatus_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_reservation_status" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
						</tr>';
					}

					Functions::environment([
						'status' => 'success',
						'data' => $data,
						'message' => '{$lang.success_operation_database}',
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.error_operation_database}',
					]);
				}
			}
		}
		else
		{
			define('_title', 'GuestVox | {$lang.settings}');

			$template = $this->view->render($this, 'index');

			$tbl_opportunity_areas = '';

			foreach ($this->model->get_opportunity_areas() as $value)
			{
				$tbl_opportunity_areas .=
				'<tr>
					<td align="left">' . $value['name'][Session::get_value('settings')['language']] . '</td>
					<td align="left" class="icon big">' . (($value['request'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
					<td align="left" class="icon big">' . (($value['incident'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
					<td align="left" class="icon big">' . (($value['public'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
					' . ((Functions::check_access(['{opportunityareas_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_opportunity_area" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
					' . ((Functions::check_access(['{opportunityareas_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_opportunity_area" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
				</tr>';
			}

			$tbl_opportunity_types = '';

			foreach ($this->model->get_opportunity_types() as $value)
			{
				$tbl_opportunity_types .=
				'<tr>
					<td align="left">' . $value['opportunity_area'][Session::get_value('settings')['language']] . '</td>
					<td align="left">' . $value['name'][Session::get_value('settings')['language']] . '</td>
					<td align="left" class="icon big">' . (($value['request'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
					<td align="left" class="icon big">' . (($value['incident'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
					<td align="left" class="icon big">' . (($value['public'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
					' . ((Functions::check_access(['{opportunitytypes_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_opportunity_type" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
					' . ((Functions::check_access(['{opportunitytypes_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_opportunity_type" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
				</tr>';
			}

			$opt_opportunity_areas = '';

			foreach ($this->model->get_opportunity_areas(false) as $value)
				$opt_opportunity_areas .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('settings')['language']] . '</option>';

			$tbl_locations = '';

			foreach ($this->model->get_locations() as $value)
			{
				$tbl_locations .=
				'<tr>
					<td align="left">' . $value['name'][Session::get_value('settings')['language']] . '</td>
					<td align="left" class="icon big">' . (($value['request'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
					<td align="left" class="icon big">' . (($value['incident'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
					<td align="left" class="icon big">' . (($value['public'] == true) ? '<span style="background-color:#00a5ab;color:#fff;"><i class="fas fa-check"></i></span>' : '<span style="background-color:#3f51b5;color:#fff;"><i class="fas fa-times"></i></span>') . '</td>
					' . ((Functions::check_access(['{locations_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_location" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
					' . ((Functions::check_access(['{locations_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_location" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
				</tr>';
			}

			$tbl_rooms = '';

			foreach ($this->model->get_rooms() as $value)
			{
				$tbl_rooms .=
				'<tr>
					<td align="left">' . $value['name'] . '</td>
					<td align="left">' . $value['qr']['code'] . '</td>
					<td align="right" class="icon"><a href="{$path.uploads}' . $value['qr']['name'] . '" download="qr_' . $value['qr']['code'] . '_' . $value['name'] . '.png"><i class="fas fa-qrcode"></i></a></td>
					' . ((Functions::check_access(['{rooms_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_room" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
					' . ((Functions::check_access(['{rooms_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_room" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
				</tr>';
			}

			$tbl_guest_treatments = '';

			foreach ($this->model->get_guest_treatments() as $value)
			{
				$tbl_guest_treatments .=
				'<tr>
					<td align="left">' . $value['name'] . '</td>
					' . ((Functions::check_access(['{guesttreatments_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_guest_treatment" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
					' . ((Functions::check_access(['{guesttreatments_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_guest_treatment" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
				</tr>';
			}

			$tbl_guest_types = '';

			foreach ($this->model->get_guest_types() as $value)
			{
				$tbl_guest_types .=
				'<tr>
					<td align="left">' . $value['name'] . '</td>
					' . ((Functions::check_access(['{guesttypes_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_guest_type" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
					' . ((Functions::check_access(['{guesttypes_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_guest_type" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
				</tr>';
			}

			$tbl_reservation_status = '';

			foreach ($this->model->get_reservation_statuss() as $value)
			{
				$tbl_reservation_status .=
				'<tr>
					<td align="left">' . $value['name'] . '</td>
					' . ((Functions::check_access(['{reservationstatus_delete}']) == true) ? '<td align="right" class="icon">' . (($value['relation'] == false) ? '<a data-action="delete_reservation_status" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
					' . ((Functions::check_access(['{reservationstatus_update}']) == true) ? '<td align="right" class="icon"><a data-action="edit_reservation_status" data-id="' . $value['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>' : '') . '
				</tr>';
			}

			$replace = [
				'{$tbl_opportunity_areas}' => $tbl_opportunity_areas,
				'{$tbl_opportunity_types}' => $tbl_opportunity_types,
				'{$opt_opportunity_areas}' => $opt_opportunity_areas,
				'{$tbl_locations}' => $tbl_locations,
				'{$tbl_rooms}' => $tbl_rooms,
				'{$tbl_guest_treatments}' => $tbl_guest_treatments,
				'{$tbl_guest_types}' => $tbl_guest_types,
				'{$tbl_reservation_status}' => $tbl_reservation_status,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
