<?php
namespace App\Tests\Infrastructure;

use App\Infrastructure\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    private const DATABASE_VALUE = "db";
    private const USER_VALUE = "root";
    private const ROOT_PASSWORD_VALUE = "password";
    private const HOST_VALUE = "db_host";
    private const PORT_VALUE = "3306";
    private const CHARSET_VALUE = "utf8";

    protected function setUp() : void
    {
        $this->setEnvVariable(Config::MYSQL_DATABASE, self::DATABASE_VALUE);
        $this->setEnvVariable(Config::MYSQL_USER, self::USER_VALUE);
        $this->setEnvVariable(Config::MYSQL_ROOT_PASSWORD, self::ROOT_PASSWORD_VALUE);
        $this->setEnvVariable(Config::MYSQL_HOST, self::HOST_VALUE);
        $this->setEnvVariable(Config::MYSQL_PORT, self::PORT_VALUE);
        $this->setEnvVariable(Config::MYSQL_CHARSET, self::CHARSET_VALUE);
    }

    public function testEnvVariablesSet()
    {
        $config = new Config();

        $this->assertEquals(self::DATABASE_VALUE, $config->dbName());
        $this->assertEquals(self::USER_VALUE, $config->dbUser());
        $this->assertEquals(self::ROOT_PASSWORD_VALUE, $config->dbRootPassword());
        $this->assertEquals(self::HOST_VALUE, $config->dbHost());
        $this->assertEquals(self::PORT_VALUE, $config->dbPort());
        $this->assertEquals(self::CHARSET_VALUE, $config->dbCharset());
    }

    /**
     * @dataProvider providerEnvVariables
     */
    public function testThrowsExceptionIfRequiredEnvVariableMissing($varName)
    {
        $this->unsetEnvVariable($varName);
        $this->expectException(\Exception::class);

        new Config();
    }

    public function providerEnvVariables()
    {
        return [
            [Config::MYSQL_DATABASE],
            [Config::MYSQL_USER],
            [Config::MYSQL_ROOT_PASSWORD],
            [Config::MYSQL_HOST],
            [Config::MYSQL_PORT],
            [Config::MYSQL_CHARSET]
        ];
    }

    private function setEnvVariable(string $name, string $value)
    {
        putenv($name . "=" . $value);
    }

    private function unsetEnvVariable(string $name)
    {
        putenv($name);
    }
}
