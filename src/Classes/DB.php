<?php


class DB
{
    static private $db_connection;

    private $saved_result, $saved_prepare;

    /**
     * DB constructor.
     * @param $saved_result
     * @param $saved_prepare
     */
    public function __construct($saved_result, $saved_prepare)
    {
        $this->saved_result = $saved_result;
        $this->saved_prepare = $saved_prepare;
    }


    public static function connected() {
        return self::$db_connection;
    }

    static function connect() {
        if (!self::connected()) {
            try {
                self::$db_connection = new PDO('mysql:host=localhost;dbname=test', 192213, 'Cedric1391');
                self::$db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Connection failed: ' . $e->getMessage());
            }
        }
        return self::$db_connection;
    }

    static function prepare($sql, $values = array()) {
        return new self($sql, $values);
    }

    protected function querySetup($sql) {
        self::connect();
        try {
            return self::$db_connection->query($sql);
        } catch (PDOException $e) {
            echo('Error: ' . $e->getMessage());
            die();
        }
    }

    public static function query($sql) {
        return new self($sql);
    }
}