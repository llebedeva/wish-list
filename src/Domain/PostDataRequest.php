<?php


namespace App\Domain;

use Webmozart\Assert\Assert;


class PostDataRequest
{
    private $wish;
    private $link;
    private $description;

    public function __construct($wish, $link, $description)
    {
        Assert::string($wish);
        Assert::stringNotEmpty($wish);
        Assert::maxLength($wish, 100);

        Assert::string($link);
        Assert::maxLength($link, 2048);

        Assert::string($description);
        Assert::maxLength($description, 2000);
        $this->wish = $wish;
        $this->link = $link;
        $this->description = $description;
    }

    public function wish() : string
    {
        return $this->wish;
    }

    public function link() : string
    {
        return $this->link;
    }

    public function description() : string
    {
        return $this->description;
    }
}
