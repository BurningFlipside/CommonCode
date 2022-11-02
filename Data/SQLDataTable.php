<?php
namespace Flipside\Data;

class SQLDataTable extends DataTable
{
    protected $dataset;
    protected $tablename;

    /**
     * @param SQLDataSet $dataset The dataset to create this datatable in
     * @param string $tablename The name of the table in the dataset
     */
    public function __construct($dataset, $tablename)
    {
        $this->dataset   = $dataset;
        $this->tablename = $tablename;
    }

    public function get_primary_key()
    {
        $res = $this->dataset->raw_query("SHOW INDEX FROM $this->tablename WHERE Key_name='PRIMARY'");
        if($res === false)
        {
            return false;
        }
        return $res[0]['Column_name'];
    }

    public function count($filter = false)
    {
        $where = false;
        if($filter !== false)
        {
            $where = $filter->to_sql_string($this->dataset);
        }
        $ret = $this->dataset->read($this->tablename, $where, 'COUNT(*)');
        if($ret === false || !isset($ret[0]) || !isset($ret[0]['COUNT(*)']))
        {
            return false;
        }
        else
        {
            return $ret[0]['COUNT(*)'];
        }
    }
  
    public function read($filter = false, $select = false, $count = false, $skip = false, $sort = false, $params = false)
    {
        $where = false;
        if($filter !== false)
        {
            if(is_string($filter))
            {
                $where = $filter;
            }
            else
            {
                $where = $filter->to_sql_string($this->dataset);
            }
        }
        if($select !== false && is_array($select))
        {
            $select = implode(',', $select);
        }
        return $this->dataset->read($this->tablename, $where, $select, $count, $skip, $sort);
    }

    public function update($filter, $data, $bypassQuote = false)
    {
        $where = $filter->to_sql_string($this->dataset);
        return $this->dataset->update($this->tablename, $where, $data, $bypassQuote);
    }

    public function create($data)
    {
        return $this->dataset->create($this->tablename, $data);
    }

    public function delete($filter)
    {
        $where = false;
        if($filter !== false)
        {
            $where = $filter->to_sql_string($this->dataset);
        }
        return $this->dataset->delete($this->tablename, $where);
    }

    public function raw_query($sql)
    {
        return $this->dataset->raw_query($sql);
    }

    public function getLastError()
    {
        return $this->dataset->getLastError();
    }
}
/* vim: set tabstop=4 shiftwidth=4 expandtab: */
