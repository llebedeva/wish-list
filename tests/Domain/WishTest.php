<?php
namespace App\Tests\Domain;

use App\Infrastructure\Config;
use App\Domain\Wish;
use App\Tests\SetUpTestCase;

class WishTest extends SetUpTestCase
{
    private const VALID_WISH = 'I wish something';
    private const VALID_LINK = 'https://ru.wikipedia.org/wiki/URL';
    private const VALID_DESCRIPTION = 'text message about my wish';

    public function testAddWishIfValidArguments()
    {
        $obj = new Wish(
            self::VALID_WISH,
            self::VALID_LINK,
            self::VALID_DESCRIPTION
        );

        $this->assertInstanceOf(Wish::class, $obj);
    }

    public function testThrowsExceptionIfInvalidArguments()
    {
        $this->expectException(\InvalidArgumentException::class);

        $obj = new Wish('', '', '');
        $obj->validate();

    }

    public function testThrowsExceptionIfConnectionWasFailed()
    {
        $this->setEnvVariable(Config::MYSQL_ROOT_PASSWORD, self::ROOT_PASSWORD_VALUE . "1");
        $this->expectException(\PDOException::class);

        $obj = new Wish(
            self::VALID_WISH,
            self::VALID_LINK,
            self::VALID_DESCRIPTION
        );
        $obj->saveToStorage();
    }
}
