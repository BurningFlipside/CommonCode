<?php
namespace Data;

class FilterClause
{
    public $var1;
    public $var2;
    public $op;

    function __construct($string=false)
    {
        if($string !== false) $this->process_filter_string($string);
    }

    static function str_startswith($haystack, $needle)
    {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }

    protected function process_filter_string($string)
    {
        if(self::str_startswith($string, 'substringof') || self::str_startswith($string, 'contains'))
        {
            $this->op   = strtok($string, '(');
            $this->var1 = strtok(',');
            $this->var2 = strtok(')');
            return;
        }
        $field = strtok($string, ' ');
        $op = strtok(' ');
        $rest = strtok("\0");
        switch($op)
        {
            case 'ne':
                $op = '!=';
                break;
            case 'eq':
                $op = '=';
                break;
            case 'lt':
                $op = '<';
                break;
            case 'le':
                $op = '<=';
                break;
            case 'gt':
                $op = '>';
                break;
            case 'ge':
                $op = '>=';
                break;
        }
        $this->var1  = $field;
        $this->op    = $op;
        $this->var2  = $rest;
    }

    function to_sql_string()
    {
        $str = '';
        switch($this->op)
        {
            case 'substringof':
            case 'contains':
                $str = $this->var1.' LIKE \'%'.trim($this->var2,"'").'%\'';
                break;
            default:
                $str = $this->var1.$this->op.$this->var2;
                break;
        }
        return $str;
    }

    function to_ldap_string()
    {
        $str = '(';
        switch($this->op)
        {
            case 'substringof':
            case 'contains':
                $str.=$this->var1.$this->op.'*'.trim($this->var2,"'").'*';
                break;
            case '!=':
                $str.='!('.$this->var1.'='.$this->var2.')';
                break;
            default:
                $str.=$this->var1.$this->op.$this->var2;
                break;
        }
        return $str.')';
    }

    function to_mongo_filter()
    {
        $this->var2 = trim($this->var2, "'");
        if($this->var1 === '_id')
        {
            $this->var2 = new \MongoId($this->var2);
        }
        switch($this->op)
        {
            case '!=':
                return array($this->var1=>array('$ne'=>$this->var2));
            case '=':
                return array($this->var1=>$this->var2);
            case '<';
                return array($this->var1=>array('$lt'=>$this->var2));
            case '<=':
                return array($this->var1=>array('$lte'=>$this->var2));
            case '>':
                return array($this->var1=>array('$gt'=>$this->var2));
            case '>=':
                return array($this->var1=>array('$gte'=>$this->var2));
            case 'substringof':
                return array($this->var1=>array('$regex'=>new MongoRegex('/'.$this->var2.'/i')));
        }
    }

    function php_compare($value)
    {
        switch($this->op)
        {
            case '!=':
                return $value != $this->var2;
            case '=':
                return $value == $this->var2;
            case '<':
                return $value < $this->var2;
            case '<=':
                return $value <= $this->var2;
            case '>':
                return $value > $this->var2;
            case '>=':
                return $value >= $this->var2;
        }
    }
}
?>
