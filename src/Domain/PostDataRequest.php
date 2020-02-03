<?php
namespace App\Domain;

use Webmozart\Assert\Assert;

class PostDataRequest
{
    public function __construct($wish, $link, $description)
    {
        $this->validateWish($wish);
        $this->validateLink($link);
        $this->validateDescription($description);
    }

    private function validateWish($wish)
    {
        Assert::string($wish);
        Assert::stringNotEmpty($wish);
        Assert::maxLength($wish, 100);
    }

    private function validateLink($link)
    {
        Assert::string($link);
        Assert::maxLength($link, 2048);
    }

    private function validateDescription($description)
    {
        Assert::string($description);
        Assert::maxLength($description, 2000);
    }
}
