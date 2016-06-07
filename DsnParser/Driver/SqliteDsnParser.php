<?php

namespace Naldz\Bundle\DsnParserBundle\DsnParser\Driver;

use Naldz\Bundle\DsnParserBundle\DsnParser\Driver\DsnParserInterface;
use Naldz\Bundle\DsnParserBundle\DsnParser\Exception\InvalidDsnException;

class SqliteDsnParser implements DsnParserInterface
{
    public function parse($dsn)
    {
        $urlComponents = parse_url($dsn);
        $dsnComponents = array();
        if (!isset($urlComponents['scheme']) || strtolower($urlComponents['scheme']) != 'sqlite') {
            throw new InvalidDsnException(sprintf('Invalid database type detected while parsing DSN: %s', $dsn));
        }
        $dsnComponents['type'] = $urlComponents['scheme'];
        $filePath = '';
        if (isset($urlComponents['host'])) {
            $filePath = '/'.$urlComponents['host'];
        }
        if (isset($urlComponents['path'])) {
            $filePath .= $urlComponents['path'];
        }
        $dsnComponents['file'] = $filePath;
        return $dsnComponents;
    }
}