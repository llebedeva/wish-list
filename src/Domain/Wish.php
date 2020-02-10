<?php
namespace App\Domain;

use App\Storage\Storage;

class Wish
{
    private $wish;
    private $link;
    private $description;

    public function __construct($wish, $link, $description)
    {
        $this->wish = $wish;
        $this->link = $link;
        $this->description = $description;
    }

    public function getWish()
    {
        return $this->wish;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function validate()
    {
        new PostDataRequest($this->wish, $this->link, $this->description);
    }

    public function saveToStorage()
    {
        $storage = new Storage();
        $sql = "INSERT INTO wishes (wish, link, description) VALUES ('" . $this->wish . "', '" . $this->link . "', '" . $this->description . "');";
        $storage->execute($sql);
    }

    public static function getTable() : array
    {
        $storage = new Storage();
        $sql = 'SELECT * FROM wishes';
        $stmt = $storage->query($sql);
        $list = [];
        while ($row = $stmt->fetch())
        {
            $list[] = new Wish($row['wish'], $row['link'], $row['description']);
        }
        return $list;
    }
}
