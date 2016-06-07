<?php

namespace Naldz\Bundle\DsnParserBundle\Tests\Unit\DsnParser\Driver;

use Naldz\Bundle\DsnParserBundle\DsnParser\Driver\SqliteDsnParser;

class SqliteDsnParserTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->parser = new SqliteDsnParser();
    }
    
    public function testParsingFullDsn()
    {
        $dsn = 'sqlite://path/to/filte.sqlite';
        $expectedDsnComponents = array(
            'type'      => 'sqlite',
            'file'      => '/path/to/filte.sqlite',
        );

        $this->assertEquals($expectedDsnComponents, $this->parser->parse($dsn));
    }

    public function testMissingDatabaseTypeThrowsException()
    {
        $this->setExpectedException('Naldz\Bundle\DsnParserBundle\DsnParser\Exception\InvalidDsnException');
        $dsn = '//path/to/filte.sqlite';
        $this->parser->parse($dsn);
    }

    public function testUnknownDatabaseTypeThrowsException()
    {
        $this->setExpectedException('Naldz\Bundle\DsnParserBundle\DsnParser\Exception\InvalidDsnException');
        $dsn = 'unknown_db://path/to/filte.sqlite';
        $this->parser->parse($dsn);
    }

}