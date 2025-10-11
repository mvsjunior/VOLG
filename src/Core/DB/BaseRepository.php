<?php

namespace Core\DB;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Sql;

class BaseRepository {
    protected AdapterInterface $adapter;
    protected Sql $sql;
    protected string $table;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        $this->sql = new Sql($adapter);
    }

    public function fetchById(int $id, array $columns = ['*']): ?array
    {
        $select = $this->sql->select($this->table)
            ->columns($columns)
            ->where(['id' => $id]);

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result->getAffectedRows() === 0) {
            return null;
        }

        return $result->current();
    }

    public function fetchAll(array $columns = ['*']): ?array
    {
        $select = $this->sql->select($this->table)
            ->columns($columns);

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result->getAffectedRows() === 0) {
            return null;
        }

        return $result->current();
    }
}