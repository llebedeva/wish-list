<?php
namespace App\Storage;

use App\Infrastructure\Config;

class Storage
{
    private $dbh;

    public function __construct()
    {
        $config = new Config();

        $host = $config->dbHost();
        $port = $config->dbPort();
        $database = $config->dbName();
        $charset = $config->dbCharset();
        $user = $config->dbUser();
        $password = $config->dbRootPassword();

        $this->dbh = new \PDO('mysql:host=' . $host . ';port=' . $port . ';dbname=' . $database . ';charset=' . $charset, $user, $password);
    }

    public function execute(string $sql)
    {
        $this->dbh->exec($sql);
    }

    public function getWishTable() : \PDOStatement
    {
        $sql = 'SELECT * FROM wishes';
        $stmt = $this->dbh->query($sql);
        return $stmt;
    }
}
