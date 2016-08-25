<?php
include_once "User.php";
include_once "FileTools.php";




function getCryptPassword($password)
{
    $salt = '$6$rounds=5000$dsfdsfrgreebe3breg#th76i8opüpo$';
    return crypt($password, $salt);
}


if ($_SERVER['REQUEST_METHOD'] == "POST")
{
    $jsonString = $_POST['jsonString'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $complete = $_POST['complete'];

    if(User::userExists($username))
    {
        $user = User::fromFile($username);
        if($user->getPassword() == getCryptPassword($password))
        {
            if($complete == "true")
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
        else
        {
            echo "401 Unauthorized\n";
        }
    }
    else
    {
        $user = new User($username, getCryptPassword($password));
        $user->setJSONString($jsonString);
        $user->save();
    }

}