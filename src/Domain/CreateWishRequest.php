<?php
namespace App\Domain;

use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

class CreateWishRequest
{
    private $wish;
    private $link;
    private $description;

    public function __construct(Request $request)
    {
        $this->wish = $request->request->get('wish');
        $this->link = $request->request->get('link');
        $this->description = $request->request->get('description');
        $this->validateWish($this->wish);
        $this->validateLink($this->link);
        $this->validateDescription($this->description);
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
