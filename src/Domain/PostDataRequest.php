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

    public function validate() : void
    {
        Assert::string($this->wish);
        Assert::stringNotEmpty($this->wish);
        Assert::maxLength($this->wish, 100);

        Assert::string($this->link);
        Assert::maxLength($this->link, 2048);

        Assert::string($this->description);
        Assert::maxLength($this->description, 2000);
    }
}
