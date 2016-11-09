<?php

/**
 * Created by IntelliJ IDEA.
 * User: max
 * Date: 25.08.16
 * Time: 21:40
 */
class FileTools
{
    static function getFileName($username)
    {
        return "users/" . $filename = $username . ".json";
    }

    static function getFileHash($username)
    {
        return md5(file_get_contents(self::getFileName($username)));
    }


}