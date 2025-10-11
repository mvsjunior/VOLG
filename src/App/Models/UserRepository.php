<?php

namespace App\Models;

use Core\DB\BaseRepository;
use Laminas\Db\Adapter\AdapterInterface;

class UserRepository extends BaseRepository
{
    public function __construct(AdapterInterface $adapter)
    {
        parent::__construct($adapter);
        $this->table = 'users';
    }

    public function fetchAllActive(): array
    {
        $select = $this->sql->select($this->table)
            ->columns(['id', 'name', 'email']);

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        $out = [];
        foreach ($result as $row) {
            $out[] = $row;
        }
        return $out;
    }
}
