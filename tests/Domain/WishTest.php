<?php
namespace App\Tests\Domain;

use App\Domain\Wish;
use App\Infrastructure\Config;
use PHPUnit\Framework\TestCase;

class WishTest extends TestCase
{
    private const VALID_WISH = 'I wish something';
    private const VALID_LINK = 'https://ru.wikipedia.org/wiki/URL';
    private const VALID_DESCRIPTION = 'text message about my wish';

    private const DATABASE_VALUE = "db";
    private const USER_VALUE = "root";
    private const ROOT_PASSWORD_VALUE = "password";
    private const HOST_VALUE = "db";
    private const PORT_VALUE = "3306";
    private const CHARSET_VALUE = "utf8";

    public function setUp() : void
    {
        $this->setEnvVariable(Config::MYSQL_DATABASE, self::DATABASE_VALUE);
        $this->setEnvVariable(Config::MYSQL_USER, self::USER_VALUE);
        $this->setEnvVariable(Config::MYSQL_ROOT_PASSWORD, self::ROOT_PASSWORD_VALUE);
        $this->setEnvVariable(Config::MYSQL_HOST, self::HOST_VALUE);
        $this->setEnvVariable(Config::MYSQL_PORT, self::PORT_VALUE);
        $this->setEnvVariable(Config::MYSQL_CHARSET, self::CHARSET_VALUE);
    }
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

    private function setEnvVariable(string $name, string $value)
    {
        putenv($name . "=" . $value);
    }
}
