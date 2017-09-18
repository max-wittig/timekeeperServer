<?php
include_once "User.php";


class JsonHelper
{
    private $user;
    private $saveObjectArray;
    private $saveProjectArray;

    public function __construct($user)
    {
        $this->user = $user;
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
        $json = json_decode($user->getJsonString());
        return $json;
    }

    private function containsProject($projectName)
    {
        $saveProjectArray = $this->saveProjectArray;
        //find project
        for($i=0; $i < sizeof($saveProjectArray); $i++)
        {
            if($saveProjectArray[$i]->{'name'} == $projectName)
            {
                return true;
            }
        }
        return false;
    }

    private function containsTask($taskName, $projectName)
    {
        $saveProjectArray = $this->saveProjectArray;
        //find project
        for($i=0; $i < sizeof($saveProjectArray); $i++)
        {
            if($saveProjectArray[$i]->{'name'} == $projectName)
            {
                $taskList = $saveProjectArray[$i]->{'taskList'};
                if(in_array($taskName, $taskList))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
        return false;
    }

    private function addTaskToProject($taskName, $projectName)
    {
        $saveProjectArray = $this->saveProjectArray;
        //find project
        for($i=0; $i < sizeof($saveProjectArray); $i++)
        {
            if($saveProjectArray[$i]->{'name'} == $projectName)
            {
                $taskList = $saveProjectArray[$i]->{'taskList'};
                for($j=0; $j < sizeof($taskList); $j++)
                {
                    if($taskList[$j] == $taskName)
                    {
                        return;
                    }
                }
                array_push($taskList, $taskName);
                $saveProjectArray[$i]->{'taskList'} = $taskList;

                return;
            }
        }
    }

    private function addProject($projectName, $taskName)
    {
        $projectArray = array(
            "name" => $projectName,
            "taskList" => [$taskName],
            "frozen" => false,
            "tags" => []
        );
        array_push($this->saveProjectArray, $projectArray);
    }

    private function addProjectToSaveProjectArray($timeKeeperObject)
    {
        $projectName = $timeKeeperObject->{'projectName'};
        $taskName = $timeKeeperObject->{'taskName'};

        if($this->containsProject($projectName))
        {
            if($this->containsTask($taskName,$projectName))
            {
                return;
            }
            else
            {
                $this->addTaskToProject($taskName,$projectName);
            }
        }
        else
        {
            $this->addProject($projectName, $taskName);
        }
    }

    private function getCompleteJSON()
    {
        $array = array(
            "saveProjectArray" => $this->saveProjectArray,
            "saveObjectArray" => $this->saveObjectArray
        );

        return json_encode($array);
    }

    private function addObject($timeKeeperObject)
    {
        array_push($this->saveObjectArray,$timeKeeperObject);
    }

    public function addToJSON($jsonString)
    {
        $this->parse();
        $timeKeeperObject = json_decode($jsonString)->{'saveObject'};
        $this->addObject($timeKeeperObject);
        $this->addProjectToSaveProjectArray($timeKeeperObject);
        $this->user->setJSONString($this->getCompleteJSON());
    }
}