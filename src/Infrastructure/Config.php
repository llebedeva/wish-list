<?php


namespace App\Infrastructure;


class Config
{
    public const MYSQL_DATABASE = 'MYSQL_DATABASE';
    public const MYSQL_USER = 'MYSQL_USER';
    public const MYSQL_ROOT_PASSWORD = 'MYSQL_ROOT_PASSWORD';
    public const MYSQL_HOST = 'MYSQL_HOST';
    public const MYSQL_PORT = 'MYSQL_PORT';
    public const MYSQL_CHARSET = 'MYSQL_CHARSET';

    private $dbName;
    private $dbUser;
    private $dbRootPassword;
    private $dbHost;
    private $dbPort;
    private $dbCharset;

    /**
     * Config constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->envVariableExists(self::MYSQL_DATABASE);
        $this->envVariableExists(self::MYSQL_USER);
        $this->envVariableExists(self::MYSQL_ROOT_PASSWORD);
        $this->envVariableExists(self::MYSQL_HOST);
        $this->envVariableExists(self::MYSQL_PORT);
        $this->envVariableExists(self::MYSQL_CHARSET);

        $this->dbName = getenv(self::MYSQL_DATABASE);
        $this->dbUser = getenv(self::MYSQL_USER);
        $this->dbRootPassword = getenv(self::MYSQL_ROOT_PASSWORD);
        $this->dbHost = getenv(self::MYSQL_HOST);
        $this->dbPort = getenv(self::MYSQL_PORT);
        $this->dbCharset = getenv(self::MYSQL_CHARSET);
    }

    public function dbName() : string
    {
        return $this->dbName;
    }

    public function dbUser() : string
    {
        return $this->dbUser;
    }

    public function dbRootPassword() : string
    {
        return $this->dbRootPassword;
    }

    public function dbHost() : string
    {
        return $this->dbHost;
    }

    public function dbPort() : string
    {
        return $this->dbPort;
    }

    public function dbCharset() : string
    {
        return $this->dbCharset;
    }

    /**
     * @param string $varName
     * @throws \Exception
     */
    private function envVariableExists(string $varName) : void
    {
        if (getenv($varName)===false) {
            throw new \Exception('Environment variable ' . $varName . ' not set');
        }
    }
}
