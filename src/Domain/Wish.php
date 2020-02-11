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
}
