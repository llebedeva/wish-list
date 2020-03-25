<?php
namespace App\Domain;

use Webmozart\Assert\Assert;

class UpdateWishRequest extends CreateWishRequest
{
    public function __construct($wish, $link, $description, $priority, $id)
    {
        parent::__construct($wish, $link, $description, $priority);
        $this->validateId($id);
    }

    private function validateId($id) : void
    {
        Assert::integerish($id);
        Assert::integer((int)$id);
    }
}
