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

    public function execute(string $sql) : void
    {
        $this->dbh->exec($sql);
    }

    public function getWishTable() : \PDOStatement
    {
        $sql = 'SELECT * FROM wishes ORDER BY priority ASC;';
        return $this->dbh->query($sql);
    }

    public function createWish($wish, $link, $description, $priority) : void
    {
        $sql = "INSERT INTO wishes (wish, link, description, priority) 
            VALUES ('$wish', '$link', '$description', '$priority');";
        $this->execute($sql);
    }

    public function updateWish($wish, $link, $description, $priority, $id) : void
    {
        $sql = "UPDATE wishes 
            SET wish='$wish', 
                link='$link', 
                description='$description', 
                priority='$priority', 
                modified_at=CURRENT_TIMESTAMP 
            WHERE id='$id';";
        $this->execute($sql);
    }

    public function deleteWish($id) : void
    {
        $sql = "DELETE FROM wishes 
            WHERE id='$id';";
        $this->execute($sql);
    }

    public function getMaxWishPriority() : \PDOStatement
    {
        $sql = "SELECT MAX(priority) FROM wishes;";
        return $this->dbh->query($sql);
    }
}
