<?php
/**
 * Created by PhpStorm.
 * User: Галина
 * Date: 09.08.2017
 * Time: 16:01
 */

namespace Common;


class AbstractRepository
{
    /**
     * Экземпляр класса PDO
     *
     * @var \PDO
     */
    public $database;

    protected static $instance;

    protected function __construct()
    {
        $this->database = new \PDO('sqlite:../test/database.sqlite') or die;
    }

    public static function getInstance ()
    {
        if (self::$instance === null)
        {
            self::$instance = new self;
        }
        return self::$instance;
    }

    //models_functions

    /**
     * Запрос к БД на выгрузку набора данных
     *
     * @param string $query Запрос к базе данных
     * @param array $params Параметры запроса
     * @return array Результирующее множество
     */
    public function queryAll($query, $params = [])
    {
        $statement = $this->database->prepare($query);
        if (!empty($params))
        {
            foreach ($params as $parameter => $value) {
                $statement->bindValue($parameter, $value);
            }
        }
        $result = $statement->execute();
        if ($result !== false)
        {
            //var_dump($result);
            return $statement->fetchAll(\PDO::FETCH_ASSOC);

        }
        return [];
    }

    /**
     * Запрос к БД на выгрузку записи с данными
     *
     * @param string $query Запрос к базе данных
     * @param array $params Параметры запроса
     * @return array Результирующая запись
     */
    public function getOne($query, array $params = array())
    {
        $statement = $this->database->prepare($query);
        foreach ($params as $parameter => $value) {
            $statement->bindValue($parameter, $value);
        }
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

}
