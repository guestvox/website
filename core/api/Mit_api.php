<?php

class Mit_api extends Model
{
    public function get($params)
    {
        return 'Ok';
    }

    public function post($params)
    {
        $query = $this->database->insert('mit', [
			'code' => json_encode($_POST['strResponse'])
		]);

        return 'Ok';
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
