<?php

namespace Naldz\Bundle\DsnParserBundle\DsnParser;

use Naldz\Bundle\DsnParserBundle\DsnParser\Driver\DsnParserInterface;
use Naldz\Bundle\DsnParserBundle\DsnParser\Exception\InvalidDsnException;

class DsnParser implements DsnParserInterface
{
    private $driverMap;

    public function __construct($driverMap = array())
    {
        $this->driverMap = $driverMap;
    }

    public function parse($dsn)
    {
        $dbType = parse_url($dsn, PHP_URL_SCHEME);

        if (!strlen($dbType)) {
            throw new InvalidDsnException(sprintf('Unable to get driver type from dsn: %s', $dsn));
        }

        if (!isset($this->driverMap[$dbType])) {
            throw new \InvalidArgumentException('Unsupported driver: '.$dbType);
        }

        $driver = $this->driverMap[$dbType];
        return $driver->parse($dsn);
    }
}