<?php

defined('_EXEC') or die;

class Dashboard_model extends Model
{
	private $crypted;

	public function __construct()
	{
		parent::__construct();

		$this->crypted = new Crypted();
	}

	public function get_voxes($option = null)
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
			$value['data'] = json_decode($this->crypted->openssl('decrypt', $value['data']), true);

			$break = false;

			if (Functions::check_access(['{views_opportunity_areas}']) == true AND !in_array($value['data']['opportunity_area'], Session::get_value('user')['opportunity_areas']))
				$break = true;

			if (Functions::check_access(['{views_own}']) == true AND $value['data']['created_user'] != Session::get_value('user')['id'] AND !in_array(Session::get_value('user')['id'], $value['data']['assigned_users']))
				$break = true;

			if (Functions::check_access(['{views_confidentiality}']) == false && $value['data']['confidentiality'] == true)
				$break = true;

			if ($option == 'noreaded' AND $value['data']['readed'] == true)
				$break = true;

			if ($option == 'readed' AND $value['data']['readed'] == false)
				$break = true;

			if ($option == 'today' AND Dates::get_format_date($value['data']['started_date']) != Dates::get_current_date())
				$break = true;

			if ($option == 'week' AND Dates::get_format_date($value['data']['started_date']) < Dates::get_current_week()[0] OR Dates::get_format_date($value['data']['started_date']) > Dates::get_current_week()[1])
				$break = true;

			if ($option == 'month' AND Dates::get_format_date($value['data']['started_date']) < Dates::get_current_month()[0] OR Dates::get_format_date($value['data']['started_date']) > Dates::get_current_month()[1])
				$break = true;

			if ($value['data']['status'] == 'close')
				$break = true;

			if ($break == false)
			{
				if (!isset($option) OR !empty($option))
				{
					$value['data']['room'] = $this->get_room($value['data']['room'])['name'];
					$value['data']['guest_treatment'] = $this->get_guest_treatment($value['data']['guest_treatment'])['name'];
					$value['data']['opportunity_area'] = $this->get_opportunity_area($value['data']['opportunity_area'])['name'][Session::get_value('settings')['language']];
					$value['data']['opportunity_type'] = $this->get_opportunity_type($value['data']['opportunity_type'])['name'][Session::get_value('settings')['language']];
					$value['data']['location'] = $this->get_location($value['data']['location'])['name'][Session::get_value('settings')['language']];

					if (!empty($value['data']['comments']))
					{
						foreach ($value['data']['comments'] as $subvalue)
							$value['data']['attachments'] = array_merge($value['data']['attachments'], $subvalue['attachments']);
					}
				}

				$aux[$key] = Dates::get_format_date_hour($value['data']['started_date'], $value['data']['started_hour']);

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

	public function get_chart($date1, $date2)
	{
		$query = $this->database->select('voxes', [
			'data',
		], [
			'account' => Session::get_value('account')['id']
		]);

		if (!empty($query))
		{
			$metrics = [];
			$voxes = [];

			foreach ($query as $key => $value)
			{
				$value['data'] = json_decode($this->crypted->openssl('decrypt', $value['data']), true);

				$break = false;

				if ($value['data']['started_date'] < $date1 OR $value['data']['started_date'] > $date2)
					$break = true;

				if ($break == false)
				{
					$metrics['labels'][$value['data']['started_date']] = '';

					array_push($voxes, $value);
				}
			}

			ksort($metrics['labels']);

			$labels = '';

			foreach ($metrics['labels'] as $key => $value)
			{
				foreach ($voxes as $subvalue)
				{
					$mdoa = $this->get_opportunity_area($subvalue['data']['opportunity_area'])['name'][Session::get_value('settings')['language']];

					if (!isset($metrics['data'][$mdoa][$key]))
						$metrics['data'][$mdoa][$key] = 0;

					if ($subvalue['data']['started_date'] == $key)
						$metrics['data'][$mdoa][$key] += 1;
				}

				$key = Dates::get_format_date($key, 'd M, y');
				$labels .= '"' . $key . '", ';
			}

			$labels = substr(trim($labels), 0, -1);
			$labels = '' . $labels . '';
			$datasets = '';

			foreach ($metrics['data'] as $key => $value)
			{
				$arrjs = '';

				foreach ($value as $x => $y)
				{
					if (!isset($metrics['totals'][$x]))
						$metrics['totals'][$x] = 0;

					$metrics['totals'][$x] += $y;
					$arrjs .= '"' . $y . '", ';
				}

				$arrjs = substr(trim($arrjs), 0, -1);
				$arrjs = '[' . $arrjs . ']';
				$color = str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);

				$datasets .= '{
					label: "' . $key . '",
					backgroundColor: "#' . $color . '",
					borderColor: "#' . $color . '",
					borderWidth: "1",
					fill: false,
					data: ' . $arrjs . '
				},';
			}

			$total = '';
			$suggested_max = 0;

			foreach ($metrics['totals'] as $value)
			{
				$total .='"' . $value . '", ';

				if ($value > $suggested_max)
					$suggested_max = $value;
			}

			$suggested_max += 1;
			$total = substr(trim($total), 0, -1);

			$datasets .= '{
				label: "Totales",
				backgroundColor: "#9e9e9e",
				borderColor: "#9e9e9e",
				borderWidth: "5",
				fill: false,
				borderDash: [5, 5],
				data: [' . $total . ']
			}';

			return [
				'labels' => $labels,
				'datasets' => $datasets,
				'suggested_max' => $suggested_max
			];
		}

		return [
			'labels' => '',
			'datasets' => '',
			'suggested_max' => 1
		];
	}

	// ---

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

	public function get_room($id)
	{
		$query = $this->database->select('rooms', [
			'id',
			'name'
		], [
			'id' => $id
		]);

		return !empty($query) ? $query[0] : null;
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
}
