<?php
namespace Flipside\Auth;

class SQLUser extends User
{
    private $data;
    private $auth;

    /**
     * Initialize a SQLUser object
     *
     * @param boolean|array $data The data to initialize the SQLUser with or false for an empty User
     * @param boolean|\Auth\SQLAuthenticator The SQLAuthenticator instance that produced this user
     */
    public function __construct($data = false, $auth = false)
    {
        $this->data = array();
        $this->auth = $auth;
        if($data !== false)
        {
            $this->data = $data;
            if(isset($data['extended']))
            {
                $this->data = $data['extended'];
            }
        }
        if(isset($this->data['title']))
        {
            $this->data['title'] = explode(',', $this->data['title']);
        }
        if(isset($this->data['ou']))
        {
            $this->data['ou'] = explode(',', $this->data['ou']);
        }
        if(isset($this->data['host']))
        {
            $this->data['host'] = explode(',', $this->data['host']);
        }
    }

    public function getGroups()
    {
        if($this->auth === false)
        {
            return false;
        }
        $dt = $this->auth->dataSet['groupUserMap'];
        $sqlMemberData = $dt->read(new \Flipside\Data\Filter("uid eq \"$this->uid\""));
        if(empty($sqlMemberData))
        {
            return false;
        }
        $res = array();
        $count = count($sqlMemberData);
        for($i = 0; $i < $count; $i++)
        {
            array_push($res, new SQLGroup($sqlMemberData[$i], $this->auth));
        }
        return $res;
    }

    public function isInGroupNamed($name)
    {
        if($this->auth === false)
        {
            return false;
        }
        $group = $this->auth->getGroupByName($name);
        if($group === null)
        {
            return false;
        }
        return $group->hasMemberUID($this->uid);
    }

    public function getPasswordResetHash()
    {
        $filter = new \Flipside\Data\Filter('uid eq "'.$this->uid.'"');
        $userDT = $this->auth->getCurrentUserDataTable();
        $data = $userDT->read($filter);
        if(strlen($data[0]['userPassword']) === 0)
        {
             $data[0]['userPassword'] = openssl_random_pseudo_bytes(10);
        }
        $hash = hash('sha512', $data[0]['uid'].';'.$data[0]['userPassword'].';'.$data[0]['mail']);
        $update = array('resetHash' => $hash);
        $res = $userDT->update($filter, $update);
        if($res === false)
        {
            throw new \Exception('Unable to create hash in SQL User!');
        }
        return $hash;
    }

    public function __get($propName)
    {
        if(isset($this->data[$propName]))
        {
            return $this->data[$propName];
        }
        return false;
    }

    public function __set($propName, $value)
    {
        $filter = new \Flipside\Data\Filter('uid eq "'.$this->uid.'"');
        $userDT = $this->auth->getCurrentUserDataTable();
        $data = array($propName => $value);
        $res = $userDT->update($filter, $data);
        if($res === true)
        {
            $this->data[$propName] = $value;
        }
    }

    public function validate_reset_hash($hash)
    {
        if(isset($this->data['resetHash']) && strcmp($hash, $this->data['resetHash']) == 0)
        {
            return true;
        }
        return false;
    }

    protected function setPass($password)
    {
        $filter = new \Flipside\Data\Filter('uid eq "'.$this->uid.'"');
        $userDT = $this->auth->getCurrentUserDataTable();
        $data = array('userPassword' => \password_hash($password, \PASSWORD_DEFAULT));
        return $userDT->update($filter, $data);
    }

    public function validate_password($password)
    {
        if(isset($this->data['userPassword']) && $this->verifyPass($password, $this->data['userPassword']))
        {
            return true;
        }
        //Check the DB since we remove this from the in session copy
        $filter = new \Flipside\Data\Filter('uid eq "'.$this->uid.'"');
        $userDT = $this->auth->getCurrentUserDataTable();
        $data = $userDT->read($filter, array('userPassword'));
        return $this->verifyPass($password, $data[0]['userPassword']);
    }

    public function delete()
    {
        $filter = new \Flipside\Data\Filter('uid eq "'.$this->uid.'"');
        $userDT = $this->auth->getCurrentUserDataTable();
        return $userDT->delete($filter);
    }

    private function verifyPass($givenPass, $savedPass)
    {
        //Is this in the even better PHP bcrypt hash format?
        if(\password_verify($givenPass, $savedPass))
        {
            return true;
        }
        //Is it in the slightly less secure, but still good LDAP format?
        if(substr($savedPass, 0, 6) === "{SSHA}")
        {
            return $this->verifyLDAPSHAAPass($givenPass, $savedPass);
        }
        //Didn't pass password_verify and not in LDAP format
        return false;
    }

    private function hashLDAPPassword($password, $salt)
    {
        $shaHashed = sha1($password.$salt);
        $packed = pack("H*",$shaHashed);
        $encoded = base64_encode($packed.$salt);
        return "{SSHA}".$encoded;
    }

    private function verifyLDAPSHAAPass($givenPass, $sshaHash)
    {
        //Remove {SSHA} from start
        $encodedString = substr($sshaHash, 6);
        $decoded = base64_decode($encodedString);
        //Get the salt, SHA1 is always 20 chars
        $salt = substr($decoded, 20);
        //hash the password given and compare it to the saved password hash
        return $this->hashLDAPPassword($givenPass, $salt) == $sshaHash;
    }
}
/* vim: set tabstop=4 shiftwidth=4 expandtab: */
