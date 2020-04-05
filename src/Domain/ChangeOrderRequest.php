<?php
namespace App\Domain;

use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

class ChangeOrderRequest
{
    private $old;
    private $new;

    public function __construct(Request $request)
    {
        $this->old = $request->request->get('old');
        $this->new = $request->request->get('new');
        $this->validatePriority($this->old);
        $this->validatePriority($this->new);
        Assert::notEq($this->old, $this->new);
    }

    private function validatePriority($value) : void
    {
        Assert::integerish($value);
        Assert::integer((int)$value);
    }

    public function old() : int
    {
        return (int)$this->old;
    }

    public function new() : int
    {
        return (int)$this->new;
    }
}
