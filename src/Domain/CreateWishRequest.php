<?php
namespace App\Domain;

use Webmozart\Assert\Assert;

class CreateWishRequest
{
    public function __construct($wish, $link, $description)
    {
        $this->validateWish($wish);
        $this->validateLink($link);
        $this->validateDescription($description);
    }

    protected function validateWish($wish) : void
    {
        Assert::string($wish);
        Assert::stringNotEmpty($wish);
        Assert::maxLength($wish, 100);
    }

    protected function validateLink($link) : void
    {
        Assert::string($link);
        Assert::maxLength($link, 2048);
    }

    protected function validateDescription($description) : void
    {
        Assert::string($description);
        Assert::maxLength($description, 2000);
    }
}
