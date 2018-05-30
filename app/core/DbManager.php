<?php

namespace app\core;

final class DbManager extends \PDO
{
    /**
     * @param string $sql
     * @param array $params
     * @return \PDOStatement
     */
    public function prepareWithParams(string $sql, array $params = []): \PDOStatement
    {
        $query = $this->prepare($sql);
        $query->execute($params);

        return $query;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array|null
     */
    public function fetchOne(string $sql, array $params = [])
    {
        return $this->prepareWithParams($sql, $params)->fetch(self::FETCH_ASSOC);
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array|null
     */
    public function fetchAll(string $sql, array $params = [])
    {
        return $this->prepareWithParams($sql, $params)->fetchAll(self::FETCH_ASSOC);
    }
}
