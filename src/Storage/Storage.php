<?php
namespace App\Storage;

use App\Domain\SortPriority;
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
        $sql = 'SELECT * FROM wish_table;';
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

    private function generateNewWishPriority() : int
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
        $priority = $this->generateNewWishPriority();

        $sql = "INSERT INTO wish_priority (wish_id, priority) 
            VALUES ('$wish_id', '$priority');";
        $this->execute($sql);
        $this->orderingWishesByPriority();
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

    public function updateWishOrder($old, $new) : void
    {
        $old = (int)$old;
        $new = (int)$new;
        $columnName = 'priority';
        $arr = ($old > $new) ?
            $this->upPriority($old, $new, $columnName) : $this->lowPriority($old, $new, $columnName);
        foreach ($arr as $row) {
            $sql = "UPDATE wish_priority
            SET
                priority={$row[$columnName]}
            WHERE wish_id={$row['wish_id']};";
            $this->execute($sql);
        }
        $this->orderingWishesByPriority();
    }

    private function lowPriority($old, $new, $columnName) : array
    {
        $sql = "SELECT * FROM wish_priority WHERE priority BETWEEN $old AND $new ORDER BY priority ASC;";
        $arr = $this->dbh->query($sql)->fetchAll();

        SortPriority::lowPriority($arr, $new, $columnName);
        return $arr;
    }

    private function upPriority($old, $new, $columnName) : array
    {
        $sql = "SELECT * FROM wish_priority WHERE priority BETWEEN $new AND $old ORDER BY priority ASC;";
        $arr = $this->dbh->query($sql)->fetchAll();

        SortPriority::upPriority($arr, $new, $columnName);
        return $arr;
    }

    public function deleteWish($id) : void
    {
        $sql = "DELETE FROM wishes 
            WHERE id='$id';";
        $this->execute($sql);

        $this->deleteWishPriority($id);
    }

    private function deleteWishPriority($wish_id) : void
    {
        $sql = "DELETE FROM wish_priority 
            WHERE wish_id='$wish_id';";
        $this->execute($sql);
        $this->orderingWishesByPriority();
    }

    private function orderingWishesByPriority() : void
    {
        $sql = "CREATE OR REPLACE VIEW wish_table AS
            SELECT
                W.id,
                W.wish,
                W.link,
                W.description,
                P.priority
            FROM
                wishes AS W
                    INNER JOIN wish_priority AS P
                               ON W.id = P.wish_id
            ORDER BY P.priority ASC;";
        $this->execute($sql);
    }
}
