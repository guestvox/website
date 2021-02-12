<?php

class Mit_api extends Model
{
    public function get($params)
    {
        return 'Ok';
    }

    public function post($params)
    {
        $file = fopen("log.txt","a") or die("ERROR");

        fwrite($file, "----------------------\n");
        fwrite($file, $_REQUEST["strResponse"]);
        fwrite($file, "----------------------\n");
        fwrite($file, "Response ----------------------\n\n");

        $response = AESCrypto::decrypt($_REQUEST['strResponse'], '22F31F5ECCDD4D29D378FB71B13641EC');

        fwrite($file, $response);
        fwrite($file, "----------------------\n");

        echo("SUCCESS");

        fclose($file);

        $query = $this->database->insert('payments', [
            'account' => Session::get_value('myvox')['account']['id'],
			'token' => Session::get_value('myvox')['payment_token'],
			'code' => 'mit',
			'response' => json_encode($response),
            'date' => Functions::get_current_date(),
            'hour' => Functions::get_current_hour()
		]);

        if (!empty($query))
            return 'Ok';
        else
            return 'ERROR';
    }

    public function put($params)
    {
        return 'Ok';
    }

    public function delete($params)
    {
        return 'Ok';
    }
}
