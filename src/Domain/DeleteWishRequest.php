<?php
namespace App\Domain;

use Webmozart\Assert\Assert;

class DeleteWishRequest
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
        $this->validateId($this->id);
    }

    private function validateId($id) : void
    {
        Assert::integerish($id);
        Assert::integer((int)$id);
    }

    public function id() : int
    {
        return (int)$this->id;
    }
}
