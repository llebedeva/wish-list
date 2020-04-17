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

        $this->dbh = new \PDO("mysql:host=$host;port=$port;dbname=$database;charset=$charset", $user, $password);
    }

    public function getWishTable() : \PDOStatement
    {
        $sql = 'SELECT * FROM wish_table;';
        return $this->dbh->query($sql);
    }

    public function getWish($id) : \PDOStatement
    {
        $sql = "SELECT * FROM wish_table WHERE id = '$id';";
        return $this->dbh->query($sql);
    }

    public function createWish($wish, $link, $description) : int
    {
        $sql = "INSERT INTO wishes (wish, link, description) 
            VALUES ('$wish', '$link', '$description');";
        $this->dbh->exec($sql);

        $wish_id = $this->dbh->lastInsertId();
        $this->insertWishPriority($wish_id);
        return $wish_id;
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
        $this->dbh->exec($sql);
        $this->orderingWishesByPriority();
    }

    public function updateWish($wish, $link, $description, $id) : void
    {
        $sql = "UPDATE wishes 
            SET wish = '$wish', 
                link = '$link', 
                description = '$description', 
                modified_at = CURRENT_TIMESTAMP 
            WHERE id = '$id';";
        $this->dbh->exec($sql);
    }

    public function updateWishOrder($old, $new) : void
    {
        $old = (int)$old;
        $new = (int)$new;
        if ($old > $new) {
            $arr = $this->getPrioritiesBetween($new, $old);
            SortPriority::putIndexToTop($arr, $new);
        } else {
            $arr = $this->getPrioritiesBetween($old, $new);
            SortPriority::putIndexToBottom($arr, $new);
        }
        $this->deleteWishPriorities($arr);
        $this->insertWishPriorities($arr);
        $this->orderingWishesByPriority();
    }

    private function getPrioritiesBetween($x, $y) : array
    {
        $sql = "SELECT * FROM wish_priority WHERE priority BETWEEN $x AND $y ORDER BY priority ASC;";
        return $this->dbh->query($sql)->fetchAll();
    }

    public function deleteWish($id) : void
    {
        $sql = "DELETE FROM wishes 
            WHERE id = '$id';";
        $this->dbh->exec($sql);

        $this->updateWishPriorities($id);
    }

    private function updateWishPriorities($wish_id) : void
    {
        $this->moveUpLowerPriorities($wish_id);

        $sql = "DELETE FROM wish_priority 
            WHERE wish_id = '$wish_id';";
        $this->dbh->exec($sql);

        $this->orderingWishesByPriority();
    }

    private function moveUpLowerPriorities($wish_id) : void
    {
        $sql = "SELECT * FROM wish_priority WHERE priority > 
                                  (SELECT priority FROM wish_priority where wish_id = $wish_id);";
        $arr = $this->dbh->query($sql)->fetchAll();
        SortPriority::moveUpAllIndexesByOneStep($arr);

        $this->deleteWishPriorities($arr);
        $this->insertWishPriorities($arr);
    }

    private function deleteWishPriorities($arr) : void
    {
        $arr_id = [];
        foreach ($arr as $row) {
            array_push($arr_id, $row['wish_id']);
        }
        $sql = "DELETE FROM wish_priority 
            WHERE wish_id IN (".implode(", ", $arr_id).");";
        $this->dbh->exec($sql);
    }

    private function insertWishPriorities($arr) : void
    {
        $arr_pair = [];
        foreach ($arr as $row) {
            array_push($arr_pair,  "{$row['wish_id']}, {$row['priority']}");
        }
        $sql = "INSERT INTO wish_priority (wish_id, priority)
        VALUES
            (".implode("), (", $arr_pair).");";
        $this->dbh->exec($sql);
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
        $this->dbh->exec($sql);
    }
}
