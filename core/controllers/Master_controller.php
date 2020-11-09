<?php

defined('_EXEC') or die;

class Master_controller extends Controller
{
	private $lang;

	public function __construct()
	{
		parent::__construct();

		$this->lang = Session::get_value('account')['language'];
	}

	public function index()
	{
        if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'change_account')
			{
                $query = $this->model->get_accounts($_POST);

                if (!empty($query))
                {
                    $this->model->update_user_account($query['account_id']);

                    $account = Session::get_value('account');

                    $account['id'] = $query['account_id'];
                    $account['token'] = $query['account_token'];
                    $account['name'] = $query['account_name'];
                    $account['path'] = $query['account_path'];
                    $account['type'] = $query['account_type'];
                    $account['time_zone'] = $query['account_time_zone'];
                    $account['currency'] = $query['account_currency'];
                    $account['language'] = $query['account_language'];
                    $account['logotype'] = $query['account_logotype'];
                    $account['qrs'] = $query['account_qrs'];
                    $account['package']['id'] = $query['package_id'];
                    $account['package']['quantity_end'] = $query['package_quantity_end'];
                    $account['operation']= $query['account_operation'];
                    $account['siteminder']= $query['account_siteminder'];
                    $account['zaviapms']= $query['account_zaviapms'];
                    $account['ambit']= $query['account_ambit'];
                    $account['settings']['menu']['currency']= $query['account_settings']['myvox']['menu']['currency'];
                    $account['settings']['menu']['multi']= $query['account_settings']['myvox']['menu']['multi'];

                    Session::set_value('account', $account);

                    Functions::environment([
                    	'status' => 'success',
                    	'message' => 'Cambiando cuenta',
                    ]);
                }
			}
		}
		else
		{
			$template = $this->view->render($this, 'index');

            define('_title', 'Guestvox | Master');
            
            $tbl_accounts = '';

            foreach ($this->model->get_accounts() as $value)
			{
				$tbl_accounts .=
				'<div>
                    <div class="datas">
                    <div class="itm_1">
                        <h2>' . $value['name']. '</h2>
                        <span>' . $value['country'] . ' | ' . $value['zip_code'] . '</span>
                        <span>' . $value['city'] . ' ' . $value['address'] . '</span>
                    </div>
                    <div class="itm_2">
                        <figure>
                        <img src="{$path.uploads}' . $value['logotype'] . '">
                        <figure>
                    </div>
					</div>
					<div class="buttons flex_right">
						' . ((Session::get_value('user')['master'] == true AND $value['status'] == true) ? '<a class="big" data-action="change_account" data-id="' . $value['id'] . '"><i class="fas fa-exchange-alt"></i></a>' : '') . '
					</div>
				</div>';
			}
            
			$replace = [
                '{$tbl_accounts}' => $tbl_accounts
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
