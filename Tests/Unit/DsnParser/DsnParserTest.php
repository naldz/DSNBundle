<?php

namespace Naldz\Bundle\DsnParserBundle\Tests\Unit\DsnParser;

use Naldz\Bundle\DsnParserBundle\DsnParser\DsnParser;

class DsnParserTest extends \PHPUnit_Framework_TestCase
{

    public function testMissingDatabaseTypeThrowsException()
    {
        $this->setExpectedException('Naldz\Bundle\DsnParserBundle\DsnParser\Exception\InvalidDsnException');
        $dsnParser = new DsnParser();
        $dsnParser->parse('//user:pass@host:3306/db_name');
    }

    public function testUnsupportedDatabaseTypeThrowsException()
    {
        $this->setExpectedException('Naldz\Bundle\DsnParserBundle\DsnParser\Exception\InvalidDsnException');
        $dsnParser = new DsnParser();
        $dsnParser->parse('unknown_type://user:pass@host:3306/db_name');
    }

    public function testParsing()
    {
        $dsn = 'mysql://user:pass@host:3306/db_name';

        $mysqlDsnParserMock = $this->getMockBuilder('Naldz\Bundle\DsnParserBundle\DsnParser\Driver\DsnParserInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $mysqlDsnParserMock->expects($this->once())
            ->method('parse')
            ->with($dsn);

        $driverMap = array(
            'mysql' => $mysqlDsnParserMock
        );

        $dsnParser = new DsnParser($driverMap);
        $dsnParser->parse($dsn);
    }

}