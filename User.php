<?php

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

    static function fromFile($username)
    {
        $filename = $username . "_" . ".json";
        $json = json_decode(file_get_contents($filename));
        $username = $json->{'username'};
        $password = $json->{'password'};
        $jsonString = $json->{'jsonString'};
        $user = new User($username, $password);
        $user->setJSONString($jsonString);
        return $user;
    }

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function setJSONString($jsonString)
    {
        $this->jsonString = $jsonString;
    }

    public function toJSON()
    {
        $this->username;
        $json = array
        (
            "username" => $this->username,
            "password" => $this->password,
            "jsonString" => $this->jsonString,
        );
        return json_encode($json, JSON_PRETTY_PRINT);
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