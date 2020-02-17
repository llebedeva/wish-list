<?php
namespace App\Tests\Storage;

use App\Infrastructure\Config;
use App\Storage\Storage;
use App\Tests\SetUpTestCase;

class StorageTest extends SetUpTestCase
{
    public function testConnection()
    {
        $obj = new Storage();

        $this->assertInstanceOf(Storage::class, $obj);
    }

    public function testThrowsExceptionIfConnectionWasFailed()
    {
        $this->setEnvVariable(Config::MYSQL_ROOT_PASSWORD, self::ROOT_PASSWORD_VALUE . "1");
        $this->expectException(\PDOException::class);

        new Storage();
    }
}
