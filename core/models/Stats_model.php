<?php

defined('_EXEC') or die;

class Stats_model extends Model
{
	private $crypted;

	public function __construct()
	{
		parent::__construct();

		$this->crypted = new Crypted();
	}

	public function get_chart_data($option, $params, $edit = false)
	{
		$data = null;

		if ($option == 'v_oa_chart' OR $option == 'v_r_chart' OR $option == 'v_l_chart')
		{
			$query = $this->database->select('voxes', [
				'type',
				'data',
			], [
				'account' => Session::get_value('account')['id'],
			]);

			$voxes = [];

			foreach ($query as $key => $value)
			{
				$value['data'] = json_decode($this->crypted->openssl('decrypt', $value['data']), true);

				$break = false;

				if (Dates::get_format_date($value['data']['started_date']) < $params['started_date'] OR Dates::get_format_date($value['data']['started_date']) > $params['date_end'])
					$break = true;

				if ($params['type'] != 'all' AND $value['type'] != $params['type'])
					$break = true;

				if ($break == false)
					array_push($voxes, $value);
			}

			if ($option == 'v_oa_chart')
			{
				$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
					'id',
					'name'
				], [
					'account' => Session::get_value('account')['id']
				]));
			}
			else if ($option == 'v_r_chart')
			{
				$query = $this->database->select('rooms', [
					'id',
					'name'
				], [
					'account' => Session::get_value('account')['id']
				]);
			}
			else if ($option == 'v_l_chart')
			{
				$query = Functions::get_json_decoded_query($this->database->select('locations', [
					'id',
					'name'
				], [
					'account' => Session::get_value('account')['id']
				]));
			}

			if ($edit == true)
			{
				$data = [
					'labels' => [],
					'datasets' => [
						'data' => [],
						'colors' => []
					]
				];
			}
			else
			{
				$data = [
					'labels' => '',
					'datasets' => [
						'data' => '',
						'colors' => ''
					]
				];
			}

			foreach ($query as $value)
			{
				$count = 0;

				foreach ($voxes as $subvalue)
				{
					if ($option == 'v_oa_chart')
					{
						if ($value['id'] == $subvalue['data']['opportunity_area'])
							$count = $count + 1;
					}
					else if ($option == 'v_r_chart')
					{
						if ($value['id'] == $subvalue['data']['room'])
							$count = $count + 1;
					}
					else if ($option == 'v_l_chart')
					{
						if ($value['id'] == $subvalue['data']['location'])
							$count = $count + 1;
					}
				}

				if ($edit == true)
				{
					if ($option == 'v_oa_chart')
						array_push($data['labels'], $value['name'][Session::get_value('settings')['language']]);
					else if ($option == 'v_r_chart')
						array_push($data['labels'], $value['name']);
					else if ($option == 'v_l_chart')
						array_push($data['labels'], $value['name'][Session::get_value('settings')['language']]);

					array_push($data['datasets']['data'], $count);
					array_push($data['datasets']['colors'], "#" . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT));
				}
				else
				{
					if ($option == 'v_oa_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('settings')['language']] . "',";
					else if ($option == 'v_r_chart')
						$data['labels'] .= "'" . $value['name'] . "',";
					else if ($option == 'v_l_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('settings')['language']] . "',";

					$data['datasets']['data'] .= $count . ',';
					$data['datasets']['colors'] .= "'#" . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . "',";
				}
			}
		}
		else if ($option == 'ar_oa_chart' OR $option == 'ar_r_chart' OR $option == 'ar_l_chart')
		{
			$query = $this->database->select('voxes', [
				'type',
				'data',
			], [
				'account' => Session::get_value('account')['id'],
			]);

			$voxes = [];

			foreach ($query as $key => $value)
			{
				$value['data'] = json_decode($this->crypted->openssl('decrypt', $value['data']), true);

				$break = false;

				if (Dates::get_format_date($value['data']['started_date']) < $params['started_date'] OR Dates::get_format_date($value['data']['started_date']) > $params['date_end'])
					$break = true;

				if ($params['type'] != 'all' AND $value['type'] != $params['type'])
					$break = true;

				if ($break == false)
					array_push($voxes, $value);
			}

			if ($option == 'ar_oa_chart')
			{
				$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
					'id',
					'name'
				], [
					'account' => Session::get_value('account')['id']
				]));
			}
			else if ($option == 'ar_r_chart')
			{
				$query = $this->database->select('rooms', [
					'id',
					'name'
				], [
					'account' => Session::get_value('account')['id']
				]);
			}
			else if ($option == 'ar_l_chart')
			{
				$query = Functions::get_json_decoded_query($this->database->select('locations', [
					'id',
					'name'
				], [
					'account' => Session::get_value('account')['id']
				]));
			}

			if ($edit == true)
			{
				$data = [
					'labels' => [],
					'datasets' => [
						'data' => [],
						'colors' => []
					]
				];
			}
			else
			{
				$data = [
					'labels' => '',
					'datasets' => [
						'data' => '',
						'colors' => ''
					]
				];
			}

			foreach ($query as $value)
			{
				$average = 0;
				$hours = 0;
				$count = 0;

				foreach ($voxes as $subvalue)
				{
					if ($option == 'ar_oa_chart')
					{
						if ($value['id'] == $subvalue['data']['opportunity_area'])
						{
							$date1 = new DateTime($subvalue['data']['started_date'] . ' ' . $subvalue['data']['started_hour']);
							$date2 = new DateTime($subvalue['data']['completed_date'] . ' ' . $subvalue['data']['completed_hour']);
							$date3 = $date1->diff($date2);
							$hours = $hours + ((24 * $date3->d) + (($date3->i / 60) + $date3->h));
							$count = $count + 1;
						}
					}
					else if ($option == 'ar_r_chart')
					{
						if ($value['id'] == $subvalue['data']['room'])
						{
							$date1 = new DateTime($subvalue['data']['started_date'] . ' ' . $subvalue['data']['started_hour']);
							$date2 = new DateTime($subvalue['data']['completed_date'] . ' ' . $subvalue['data']['completed_hour']);
							$date3 = $date1->diff($date2);
							$hours = $hours + ((24 * $date3->d) + (($date3->i / 60) + $date3->h));
							$count = $count + 1;
						}
					}
					else if ($option == 'ar_l_chart')
					{
						if ($value['id'] == $subvalue['data']['location'])
						{
							$date1 = new DateTime($subvalue['data']['started_date'] . ' ' . $subvalue['data']['started_hour']);
							$date2 = new DateTime($subvalue['data']['completed_date'] . ' ' . $subvalue['data']['completed_hour']);
							$date3 = $date1->diff($date2);
							$hours = $hours + ((24 * $date3->d) + (($date3->i / 60) + $date3->h));
							$count = $count + 1;
						}
					}
				}

				$average = ($count > 0) ? $hours / $count : $average;

				if ($average < 1)
					$average = round(($average * 60), 2);
				else
					$average = round($average, 2);

				if ($edit == true)
				{
					if ($option == 'ar_oa_chart')
						array_push($data['labels'], $value['name'][Session::get_value('settings')['language']]);
					else if ($option == 'ar_r_chart')
						array_push($data['labels'], $value['name']);
					else if ($option == 'ar_l_chart')
						array_push($data['labels'], $value['name'][Session::get_value('settings')['language']]);

					array_push($data['datasets']['data'], $average);
					array_push($data['datasets']['colors'], "#" . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT));
				}
				else
				{
					if ($option == 'ar_oa_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('settings')['language']] . "',";
					else if ($option == 'ar_r_chart')
						$data['labels'] .= "'" . $value['name'] . "',";
					else if ($option == 'ar_l_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('settings')['language']] . "',";

					$data['datasets']['data'] .= $average . ',';
					$data['datasets']['colors'] .= "'#" . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . "',";
				}
			}
		}
		else if ($option == 'c_oa_chart' OR $option == 'c_r_chart' OR $option == 'c_l_chart')
		{
			$query = $this->database->select('voxes', [
				'type',
				'data',
			], [
				'account' => Session::get_value('account')['id'],
			]);

			$voxes = [];

			foreach ($query as $key => $value)
			{
				$value['data'] = json_decode($this->crypted->openssl('decrypt', $value['data']), true);

				$break = false;

				if (Dates::get_format_date($value['data']['started_date']) < $params['started_date'] OR Dates::get_format_date($value['data']['started_date']) > $params['date_end'])
					$break = true;

				if ($value['type'] != 'incident')
					$break = true;

				if ($break == false)
					array_push($voxes, $value);
			}

			if ($option == 'c_oa_chart')
			{
				$query = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
					'id',
					'name'
				], [
					'account' => Session::get_value('account')['id']
				]));
			}
			else if ($option == 'c_r_chart')
			{
				$query = $this->database->select('rooms', [
					'id',
					'name'
				], [
					'account' => Session::get_value('account')['id']
				]);
			}
			else if ($option == 'c_l_chart')
			{
				$query = Functions::get_json_decoded_query($this->database->select('locations', [
					'id',
					'name'
				], [
					'account' => Session::get_value('account')['id']
				]));
			}

			if ($edit == true)
			{
				$data = [
					'labels' => [],
					'datasets' => [
						'data' => [],
						'colors' => []
					]
				];
			}
			else
			{
				$data = [
					'labels' => '',
					'datasets' => [
						'data' => '',
						'colors' => ''
					]
				];
			}

			foreach ($query as $value)
			{
				$cost = 0;

				foreach ($voxes as $subvalue)
				{
					if ($option == 'c_oa_chart')
					{
						if ($value['id'] == $subvalue['data']['opportunity_area'])
							$cost = !empty($subvalue['data']['cost']) ? $cost + $subvalue['data']['cost'] : $cost;
					}
					else if ($option == 'c_r_chart')
					{
						if ($value['id'] == $subvalue['data']['room'])
							$cost = !empty($subvalue['data']['cost']) ? $cost + $subvalue['data']['cost'] : $cost;
					}
					else if ($option == 'c_l_chart')
					{
						if ($value['id'] == $subvalue['data']['location'])
							$cost = !empty($subvalue['data']['cost']) ? $cost + $subvalue['data']['cost'] : $cost;
					}
				}

				if ($edit == true)
				{
					if ($option == 'c_oa_chart')
						array_push($data['labels'], $value['name'][Session::get_value('settings')['language']]);
					else if ($option == 'c_r_chart')
						array_push($data['labels'], $value['name']);
					else if ($option == 'c_l_chart')
						array_push($data['labels'], $value['name'][Session::get_value('settings')['language']]);

					array_push($data['datasets']['data'], $cost);
					array_push($data['datasets']['colors'], "#" . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT));
				}
				else
				{
					if ($option == 'c_oa_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('settings')['language']] . "',";
					else if ($option == 'c_r_chart')
						$data['labels'] .= "'" . $value['name'] . "',";
					else if ($option == 'c_l_chart')
						$data['labels'] .= "'" . $value['name'][Session::get_value('settings')['language']] . "',";

					$data['datasets']['data'] .= $cost . ',';
					$data['datasets']['colors'] .= "'#" . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . "',";
				}
			}
		}

		return $data;
	}

	public function get_count($option, $params = null)
	{
		$count = 0;

		if ($option == 'created_today' OR $option == 'created_week' OR $option == 'created_month' OR $option == 'created_year' OR $option == 'created_total')
		{
			$query = $this->database->select('voxes', [
				'data',
			], [
				'account' => Session::get_value('account')['id']
			]);

			foreach ($query as $key => $value)
			{
				$value['data'] = json_decode($this->crypted->openssl('decrypt', $value['data']), true);

				$break = false;

				if ($option == 'created_today' AND Dates::get_format_date($value['data']['started_date']) != Dates::get_current_date())
					$break = true;

				if ($option == 'created_week' AND Dates::get_format_date($value['data']['started_date']) < Dates::get_current_week()[0] OR Dates::get_format_date($value['data']['started_date']) > Dates::get_current_week()[1])
					$break = true;

				if ($option == 'created_month' AND Dates::get_format_date($value['data']['started_date']) < Dates::get_current_month()[0] OR Dates::get_format_date($value['data']['started_date']) > Dates::get_current_month()[1])
					$break = true;

				if ($option == 'created_year' AND explode('-', Dates::get_format_date($value['data']['started_date']))[0] != Dates::get_current_year())
					$break = true;

				if ($break == false)
					$count = $count + 1;
			}
		}

		return $count;
	}

	public function get_average($option, $params = null)
	{
		$average = 0;

		if ($option == 'general_resolution')
		{
			$query = $this->database->select('voxes', [
				'data',
			], [
				'account' => Session::get_value('account')['id']
			]);

			$hours = 0;
			$count = 0;

			foreach ($query as $key => $value)
			{
				$value['data'] = json_decode($this->crypted->openssl('decrypt', $value['data']), true);

				$date1 = new DateTime($value['data']['started_date'] . ' ' . $value['data']['started_hour']);
				$date2 = new DateTime($value['data']['completed_date'] . ' ' . $value['data']['completed_hour']);
				$date3 = $date1->diff($date2);
				$hours = $hours + ((24 * $date3->d) + (($date3->i / 60) + $date3->h));
				$count = $count + 1;
			}

			$average = $hours / $count;

			if ($average < 1)
				$average = round(($average * 60), 2) . ' Min';
			else
				$average = round($average, 2) . ' Hrs';
		}

		return $average;
	}
}
