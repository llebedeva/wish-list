<?php
namespace App\Domain;

use Webmozart\Assert\Assert;

class DeleteWishRequest
{
    public function __construct($id)
    {
        $this->validateId($id);
    }

    private function validateId($id) : void
    {
        Assert::string($id);
        Assert::stringNotEmpty($id);
    }
}
