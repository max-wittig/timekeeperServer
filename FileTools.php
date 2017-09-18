<?php


class FileTools
{

    static function mkUserDir()
    {
        //mkdir if not exist
        if(!file_exists("users"))
        {
            mkdir("users");
        }
    }

    static function generateSalt($saltFilename)
    {
        if(!file_exists($saltFilename))
        {
            //generate random salt
            $salt = '$6$rounds=5000$' . base64_encode(openssl_random_pseudo_bytes(30)) . '$';
            file_put_contents($saltFilename, $salt);
        }
    }

    static function getFileName($username)
    {
        return "users/" . $filename = $username . ".json";
    }

    static function getFileHash($username)
    {
        return md5(file_get_contents(self::getFileName($username)));
    }


}