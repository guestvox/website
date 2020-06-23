<?php
defined('_EXEC') or die;

/**
 * @author David Miguel Gomez Macias <dgomez@codemonkey.com.mx>
 * @version 1.0
 * @copyright Copyright (c) 2014, David Miguel Gomez Macias
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Upload
{
    private $security;
    private $show_404;
    private $fileName;
    private $tempName;
    private $fileType;
    private $fileSize;
    private $uploadDirectory;
    private $validExtensions;
    private $maximumFileSize;

    public function __construct($show_404 = false)
    {
        $this->security = new Security();
        $this->show_404 = $show_404;
    }

    public function SetFileName( $argv )
    {
        $this->fileName = $argv . $this->security->random_string(16);
    }

    public function SetTempName( $argv )
    {
        $this->tempName = $argv;
    }

    public function SetFileType( $argv )
    {
        $this->fileType = explode( '/', $argv );
    }

    public function SetFileSize( $argv )
    {
        $this->fileSize = $argv;
    }

    public function SetUploadDirectory( $argv )
    {
        $this->uploadDirectory = $argv;
    }

    public function SetValidExtensions( $argv )
    {
        $this->validExtensions = $argv;
    }

    public function SetMaximumFileSize( $argv )
    {
        $this->maximumFileSize = $argv;
    }

    public function UploadFile()
    {
        if ( !empty( $this->validExtensions ) )
        {
            if ( isset($this->fileType[1]) )
            {
                if ( in_array( $this->fileType[1], $this->validExtensions ) )
                {
                    if ( $this->fileSize < $this->maximumFileSize || $this->maximumFileSize == 'unlimited' )
                    {
                        if ( @copy( $this->tempName, $this->uploadDirectory . '/' . $this->fileName . '.' . $this->fileType[1] ) )
                        {
                            return [
                                'status'    => 'success',
                                'file'      => $this->fileName . '.' . $this->fileType[1],
                                'route'     => $this->security->DS($this->uploadDirectory . '/' . $this->fileName . '.' . $this->fileType[1])
                            ];
                        }
                        else
                        {
                            if ( $this->show_404 == true )
                                header("HTTP/1.0 404 Not Found");

                            return [
                                'status' => 'error',
                                'message' => '{system_failed}'
                            ];
                        }
                    }
                    else
                    {
                        if ( $this->show_404 == true )
                            header("HTTP/1.0 404 Not Found");

                        return [
                            'status' => 'error',
                            'message' => '{file_is_larger}'
                        ];
                    }
                }
                else
                {
                    if ( $this->show_404 == true )
                        header("HTTP/1.0 404 Not Found");

                    return [
                        'status' => 'error',
                        'message' => '{file_not_allowed}'
                    ];
                }
            }
            else
            {
                if ( $this->show_404 == true )
                    header("HTTP/1.0 404 Not Found");

                return [
                    'status' => 'error',
                    'message' => '{file_error}'
                ];
            }
        }
        else
        {
            if ( $this->show_404 == true )
                header("HTTP/1.0 404 Not Found");

            return [
                'status' => 'error',
                'message' => '{extension_not_valid}'
            ];
        }
    }
}
