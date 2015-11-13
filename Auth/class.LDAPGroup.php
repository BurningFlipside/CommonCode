<?php
namespace Auth;
require_once("/var/www/secure_settings/class.FlipsideSettings.php");

class LDAPGroup extends Group
{
    private $ldap_obj;
    private $server;

    function __construct($data)
    {
        $this->ldap_obj = $data;
        $this->server   = $this->ldap_obj->server;
        if($this->server === null)
        {
            $this->server = \LDAP\LDAPServer::getInstance();
        }
    }

    public function getGroupName()
    {
        return $this->ldap_obj->cn[0];
    }

    public function getDescription()
    {
        if(!isset($this->ldap_obj->description) || !isset($this->ldap_obj->description[0]))
        {
            return false;
        } 
        return $this->ldap_obj->description[0];
    }

    function setDescription($name)
    {
        if(!is_object($this->ldap_obj))
        {
            if($this->ldap_obj === false)
            {
                $this->ldap_obj = array();
            }
            $this->ldap_obj['description'] = $name;
        }
        else
        {
            $obj = array('dn'=>$this->ldap_obj->dn);
            $obj['description'] = $name;
            $this->ldap_obj->description = array($name);
            return $this->server->update($obj);
        }
    }

    public function getMemberUids($recursive=true)
    {
        $members = array();
        $raw_members = false;
        if(isset($this->ldap_obj['member']))
        {
            $raw_members = $this->ldap_obj['member'];
        }
        else if(isset($this->ldap_obj['uniquemember']))
        {
            $raw_members = $this->ldap_obj['uniquemember'];
        }
        else if(isset($this->ldap_obj['memberuid']))
        {
            $raw_members = $this->ldap_obj['memberuid'];
        }
        for($i = 0; $i < $raw_members['count']; $i++)
        {
            if($recursive && strncmp($raw_members[$i], 'cn=', 3) === 0)
            {
                $child = self::from_dn($raw_members[$i], $this->server);
                if($child !== false)
                {
                    $members = array_merge($members, $child->members());
                }
            }
            else
            {
                array_push($members, $raw_members[$i]);
            }
        }
        $count = count($members);
        for($i = 0; $i < $count; $i++)
        {
            $split = explode(',', $members[$i]);
            if(count($split) === 1)
            {
            }
            else if(strncmp('cn=', $split[0], 3) === 0)
            {
                $members[$i] = substr($split[0], 3);
            }
            else
            {
                $members[$i] = substr($split[0], 4);
            }
        }
        return $members;
    }

    public function members($details=false, $recursive=true)
    {
        $members = array();
        $raw_members = false;
        if(isset($this->ldap_obj['member']))
        {
            $raw_members = $this->ldap_obj['member'];
        }
        else if(isset($this->ldap_obj['uniquemember']))
        {
            $raw_members = $this->ldap_obj['uniquemember'];
        }
        else if(isset($this->ldap_obj['memberuid']))
        {
            $raw_members = $this->ldap_obj['memberuid'];
        }
        for($i = 0; $i < $raw_members['count']; $i++)
        {
            if($recursive && strncmp($raw_members[$i], 'cn=', 3) === 0)
            {
                $child = self::from_dn($raw_members[$i], $this->server);
                if($child !== false)
                {
                    $members = array_merge($members, $child->members());
                }
            }
            else
            {
                array_push($members, $raw_members[$i]);
            }
        }
        if($details === true)
        {
            $details = array();
            $count = count($members);
            for($i = 0; $i < $count; $i++)
            {
                $split = explode(',', $members[$i]);
                if(strncmp('cn=', $members[$i], 3) === 0)
                {
                    if(count($split) === 1)
                    {
                        $details[$i] = LDAPGroup::from_name($members[$i], $this->server);
                    }
                    else
                    {
                        $details[$i] = LDAPGroup::from_name(substr($split[0], 3), $this->server);
                    }
                }
                else
                {
                    if(count($split) === 1)
                    {
                        $details[$i] = LDAPUser::from_name($members[$i], $this->server);
                    }
                    else
                    {
                        $details[$i] = LDAPUser::from_name(substr($split[0], 4), $this->server);
                    }
                }
            }
            unset($members);
            $members = $details;
        }
        return $members;
    }

    public function getNonMemebers()
    {
        $data = array();
        $group_filter = '(&(cn=*)(!(cn='.$this->getGroupName().'))';
        $user_filter = '(&(cn=*)';
        $members = $this->members();
        $count = count($members);
        for($i = 0; $i < $count; $i++)
        {
            $dn_comps = explode(',',$members[$i]);
            if(strncmp($members[$i], "uid=", 4) == 0)
            {
                $user_filter.='(!('.$dn_comps[0].'))';
            }
            else
            {
                $group_filter.='(!('.$dn_comps[0].'))';
            }
        }
        $user_filter.=')';
        $group_filter.=')';
        $groups = $this->server->read($this->server->group_base, $group_filter);
        $count = count($groups);
        for($i = 0; $i < $count; $i++)
        {
            array_push($data, new LDAPGroup($groups[$i]));
        }
        $users = $this->server->read($this->server->user_base, $user_filter);
        $count = count($users);
        for($i = 0; $i < $count; $i++)
        {
            array_push($data, new LDAPUser($users[$i]));
        } 
        return $data;
    }

    public function addMember($name, $isGroup=false)
    {
        $dn = false;
        if($isGroup)
        {
            $dn = 'cn='.$name.','.$this->server->group_base;
        }
        else
        {
            $dn = 'uid='.$name.','.$this->server->user_base;
        }
        $raw_members = false;
        $propName = false;
        if(isset($this->ldap_obj['member']))
        {
            $raw_members = $this->ldap_obj['member'];
            $propName = 'member';
        }
        else if(isset($this->ldap_obj['uniquemember']))
        {
            $raw_members = $this->ldap_obj['uniquemember'];
            $propName = 'uniquemember';
        }
        else if(isset($this->ldap_obj['memberuid']))
        {
            $raw_members = $this->ldap_obj['memberuid'];
            $propName = 'memberuid';
        }
        if(in_array($dn, $raw_members) || in_array($name, $raw_members))
        {
            return true;
        }
        if($propName === 'memberuid')
        {
            if($isGroup)
            {
                throw new \Exception('Unable to add a group as a child of this group type');
            }
            array_push($raw_members, $name);
        }
        else
        {
            array_push($raw_members, $dn);
        }
        $obj = array('dn'=>$this->ldap_obj->dn);
        $obj[$propName] = $raw_members;
        $this->ldap_obj->$propName = array($raw_members);
        return $this->server->update($obj);
    }

    static function from_dn($dn, $data=false)
    {
        if($data === false)
        {
            throw new \Exception('data must be set for LDAPGroup');
        }
        $group = $data->read($dn, false, true);
        if($group === false || !isset($group[0]))
        {
            return false;
        }
        return new static($group[0]);
    }

    static function from_name($name, $data=false)
    {
        if($data === false)
        {
            throw new \Exception('data must be set for LDAPGroup');
        }
        $filter = new \Data\Filter("cn eq $name");
	$group = $data->read($data->group_base, $filter);
        if($group === false || !isset($group[0]))
        {
            return false;
        }
        return new static($group[0]);
    }
}
?>
