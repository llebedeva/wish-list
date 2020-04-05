<?php
namespace App\Domain;

use Webmozart\Assert\Assert;

class ChangeOrderRequest
{
    public function __construct($old, $new)
    {
        $this->validatePriority($old);
        $this->validatePriority($new);
        Assert::notEq($old, $new);
    }

    private function validatePriority($value) : void
    {
        Assert::integerish($value);
        Assert::integer((int)$value);
    }

}
