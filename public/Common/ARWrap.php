<?php
/**
 * Created by PhpStorm.
 * User: Галина
 * Date: 09.08.2017
 * Time: 18:18
 */

namespace Common;


class ARWrap
{

    protected $pdo;

    public function __construct()
    {
        $this->pdo = AbstractRepository::getInstance();
    }

    public function getMany ($sql,$params = [])
    {
        return $this->pdo->queryAll($sql,$params);
    }
}