<?php

namespace Helper;

use Codeception\Lib\Driver\Db as Driver;
use Codeception\Module;
use Codeception\Module\Db;
use Codeception\TestInterface;
use Exception;
use PDOStatement;

/**
 * check drop all tables
 */
class TableSpy extends Module
{

    // @codingStandardsIgnoreStart
    public function _before(TestInterface $test)// @codingStandardsIgnoreEnd
    {
        $db = $this->getModule('Db');
        /* @var $db Db */
        $dbConfig = $db->_getConfig();
        $driver = Driver::create($dbConfig['dsn'], $dbConfig['user'], $dbConfig['password']);

        $sth = $driver->executeQuery('SHOW TABLES', []);
        /* @var $sth PDOStatement */
        $tables = $sth->fetchAll();
        if (count($tables) > 1) {
            // should be remaining tables only `users`
            throw new Exception('Fixture created not droped.');
        }
        unset($driver);
    }
}
