<?php

class Mit_api extends Model
{
    public function get($params)
    {
        return 'Ok';
    }

    public function post($params)
    {
        $archivo = fopen("log.txt","a") or die("Error al crear");
        fwrite($archivo,"----------------------\n");
        fwrite($archivo,$_REQUEST['strResponse']);
        fwrite($archivo,"----------------------\n");
        fwrite($archivo,"Respuesta en claro ----------------------\n\n");
        $respuesta = AESCrypto::decrypt($_REQUEST['strResponse'], 'AC1D8AC2C3F14F713B13A82A91D806C3');
        fwrite($archivo,$respuesta);
        fwrite($archivo,"----------------------\n");

        echo("Se creo correctamente el log");
        fclose($archivo);

        $query = $this->database->insert('mit', [
			'code' => json_encode($respuesta)
		]);

        if (!empty($query))
            return 'Ok';
        else
            return 'Error';
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
