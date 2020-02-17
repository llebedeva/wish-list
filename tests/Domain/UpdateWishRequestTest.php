<?php
namespace App\Tests\Domain;

use App\Domain\UpdateWishRequest;
use PHPUnit\Framework\TestCase;

class UpdateWishRequestTest extends TestCase
{
    private const VALID_WISH = 'I wish something';
    private const VALID_LINK = 'https://ru.wikipedia.org/wiki/URL';
    private const VALID_DESCRIPTION = 'text message about my wish';
    private const VALID_ID = 15;

    private const TOO_LONG_WISH = 'RIXviHKDcR9RZry5x8EyrM117hnBGWFdoTTNPEiVhe3qDODHjJwX75sFdRJ502KtkdLJ65PKcIjjHN5O8MU2IwlMgCtQAdP4xMxA9';
    private const TOO_LONG_LINK = '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';
    private const TOO_LONG_DESCRIPTION = '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';

    public function testSuccessIfVaidAgruments()
    {
        $wish = self::VALID_WISH;
        $link = self::VALID_LINK;
        $description = self::VALID_DESCRIPTION;
        $id = self::VALID_ID;

        $request = new UpdateWishRequest($wish, $link, $description, $id);

        $this->assertInstanceOf(UpdateWishRequest::class, $request);
    }

    /**
     * @dataProvider providerInvalidArguments
     */
    public function testThrowsExceptionIfInvalidArguments($wish, $link, $description, $id)
    {
        $this->expectException(\InvalidArgumentException::class);

        new UpdateWishRequest($wish, $link, $description, $id);
    }

    public function providerInvalidArguments()
    {
        return [
            ['', self::VALID_LINK, self::VALID_DESCRIPTION, self::VALID_ID],

            [self::TOO_LONG_WISH, self::VALID_LINK, self::VALID_DESCRIPTION, self::VALID_ID],
            [self::VALID_WISH, self::TOO_LONG_LINK, self::VALID_DESCRIPTION, self::VALID_ID],
            [self::VALID_WISH, self::VALID_LINK, self::TOO_LONG_DESCRIPTION, self::VALID_ID],

            [null, self::VALID_LINK, self::VALID_DESCRIPTION, self::VALID_ID],
            [self::VALID_WISH, null, self::VALID_DESCRIPTION, self::VALID_ID],
            [self::VALID_WISH, self::VALID_LINK, null, self::VALID_ID],
            [self::VALID_WISH, self::VALID_LINK, self::VALID_DESCRIPTION, null]
        ];
    }
}
