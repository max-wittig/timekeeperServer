<?php
include_once "User.php";

function getFileName($username)
{
    return "users/" . $filename = $username . ".json";
}

function userExists($username)
{

    if(file_exists(getFileName($username)))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function getCryptPassword($password)
{
    $salt = '$6$rounds=5000$dsfdsfrgreebe3breg#th76i8opüpo$';
    return crypt($password, $salt);
}


if ($_SERVER['REQUEST_METHOD'] == "POST")
{
    $timekeeperString = $_POST['jsonString'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $complete = $_POST['complete'];

    if(userExists($username))
    {
        $user = User::fromFile($username);
        if($user->getPassword() == getCryptPassword($password))
        {
            
        }
    }
    else
    {
        $user = new User($username, getCryptPassword($password));
        $user->setJSONString($timekeeperString);
        file_put_contents(getFileName($username),$user->toJSON());
    }

}