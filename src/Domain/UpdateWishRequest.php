<?php
namespace App\Domain;

class UpdateWishRequest extends CreateWishRequest
{
    public function __construct($wish, $link, $description)
    {
        parent::__construct($wish, $link, $description);
    }
}
