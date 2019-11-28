<?php

defined('_EXEC') or die;

class Dashboard_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_voxes_unresolve($option = null)
	{
		$voxes = [];

		$query = $this->database->select('voxes', [
			'id',
			'data',
		], [
			'account' => Session::get_value('account')['id'],
		]);

		foreach ($query as $key => $value)
		{
			$value['data'] = json_decode(Functions::get_openssl('decrypt', $value['data']), true);

			$break = false;

			if (Functions::check_user_access(['{view_opportunity_areas}']) == true AND !in_array($value['data']['opportunity_area'], Session::get_value('user')['opportunity_areas']))
				$break = true;

			if (Functions::check_user_access(['{view_own}']) == true AND $value['data']['created_user'] != Session::get_value('user')['id'] AND !in_array(Session::get_value('user')['id'], $value['data']['assigned_users']))
				$break = true;

			if (Functions::check_user_access(['{view_confidentiality}']) == false && $value['data']['confidentiality'] == true)
				$break = true;

			if ($option == 'noreaded' AND $value['data']['readed'] == true)
				$break = true;

			if ($option == 'readed' AND $value['data']['readed'] == false)
				$break = true;

			if ($option == 'today' AND Functions::get_formatted_date($value['data']['started_date']) != Functions::get_current_date())
				$break = true;

			if ($option == 'week' AND Functions::get_formatted_date($value['data']['started_date']) < Functions::get_current_week()[0] OR Functions::get_formatted_date($value['data']['started_date']) > Functions::get_current_week()[1])
				$break = true;

			if ($option == 'month' AND Functions::get_formatted_date($value['data']['started_date']) < Functions::get_current_month()[0] OR Functions::get_formatted_date($value['data']['started_date']) > Functions::get_current_month()[1])
				$break = true;

			if ($value['data']['status'] == 'close')
				$break = true;

			if ($break == false)
			{
				if (!isset($option) OR !empty($option))
				{
					$value['data']['room'] = $this->get_room($value['data']['room'])['name'];
					$value['data']['opportunity_area'] = $this->get_opportunity_area($value['data']['opportunity_area'])['name'][Session::get_value('account')['language']];
					$value['data']['opportunity_type'] = $this->get_opportunity_type($value['data']['opportunity_type'])['name'][Session::get_value('account')['language']];
					$value['data']['location'] = $this->get_location($value['data']['location'])['name'][Session::get_value('account')['language']];
					$value['data']['guest_treatment'] = $this->get_guest_treatment($value['data']['guest_treatment'])['name'];

					if (!empty($value['data']['comments']))
					{
						foreach ($value['data']['comments'] as $subvalue)
							$value['data']['attachments'] = array_merge($value['data']['attachments'], $subvalue['attachments']);
					}
				}

				$aux[$key] = Functions::get_formatted_date_hour($value['data']['started_date'], $value['data']['started_hour']);

				array_push($voxes, $value);
			}
		}

		if (!empty($voxes))
			array_multisort($aux, SORT_DESC, $voxes);

		if ($option == 'noreaded' OR $option == 'readed' OR $option == 'today' OR $option == 'week' OR $option == 'month' OR $option == 'total')
			return count($voxes);
		else
			return $voxes;
	}

	public function get_room($id)
	{
		$query = $this->database->select('rooms', [
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function get_opportunity_area($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
			'name'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_opportunity_type($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
			'name'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_location($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('locations', [
			'name'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_guest_treatment($id)
	{
		$query = $this->database->select('guest_treatments', [
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
	}
}
