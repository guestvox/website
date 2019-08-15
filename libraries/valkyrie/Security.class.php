<?php
defined('_EXEC') or die;

/**
 *
 * @package Valkyrie.Libraries
 *
 * @since 1.0.0
 * @version 1.0.1
 * @license You can see LICENSE.txt
 *
 * @author David Miguel Gómez Macías < davidgomezmacias@gmail.com >
 * @copyright Copyright (C) CodeMonkey - Platform. All Rights Reserved.
 */

class Security
{
    /**
     * Obtiene la url dividida en array.
     *
     * @static
     *
     * @return  string
     */
    public static function url()
    {
        if ( isset($_SERVER['PATH_INFO']) )
            $PATH_INFO = $_SERVER['PATH_INFO'];
        else if ( isset($_SERVER['ORIG_PATH_INFO']) )
            $PATH_INFO = $_SERVER['ORIG_PATH_INFO'];
        else
            $PATH_INFO = null;

        if ( isset($PATH_INFO) && !is_null($PATH_INFO) )
        {
            $url = explode('/', $PATH_INFO);

            $params = [];

            foreach ( $url as $key => $value )
            {
                if ( empty($value) )
                    unset($url[$key]);
                else
                    $params[] = strtolower(self::clean_string($value));
            }

            unset($url);

            $params[0] = "{$params[0]}";

            return $params;
        }
        else
            return ["/"];
    }

    /**
     * Quita caracteres especiales de un string.
     *
     * @static
     *
     * @param   string    $str    Cadena de texto
     *
     * @return  string
     */
    public static function clean_string( $str )
    {
        if ( $str !== false )
        {
            $str    = trim($str);

            $find   = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
            $repl   = array('a', 'e', 'i', 'o', 'u', 'n');
            $str    = str_replace($find, $repl, $str);

            $find   = array(' ', '&', '\r\n', '\n', '+');
            $str    = str_replace ($find, '-', $str);

            $str = strtolower($str);
        }

        return $str;
    }

    /**
     * Remplaza los slashes de un uri por los default del sistema.
     *
     * @static
     *
     * @param   string    $path    URI
     * @return  string
     */
    public static function DS( $path )
    {
        $path = str_replace('/', DIRECTORY_SEPARATOR, $path);
        $first_character = substr($path, 0, 1);

        $parts = explode(DIRECTORY_SEPARATOR, $path);

        $return = "";

        foreach ( $parts as $value )
        {
            if ( !empty($value) )
                $return .= $value . DIRECTORY_SEPARATOR;
        }

        $return = substr($return, 0, -1);

        if ( $first_character == DIRECTORY_SEPARATOR )
            return DIRECTORY_SEPARATOR . $return;
        else
            return $return;
    }

    /**
     * Obtiene el protocolo Web en uso.
     *
     * @static
     *
     * @return  string
     */
    public static function protocol()
    {
        return ( isset($_SERVER['HTTPS']) ) ? "https://" : "http://";
    }

    /**
     * Crea un hash encriptado con la clave secreta de la configuración.
     *
     * @param   string    $algorithm    Tipo de algoritmo para usar.
     * @param   string    $data
     *
     * @return  string
     */
    public function create_hash( $algorithm, $data )
	{
		$context = hash_init($algorithm, HASH_HMAC, Configuration::$secret);
		hash_update($context, $data);

		return hash_final($context);
	}

    /**
     * Crea una password encriptada.
     *
     * @param   string    $string    Password para encriptar.
     *
     * @return  string
     */
	public function create_password( $string )
	{
		$salt = $this->random_string(64);
		$password = $this->create_hash('sha1', $string . $salt);

		return $password . ':' . $salt;
	}

    /**
     * Genera un numero dado de bytes.
     *
     * @param   integer    $length    Numero de bytes.
     *
     * @return  mixed
     */
    public function random_bytes( $length = 16 )
	{
		$sslStr = '';

		if (function_exists('openssl_random_pseudo_bytes') && (version_compare(PHP_VERSION, '5.3.4') >= 0 || IS_WIN))
		{
			$sslStr = openssl_random_pseudo_bytes($length, $strong);

			if ($strong)
				return $sslStr;
		}

		$bitsPerRound = 2;
		$maxTimeMicro = 400;
		$shaHashLength = 20;
		$randomStr = '';
		$total = $length;

		$urandom = false;
		$handle = null;

		if (function_exists('stream_set_read_buffer') && @is_readable('/dev/urandom'))
		{
			$handle = @fopen('/dev/urandom', 'rb');

			if ($handle)
				$urandom = true;
		}

		while ($length > strlen($randomStr))
		{
			$bytes = ($total > $shaHashLength) ? $shaHashLength : $total;
			$total -= $bytes;

			$entropy = rand() . uniqid(mt_rand(), true) . $sslStr;
			$entropy .= implode('', @fstat(fopen(__FILE__, 'r')));
			$entropy .= memory_get_usage();
			$sslStr = '';

			if ($urandom)
			{
				stream_set_read_buffer($handle, 0);
				$entropy .= @fread($handle, $bytes);
			}
			else
			{
				$samples = 3;
				$duration = 0;

				for ($pass = 0; $pass < $samples; ++$pass)
				{
					$microStart = microtime(true) * 1000000;
					$hash = sha1(mt_rand(), true);

					for ($count = 0; $count < 50; ++$count)
						$hash = sha1($hash, true);

					$microEnd = microtime(true) * 1000000;
					$entropy .= $microStart . $microEnd;

					if ($microStart > $microEnd)
						$microEnd += 1000000;

					$duration += $microEnd - $microStart;
				}

				$duration = $duration / $samples;

				$rounds = (int) (($maxTimeMicro / $duration) * 50);

				$iter = $bytes * (int) ceil(8 / $bitsPerRound);

				for ($pass = 0; $pass < $iter; ++$pass)
				{
					$microStart = microtime(true);
					$hash = sha1(mt_rand(), true);

					for ($count = 0; $count < $rounds; ++$count)
                        $hash = sha1($hash, true);

					$entropy .= $microStart . microtime(true);
				}
			}

			$randomStr .= sha1($entropy, true);
		}

		if ($urandom)
			@fclose($handle);

		return substr($randomStr, 0, $length);
	}

    /**
     * Genera un string de caracteres random.
     *
     * @param   integer    $length    Tamaño del string.
     *
     * @return  string
     */
	public function random_string( $length = 8 )
	{
		$salt = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$base = strlen($salt);
		$stringRandom = '';

		$random = $this->random_bytes($length + 1);
		$shift = ord($random[0]);

		for ( $i = 1; $i <= $length; ++$i )
		{
			$stringRandom .= $salt[($shift + ord($random[$i])) % $base];
			$shift += ord($random[$i]);
		}

		return $stringRandom;
	}

}
