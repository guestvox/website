<?php

defined('_EXEC') or die;

require_once 'plugins/nexmo/vendor/autoload.php';

class Reviews_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

    public function index($params)
    {
		$data['account'] = $this->model->get_account($params[0]);

		if (!empty($data['account']))
		{
			Session::set_value('account', $data['account']);
		}

			if (Format::exist_ajax_request() == true)
			{

				if ($_POST['action'] == 'get_opt_opportunity_types')
				{
					$html = '<option value="" selected hidden>{$lang.choose}</option>';

					foreach ($this->model->get_opportunity_types($_POST['opportunity_area'], $_POST['type']) as $value)
						$html .= '<option value="' . $value['id'] . '">' . $value['name'][Session::get_value('lang')] . '</option>';

					Functions::environment([
						'status' => 'success',
						'data' => $html
					]);
				}

			}
			else
			{
				define('_title', 'GuestVox');

				$template = $this->view->render($this, 'index');

                $name = $data['account']['name'];

                $general_average_rate = $this->model->get_general_average_rate($data['account']['id']);

    			$h4_general_average_rate = '';

    			if ($general_average_rate == 0)
    				$h4_general_average_rate = '<h4 style="color:#f44336;">' . $general_average_rate . '</h4>';
    			else if ($general_average_rate >= 1 AND $general_average_rate < 1.8)
    				$h4_general_average_rate = '<h4 style="color:#f44336;">' . $general_average_rate . '</h4>';
    			else if ($general_average_rate >= 1.8 AND $general_average_rate < 2.8)
    				$h4_general_average_rate = '<h4 style="color:#ffc107;">' . $general_average_rate . '</h4>';
    			else if ($general_average_rate >= 2.8 AND $general_average_rate < 3.8)
    				$h4_general_average_rate = '<h4 style="color:#ffeb3b;">' . $general_average_rate . '</h4>';
    			else if ($general_average_rate >= 3.8 AND $general_average_rate < 4.8)
    				$h4_general_average_rate = '<h4 style="color:#4caf50;">' . $general_average_rate . '</h4>';
    			else if ($general_average_rate >= 4.8 AND $general_average_rate <= 5)
    				$h4_general_average_rate = '<h4 style="color:#00a5ab;">' . $general_average_rate . '</h4>';

    			$spn_general_avarage_rate =
    			'<span>
    				' . (($general_average_rate == 0) ? '<i class="fas fa-sad-cry" style="font-size:50px;color:#f44336;"></i>' : '<i class="far fa-sad-cry"></i>') . '
    				' . (($general_average_rate >= 1 AND $general_average_rate < 1.8) ? '<i class="fas fa-sad-cry" style="font-size:50px;color:#f44336;"></i>' : '<i class="far fa-sad-cry"></i>') . '
    				' . (($general_average_rate >= 1.8 AND $general_average_rate < 2.8) ? '<i class="fas fa-frown" style="font-size:50px;color:#ffc107;"></i>' : '<i class="far fa-frown"></i>') . '
    				' . (($general_average_rate >= 2.8 AND $general_average_rate < 3.8) ? '<i class="fas fa-meh-rolling-eyes" style="font-size:50px;color:#ffeb3b;"></i>' : '<i class="far fa-meh-rolling-eyes"></i>') . '
    				' . (($general_average_rate >= 3.8 AND $general_average_rate < 4.8) ? '<i class="fas fa-smile" style="font-size:50px;color:#4caf50;"></i>' : '<i class="far fa-smile"></i>') . '
    				' . (($general_average_rate >= 4.8 AND $general_average_rate <= 5) ? '<i class="fas fa-grin-stars" style="font-size:50px;color:#00a5ab;"></i>' : '<i class="far fa-grin-stars"></i>') . '
    			</span>';

				$replace = [
                    '{$name}' => $name,
                    '{$h4_general_average_rate}' => $h4_general_average_rate,
    				'{$spn_general_avarage_rate}' => $spn_general_avarage_rate,
    				'{$five_percentage_rate}' => $this->model->get_percentage_rate('five', $data['account']['id']),
    				'{$four_percentage_rate}' => $this->model->get_percentage_rate('four', $data['account']['id']),
    				'{$tree_percentage_rate}' => $this->model->get_percentage_rate('tree', $data['account']['id']),
    				'{$two_percentage_rate}' => $this->model->get_percentage_rate('two', $data['account']['id']),
    				'{$one_percentage_rate}' => $this->model->get_percentage_rate('one', $data['account']['id']),
    				'{$count_answered_total}' => $this->model->get_count('answered_total', $data['account']['id']),
    				'{$count_answered_today}' => $this->model->get_count('answered_today', $data['account']['id']),
    				'{$count_answered_week}' => $this->model->get_count('answered_week', $data['account']['id']),
    				'{$count_answered_month}' => $this->model->get_count('answered_month', $data['account']['id']),
    				'{$count_answered_year}' => $this->model->get_count('answered_year', $data['account']['id'])
				];

				$template = $this->format->replace($replace, $template);

				echo $template;
			}
    }
}
