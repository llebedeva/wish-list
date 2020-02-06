<?php
namespace App\Tests;

use App\Infrastructure\Config;
use PHPUnit\Framework\TestCase;

class SetUpTestCase extends TestCase
{
    protected const DATABASE_VALUE = "db";
    protected const USER_VALUE = "root";
    protected const ROOT_PASSWORD_VALUE = "password";
    protected const HOST_VALUE = "db";
    protected const PORT_VALUE = "3306";
    protected const CHARSET_VALUE = "utf8";

    protected function setUp() : void
    {
        $this->setEnvVariable(Config::MYSQL_DATABASE, self::DATABASE_VALUE);
        $this->setEnvVariable(Config::MYSQL_USER, self::USER_VALUE);
        $this->setEnvVariable(Config::MYSQL_ROOT_PASSWORD, self::ROOT_PASSWORD_VALUE);
        $this->setEnvVariable(Config::MYSQL_HOST, self::HOST_VALUE);
        $this->setEnvVariable(Config::MYSQL_PORT, self::PORT_VALUE);
        $this->setEnvVariable(Config::MYSQL_CHARSET, self::CHARSET_VALUE);
    }

    protected function setEnvVariable(string $name, string $value)
    {
        putenv($name . "=" . $value);
    }
}
