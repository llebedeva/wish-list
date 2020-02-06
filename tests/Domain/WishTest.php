<?php
namespace App\Tests\Domain;

use App\Domain\Wish;
use App\Tests\SetUpTestCase;

class WishTest extends SetUpTestCase
{
    private const VALID_WISH = 'I wish something';
    private const VALID_LINK = 'https://ru.wikipedia.org/wiki/URL';
    private const VALID_DESCRIPTION = 'text message about my wish';

    public function testAddWishIfValidArguments()
    {
        $wish = self::VALID_WISH;
        $link = self::VALID_LINK;
        $description = self::VALID_DESCRIPTION;

        $obj = new Wish($wish, $link, $description);

        $this->assertInstanceOf(Wish::class, $obj);
    }

    public function testThrowsExceptionIfInvalidArguments()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Wish('', '', '');
    }

    public function testThrowsExceptionIfConnectionWasFailed()
    {
        $this->markTestSkipped();
    }
}
