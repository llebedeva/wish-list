<?php
namespace App\Domain;

use Webmozart\Assert\Assert;

class PostDataRequest
{
    public function __construct($wish, $link, $description)
    {
        Assert::string($wish);
        Assert::stringNotEmpty($wish);
        Assert::maxLength($wish, 100);

        Assert::string($link);
        Assert::maxLength($link, 2048);

        Assert::string($description);
        Assert::maxLength($description, 2000);
    }
}
