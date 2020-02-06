<?php
namespace App\Tests\Infrastructure;

use App\Infrastructure\Config;
use App\Tests\SetUpTestCase;

class ConfigTest extends SetUpTestCase
{
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

    private function unsetEnvVariable(string $name)
    {
        putenv($name);
    }
}
