<?php

namespace Naldz\Bundle\DsnParserBundle\Tests\Unit\DsnParser\Driver;

use Naldz\Bundle\DsnParserBundle\DsnParser\Driver\MysqlDsnParser;

class MysqlDsnParserTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        $this->parser = new MysqlDsnParser();
    }
    
    public function testParsingFullDsn()
    {
        $dsn = 'mysql://my_user:my_pass@example.com:3307/my_db';
        $expectedDsnComponents = array(
            'type'      => 'mysql',
            'user'      => 'my_user',
            'password'  => 'my_pass',
            'host'      => 'example.com',
            'port'      => 3307,
            'database'  => 'my_db'
        );

        $this->assertEquals($expectedDsnComponents, $this->parser->parse($dsn));

    }

    public function testParsingDsnWithoutPort()
    {
        $dsn = 'mysql://my_user:my_pass@example.com/my_db';
        $expectedDsnComponents = array(
            'type'      => 'mysql',
            'user'      => 'my_user',
            'password'  => 'my_pass',
            'host'      => 'example.com',
            'port'      => null,
            'database'  => 'my_db'
        );

        $this->assertEquals($expectedDsnComponents, $this->parser->parse($dsn));
    }

    public function testParsingDsnWithoutPassword()
    {
        $dsn = 'mysql://my_user@example.com:3307/my_db';
        $expectedDsnComponents = array(
            'type'      => 'mysql',
            'user'      => 'my_user',
            'password'  => null,
            'host'      => 'example.com',
            'port'      => 3307,
            'database'  => 'my_db'
        );

        $this->assertEquals($expectedDsnComponents, $this->parser->parse($dsn));
    }

    public function testMissingDatabaseTypeThrowsException()
    {
        $this->setExpectedException('Naldz\Bundle\DsnParserBundle\DsnParser\Exception\InvalidDsnException');
        $dsn = '//my_user@example.com:3307/my_db';
        $this->parser->parse($dsn);
    }

    public function testUnknownDatabaseTypeThrowsException()
    {
        $this->setExpectedException('Naldz\Bundle\DsnParserBundle\DsnParser\Exception\InvalidDsnException');
        $dsn = 'unknown_db://my_user@example.com:3307/my_db';
        $this->parser->parse($dsn);
    }

}