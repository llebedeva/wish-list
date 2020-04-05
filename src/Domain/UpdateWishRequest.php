<?php
namespace App\Domain;

use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

class UpdateWishRequest extends CreateWishRequest
{
    private $wish;
    private $link;
    private $description;
    private $id;

    public function __construct(Request $request)
    {
        $this->wish = $request->request->get('wish');
        $this->link = $request->request->get('link');
        $this->description = $request->request->get('description');
        $this->id = $request->request->get('id');
        parent::__construct($request);
        $this->validateId($this->id);
    }

    private function validateId($id) : void
    {
        Assert::integerish($id);
        Assert::integer((int)$id);
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

    public function id() : int
    {
        return (int)$this->id;
    }
}
