<?php
include_once "User.php";
include_once "FileTools.php";

header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] == "POST")
{

    $hash = "";
    $username = "";
    $password = "";
    $jsonString = "";
    $complete = "";
    $saltFilename = "salt.txt";

    //hash can be "true" or "false"
    if(isset($_POST['hash']))
        $hash = $_POST['hash'];
    if(isset($_POST['username']))
        $username = $_POST['username'];
    if(isset($_POST['password']))
        $password = $_POST['password'];
    if(isset($_POST['jsonString']))
        $jsonString = $_POST['jsonString'];
    if(isset($_POST['complete']))
        $complete = $_POST['complete'];

    if(!isset($username) || !isset($password))
    {
        echo "Invalid data";
        return;
    }

    FileTools::mkUserDir();
    FileTools::generateSalt($saltFilename);

    if(User::userExists($username))
    {
        $user = User::fromFile($username);
        if($hash != "" && $hash != NULL)
        {
            echo $user->getHash();
            return;
        }

        if($user->getPassword() == User::getCryptPassword($password, $saltFilename))
        {
            if(empty($jsonString))
            {
                echo $user->getJsonString();
            }
            else
            {
                if(isset($complete) && isset($jsonString))
                {
                    if ($complete == "true")
                    {
                        $user->setJSONString($jsonString);
                        $user->save();
                    }
                    else
                    {
                        $user->addToJSON($jsonString);
                        $user->save();
                    }
                }
            }
        }
        else
        {
            echo "401 Unauthorized\n";
        }
    }
    else
    {
        if(!empty($jsonString))
        {
            $user = new User($username, User::getCryptPassword($password, $saltFilename));
            $user->setJSONString($jsonString);
            $user->save();
        }
        else
        {
            echo "No data";
            return;
        }
    }

}