<?php

namespace app\core;

final class DbManager extends \PDO
{
    /**
     * @param string $sql
     * @param array $params
     * @return array|null
     */
    public function queryWithParams(string $sql, array $params = [])
    {
        $query = $this->prepare($sql);
        $query->execute($params);

        return $query->fetch(self::FETCH_ASSOC) ?: null;
    }
}
