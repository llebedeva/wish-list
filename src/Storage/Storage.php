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
        $sql = 'SELECT * FROM wishes;';
        return $this->dbh->query($sql);
    }

    public function createWish($wish, $link, $description) : void
    {
        $sql = "INSERT INTO wishes (wish, link, description) 
            VALUES ('$wish', '$link', '$description');";
        $this->execute($sql);

        $wish_id = $this->dbh->lastInsertId();
        $this->insertWishPriority($wish_id);

    }

    public function updateWish($wish, $link, $description, $id) : void
    {
        $sql = "UPDATE wishes 
            SET wish='$wish', 
                link='$link', 
                description='$description', 
                modified_at=CURRENT_TIMESTAMP 
            WHERE id='$id';";
        $this->execute($sql);
    }

    public function deleteWish($id) : void
    {
        $sql = "DELETE FROM wishes 
            WHERE id='$id';";
        $this->execute($sql);

        $this->deleteWishPriority($id);
    }

    private function generateNextPriority() : int
    {
        if ($this->dbh->query("SELECT priority FROM wish_priority;")->rowCount() === 0) {
            return 0;
        }
        $sql = "SELECT MAX(priority) FROM wish_priority;";
        $maxPriority = $this->dbh->query($sql)->fetch()['MAX(priority)'];
        return (int)$maxPriority + 1;
    }

    private function insertWishPriority($wish_id) : void
    {
        $priority = $this->generateNextPriority();

        $sql = "INSERT INTO wish_priority (wish_id, priority) 
            VALUES ('$wish_id', '$priority');";
        $this->execute($sql);
    }

    private function deleteWishPriority($wish_id) : void
    {
        $sql = "DELETE FROM wish_priority 
            WHERE wish_id='$wish_id';";
        $this->execute($sql);
    }
}
