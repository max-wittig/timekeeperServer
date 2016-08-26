<?php
include_once "User.php";
include_once "FileTools.php";

header('Access-Control-Allow-Origin: *');



function getCryptPassword($password)
{
    $salt = '$6$rounds=5000$dsfdsfrgreebe3breg#th76i8opüpo$';
    return crypt($password, $salt);
}


if ($_SERVER['REQUEST_METHOD'] == "POST")
{
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

    if(User::userExists($username))
    {
        $user = User::fromFile($username);
        if($user->getPassword() == getCryptPassword($password))
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
            $user = new User($username, getCryptPassword($password));
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