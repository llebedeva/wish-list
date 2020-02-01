<?php
namespace App\Domain;

use App\Domain\PostDataRequest;

class Wish
{
    private $wish;
    private $link;
    private $description;

    public function __construct($wish, $link, $description)
    {
        new PostDataRequest($wish, $link, $description);
        $this->wish = $wish;
        $this->link = $link;
        $this->description = $description;
    }
}
