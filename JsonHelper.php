<?php
include_once "User.php";
/**
 * Created by IntelliJ IDEA.
 * User: max
 * Date: 25.08.16
 * Time: 21:59
 */
class JsonHelper
{
    private $user;
    private $saveObjectArray;
    private $saveProjectArray;

    public function __construct($user)
    {
        $this->user = $user;
        $this->parse();
    }

    private function parse()
    {
        $this->parseSaveObjectArray();
        $this->parseSaveProjectArray();
    }

    private function parseSaveProjectArray()
    {
        $array = $this->getArray();
        $this->saveProjectArray = $array->{'saveProjectArray'};
    }

    private function parseSaveObjectArray()
    {
        $array = $this->getArray();
        $this->saveObjectArray = $array->{'saveObjectArray'};
    }

    private function getArray()
    {
        $user = $this->user;
        echo "Test".$user->getJsonString();
        $json = json_decode($user->getJsonString());
        return $json;
    }

    public function addToJSON($jsonString)
    {

    }
}