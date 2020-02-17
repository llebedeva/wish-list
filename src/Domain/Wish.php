<?php
namespace App\Domain;

use App\Storage\Storage;
use Webmozart\Assert\Assert;

class Wish
{
    private $id;
    private $wish;
    private $link;
    private $description;

    public function __construct($wish, $link, $description, $id=null)
    {
        $this->wish = $wish;
        $this->link = $link;
        $this->description = $description;
        $this->id = $id;
    }

    public function validate()
    {
        new PostDataRequest($this->wish, $this->link, $this->description);
    }

    public function isIdNotNull()
    {
        Assert::notNull($this->id);
    }

    public function saveToStorage()
    {
        $storage = new Storage();
        $sql = "INSERT INTO wishes (wish, link, description) VALUES ('" . $this->wish . "', '" . $this->link . "', '" . $this->description . "');";
        $storage->execute($sql);
    }

    public function updateInStorage()
    {
        $storage = new Storage();
        $sql = "UPDATE wishes SET wish='" . $this->wish . "', link='" . $this->link . "', description='" . $this->description . "', modified_at=CURRENT_TIMESTAMP WHERE id='" . $this->id . "';";
        $storage->execute($sql);
    }

    public function deleteFromStorage()
    {
        $storage = new Storage();
        $sql = "DELETE FROM wishes WHERE id='" . $this->id . "';";
        $storage->execute($sql);
    }
}
