<?php
include_once "JsonHelper.php";

/**
 * Created by IntelliJ IDEA.
 * User: max
 * Date: 09.08.16
 * Time: 18:35
 */
class User
{
    private $username = "";
    private $password = "";
    private $jsonString = "";
    private $jsonHelper;

    static function fromFile($username)
    {
        $filename = "users/". $username . ".json";
        $json = json_decode(file_get_contents($filename));
        $username = $json->{'username'};
        $password = $json->{'password'};
        $jsonString = $json->{'jsonString'};
        $user = new User($username, $password);
        $user->setJSONString($jsonString);
        return $user;
    }

    static function getCryptPassword($password)
    {
        $salt = file_get_contents("salt.txt");
        return crypt($password, $salt);
    }

    static function userExists($username)
    {
        if(file_exists(FileTools::getFileName($username)))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getHash()
    {
        return FileTools::getFileHash($this->username);
    }

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        $this->jsonHelper = new JsonHelper($this);
    }

    public function setJSONString($jsonString)
    {
        $this->jsonString = $jsonString;
    }

    private function toJSON()
    {
        $json = array
        (
            "username" => $this->username,
            "password" => $this->password,
            "jsonString" => $this->jsonString,
        );
        return json_encode($json, JSON_PRETTY_PRINT);
    }

    public function addToJSON($jsonString)
    {
        $this->jsonHelper->addToJSON($jsonString);
    }

    public function save()
    {
        file_put_contents(FileTools::getFileName($this->username),$this->toJSON());
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getJsonString()
    {
        return $this->jsonString;
    }

    public function fromJSON($string)
    {
        return json_decode($string);
    }

}