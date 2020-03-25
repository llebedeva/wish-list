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
        return $this->dbh->query($sql);
    }

    public function createWish($wish, $link, $description, $priority)
    {
        $storage = new Storage();
        $sql = "INSERT INTO wishes (wish, link, description, priority) 
            VALUES ('$wish', '$link', '$description', '$priority');";
        $storage->execute($sql);
    }

    public function updateWish($wish, $link, $description, $id)
    {
        $storage = new Storage();
        $sql = "UPDATE wishes 
            SET wish='$wish', link='$link', description='$description', modified_at=CURRENT_TIMESTAMP 
            WHERE id='$id';";
        $storage->execute($sql);
    }

    public function deleteWish($id)
    {
        $storage = new Storage();
        $sql = "DELETE FROM wishes 
            WHERE id='$id';";
        $storage->execute($sql);
    }

    public function getMaxWishPriority() : \PDOStatement
    {
        $sql = "SELECT MAX(priority) FROM wishes;";
        return $this->dbh->query($sql);
    }
}
