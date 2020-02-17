<?php
namespace App\Domain;

use Webmozart\Assert\Assert;

class UpdateWishRequest extends CreateWishRequest
{
    public function __construct($wish, $link, $description, $id)
    {
        parent::__construct($wish, $link, $description);
        $this->validateId($id);
    }

    private function validateId($id)
    {
        Assert::integer($id);
    }
}
