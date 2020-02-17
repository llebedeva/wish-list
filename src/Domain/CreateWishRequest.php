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

    protected function validateWish($wish)
    {
        Assert::string($wish);
        Assert::stringNotEmpty($wish);
        Assert::maxLength($wish, 100);
    }

    protected function validateLink($link)
    {
        Assert::string($link);
        Assert::maxLength($link, 2048);
    }

    protected function validateDescription($description)
    {
        Assert::string($description);
        Assert::maxLength($description, 2000);
    }
}
