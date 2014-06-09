<?php

//singleton - to forbid to open database connection a few times 
class Model
{
    protected static $_instance;
    public static $db;
    
    private function __construct(){}

    private function __clone(){}

    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            static::$_instance = new static;
        }
        static::initDbConnection();

        return self::$_instance;
    }

    private static function initDbConnection()
    {
        try {
            
            $db = new PDO('pgsql:host='.Container::get('params')->dbHost
                    .';dbname='.Container::get('params')->dbName, 
                    Container::get('params')->dbUser, 
                    Container::get('params')->dbPass
                );
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                static::$db = $db;
                
        } catch(PDOException $e) {
            echo $e->getMessage();
        }

        return;
    }

    protected function getAllRecords($table)
    {
        $table = str_replace(" ","",$table);
        $query = self::$db->prepare("SELECT *
                                     FROM ".$table);
        self::$db->beginTransaction();
            $query->execute();
        self::$db->commit();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function selectIn($table, $coloumn, $array)
    {
        $qMarks = str_repeat('?,', count($array)-1).'?';
        
        self::$db->beginTransaction();
            $selectQuery = self::$db->prepare("SELECT * FROM $table WHERE $coloumn IN ($qMarks)");
            $selectQuery->execute($array);
        self::$db->commit();

        return $selectQuery->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
