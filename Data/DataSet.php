<?php

namespace Flipside\Data;

class DataSet implements \ArrayAccess
{
    public function offsetSet($offset, $value): void
    {
        return;
    }

    public function offsetExists($offset): bool
    {
        return $this->tableExists($offset);
    }

    public function offsetUnset($offset): void
    {
        return;
    }

    public function offsetGet($offset): mixed
    {
        return $this->getTable($offset);
    }

    public function tableExists($name)
    {
        throw new \Exception('Unimplemented');
    }

    public function getTable($name)
    {
        throw new \Exception('Unimplemented');
    }

    public function raw_query($query)
    {
        throw new \Exception('Unimplemented');
    }

    public function quote(string $string, int $type = \PDO::PARAM_STR): string|false
    {
        throw new \Exception('Unimplemented');
    }
}

