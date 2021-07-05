<?php
// Justin PHP Framework
// (c)2021 SuperSonic(https://randychen.tk)

require_once __DIR__ . '/Config.php';
require_once __DIR__ . '/DuplicateResultException.php';

class Database
{
    private PDO $client;

    public function __construct(Config $config)
    {
        $this->client = new PDO(
            $config->get("DB_DSN"),
            $config->get("DB_USERNAME"),
            $config->get("DB_PASSWORD")
        );
    }

    public function getClient(): PDO
    {
        return $this->client;
    }

    public static function bindParamsFilled(object $stmt, array $data)
    {
        foreach ($data as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }
    }

    public static function bindParamsSafe(object $stmt, array $data, array $fields)
    {
        foreach ($fields as $key) {
            $stmt->bindParam(":$key", $data[$key]);
        }
    }
}