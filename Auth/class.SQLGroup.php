<?php
namespace Auth;

class SQLGroup extends Group
{
    private $data;

    function __construct($data)
    {
        $this->data = $data;
    }

    public function getGroupName()
    {
        if(isset($data['gid']))
        {
            return $data['gid'];
        }
        return false;
    }

    public function getDescription()
    {
        if(isset($data['description']))
        {
            return $data['description'];
        }
        return false;
    }

    public function getMemberUids()
    {
        return $this->members(false);
    }

    public function members($details=false)
    {
        //TODO
        return array();
    }
}
?>
