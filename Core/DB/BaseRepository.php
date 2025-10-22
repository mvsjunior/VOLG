<?php

namespace Core\DB;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Expression;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\Select;
use Laminas\Paginator\Paginator;
use Laminas\Paginator\Adapter\DbSelect;

class BaseRepository {
    protected AdapterInterface $adapter;
    protected Sql $sql;
    protected string $table;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        $this->sql = new Sql($adapter);
    }

    public function create(array $values = []){
        $insert = $this->sql->insert($this->table)->values($values);
        $statement = $this->sql->prepareStatementForSqlObject($insert);
        return $statement->execute();
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

    public function deleteById(int $id){
        $select = $this->sql->delete($this->table)->where(['id' => $id]);

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return $result->getAffectedRows();
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

        $rows = [];

        foreach($result as $row){
            $rows[] = $row;
        }

        return $rows;
    }

    public function fetchAllPaginated(array $columns = ['*'], int $perPage = 8, int $page = 1){
               
        $totalRegisters = $this->getTotalRegisters($this->sql->select($this->table)->columns($columns)->where(['id' => new Expression('id > 3')]));
        $infoMetaPage = $this->getMetaPage($perPage,$totalRegisters);
        
        $offset = $page <= 1  ? 0 : ($page * $perPage) - $perPage;

        $select = $this->sql->select($this->table)
            ->columns($columns)->where(['name' => 'Mauro'])->limit($perPage)->offset($offset);

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        $rows = [];
        foreach($result as $row){
            $rows[] = $row;
        }

        $infoMetaPage['data'] = $rows;
        return $infoMetaPage;

    }

    public function getTotalRegisters(Select $select): int{

        $select->columns([
            'count' => new Expression('COUNT(id)')
        ]);

        if(!empty($where)){
            $select->where($where);
        }

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result->getAffectedRows() === 0) {
            return 0;
        }

        return $result->current()['count'];
    }

    public function getMetaPage(int $perPage = 10, int $totalRegisters = 0){
        if($perPage > 0 && $totalRegisters > 0){
            $totalInt = floor($totalRegisters / $perPage);
            $totalDecimal = ($totalRegisters / $perPage) - $totalInt;
            $pages = $totalDecimal > 0 ? $totalInt + 1 : $totalInt;
        }else{
            $pages = 1;
        }

        return [
            "pages" => $pages,
            "total" => $totalRegisters,
            "page" => 1
        ];
    }
}